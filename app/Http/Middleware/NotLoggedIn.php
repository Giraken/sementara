<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class NotLoggedIn
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
//        $default_language = \Acelle\Models\Language::find(\Acelle\Models\Setting::get('default_language'));
//        if (isset($_COOKIE['last_language_code'])) {
//            $language_code = $_COOKIE['last_language_code'];
//        } elseif (is_object($default_language)) {
//            $language_code = $default_language->code;
//        } else {
//            $language_code = 'en';
//        }
//
//        // Language
//        try {
//            if ($language_code) {
//                \App::setLocale($language_code);
//                \Carbon\Carbon::setLocale($language_code);
//            }
//        } catch (\Exception $e) {
//        }
        return $next($request);
    }
}
