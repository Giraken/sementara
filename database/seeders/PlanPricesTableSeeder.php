<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PlanPricesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('plan_prices')->delete();

        Schema::disableForeignKeyConstraints();
        DB::table('plan_prices')->insert([
            0 => [
                'id' => 1,
                'plan_id' => 1,
                'currency_id' => 1,
                'price' => 50,
                'price_per_set' => 10,
                'created_at' => '2022-04-20 08:18:04',
                'updated_at' => '2022-04-20 08:18:04',
            ],
            1 => [
                'id' => 2,
                'plan_id' => 1,
                'currency_id' => 2,
                'price' => 500000,
                'price_per_set' => 250000,
                'created_at' => '2022-04-20 08:18:04',
                'updated_at' => '2022-04-20 08:18:04',
            ],
        ]);
        Schema::enableForeignKeyConstraints();
    }
}
