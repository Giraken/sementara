<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguagesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('languages')->delete();

        DB::table('languages')->insert([
            0 => [
                'code' => 'en',
                'created_at' => '2016-07-10 00:44:17',
                'id' => 1,
                'is_default' => 1,
                'name' => 'English',
                'region_code' => 'us',
                'status' => 'active',
                'updated_at' => '2016-07-10 00:44:17',
            ],
            1 => [
                'code' => 'es',
                'created_at' => '2016-07-10 00:44:17',
                'id' => 2,
                'is_default' => 0,
                'name' => 'Spanish',
                'region_code' => 'es',
                'status' => 'active',
                'updated_at' => '2016-07-10 00:44:17',
            ],
            2 => [
                'code' => 'pt',
                'created_at' => '2022-04-20 08:17:57',
                'id' => 3,
                'is_default' => 0,
                'name' => 'Portuguese',
                'region_code' => 'pt',
                'status' => 'active',
                'updated_at' => '2022-04-20 08:17:57',
            ],
            3 => [
                'code' => 'de',
                'created_at' => '2022-04-20 08:17:57',
                'id' => 4,
                'is_default' => 0,
                'name' => 'German',
                'region_code' => 'de',
                'status' => 'active',
                'updated_at' => '2022-04-20 08:17:57',
            ],
            4 => [
                'code' => 'ja',
                'created_at' => '2022-04-20 08:18:01',
                'id' => 5,
                'is_default' => 0,
                'name' => '日本語 (Japanese)',
                'region_code' => 'ja',
                'status' => 'active',
                'updated_at' => '2022-04-20 08:18:01',
            ],
        ]);
    }
}
