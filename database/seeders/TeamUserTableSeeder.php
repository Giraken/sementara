<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeamUserTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('team_user')->delete();

        DB::table('team_user')->insert([
            0 => [
                'created_at' => '2022-05-07 23:00:05',
                'id' => 1,
                'role' => 'admin',
                'team_id' => 1,
                'updated_at' => '2022-05-07 23:00:06',
                'user_id' => 13,
            ],
            1 => [
                'created_at' => '2022-05-07 23:00:05',
                'id' => 2,
                'role' => 'admin',
                'team_id' => 2,
                'updated_at' => '2022-05-07 23:00:06',
                'user_id' => 11,
            ],
            2 => [
                'created_at' => '2022-05-07 23:00:05',
                'id' => 3,
                'role' => 'admin',
                'team_id' => 3,
                'updated_at' => '2022-05-07 23:00:06',
                'user_id' => 1,
            ],
        ]);
    }
}
