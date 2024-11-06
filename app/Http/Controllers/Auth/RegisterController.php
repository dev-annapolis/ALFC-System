<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request; // Add this import
use Log;
use App\Models\Role; // Import the Role model

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        // Fetch roles from the database
        $roles = Role::select('id', 'view_name')->get();

        Log::info('Roles loaded:', $roles->toArray()); // Log the roles array

        // Pass roles to the view
        return view('auth.register', compact('roles'));
    }
    protected function validator(array $data)
    {
        Log::info('Validator started. Data received:', $data);

        $validator = Validator::make($data, [
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'viber_number' => ['required', 'numeric', 'digits:11'],
            'role_id' => ['required', 'integer'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            Log::error('Validation failed:', $validator->errors()->toArray());
            throw new \Exception('Validation failed.');
        }

        return $validator; // Ensure it returns the validator if no issues
    }

    protected function create(array $data)
    {
        try {
            Log::info('Registration data:', $data);

            $user = User::create([
                'username' => $data['username'],
                'name' => $data['name'],
                'email' => $data['email'],
                'viber_number' => $data['viber_number'],
                'role_id' => $data['role_id'],
                'password' => Hash::make($data['password']),
                'status' => 'unverified',
            ]);

            Log::info('User created successfully: User ID ' . $user->id);
            return $user;
        } catch (\Exception $e) {
            Log::error('Error creating user: ' . $e->getMessage());
            throw $e; // Re-throw exception for further handling if needed
        }
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
