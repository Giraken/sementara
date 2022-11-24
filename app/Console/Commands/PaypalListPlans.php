<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaypalListPlans extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'paypal:list-plans';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List registered plans in paypal';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $provider = new PayPalClient;
        $provider->getAccessToken();
        $plans = $provider->listPlans();

        $this->info(json_encode($plans, JSON_PRETTY_PRINT));
        return 0;
    }
}
