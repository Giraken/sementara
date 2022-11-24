<?php

namespace App\Library\Services\Payments;

use App\Library\Contracts\PaymentGatewaySubscriptionInterface;
use App\Models\PaymentCharge;
use App\Models\PaymentServiceProvider;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\SubscriptionPayment;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaypalService implements PaymentGatewaySubscriptionInterface
{
	public function createSubscription(array $data): array
	{
		return [];
	}

	public function cancelSubscription(array $data): bool
	{
		$userId = $data['user_id'];
		$assignedSubscriptionId = $data['assigned_subscription_id'];

		$paypalPaymentService = PaymentServiceProvider::where('name', 'paypal')->first();
		throw_if($paypalPaymentService === null, new Exception('Paypal payment service provider not found'));

		$subscriptionPayment = SubscriptionPayment::where('payment_service_provider_id', $paypalPaymentService->id)
			->where('assigned_subscription_id', $assignedSubscriptionId)
			->where('is_active', true)
			->first();

		throw_if($subscriptionPayment === null, new Exception('Subscription payment not found'));

		throw_if($userId !== $subscriptionPayment->subscription->customer_id, new Exception('User not authorized to cancel subscription'));

		try {
			$provider = new PayPalClient;
			$provider->getAccessToken();
			$provider->cancelSubscription($subscriptionPayment->assigned_subscription_id, 'User request to cancel subscription');
		} catch (\Throwable $th) {
			throw new Exception('Something went wrong while cancelling subscription');
		}

		DB::beginTransaction();
		try {
			$subscriptionPayment->is_active = false;
			$subscriptionPayment->subscription->status = Subscription::STATUS_CANCELLED;

			$subscriptionPayment->subscription->save();
			$subscriptionPayment->save();

			DB::commit();
		} catch (\Throwable $th) {
			DB::rollBack();
			throw new Exception('Failed updating subscription payment status');
		}

		return true;
	}

	public function handleRecurringCharge(array $data): array
	{
		$webhookId = $data['webhook_id'];
		$body = $data['webhook_event'];
		$transmissionId = $data['paypal_transmission_id'];
		$transmissionTime = $data['paypal_transmission_time'];
		$sig = $data['paypal_transmission_sig'];
		$algo = $data['paypal_auth_algo'];
		$cert = $data['paypal_cert_url'];
		$assignedSubscriptionId = $data['assigned_subscription_id'];
		$assignedTransactionId = $data['assigned_transaction_id'];
		$price = $data['price'];
		$currency = $data['currency'];

		$isValid = $this->verifyCallbackRequest($algo, $cert, $transmissionId, $sig, $transmissionTime, $body, $webhookId);
		throw_if($isValid === false, new Exception('Invalid Request'));

		$paypalPaymentServiceProvider = PaymentServiceProvider::where('name', 'paypal')->first();
		throw_if($paypalPaymentServiceProvider === null, new Exception('PAYPAL PAYMENT SERVCE PROVIDER NOT FOUND'));

		// * Handle in an idempotent way. If the it has been charged before and success (paid), do nothing.
		$existingCharge = PaymentCharge::where('assigned_transaction_id', $assignedTransactionId)->first();
		if ($existingCharge && $existingCharge->status === PaymentCharge::STATUS_PAID) {
			return ['message' => 'Payment has been charged before'];
		}

		$existingSubscriptionPayment = SubscriptionPayment::where('assigned_subscription_id', $assignedSubscriptionId)
			->where('payment_service_provider_id', $paypalPaymentServiceProvider->id)
			->first();

		// If it is a new or a first subscription payment
		if ($existingSubscriptionPayment === null) {
			$this->handleInitialRecurringPayment(
				$paypalPaymentServiceProvider->id,
				$assignedSubscriptionId,
				$assignedTransactionId,
				$price,
				$currency,
			);

			return ['success' => ['message' => 'Subscription payment successfully handled']];
		}

		// It is a recurring subscription charge, then the subscription payment should already exist
		$this->handleNextRecurringPayment(
			$existingSubscriptionPayment,
			$assignedTransactionId,
			$price,
			$currency
		);
		return ['success' => ['message' => 'Subscription payment successfully handled']];
	}

	public function handleFailedRecurringCharge(array $data): array
	{
		$webhookId = $data['webhook_id'];
		$body = $data['webhook_event'];
		$transmissionId = $data['paypal_transmission_id'];
		$transmissionTime = $data['paypal_transmission_time'];
		$sig = $data['paypal_transmission_sig'];
		$algo = $data['paypal_auth_algo'];
		$cert = $data['paypal_cert_url'];
		$assignedSubscriptionId = $data['assigned_subscription_id'];

		$isValid = $this->verifyCallbackRequest($algo, $cert, $transmissionId, $sig, $transmissionTime, $body, $webhookId);
		throw_if($isValid === false, new Exception('Invalid Request'));

		$paypalPaymentService = PaymentServiceProvider::where('name', 'paypal')->first();
		throw_if($paypalPaymentService === null, new Exception('Paypal payment service is not found'));

		$subscriptionPayment = SubscriptionPayment::where('assigned_subscription_id', $assignedSubscriptionId)
			->where('payment_service_provider_id', $paypalPaymentService->id)
			->first();
		throw_if($subscriptionPayment === null, new Exception('Subscription is not found'));

		$subscriptionPayment->subscription->status = Subscription::STATUS_SUSPENDED;
		$subscriptionPayment->subscription->save();

		return ['message' => 'OK'];
	}

	public function handleCancelledSubscription(array $data): bool
	{
		$webhookId = $data['webhook_id'];
		$body = $data['webhook_event'];
		$transmissionId = $data['paypal_transmission_id'];
		$transmissionTime = $data['paypal_transmission_time'];
		$sig = $data['paypal_transmission_sig'];
		$algo = $data['paypal_auth_algo'];
		$cert = $data['paypal_cert_url'];
		$assignedSubscriptionId = $data['assigned_subscription_id'];

		$isValid = $this->verifyCallbackRequest($algo, $cert, $transmissionId, $sig, $transmissionTime, $body, $webhookId);
		throw_if($isValid === false, new Exception('Forbidden'));

		$paypalPaymentService = PaymentServiceProvider::where('name', 'paypal')->first();
		throw_if($paypalPaymentService === null, new Exception('Paypal payment service provider not found'));

		$subscriptionPayment = SubscriptionPayment::where('payment_service_provider_id', $paypalPaymentService->id)
			->where('assigned_subscription_id', $assignedSubscriptionId)
			->first();

		throw_if($subscriptionPayment === null, new Exception('Subscription payment not found'));

		// If it is already inactive & cancelled, do nothing
		if ($subscriptionPayment->is_active === false && $subscriptionPayment->subscription->status === Subscription::STATUS_CANCELLED) {
			return true;
		}

		DB::beginTransaction();
		try {
			$subscriptionPayment->is_active = false;
			$subscriptionPayment->subscription->status = Subscription::STATUS_CANCELLED;

			$subscriptionPayment->subscription->save();
			$subscriptionPayment->save();

			DB::commit();
		} catch (\Throwable $th) {
			DB::rollBack();
			throw new Exception('Failed updating subscription payment status');
		}

		return true;
	}


	private function verifyCallbackRequest(
		string $algo,
		string $cert,
		string $transmissionId,
		string $sig,
		string $transmissionTime,
		string $rawBody,
		string $webhookId
	): bool {
		$provider = new PayPalClient;
		$accessToken = $provider->getAccessToken()['access_token'];

		$verifyWebhookUrl = config('paypal.domain') . "/v1/notifications/verify-webhook-signature";
		$response = Http::withToken($accessToken)->asJson()->post($verifyWebhookUrl, [
			"auth_algo" => $algo,
			"cert_url" => $cert,
			"transmission_id" => $transmissionId,
			"transmission_sig" => $sig,
			"transmission_time" => $transmissionTime,
			// ! webhook_event should be original, untouched json data sent by PayPal
			// ! if the structure of json data is altered, it will be invalid
			"webhook_event" => json_decode($rawBody, true),
			"webhook_id" => $webhookId,
		]);

		$responsePayload = $response->json();
		if ($response->failed()) {
			error_log("SOMETHING WENT WRONG:\n" . json_encode($responsePayload, JSON_PRETTY_PRINT));
			return false;
		}

		if ($responsePayload['verification_status'] !== "SUCCESS") {
			error_log("FAILED VERIFICATION:\n" . json_encode($responsePayload, JSON_PRETTY_PRINT));
			return false;
		}

		return true;
	}

	private function handleInitialRecurringPayment(
		int $paypalPaymentServiceProviderId,
		string $assignedSubscriptionId,
		string $assignedTransactionId,
		string $price,
		string $currency
	): void {
		$tmpSubscriptionPayment = DB::table('_tmp_subscription_payments')
			->where('assigned_subscription_id', '=', $assignedSubscriptionId)
			->where('payment_service_provider_id', '=', $paypalPaymentServiceProviderId)
			->first();
		throw_if($tmpSubscriptionPayment === null, new Exception("Paypal Subscription Payment Not Found: {$assignedSubscriptionId}"));

		$plan = Plan::find($tmpSubscriptionPayment->plan_id);
		throw_if($plan === null, new Exception('Plan Is Not Found'));

		$frequencyAmount = $plan->frequency_amount;
		$frequencyUnit = $plan->frequency_unit;
		$endsAtMap = [
			'month' => now()->addMonth($frequencyAmount),
			'year' => now()->addYears($frequencyAmount),
		];
		throw_if(array_key_exists($frequencyUnit, $endsAtMap) === false, new Exception('Unregistered Frequency Unit'));

		DB::beginTransaction();
		try {
			$subscription = new Subscription([
				'customer_id' => $tmpSubscriptionPayment->customer_id,
				'plan_id' => $tmpSubscriptionPayment->plan_id,
				'status' => Subscription::STATUS_ACTIVE,
				'started_at' => now(),
				'current_period_ends_at' => $endsAtMap[$frequencyUnit],
			]);

			$subscriptionPayment = new SubscriptionPayment([
				'payment_service_provider_id' => $paypalPaymentServiceProviderId,
				'assigned_subscription_id' => $assignedSubscriptionId,
				'is_active' => true
			]);

			$paymentCharge = new PaymentCharge([
				'assigned_transaction_id' => $assignedTransactionId,
				'price' => $price,
				'currency' => $currency,
				'status' => PaymentCharge::STATUS_PAID,
			]);

			$subscription->save();
			$subscription->subscriptionPayments()->save($subscriptionPayment);
			$subscriptionPayment->paymentCharges()->save($paymentCharge);

			DB::table('_tmp_subscription_payments')
				->where('assigned_subscription_id', '=', $assignedSubscriptionId)
				->where('payment_service_provider_id', '=', $paypalPaymentServiceProviderId)
				->update(['status' => PaymentCharge::STATUS_PAID]);

			DB::commit();
		} catch (\Throwable $th) {
			DB::rollBack();
			throw $th;
		}
	}

	private function handleNextRecurringPayment(
		SubscriptionPayment $existingSubscriptionPayment,
		string $assignedTransactionId,
		string $price,
		string $currency,
	): void {
		$plan = $existingSubscriptionPayment->subscription->plan;
		throw_if($plan === null, 'Exception', 'PLAN IS NOT FOUND');

		$frequencyAmount = $plan->frequency_amount;
		$frequencyUnit = $plan->frequency_unit;
		$endsAtMap = [
			'month' => now()->addMonth($frequencyAmount),
			'year' => now()->addYears($frequencyAmount),
		];
		throw_if(array_key_exists($frequencyUnit, $endsAtMap) === false, new Exception('UNREGISTERED PLAN FREQUENCY UNIT'));

		$paymentCharge = new PaymentCharge([
			'assigned_transaction_id' => $assignedTransactionId,
			'price' => $price,
			'currency' => $currency,
			'status' => PaymentCharge::STATUS_PAID,
		]);

		$existingSubscriptionPayment->subscription->status = Subscription::STATUS_ACTIVE;
		$existingSubscriptionPayment->subscription->current_period_ends_at = $endsAtMap[$frequencyUnit];
		$existingSubscriptionPayment->subscription->save();

		$existingSubscriptionPayment->paymentCharges()->save($paymentCharge);
	}
}
