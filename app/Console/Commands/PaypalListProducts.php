<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaypalListProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'paypal:list-products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List products';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $provider = new PayPalClient;
        $provider->getAccessToken();
        $products = $provider->listProducts(1, 30, true);

        $this->info(json_encode($products));
        return 0;
    }
}
