<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->delete();

        DB::table('admins')->insert([
            0 => [
                'admin_level_id' => -1,
                'created_at' => null,
                'email' => 'asd',
                'id' => 1,
                'is_active' => 1,
                'last_activity_at' => null,
                'password' => '$2y$10$Q5bygvt.XZwUtzNjZY5g.ePaSRhzYEDjRyn6oFpIPDiGjHpOPUyIi',
                'profile' => null,
                'username' => 'asd',
            ],
        ]);
    }
}
