<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminLevelsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin_levels')->delete();

        DB::table('admin_levels')->insert([
            0 => [
                'admin_level_name' => 'Anonymous',
                'id' => -2,
            ],
            1 => [
                'admin_level_name' => 'Administrator',
                'id' => -1,
            ],
            2 => [
                'admin_level_name' => 'Default',
                'id' => 0,
            ],
        ]);
    }
}
