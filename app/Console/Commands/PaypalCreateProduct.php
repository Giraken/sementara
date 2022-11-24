<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaypalCreateProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'paypal:create-product {product_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Register product for paypal subscription';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $id = $this->argument('product_id');
        $product = Product::find($id);
        if (!$product) {
            $this->error('Product not found');
            return 1;
        }

        $provider = new PayPalClient;

        // Don't create product if it already exists
        $provider->getAccessToken();
        $paypalProduct = $provider->showProductDetails($product->uuid);
        if (array_key_exists('id', $paypalProduct)) {
            $this->error("Product already exists!");
            $this->line(json_encode($paypalProduct));
            return 1;
        }

        $data = [
            "id" => $product->uuid,
            "name" => $product->name,
            "description" => $product->description,
            "type" => "SERVICE",
            "category" => "SOFTWARE",
            "image_url" => "http://www.example.com/image.jpg",
            "home_url" => "http://www.example.com/products.jpg",
        ];

        $request_id = 'create-product-' . time();
        $provider->getAccessToken();
        $response = $provider->createProduct($data, $request_id);

        $this->info(json_encode($response));
        return 0;
    }
}
