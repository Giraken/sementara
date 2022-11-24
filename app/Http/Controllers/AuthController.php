<?php

namespace App\Http\Controllers;

use Acelle\Models\User;
use Auth;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    /**
     * Check if the user is not authorized.
     *
     * @return Response
     */
    public function notAuthorized()
    {
        if (request()->ajax()) {
            return response()->json(['message' => trans('messages.not_authorized_message')], 403);
        }

        return response()->view('notAuthorized')->setStatusCode(403);
    }

    /**
     * Check if the user cannot create more item.
     *
     * @return Response
     */
    public function noMoreItem()
    {
        return view('noMoreItem');
    }

    /**
     * When site status is offline.
     *
     * @return Response
     */
    public function offline()
    {
        return view('offline');
    }

    /**
     * Login from outsite.
     *
     * @param mixed $api_token
     * @return Response
     */
    public function autoLogin($api_token)
    {
        $user = User::where('api_token', $api_token)->first();

        Auth::login($user);

        return redirect()->action('HomeController@index');
    }

    public function validateToken($api_token)
    {
        $valid = is_object(User::where('api_token', $api_token)->first());

        if ($valid) {
            return response()
                ->json([
                    'status' => 'success',
                ], 200);
        } else {
            return response()
                ->json([
                    'status' => 'failed',
                ], 401);
        }
    }

    /**
     * Login from outsite.
     *
     * @param mixed $token
     * @return Response
     */
    public function tokenLogin($token)
    {
        $user = User::where('one_time_api_token', $token)->first();

        if (!$user) {
            return view('somethingWentWrong', ['message' => trans('messages.token_expired')]);
        }

        Auth::login($user);
        $user->clearOneTimeToken();

        return redirect()->action('HomeController@index');
    }

    /**
     * When user is diabled.
     *
     * @return Response
     */
    public function userDisabled()
    {
        Auth::logout();

        return view('isDisabled');
    }

    public function appkey()
    {
        echo get_app_identity();
    }

    public function termsOfService()
    {
        return view('termsOfService');
    }
}
