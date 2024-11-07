<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class TestController extends Controller
{
    public function userIndex()
    {
        $users = User::all();  // or User::get() as both work similarly

        // Pass the users collection to the view
        return view('testblades.testuserindex', compact('users'));
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);  // Return user data as JSON
    }
}
