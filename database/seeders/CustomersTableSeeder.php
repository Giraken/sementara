<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomersTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('customers')->delete();

        DB::table('customers')->insert([
            0 => [
                'auto_billing_data' => null,
                'cache' => null,
                'color_scheme' => null,
                'contact_id' => null,
                'created_at' => '2022-04-20 08:18:04',
                'id' => 1,
                'language_id' => 1,
                'menu_layout' => 'left',
                'payment_method' => null,
                'quota' => null,
                'status' => 'active',
                'text_direction' => 'ltr',
                'theme_mode' => 'light',
                'timezone' => 'America/Miquelon',
                'updated_at' => '2022-04-20 08:18:04',
                'uuid' => '',
            ],
            1 => [
                'auto_billing_data' => null,
                'cache' => null,
                'color_scheme' => null,
                'contact_id' => null,
                'created_at' => '2022-04-20 08:18:04',
                'id' => 11,
                'language_id' => 1,
                'menu_layout' => 'left',
                'payment_method' => null,
                'quota' => null,
                'status' => 'active',
                'text_direction' => 'ltr',
                'theme_mode' => 'light',
                'timezone' => 'America/Miquelon',
                'updated_at' => '2022-04-20 08:18:04',
                'uuid' => '',
            ]
        ]);
    }
}
