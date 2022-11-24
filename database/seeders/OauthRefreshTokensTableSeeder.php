<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OauthRefreshTokensTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('oauth_refresh_tokens')->delete();

        DB::table('oauth_refresh_tokens')->insert([
            0 => [
                'access_token_id' => '8eb4e88bb8c132eacfa8d4b420365f159c0cc91874acf7ed949080bb6d969501e151b653d920d2dc',
                'expires_at' => '2022-05-31 02:14:58',
                'id' => '2673629d0cee13c7be91f31622d19d5028dd2c3cb2e8719fd84a75b089f74d8d69936778dbaf0ab6',
                'revoked' => 0,
            ],
            1 => [
                'access_token_id' => '12cd31cfa5ae4cf930860b711721002a4244272538b0fa3ab7a72494972339f35ac41c18476fb07d',
                'expires_at' => '2022-05-31 02:22:48',
                'id' => '41ce24b321b5f9a6d3bd05f99d0b4950e97dd0d196402f12b9b5995b4e17265019d855dd841c7bd5',
                'revoked' => 0,
            ],
        ]);
    }
}
