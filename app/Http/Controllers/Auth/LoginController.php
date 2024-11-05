<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\User;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'username'; // Use 'username' instead of 'email' for authentication
    }

    /**
     * Override attemptLogin to prevent unverified users from logging in.
     *
     * @param Request $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        $user = User::where('username', $request->input('username'))->first();

        if ($user && $user->status === 'verified') {
            return $this->guard()->attempt(
                $this->credentials($request),
                $request->filled('remember')
            );
        }

        return false;
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        $user = User::where('username', $request->input('username'))->first();

        if ($user && $user->status !== 'verified') {
            return redirect()->back()
                ->withInput($request->only('username', 'remember'))
                ->withErrors(['username' => 'Your account is not verified.']);
        }

        return parent::sendFailedLoginResponse($request);
    }
}
