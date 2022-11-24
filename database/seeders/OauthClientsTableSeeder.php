<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OauthClientsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('oauth_clients')->delete();

        DB::table('oauth_clients')->insert([
            0 => [
                'created_at' => '2022-04-30 16:35:16',
                'id' => '9630edc3-5d9f-44fa-a811-c3a9ea0c6bc2',
                'name' => 'Bee Mata Indonesia Password Grant Client',
                'password_client' => 1,
                'personal_access_client' => 0,
                'provider' => 'users',
                'redirect' => 'http://localhost',
                'revoked' => 0,
                'secret' => 'YD0dswJQfYMoOGnWyd7h65CPMaRnhWnlLwhZYWXh',
                'updated_at' => '2022-04-30 16:35:16',
                'user_id' => null,
            ],
        ]);
    }
}
