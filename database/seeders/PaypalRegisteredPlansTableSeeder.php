<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PaypalRegisteredPlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('paypal_registered_plans')->delete();

        Schema::disableForeignKeyConstraints();
        DB::table('paypal_registered_plans')->insert([
            0 => [
                'id' => 1,
                'assigned_paypal_plan_id' => 'P-2V163051PB316634LMLO7UBA',
                'is_active' => true,
                'plan_price_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
        Schema::enableForeignKeyConstraints();
    }
}
