<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Team;

class DropdownController extends Controller
{
    public function teamsIndex()
    {
        $teams = Team::all();
        return view('dropdown.teams', compact( 'teams'));
    }

    public function teamsAdd()
    {

    }

    public function teamsChangeStatus($id)
    {

    }













}
