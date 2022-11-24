<?php

namespace App\Http\Controllers;

use App\Http\Requests\CancelSubscriptionRequest;
use App\Http\Requests\StoreSubscriptionRequest;
use App\Library\Contracts\PaymentGatewaySubscriptionInterface;
use App\Library\Services\Payments\MidtransService;
use App\Library\Services\Payments\PaypalService;
use App\Models\BillingAddress;
use App\Models\Customer;
use App\Models\PaymentCharge;
use App\Models\PaymentServiceProvider;
use App\Models\PlanPrice;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Srmklive\PayPal\Services\PayPal as PayPalClient;


class PaymentController extends Controller
{
    private PaypalService $paypal;
    private PaymentGatewaySubscriptionInterface $midtrans;

    public function __construct(PaypalService $paypal, MidtransService $midtrans)
    {
        $this->paypal = $paypal;
        $this->midtrans = $midtrans;
    }

    public function storePaypalSubscription(StoreSubscriptionRequest $request)
    {
        $validated = $request->validated();
        $planPriceId = $validated['plan_price_id'];
        $billingAddress = $validated['billing_address'];

        $planPrice = PlanPrice::where('id', $planPriceId)
            ->with(['paypalRegisteredPlan'])
            ->first();

        if ($planPrice === null || $planPrice->paypalRegisteredPlan === null) {
            return response()->json(['error' => 'Plan is not found'], Response::HTTP_NOT_FOUND);
        }

        $paypalPayment = PaymentServiceProvider::where('name', 'paypal')->first();
        if ($paypalPayment === null) {
            return response()->json(['error' => 'Payment service provider not found'], Response::HTTP_NOT_FOUND);
        }

        $user = Auth::user();
        Customer::firstOrCreate(['id' => $user->id], [
            'uuid' => Str::uuid(),
            // TODO: resolve what should be set as timezone...
            'timezone' => config('app.timezone')
        ]);

        BillingAddress::updateOrCreate([
            'customer_id' => $user->id
        ], [
            'first_name' => $billingAddress['first_name'],
            'last_name' => $billingAddress['last_name'],
            'email' => $billingAddress['email'],
            'address' => $billingAddress['address'],
            'phone' => $billingAddress['phone'],
            'country_id' => $billingAddress['country'],
        ]);

        $paypalSubscription = [
            'plan_id' => $planPrice->paypalRegisteredPlan->assigned_paypal_plan_id,
            'application_context' => [
                'brand_name' => 'Central App',
                'locale' => 'en-US',
                'payment_method' => [
                    'payer_selected' => 'PAYPAL',
                    'payee_preferred' => 'IMMEDIATE_PAYMENT_REQUIRED'
                ],
                'shipping_preference' => 'NO_SHIPPING',
                'user_action' => 'SUBSCRIBE_NOW',
                'subscriber' => [
                    'email_address' => $billingAddress['email'],
                    'name' => [
                        'given_name' => $billingAddress['first_name'],
                        'surname' => $billingAddress['last_name']
                    ],
                ]
            ]
        ];

        try {
            $provider = new PayPalClient;
            $provider->getAccessToken();
            $response =  $provider->createSubscription($paypalSubscription);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if (array_key_exists('error', $response)) {
            return response()->json(['error' => 'Failed processing paypal'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        DB::table('_tmp_subscription_payments')->insert([
            // 'customer_id' =>  $user->id,
            // 'plan_id' =>  $planPrice->plan_id,
            // 'assigned_subscription_id' => $response['id'],
            // 'payment_service_provider_id' => $paypalPayment->id,
            // 'status' =>  PaymentCharge::STATUS_PENDING,
        ]);

        return response()->json($response);
    }

    public function storeMidtransSubscription(StoreSubscriptionRequest $request)
    {

        $validated = $request->validated();
        $planPriceId = $validated['plan_price_id'];
        $billingAddress = $validated['billing_address'];

        $planPrice = PlanPrice::where('id', $planPriceId)->with(['currency', 'plan', 'plan.product'])->first();
        if ($planPrice === null) {
            return response()->json(['error' => 'Midtrans plan not found'], Response::HTTP_NOT_FOUND);
        }

        $supportedIntervalUnits = collect(config('midtrans.supported_interval_units'));
        $planIntervalUnit = function ($value) use ($planPrice) {
            return $value === $planPrice->plan->frequency_unit;
        };

        if ($supportedIntervalUnits->doesntContain($planIntervalUnit)) {
            return response()->json(['error' => ['message' => 'Unsupported interval unit']], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $midtransPaymentService = PaymentServiceProvider::where('name', 'midtrans')->first();
        if ($midtransPaymentService === null) {
            return response()->json(['error' => 'Midtrans payment service provider not found'], Response::HTTP_NOT_FOUND);
        }

        $user = Auth::user();

        try {
            // If user is not registered as customer, register a new one
            Customer::firstOrCreate(['id' => $user->id], [
                'uuid' => Str::uuid(),
                // ? What shoule be the timezone
                'timezone' => config('app.timezone')
            ]);

            BillingAddress::updateOrCreate([
                'customer_id' => $user->id
            ], [
                'first_name' => $billingAddress['first_name'],
                'last_name' => $billingAddress['last_name'],
                'email' => $billingAddress['email'],
                'address' => $billingAddress['address'],
                'phone' => $billingAddress['phone'],
                'country_id' => $billingAddress['country'],
            ]);

            $customOrderId = Str::uuid()->toString();
            DB::table('_tmp_payment_charges')->insert([
                // 'customer_id' => $user->id,
                // 'payment_service_provider_id' => $midtransPaymentService->id,
                // 'plan_price_id' => $planPrice->id,
                // 'order_id' => $customOrderId,
                // 'status' => PaymentCharge::STATUS_PENDING,
                'price' => $planPrice->price,
                'currency' => $planPrice->currency->code,
            ]);
        } catch (QueryException $error) {
            error_log($error->getMessage());
            return response()->json(['error' => ['message' => 'unable to save subscription data']]);
        }

        try {
            $params = [
                'transaction_details' => [
                    'order_id' => $customOrderId,
                    'gross_amount' => (int) $planPrice->price,
                ],
                "credit_card" => [
                    "secure" => true,
                    "save_card" => true
                ],
                "item_details" => [
                    [
                        'id' => $planPrice->id,
                        'price' => (int) $planPrice->price,
                        'quantity' => 1,
                        'name' => "{$planPrice->plan->product->name} | {$planPrice->plan->name}",
                        'merchant_name' => "Beemata",
                        'url' => route('plans.checkout', ['plan_id' => $planPrice->plan->id]),
                    ]
                ],
                "enabled_payments" => [
                    // Midtrans subscription only supports credit card as payment method
                    "credit_card",
                ],
                "user_id" => $user->id,
                'customer_details' => [
                    'first_name' => $billingAddress['first_name'],
                    'last_name' => $billingAddress['last_name'],
                    'email' => $billingAddress['email'],
                    'phone' => $billingAddress['phone'],
                ],
                'custom_plan_price_id' => $planPrice->id,
                'custom_customer_id' => $user->id,
            ];

            \Midtrans\Config::$serverKey = config("midtrans.server_key");
            \Midtrans\Config::$isProduction = config("midtrans.is_production");
            \Midtrans\Config::$isSanitized = config("midtrans.is_sanitized");
            \Midtrans\Config::$is3ds = config("midtrans.is_3ds");
            $snapToken = \Midtrans\Snap::getSnapToken($params);
        } catch (\Throwable $th) {
            error_log($th->getMessage());
            return response()->json(['error' => 'Failed creating initial subscription payment'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json(['snap_token' => $snapToken]);
    }

    public function cancelPaypalSubscription(CancelSubscriptionRequest $request)
    {
        $validated  = $request->validated();

        try {
            $result = $this->paypal->cancelSubscription([
                'user_id' => Auth::id(),
                'assigned_subscription_id' => $validated['assigned_subscription_id'],
            ]);
        } catch (\Throwable $th) {
            error_log($th->getMessage());
            return redirect()->route('plans.index')->with(['success' => $result, 'error' => $th->getMessage()]);
        }

        // TODO: redirect to proper page
        return redirect()->route('billings.index')->with('success', $result);
    }

    public function cancelMidtransSubscription(CancelSubscriptionRequest $request)
    {
        $validated = $request->validated();

        try {
            $result = $this->midtrans->cancelSubscription([
                'user_id' => Auth::id(),
                'assigned_subscription_id' => $validated['assigned_subscription_id'],
            ]);

            throw_if($result === false, new Exception('Failed cancelling subscription...'));
        } catch (\Throwable $th) {
            return response()->json(['success' => $result, 'error' => ['message' => $th->getMessage()]]);
        }

        return redirect()->back()->with(['success' => $result]);
    }

    public function handlePaypalRecurringCharge(Request $request)
    {
        error_log('handlePaypalRecurringCharge');
        try {
            $this->paypal->handleRecurringCharge([
                'webhook_id' => '86L92863C4659380N',
                'webhook_event' => $request->getContent(),
                'paypal_transmission_id' => $request->header('PAYPAL-TRANSMISSION-ID'),
                'paypal_transmission_time' => $request->header('PAYPAL-TRANSMISSION-TIME'),
                'paypal_transmission_sig' => $request->header('PAYPAL-TRANSMISSION-SIG'),
                'paypal_auth_algo' => $request->header('PAYPAL-AUTH-ALGO'),
                'paypal_cert_url' => $request->header('PAYPAL-CERT-URL'),
                'assigned_subscription_id' => $request->resource["billing_agreement_id"],
                'assigned_transaction_id' => $request->resource["id"],
                'price' => $request->resource["amount"]["total"],
                'currency' => $request->resource["amount"]["currency"],
            ]);
        } catch (\Throwable $th) {
            error_log("Error: {$th->getMessage()} \n");
            return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response(null, Response::HTTP_OK);
    }

    public function handlePaypalSubscriptionPaymentFailed(Request $request)
    {
        error_log('handlePaypalSubscriptionPaymentFailed');

        try {
            $this->paypal->handleFailedRecurringCharge([
                'webhook_id' => '6DR53493JY037445Y',
                'webhook_event' => $request->getContent(),
                'paypal_transmission_id' => $request->header('PAYPAL-TRANSMISSION-ID'),
                'paypal_transmission_time' => $request->header('PAYPAL-TRANSMISSION-TIME'),
                'paypal_transmission_sig' => $request->header('PAYPAL-TRANSMISSION-SIG'),
                'paypal_auth_algo' => $request->header('PAYPAL-AUTH-ALGO'),
                'paypal_cert_url' => $request->header('PAYPAL-CERT-URL'),
                'assigned_subscription_id' => $request->resource["id"],
            ]);
        } catch (\Throwable $th) {
            return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response(null, Response::HTTP_OK);
    }

    public function handlePaypalCancelledSubscription(Request $request)
    {
        error_log('handlePaypalCancelledSubscription');

        try {
            $this->paypal->handleCancelledSubscription([
                'webhook_id' => '0CR633001H102333P',
                'webhook_event' => $request->getContent(),
                'paypal_transmission_id' => $request->header('PAYPAL-TRANSMISSION-ID'),
                'paypal_transmission_time' => $request->header('PAYPAL-TRANSMISSION-TIME'),
                'paypal_transmission_sig' => $request->header('PAYPAL-TRANSMISSION-SIG'),
                'paypal_auth_algo' => $request->header('PAYPAL-AUTH-ALGO'),
                'paypal_cert_url' => $request->header('PAYPAL-CERT-URL'),
                'assigned_subscription_id' => $request->resource["id"],
            ]);
        } catch (\Throwable $th) {
            error_log('error:' . $th->getMessage());
            return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response(null, Response::HTTP_OK);
    }

    public function handleMidtransRecurringCharge(Request $request)
    {
        error_log('handleMidtransRecurringCharge');
        error_log(json_encode($request->all(), JSON_PRETTY_PRINT));
        return response(null, 200);

        try {
            $this->midtrans->handleRecurringCharge([
                'subscription_id' => $request?->subscription_id,
                'saved_token_id' => $request?->saved_token_id,
                'saved_token_id_expired_at' => $request?->saved_token_id_expired_at,
                'order_id' => $request->order_id,
                'status_code' => $request->status_code,
                'gross_amount' => $request->gross_amount,
                'signature_key' => $request->signature_key,
                'transaction_status' => $request->transaction_status,
                'fraud_status' => $request->fraud_status,
                'payment_type' => $request->payment_type,
                'currency' => $request->currency,
                'transaction_id' => $request->transaction_id,
            ]);
        } catch (\Throwable $th) {
            error_log("Error: {$th->getMessage()} \n");
            response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response(null, Response::HTTP_OK);
    }
}
