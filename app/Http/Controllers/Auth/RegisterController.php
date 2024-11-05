<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request; // Add this import
use Log;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'viber_number' => ['required', 'numeric', 'digits:11'],
            'role' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        Log::info('Registration data:', $data);
        return User::create([
            'username' => $data['username'],
            'name' => $data['name'],
            'email' => $data['email'],
            'viber_number' => $data['viber_number'],
            'role' => $data['role'],
            'password' => Hash::make($data['password']),
            'status' => 'unverified',
        ]);
    }

    /**
     * Handle a successful registration.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    protected function registered(Request $request, $user)
    {
        $this->guard()->logout(); // Log out the user
        $request->session()->invalidate(); // Invalidate the session

        // Flash a success message to the session
        $request->session()->flash('success', 'Your account has been created successfully please wait for you account to be verified.');

        // Redirect to the login page
        return redirect('/login');
    }
}
