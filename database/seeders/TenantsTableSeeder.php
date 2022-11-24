<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TenantsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('tenants')->delete();

        DB::table('tenants')->insert([
            0 => [
                'created_at' => '2022-05-01 13:54:58',
                'data' => '{"updated_at":"2022-04-30 14:56:20","created_at":"2022-04-30 14:56:20","identifier":"testid","tenancy_db_name":"egisto_test"}',
                'id' => 'test',
                'identifier' => 'testid',
                'product_id' => 1,
                'status' => 0,
                'updated_at' => '2022-05-01 13:54:58',
            ],
        ]);
    }
}
