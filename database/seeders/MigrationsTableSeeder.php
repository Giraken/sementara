<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MigrationsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('migrations')->delete();

        DB::table('migrations')->insert([
            0 => [
                'batch' => 1,
                'id' => 1,
                'migration' => '2014_10_12_000000_create_users_table',
            ],
            1 => [
                'batch' => 1,
                'id' => 2,
                'migration' => '2014_10_12_100000_create_password_resets_table',
            ],
            2 => [
                'batch' => 1,
                'id' => 3,
                'migration' => '2014_10_12_200000_add_two_factor_columns_to_users_table',
            ],
            3 => [
                'batch' => 1,
                'id' => 4,
                'migration' => '2016_06_01_000001_create_oauth_auth_codes_table',
            ],
            4 => [
                'batch' => 1,
                'id' => 5,
                'migration' => '2016_06_01_000002_create_oauth_access_tokens_table',
            ],
            5 => [
                'batch' => 1,
                'id' => 6,
                'migration' => '2016_06_01_000003_create_oauth_refresh_tokens_table',
            ],
            6 => [
                'batch' => 1,
                'id' => 7,
                'migration' => '2016_06_01_000004_create_oauth_clients_table',
            ],
            7 => [
                'batch' => 1,
                'id' => 8,
                'migration' => '2016_06_01_000005_create_oauth_personal_access_clients_table',
            ],
            8 => [
                'batch' => 1,
                'id' => 9,
                'migration' => '2019_08_19_000000_create_failed_jobs_table',
            ],
            9 => [
                'batch' => 1,
                'id' => 10,
                'migration' => '2019_09_15_000010_create_tenants_table',
            ],
            10 => [
                'batch' => 1,
                'id' => 11,
                'migration' => '2019_09_15_000020_create_domains_table',
            ],
            11 => [
                'batch' => 1,
                'id' => 12,
                'migration' => '2020_05_21_100000_create_teams_table',
            ],
            12 => [
                'batch' => 1,
                'id' => 13,
                'migration' => '2020_05_21_200000_create_team_user_table',
            ],
            13 => [
                'batch' => 1,
                'id' => 14,
                'migration' => '2020_05_21_300000_create_team_invitations_table',
            ],
            14 => [
                'batch' => 1,
                'id' => 15,
                'migration' => '2022_04_18_225416_create_sessions_table',
            ],
            15 => [
                'batch' => 2,
                'id' => 16,
                'migration' => '2022_03_28_131018_add_client_passport',
            ],
            16 => [
                'batch' => 3,
                'id' => 17,
                'migration' => '0000_00_00_000000_create_websockets_statistics_entries_table',
            ],
        ]);
    }
}
