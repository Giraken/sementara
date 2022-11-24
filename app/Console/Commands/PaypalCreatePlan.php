<?php

namespace App\Console\Commands;

use App\Models\Plan;
use Illuminate\Console\Command;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaypalCreatePlan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'paypal:create-plan {plan_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Register plan for paypal subscription';

    // https://developer.paypal.com/reference/currency-codes/
    static private $paypalSupportedCurrencies = [
        "AUD",
        "BRL",
        "CAD",
        "CNY",
        "CZK",
        "DKK",
        "EUR",
        "HKD",
        "HUF",
        "ILS",
        "JPY",
        "MYR",
        "MXN",
        "TWD",
        "NZD",
        "NOK",
        "PHP",
        "PLN",
        "GBP",
        "RUB",
        "SGD",
        "SEK",
        "CHF",
        "THB",
        "USD",
    ];

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $paypalSupportedCurrencies = fn ($query) => $query->whereIn('code', self::$paypalSupportedCurrencies);

        $id = $this->argument('plan_id');
        $plan = Plan::where('status', 'active')
            ->where('is_visible', 1)
            ->with(['product', 'currencies' => $paypalSupportedCurrencies])
            ->find($id);

        if (!$plan) {
            $this->error('Plan not found');
            return 1;
        }

        $provider = new PayPalClient;

        // TODO: Taxes value ??
        // TODO: Billing cycles for free trials?? because free trial is at product level, not at plan level
        $data = [
            "product_id" => $plan->product->uuid,
            "name" => "{$plan->product->name}: {$plan->name}",
            "description" => $plan->description,
            "status" => "ACTIVE",
            "billing_cycles" => [
                [
                    "frequency" => [
                        "interval_unit" => strtoupper($plan->frequency_unit),
                        "interval_count" => 1
                    ],
                    "tenure_type" => "REGULAR",
                    "sequence" => 1,
                    "total_cycles" => 0,
                    "pricing_scheme" => [
                        "fixed_price" => [
                            "value" => "",
                            "currency_code" => ""
                        ]
                    ]
                ]
            ],
            "quantity_supported" => true,
            // TODO: Discuss about setup fee... should it be included or not?
            "payment_preferences" => [
                "auto_bill_outstanding" => true,
                "payment_failure_threshold" => 1
                // ? What does this mean?
                // "setup_fee_failure_action" => "CONTINUE",
            ],
            "taxes" => [
                "percentage" => "10",
                "inclusive" => false
            ]
        ];

        // Iterate for every currencies, create its own plan
        $plan->currencies->each(function ($currency) use ($data, $provider) {
            // Don't create then plan if it already exists
            $plan_id = $currency->pivot->uuid;
            $provider->getAccessToken();
            $existingPlan = $provider->showPlanDetails($plan_id);
            if (array_key_exists('id', $existingPlan)) {
                $this->info("Plan already exists => " . $plan_id);
                return;
            }

            // TODO: Discuss about price, should be rounded into INT since PayPal doesn't support decimals
            $data["billing_cycles"][0]["pricing_scheme"]["fixed_price"]["value"] = intval($currency->pivot->price);
            $data["billing_cycles"][0]["pricing_scheme"]["fixed_price"]["currency_code"] = $currency->code;

            $request_id = 'create-plan-' . time();
            $provider->getAccessToken();
            $response = $provider->createPlan($data, $request_id);

            $currency->pivot->uuid = $response["id"];
            $currency->pivot->save()
                ? $this->info("Plan uuid updated => " . $response["id"] . " => " . $currency->id)
                : $this->error("Failed updateing plan uuid => " . $response["id"] . " => " . $currency->id);

            $result = json_encode($response, JSON_PRETTY_PRINT);
            array_key_exists('error', $response) ? $this->error($result) : $this->info($result);
        });

        return 0;
    }
}
