<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SubscriptionsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('subscriptions')->delete();

        // turn off foreign key check for this connection before running seeders
        Schema::disableForeignKeyConstraints();
        // DB::table('subscriptions')->insert([
        //     0 => [
        //         'created_at' => '2022-05-08 03:40:28',
        //         'currency_id' => null,
        //         'current_payment_service_provider_id' => 1,
        //         'current_period_ends_at' => '2025-05-01 12:40:06',
        //         'customer_id' => 13,
        //         'ends_at' => '2022-05-08 12:40:24',
        //         'id' => 1,
        //         'last_period_ends_at' => '2022-05-08 12:40:31',
        //         'plan_id' => 1,
        //         'started_at' => '2022-05-08 12:40:30',
        //         'status' => 'active',
        //         'tenant_id' => 'test',
        //         'trial_ends_at' => '2022-05-08 03:40:23',
        //         'updated_at' => '2022-05-08 03:40:29',
        //         'uuid' => '',
        //     ],
        // ]);
        Schema::enableForeignKeyConstraints();
    }
}
