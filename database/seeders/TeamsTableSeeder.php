<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeamsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('teams')->delete();

        DB::table('teams')->insert([
            0 => [
                'created_at' => null,
                'id' => 1,
                'name' => 'Test Team',
                'personal_team' => 1,
                'updated_at' => null,
                'user_id' => 13,
            ],
            1 => [
                'created_at' => null,
                'id' => 2,
                'name' => 'Test Team',
                'personal_team' => 1,
                'updated_at' => null,
                'user_id' => 11,
            ],
            2 => [
                'created_at' => null,
                'id' => 3,
                'name' => 'Test Team',
                'personal_team' => 1,
                'updated_at' => null,
                'user_id' => 1,
            ],
            3 => [
                'created_at' => '2022-05-19 08:04:14',
                'id' => 4,
                'name' => 'Test 2',
                'personal_team' => 0,
                'updated_at' => '2022-05-19 08:04:14',
                'user_id' => 1,
            ],
        ]);
    }
}
