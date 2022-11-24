<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function guest(Request $request)
    {
        return response()->view('store.guest');
    }

    public function selectApp(Request $request)
    {
        return view('apps.select-app', []);
    }

    public function selectPlan(Request $request)
    {
        return view('apps.select-plan', []);
    }
}
