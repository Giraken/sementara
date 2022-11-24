<?php

namespace App\Library\Services\Payments;

use App\Library\Contracts\PaymentGatewaySubscriptionInterface;
use App\Models\PaymentCharge;
use App\Models\PaymentServiceProvider;
use App\Models\Plan;
use App\Models\PlanPrice;
use App\Models\Subscription;
use App\Models\SubscriptionPayment;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class MidtransService implements PaymentGatewaySubscriptionInterface
{
	public function createSubscription(array $data): array
	{
		return [];
	}

	public function cancelSubscription(array $data): bool
	{
		$userId = $data['user_id'];
		$assignedSubscriptionId = $data['assigned_subscription_id'];

		$subscriptionPayment = SubscriptionPayment::where('assigned_subscription_id', $assignedSubscriptionId)
			->where('payment_service_provider_id', function ($query) {
				return $query->select('id')
					->from('payment_service_providers')
					->where('name', 'midtrans')
					->limit(1);
			})
			->first();

		throw_if($subscriptionPayment === null, new Exception('Subscription payment not found'));
		throw_if($subscriptionPayment->subscription->customer_id !== $userId, new Exception('User not authorized'));

		try {
			\Midtrans\Config::$serverKey = config("midtrans.server_key");
			\Midtrans\Config::$isProduction = config("midtrans.is_production");

			\Midtrans\CoreApi::disableSubscription($subscriptionPayment->assigned_subscription_id);
		} catch (\Throwable $th) {
			throw new Exception('Unable to cancel subscription');
		}

		DB::beginTransaction();
		try {
			$subscriptionPayment->is_active = false;
			$subscriptionPayment->subscription->status = Subscription::STATUS_CANCELLED;

			$subscriptionPayment->save();
			$subscriptionPayment->subscription->save();

			DB::commit();
		} catch (\Throwable $th) {
			DB::rollBack();
			throw new Exception('Failed updating subscription status');
		}

		return true;
	}

	public function handleRecurringCharge(array $data): array
	{
		$assignedSubscriptionId = $data['subscription_id'];
		$savedTokenId = $data['saved_token_id'];
		$savedTokenIdExpiredAt = $data['saved_token_id_expired_at'];
		$orderId = $data['order_id'];
		$statusCode = $data['status_code'];
		$grossAmount = $data['gross_amount'];
		$signatureKey = $data['signature_key'];
		$transactionStatus = $data['transaction_status'];
		$fraudStatus = $data['fraud_status'];
		$paymentType = $data['payment_type'];
		$currency = $data['currency'];
		$assignedTransactionId = $data['transaction_id'];

		// Validate if it is a request from Midtrans
		$isValid = $this->verifyCallbackRequest($orderId, $statusCode, $grossAmount, $signatureKey);
		throw_if($isValid === false, 'Exception', 'Invalid signature key');

		// Unknown transaction status
		throw_if(
			config('midtrans.transaction_statuses')->doesntContain(fn ($value) => $value === $transactionStatus),
			new Exception("Unknown transaction status: {$transactionStatus}")
		);

		$midtransPaymentService = PaymentServiceProvider::where('name', 'midtrans')->first();
		throw_if($midtransPaymentService === null, new Exception('Midtrans payment service provider not found'));

		// Case 1: Payment is a new payment for subscription initialization,
		if ($savedTokenId) {
			return $this->handleInitialRecurringPayment(
				$midtransPaymentService->id,
				$orderId,
				$assignedTransactionId,
				$transactionStatus,
				$fraudStatus,
				$grossAmount,
				$paymentType,
				$currency,
				$savedTokenId,
				$savedTokenIdExpiredAt
			);
		}

		// Case 2: Automated payment charge from subscription
		if ($assignedSubscriptionId) {
			return $this->handleNextRecurringPayment(
				$midtransPaymentService->id,
				$assignedSubscriptionId,
				$assignedTransactionId,
				$transactionStatus,
				$fraudStatus,
				$grossAmount,
				$currency
			);
		}

		throw new Exception("Unknown condition to handle");
	}

	private function verifyCallbackRequest($orderId, $statusCode, $grossAmount, $signatureKey): bool
	{
		$signatureKeyFormula = $orderId . $statusCode . $grossAmount . config('midtrans.server_key');
		$signature = hash('sha512', $signatureKeyFormula);
		return $signature === $signatureKey;
	}

	private function handleInitialRecurringPayment(
		int $paymentServiceProviderId,
		string $customOrderId,
		string $assignedTransactionId,
		string $transactionStatus,
		string $fraudStatus,
		string $price,
		string $paymentType,
		string $currency,
		string $savedTokenId,
		string $savedTokenIdExpiredAt,
	): array {
		$charge = DB::table('_tmp_payment_charges')
			->where('payment_service_provider_id', '=', $paymentServiceProviderId)
			->where('order_id', '=', $customOrderId)
			->first();

		throw_if($charge === null, new Exception("No payment charge found for order_id: {$customOrderId}"));

		$planPrice = PlanPrice::find($charge->plan_price_id);
		throw_if($planPrice === null, new Exception("Plan is not found"));

		$plan = $planPrice->plan;
		throw_if($plan === null, new Exception("Plan is not found"));

		$supportedIntervalUnits = collect(config('midtrans.supported_interval_units'));
		$planIntervalUnit = function ($value) use ($plan) {
			return $value === $plan->frequency_unit;
		};
		throw_if($supportedIntervalUnits->doesntContain($planIntervalUnit), new Exception("Unsupported interval unit: {$plan->frequency_unit}"));

		$paymentStatus = PaymentCharge::STATUS_PAID;

		// Transaction is failed: set transaction status on your database to 'failure'
		if ($transactionStatus === 'cancel' || $transactionStatus === 'deny' || $transactionStatus === 'expire' || $fraudStatus === 'deny') {
			$paymentStatus = PaymentCharge::STATUS_FAILED;
		}

		// Transaction is still pending: set transaction status on your database to 'pending' / waiting payment
		if ($transactionStatus === 'pending') {
			$paymentStatus = PaymentCharge::STATUS_PENDING;
		}

		// Transaction is in challenge: set transaction status on your database to 'challenge'
		if ($transactionStatus === 'capture' && $fraudStatus === 'challenge') {
			$paymentStatus = PaymentCharge::STATUS_CHALLENGE;
		}

		// * If it was already processed for the same payment status, do nothing.
		if ($charge->status === $paymentStatus) {
			return ['message' => 'Payment is already processed'];
		}

		// * If payment is not success, mark as it is and return.
		if ($paymentStatus !== PaymentCharge::STATUS_PAID) {
			try {
				DB::table('_tmp_payment_charges')
					->where('assigned_transaction_id', '=', $assignedTransactionId)
					->update(['status' => $paymentStatus]);
			} catch (\Throwable $th) {
				throw new Exception("Failed updating payment charge status");
			}

			return ['message' => "Payment is {$paymentStatus}"];
		}

		$subscriptionData = [
			'name' => "{$plan->name} | {$plan->product->name} Subscription",
			'amount' => (string) (int) $price, // remove decimal
			'payment_type' => $paymentType,
			'currency' => $currency,
			'token' => $savedTokenId,
			"schedule" => [
				"interval" => $plan->frequency_amount,
				"max_interval" => 999999, // infinite
				"current_interval" => 1,
				"interval_unit" => $plan->frequency_unit,
				// TODO: start_time to next month from now
				"start_time" => $this->toMidtransDateTime(now("GMT+7")->addMinute())
			],
		];

		try {
			\Midtrans\Config::$serverKey = config("midtrans.server_key");
			\Midtrans\Config::$isProduction = config("midtrans.is_production");
			\Midtrans\Config::$isSanitized = config("midtrans.is_sanitized");
			\Midtrans\Config::$is3ds = config("midtrans.is_3ds");

			$createSubscriptionResponse = \Midtrans\CoreApi::createSubscription($subscriptionData);
		} catch (\Throwable $th) {
			throw new Exception("Unable to create subscription");
		}

		DB::beginTransaction();
		try {
			$subscription = new Subscription([
				'customer_id' => $charge->customer_id,
				'plan_id' => $plan->id,
				'status' => Subscription::STATUS_ACTIVE,
				'started_at' => now(),
				'current_period_ends_at' => now()->addMonth(),
			]);

			$subscriptionPayment = new SubscriptionPayment([
				'payment_service_provider_id' => $paymentServiceProviderId,
				'assigned_subscription_id' => $createSubscriptionResponse->id,
				'is_active' => true,
				'metadata' => [
					'saved_token_id' => $savedTokenId,
					'saved_token_id_expired_at' => $savedTokenIdExpiredAt,
				]
			]);

			$paymentCharge = new PaymentCharge([
				'assigned_transaction_id' => $assignedTransactionId,
				'price' => (string) (int) $price,
				'currency' => $currency,
				'status' => PaymentCharge::STATUS_PAID,
			]);

			$subscription->save();
			$subscription->subscriptionPayments()->save($subscriptionPayment);
			$subscriptionPayment->paymentCharges()->save($paymentCharge);

			DB::table('_tmp_payment_charges')
				->where('order_id', '=', $customOrderId)
				->update([
					'status' => PaymentCharge::STATUS_PAID,
					'assigned_transaction_id' => $assignedTransactionId
				]);

			DB::commit();
		} catch (\Throwable $th) {
			DB::rollBack();
			error_log($th->getMessage());
			throw new Exception("Unable to create subscription");
		}

		return ['message' => 'Subscription successfully created'];
	}

	private function handleNextRecurringPayment(
		int $paymentServiceProviderId,
		string $assignedSubscriptionId,
		string $assignedTransactionId,
		string $transactionStatus,
		string $fraudStatus,
		string $price,
		string $currency
	): array {
		$subscriptionPayment = SubscriptionPayment::where('assigned_subscription_id', $assignedSubscriptionId)
			->where('payment_service_provider_id', $paymentServiceProviderId)
			->first();
		throw_if($subscriptionPayment === null, 'Exception', 'Subscription payment not found');

		$paymentChargeStatus = '';
		$subscriptionStatus = '';

		// Transaction is failed
		if ($transactionStatus === 'cancel' || $transactionStatus === 'deny' || $transactionStatus === 'expire' || $fraudStatus === 'deny') {
			// set transaction status on your database to 'failure'
			$paymentChargeStatus = PaymentCharge::STATUS_FAILED;
			$$subscriptionStatus = Subscription::STATUS_SUSPENDED;
		}

		// Transaction is still pending
		if ($transactionStatus === 'pending') {
			// set transaction status on your database to 'pending' / waiting payment
			$paymentChargeStatus = PaymentCharge::STATUS_PENDING;
			$subscriptionStatus = Subscription::STATUS_SUSPENDED;
		}

		// Transaction is in challenge
		if ($transactionStatus === 'capture' && $fraudStatus == 'challenge') {
			// set transaction status on your database to 'challenge'
			$paymentChargeStatus = PaymentCharge::STATUS_CHALLENGE;
			$subscriptionStatus = Subscription::STATUS_SUSPENDED;
		}

		// Transaction is success
		if ($transactionStatus === 'settlement' || ($transactionStatus === 'capture' && $fraudStatus === 'accept')) {
			$paymentChargeStatus = PaymentCharge::STATUS_PAID;
			$subscriptionStatus = Subscription::STATUS_ACTIVE;
		}

		// * If it already processed, do nothing
		$existingCharge = PaymentCharge::where('assigned_transaction_id', $assignedTransactionId)->first();
		if ($existingCharge !== null && $existingCharge->status === $paymentChargeStatus) {
			return ['message' => 'Already processed'];
		}

		DB::beginTransaction();
		try {
			PaymentCharge::updateOrCreate([
				'subscription_payment_id' => $subscriptionPayment->id,
				'assigned_transaction_id' => $assignedTransactionId,
			], [
				'currency' => $currency,
				'price' => (string) (int) $price,
				'status' => $paymentChargeStatus,
			]);

			$subscriptionPayment->subscription->current_period_ends_at = now()->addMonth();
			$subscriptionPayment->subscription->status = $subscriptionStatus;
			$subscriptionPayment->subscription->save();
			DB::commit();
		} catch (\Throwable $th) {
			DB::rollBack();
			error_log($th->getMessage());
			throw new Exception("Failed updating recurring subscription charge");
		}

		return ['message' => 'Subscription successfully updated'];
	}

	private function toMidtransDateTime(Carbon $time)
	{
		// Mindtrans using the GMT+7 timezone
		$time->setTimezone('GMT+7');

		// Result of this Iso8601String: "2022-09-09T07:29:19+07:00"
		// expected result: "2022-09-09 07:29:19 +0700"
		$datetime = $time->toIso8601String();

		[$date, $hourZone] = explode("T", $datetime);
		[$hour, $zone] = explode("+", $hourZone);
		$zone = str_replace(":", "", $zone);

		return "{$date} {$hour} +{$zone}";
	}
}
