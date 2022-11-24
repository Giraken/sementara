<?php

use Laravel\Passport\Passport;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'prefix' => 'v1',
], function () {
    Route::group([
        'middleware' => [
            'auth:api',
        ],
    ], function () {
        Route::get('public_profile', function () {
            $user = auth()->user();

            return response()->json([
                'name' => $user->name,
                'email' => $user->email,
                'profile_photo_url' => $user->profile_photo_url,
            ]);
        });
    });

    Passport::routes();
});
