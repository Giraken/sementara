<?php

namespace App\Http\Controllers;

class TeamController extends Controller
{
    public function show()
    {
        return view('teams.list');
    }
}
