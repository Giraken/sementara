<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OauthAccessTokensTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('oauth_access_tokens')->delete();

        DB::table('oauth_access_tokens')->insert([
            0 => [
                'client_id' => '9630edc3-5d9f-44fa-a811-c3a9ea0c6bc2',
                'created_at' => '2022-04-30 17:22:48',
                'expires_at' => '2022-05-16 02:22:48',
                'id' => '12cd31cfa5ae4cf930860b711721002a4244272538b0fa3ab7a72494972339f35ac41c18476fb07d',
                'name' => null,
                'revoked' => 0,
                'scopes' => '[]',
                'updated_at' => '2022-04-30 17:22:48',
                'user_id' => 1,
            ],
            1 => [
                'client_id' => '9630edc3-5d9f-44fa-a811-c3a9ea0c6bc2',
                'created_at' => '2022-04-30 17:14:58',
                'expires_at' => '2022-05-16 02:14:58',
                'id' => '8eb4e88bb8c132eacfa8d4b420365f159c0cc91874acf7ed949080bb6d969501e151b653d920d2dc',
                'name' => null,
                'revoked' => 0,
                'scopes' => '[]',
                'updated_at' => '2022-04-30 17:14:58',
                'user_id' => 1,
            ],
        ]);
    }
}
