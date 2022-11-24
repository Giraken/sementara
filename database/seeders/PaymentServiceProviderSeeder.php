<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class PaymentServiceProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payment_service_providers')->delete();

        DB::table('payment_service_providers')->insert([
            0 => [
                'id' => 1,
                'name' => 'paypal',
                'created_at' => '2022-04-20 08:18:04',
                'updated_at' => '2022-04-20 08:18:04',
            ],
            1 => [
                'id' => 2,
                'name' => 'midtrans',
                'created_at' => '2022-04-20 08:18:04',
                'updated_at' => '2022-04-20 08:18:04',
            ],
        ]);
    }
}
