<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrenciesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('currencies')->delete();

        DB::table('currencies')->insert([
            0 => [
                'admin_id' => null,
                'code' => 'USD',
                'created_at' => '2022-04-20 08:18:04',
                'format' => '${PRICE}',
                'id' => 1,
                'name' => 'US Dollar',
                'status' => 'active',
                'updated_at' => '2022-04-20 08:18:04',
            ],
            1 => [
                'admin_id' => null,
                'code' => 'IDR',
                'created_at' => '2022-04-20 08:18:04',
                'format' => 'IDR {PRICE}',
                'id' => 2,
                'name' => 'Rupiah',
                'status' => 'active',
                'updated_at' => '2022-04-20 08:18:04',
            ],
        ]);
    }
}
