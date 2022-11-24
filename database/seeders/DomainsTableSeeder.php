<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DomainsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('domains')->delete();

        DB::table('domains')->insert([
            0 => [
                'created_at' => '2022-05-01 13:55:58',
                'domain' => 'test.dev.local',
                'id' => 1,
                'status' => 'enabled',
                'tenant_id' => 'test',
                'updated_at' => '2022-05-01 13:55:59',
            ],
        ]);
    }
}
