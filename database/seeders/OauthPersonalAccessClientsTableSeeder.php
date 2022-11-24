<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OauthPersonalAccessClientsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('oauth_personal_access_clients')->delete();

        DB::table('oauth_personal_access_clients')->insert([
            0 => [
                'client_id' => '9633c7db-4f09-4755-ba60-ad98fc27a412',
                'created_at' => '2022-05-02 02:36:45',
                'id' => 1,
                'updated_at' => '2022-05-02 02:36:45',
            ],
        ]);
    }
}
