<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlansTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('plans')->delete();

        DB::table('plans')->insert([
            0 => [
                'created_at' => '2017-03-06 04:33:12',
                'description' => 'All the basics for businesses or individual to get started with email marketing',
                'frequency_amount' => 1,
                'frequency_unit' => 'month',
                'id' => 1,
                'uuid' => 'abac2f37-6ac5-41f5-842a-28771bc612f1',
                'is_visible' => 1,
                'name' => 'Free',
                'product_id' => 1,
                'seat_max' => -1,
                'status' => 'active',
                'updated_at' => '2020-01-13 22:59:58',
            ],
            1 => [
                'created_at' => '2019-06-05 10:52:09',
                'description' => 'Must-have features for marketing agency & individual to engage in email marketing',
                'frequency_amount' => 1,
                'frequency_unit' => 'month',
                'id' => 2,
                'uuid' => '62a980e2-aae3-4b61-9a8d-37e941dc6c20',
                'is_visible' => 0,
                'name' => 'Essentials',
                'product_id' => 1,
                'seat_max' => -1,
                'status' => 'active',
                'updated_at' => '2020-01-13 23:00:12',
            ],
            2 => [
                'created_at' => '2017-03-06 04:33:12',
                'description' => 'Powerful statistics & insight report for maximized sales & marketing performance',
                'frequency_amount' => 1,
                'frequency_unit' => 'month',
                'id' => 3,
                'uuid' => '188b4a0a-c3ca-4796-8d1e-75f43fa12c9a',
                'is_visible' => 0,
                'name' => 'Standard',
                'product_id' => 1,
                'seat_max' => -1,
                'status' => 'active',
                'updated_at' => '2020-01-13 23:01:05',
            ],
            3 => [
                'created_at' => '2017-03-06 04:43:09',
                'description' => 'Advanced features for professionals who need unlimited marketing capability',
                'frequency_amount' => 1,
                'frequency_unit' => 'month',
                'id' => 4,
                'uuid' => '7ca5d835-ab7c-41cf-9184-7a2622abd767',
                'is_visible' => 0,
                'name' => 'Premium',
                'product_id' => 1,
                'seat_max' => -1,
                'status' => 'active',
                'updated_at' => '2020-01-13 23:01:32',
            ],
        ]);
    }
}
