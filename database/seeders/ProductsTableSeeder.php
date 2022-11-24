<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->delete();

        DB::table('products')->insert([
            0 => [
                'created_at' => null,
                'data' => null,
                'description' => 'Egisto',
                'domain' => null,
                'id' => 1,
                'uuid' => '908f7efb-5f60-41b4-82ff-f03b873db10d',
                'is_trialable' => 1,
                'is_visible' => 1,
                'logo' => 'logo.png',
                'name' => 'Egisto',
                'status' => 'active',
                'updated_at' => null,
            ],
            1 => [
                'created_at' => null,
                'data' => null,
                'description' => 'Mairu',
                'domain' => null,
                'id' => 2,
                'uuid' => '62a980e2-aae3-4b61-9a8d-37e941dc6c20',
                'is_trialable' => 1,
                'is_visible' => 1,
                'logo' => 'logo.png',
                'name' => 'Mairu',
                'status' => 'inactive',
                'updated_at' => null,
            ],
        ]);
    }
}
