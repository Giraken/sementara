<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminLevelPermissionsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin_level_permissions')->delete();

        DB::table('admin_level_permissions')->insert([
            0 => [
                'id' => -2,
                'permission' => 0,
                'table_name' => '{E6167E7F-C842-478D-A2C3-0C82486A6649}_tmp_subscriptions',
            ],
            1 => [
                'id' => -2,
                'permission' => 0,
                'table_name' => '{E6167E7F-C842-478D-A2C3-0C82486A6649}admin_level_permissions',
            ],
            2 => [
                'id' => -2,
                'permission' => 0,
                'table_name' => '{E6167E7F-C842-478D-A2C3-0C82486A6649}admin_levels',
            ],
            3 => [
                'id' => -2,
                'permission' => 0,
                'table_name' => '{E6167E7F-C842-478D-A2C3-0C82486A6649}admins',
            ],
            4 => [
                'id' => -2,
                'permission' => 0,
                'table_name' => '{E6167E7F-C842-478D-A2C3-0C82486A6649}billing_addresses',
            ],
            5 => [
                'id' => -2,
                'permission' => 0,
                'table_name' => '{E6167E7F-C842-478D-A2C3-0C82486A6649}contacts',
            ],
            6 => [
                'id' => -2,
                'permission' => 0,
                'table_name' => '{E6167E7F-C842-478D-A2C3-0C82486A6649}countries',
            ],
            7 => [
                'id' => -2,
                'permission' => 0,
                'table_name' => '{E6167E7F-C842-478D-A2C3-0C82486A6649}currencies',
            ],
            8 => [
                'id' => -2,
                'permission' => 0,
                'table_name' => '{E6167E7F-C842-478D-A2C3-0C82486A6649}customers',
            ],
            9 => [
                'id' => -2,
                'permission' => 0,
                'table_name' => '{E6167E7F-C842-478D-A2C3-0C82486A6649}dashboard.php',
            ],
            10 => [
                'id' => -2,
                'permission' => 0,
                'table_name' => '{E6167E7F-C842-478D-A2C3-0C82486A6649}domains',
            ],
            11 => [
                'id' => -2,
                'permission' => 0,
                'table_name' => '{E6167E7F-C842-478D-A2C3-0C82486A6649}failed_jobs',
            ],
            12 => [
                'id' => -2,
                'permission' => 0,
                'table_name' => '{E6167E7F-C842-478D-A2C3-0C82486A6649}invoice_items',
            ],
            13 => [
                'id' => -2,
                'permission' => 0,
                'table_name' => '{E6167E7F-C842-478D-A2C3-0C82486A6649}invoices',
            ],
            14 => [
                'id' => -2,
                'permission' => 0,
                'table_name' => '{E6167E7F-C842-478D-A2C3-0C82486A6649}ip_locations',
            ],
            15 => [
                'id' => -2,
                'permission' => 0,
                'table_name' => '{E6167E7F-C842-478D-A2C3-0C82486A6649}languages',
            ],
            16 => [
                'id' => -2,
                'permission' => 0,
                'table_name' => '{E6167E7F-C842-478D-A2C3-0C82486A6649}migrations',
            ],
            17 => [
                'id' => -2,
                'permission' => 0,
                'table_name' => '{E6167E7F-C842-478D-A2C3-0C82486A6649}oauth_access_tokens',
            ],
            18 => [
                'id' => -2,
                'permission' => 0,
                'table_name' => '{E6167E7F-C842-478D-A2C3-0C82486A6649}oauth_auth_codes',
            ],
            19 => [
                'id' => -2,
                'permission' => 0,
                'table_name' => '{E6167E7F-C842-478D-A2C3-0C82486A6649}oauth_clients',
            ],
            20 => [
                'id' => -2,
                'permission' => 0,
                'table_name' => '{E6167E7F-C842-478D-A2C3-0C82486A6649}oauth_personal_access_clients',
            ],
            21 => [
                'id' => -2,
                'permission' => 0,
                'table_name' => '{E6167E7F-C842-478D-A2C3-0C82486A6649}oauth_refresh_tokens',
            ],
            22 => [
                'id' => -2,
                'permission' => 0,
                'table_name' => '{E6167E7F-C842-478D-A2C3-0C82486A6649}password_resets',
            ],
            23 => [
                'id' => -2,
                'permission' => 0,
                'table_name' => '{E6167E7F-C842-478D-A2C3-0C82486A6649}plan_prices',
            ],
            24 => [
                'id' => -2,
                'permission' => 0,
                'table_name' => '{E6167E7F-C842-478D-A2C3-0C82486A6649}plans',
            ],
            25 => [
                'id' => -2,
                'permission' => 0,
                'table_name' => '{E6167E7F-C842-478D-A2C3-0C82486A6649}products',
            ],
            26 => [
                'id' => -2,
                'permission' => 0,
                'table_name' => '{E6167E7F-C842-478D-A2C3-0C82486A6649}sessions',
            ],
            27 => [
                'id' => -2,
                'permission' => 0,
                'table_name' => '{E6167E7F-C842-478D-A2C3-0C82486A6649}subscription_logs',
            ],
            28 => [
                'id' => -2,
                'permission' => 0,
                'table_name' => '{E6167E7F-C842-478D-A2C3-0C82486A6649}subscriptions',
            ],
            29 => [
                'id' => -2,
                'permission' => 0,
                'table_name' => '{E6167E7F-C842-478D-A2C3-0C82486A6649}team_invitations',
            ],
            30 => [
                'id' => -2,
                'permission' => 0,
                'table_name' => '{E6167E7F-C842-478D-A2C3-0C82486A6649}team_user',
            ],
            31 => [
                'id' => -2,
                'permission' => 0,
                'table_name' => '{E6167E7F-C842-478D-A2C3-0C82486A6649}teams',
            ],
            32 => [
                'id' => -2,
                'permission' => 0,
                'table_name' => '{E6167E7F-C842-478D-A2C3-0C82486A6649}tenants',
            ],
            33 => [
                'id' => -2,
                'permission' => 0,
                'table_name' => '{E6167E7F-C842-478D-A2C3-0C82486A6649}transactions',
            ],
            34 => [
                'id' => -2,
                'permission' => 0,
                'table_name' => '{E6167E7F-C842-478D-A2C3-0C82486A6649}users',
            ],
            35 => [
                'id' => -2,
                'permission' => 0,
                'table_name' => '{E6167E7F-C842-478D-A2C3-0C82486A6649}websockets_statistics_entries',
            ],
        ]);
    }
}
