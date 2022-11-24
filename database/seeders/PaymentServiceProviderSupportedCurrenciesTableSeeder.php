<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PaymentServiceProviderSupportedCurrenciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('payment_service_provider_supported_currencies')->insert([
            [
                'currency_id' => 1,
                'payment_service_provider_id' => 1,
            ],
            [
                'currency_id' => 2,
                'payment_service_provider_id' => 2,
            ]
        ]);
        Schema::enableForeignKeyConstraints();
    }
}
