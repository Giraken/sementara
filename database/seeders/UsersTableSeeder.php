<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        DB::table('users')->insert([
            0 => [
                'created_at' => '2022-04-30 17:14:30',
                'current_team_id' => 3,
                'customer_id' => null,
                'email' => 'rernser@example.org',
                'email_verified_at' => '2022-04-30 17:14:30',
                'facebook_id' => null,
                'facebook_refresh_token' => null,
                'facebook_token' => null,
                'google_id' => null,
                'google_refresh_token' => null,
                'google_token' => null,
                'id' => 1,
                'name' => 'Lonie Cruickshank IV',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'profile_photo_path' => 'profile-photos/II4xLkhJwAGjj7rbpzykiFvVs2A3yc2BzhmVMiNK.jpg',
                'remember_token' => 'KtfzsCsY0E',
                'two_factor_confirmed_at' => null,
                'two_factor_recovery_codes' => null,
                'two_factor_secret' => null,
                'updated_at' => '2022-05-19 08:04:43',
                'uuid' => null,
            ],
            1 => [
                'created_at' => '2022-04-30 17:14:30',
                'current_team_id' => null,
                'customer_id' => null,
                'email' => 'zboncak.may@example.org',
                'email_verified_at' => '2022-04-30 17:14:30',
                'facebook_id' => null,
                'facebook_refresh_token' => null,
                'facebook_token' => null,
                'google_id' => null,
                'google_refresh_token' => null,
                'google_token' => null,
                'id' => 2,
                'name' => 'Dr. Jaiden Dare III',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'profile_photo_path' => null,
                'remember_token' => 'lIbNKRHAKT',
                'two_factor_confirmed_at' => null,
                'two_factor_recovery_codes' => null,
                'two_factor_secret' => null,
                'updated_at' => '2022-04-30 17:14:30',
                'uuid' => null,
            ],
            2 => [
                'created_at' => '2022-04-30 17:14:30',
                'current_team_id' => null,
                'customer_id' => null,
                'email' => 'lpollich@example.com',
                'email_verified_at' => '2022-04-30 17:14:30',
                'facebook_id' => null,
                'facebook_refresh_token' => null,
                'facebook_token' => null,
                'google_id' => null,
                'google_refresh_token' => null,
                'google_token' => null,
                'id' => 3,
                'name' => 'Darrel Marquardt',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'profile_photo_path' => null,
                'remember_token' => 'PBcyt1gsi3',
                'two_factor_confirmed_at' => null,
                'two_factor_recovery_codes' => null,
                'two_factor_secret' => null,
                'updated_at' => '2022-04-30 17:14:30',
                'uuid' => null,
            ],
            3 => [
                'created_at' => '2022-04-30 17:14:30',
                'current_team_id' => null,
                'customer_id' => null,
                'email' => 'joshuah.kessler@example.org',
                'email_verified_at' => '2022-04-30 17:14:30',
                'facebook_id' => null,
                'facebook_refresh_token' => null,
                'facebook_token' => null,
                'google_id' => null,
                'google_refresh_token' => null,
                'google_token' => null,
                'id' => 4,
                'name' => 'Mrs. Gudrun Hintz',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'profile_photo_path' => null,
                'remember_token' => 'H8Zzq23crC',
                'two_factor_confirmed_at' => null,
                'two_factor_recovery_codes' => null,
                'two_factor_secret' => null,
                'updated_at' => '2022-04-30 17:14:30',
                'uuid' => null,
            ],
            4 => [
                'created_at' => '2022-04-30 17:14:30',
                'current_team_id' => null,
                'customer_id' => null,
                'email' => 'tgerlach@example.net',
                'email_verified_at' => '2022-04-30 17:14:30',
                'facebook_id' => null,
                'facebook_refresh_token' => null,
                'facebook_token' => null,
                'google_id' => null,
                'google_refresh_token' => null,
                'google_token' => null,
                'id' => 5,
                'name' => 'Mr. Moriah Gottlieb Jr.',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'profile_photo_path' => null,
                'remember_token' => 'yHkWTp9qHC',
                'two_factor_confirmed_at' => null,
                'two_factor_recovery_codes' => null,
                'two_factor_secret' => null,
                'updated_at' => '2022-04-30 17:14:30',
                'uuid' => null,
            ],
            5 => [
                'created_at' => '2022-04-30 17:14:30',
                'current_team_id' => null,
                'customer_id' => null,
                'email' => 'okautzer@example.org',
                'email_verified_at' => '2022-04-30 17:14:30',
                'facebook_id' => null,
                'facebook_refresh_token' => null,
                'facebook_token' => null,
                'google_id' => null,
                'google_refresh_token' => null,
                'google_token' => null,
                'id' => 6,
                'name' => 'Mr. Finn Beer I',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'profile_photo_path' => null,
                'remember_token' => 'SuWRphP3eq',
                'two_factor_confirmed_at' => null,
                'two_factor_recovery_codes' => null,
                'two_factor_secret' => null,
                'updated_at' => '2022-04-30 17:14:30',
                'uuid' => null,
            ],
            6 => [
                'created_at' => '2022-04-30 17:14:30',
                'current_team_id' => null,
                'customer_id' => null,
                'email' => 'elwin72@example.com',
                'email_verified_at' => '2022-04-30 17:14:30',
                'facebook_id' => null,
                'facebook_refresh_token' => null,
                'facebook_token' => null,
                'google_id' => null,
                'google_refresh_token' => null,
                'google_token' => null,
                'id' => 7,
                'name' => 'Brett Ritchie',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'profile_photo_path' => null,
                'remember_token' => 'WpXXw5Ndb3',
                'two_factor_confirmed_at' => null,
                'two_factor_recovery_codes' => null,
                'two_factor_secret' => null,
                'updated_at' => '2022-04-30 17:14:30',
                'uuid' => null,
            ],
            7 => [
                'created_at' => '2022-04-30 17:14:30',
                'current_team_id' => null,
                'customer_id' => null,
                'email' => 'fcrona@example.org',
                'email_verified_at' => '2022-04-30 17:14:30',
                'facebook_id' => null,
                'facebook_refresh_token' => null,
                'facebook_token' => null,
                'google_id' => null,
                'google_refresh_token' => null,
                'google_token' => null,
                'id' => 8,
                'name' => 'Stacey Ratke',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'profile_photo_path' => null,
                'remember_token' => 'j9Doyh2CKs',
                'two_factor_confirmed_at' => null,
                'two_factor_recovery_codes' => null,
                'two_factor_secret' => null,
                'updated_at' => '2022-04-30 17:14:30',
                'uuid' => null,
            ],
            8 => [
                'created_at' => '2022-04-30 17:14:30',
                'current_team_id' => null,
                'customer_id' => null,
                'email' => 'fisher.haleigh@example.net',
                'email_verified_at' => '2022-04-30 17:14:30',
                'facebook_id' => null,
                'facebook_refresh_token' => null,
                'facebook_token' => null,
                'google_id' => null,
                'google_refresh_token' => null,
                'google_token' => null,
                'id' => 9,
                'name' => 'Miss Raquel Okuneva I',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'profile_photo_path' => null,
                'remember_token' => 'mmqjpguC3T',
                'two_factor_confirmed_at' => null,
                'two_factor_recovery_codes' => null,
                'two_factor_secret' => null,
                'updated_at' => '2022-04-30 17:14:30',
                'uuid' => null,
            ],
            9 => [
                'created_at' => '2022-04-30 17:14:30',
                'current_team_id' => null,
                'customer_id' => null,
                'email' => 'klangworth@example.com',
                'email_verified_at' => '2022-04-30 17:14:30',
                'facebook_id' => null,
                'facebook_refresh_token' => null,
                'facebook_token' => null,
                'google_id' => null,
                'google_refresh_token' => null,
                'google_token' => null,
                'id' => 10,
                'name' => 'Cordia Hammes I',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'profile_photo_path' => null,
                'remember_token' => 'lESOr2wJoV',
                'two_factor_confirmed_at' => null,
                'two_factor_recovery_codes' => null,
                'two_factor_secret' => null,
                'updated_at' => '2022-04-30 17:14:30',
                'uuid' => null,
            ],
            10 => [
                'created_at' => '2022-05-01 14:22:45',
                'current_team_id' => 2,
                'customer_id' => null,
                'email' => 'admin@example.com',
                'email_verified_at' => '2022-05-01 14:22:38',
                'facebook_id' => null,
                'facebook_refresh_token' => null,
                'facebook_token' => null,
                'google_id' => null,
                'google_refresh_token' => null,
                'google_token' => null,
                'id' => 11,
                'name' => 'Admin',
                'password' => '$2y$10$CI8pqbv5bb15jISqhKXROu2O6KNePYXvFzt.v9zua484kRe5ABG/W',
                'profile_photo_path' => null,
                'remember_token' => 'bK6Mtim0aWPViQNw7sqooeRgOjndPcWuUSSA770nUHhtO8Pvtj7OKdmFKYRi',
                'two_factor_confirmed_at' => null,
                'two_factor_recovery_codes' => null,
                'two_factor_secret' => null,
                'updated_at' => '2022-05-19 07:40:34',
                'uuid' => '123qwe',
            ],
            11 => [
                'created_at' => '2022-04-30 21:15:34',
                'current_team_id' => null,
                'customer_id' => null,
                'email' => 'test@example.com',
                'email_verified_at' => '2022-05-01 15:32:29',
                'facebook_id' => null,
                'facebook_refresh_token' => null,
                'facebook_token' => null,
                'google_id' => null,
                'google_refresh_token' => null,
                'google_token' => null,
                'id' => 12,
                'name' => 'Admin',
                'password' => '$2y$10$z26u.JVz4VrxFEPXgKsYWuFkgtzNS2lqL3Wx44E6lVjTxQT4zpX02',
                'profile_photo_path' => null,
                'remember_token' => null,
                'two_factor_confirmed_at' => null,
                'two_factor_recovery_codes' => null,
                'two_factor_secret' => null,
                'updated_at' => '2022-04-30 21:15:34',
                'uuid' => null,
            ],
            12 => [
                'created_at' => '2022-04-30 21:44:26',
                'current_team_id' => null,
                'customer_id' => null,
                'email' => 'clientx@example.com',
                'email_verified_at' => null,
                'facebook_id' => null,
                'facebook_refresh_token' => null,
                'facebook_token' => null,
                'google_id' => null,
                'google_refresh_token' => null,
                'google_token' => null,
                'id' => 13,
                'name' => 'TestClient',
                'password' => '$2y$10$1dNMlIegW.cJUs1QsqNDjulOf7oh2.ez2IFlanKfK1txw1A4M1uhS',
                'profile_photo_path' => null,
                'remember_token' => null,
                'two_factor_confirmed_at' => null,
                'two_factor_recovery_codes' => null,
                'two_factor_secret' => null,
                'updated_at' => '2022-04-30 22:10:35',
                'uuid' => null,
            ],
            13 => [
                'created_at' => '2022-05-01 14:22:45',
                'current_team_id' => null,
                'customer_id' => null,
                'email' => 'employee@example.com',
                'email_verified_at' => '2022-05-01 14:22:38',
                'facebook_id' => null,
                'facebook_refresh_token' => null,
                'facebook_token' => null,
                'google_id' => null,
                'google_refresh_token' => null,
                'google_token' => null,
                'id' => 14,
                'name' => 'Admin',
                'password' => '$2y$10$CI8pqbv5bb15jISqhKXROu2O6KNePYXvFzt.v9zua484kRe5ABG/W',
                'profile_photo_path' => null,
                'remember_token' => null,
                'two_factor_confirmed_at' => null,
                'two_factor_recovery_codes' => null,
                'two_factor_secret' => null,
                'updated_at' => '2022-05-01 14:22:45',
                'uuid' => null,
            ],
        ]);
    }
}
