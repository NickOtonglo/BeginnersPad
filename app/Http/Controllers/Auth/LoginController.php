<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function credentials(\Illuminate\Http\Request $request)
    {
        // if (Auth::attempt(['email' => $email, 'password' => $password, 'status'=>'active'])) {
        //     return redirect('/');
        // } else if (Auth::attempt(['email' => $email, 'password' => $password, 'status'=>'inactive'])) {
        //     Auth::logout();
        //     return redirect('/login')->with('error_login','Sorry, your account is pending activation by the system administrator.');
        // } else if (Auth::attempt(['email' => $email, 'password' => $password, 'status'=>'suspended'])) {
        //     Auth::logout();
        //     return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
        // }
        return ['email' => $request->{$this->username()}, 'password' => $request->password, 'status' => 'active'];
    }

    // public function login(\Illuminate\Http\Request $request) {
    //     $this->validateLogin($request);

    //     if ($this->hasTooManyLoginAttempts($request)) {
    //         $this->fireLockoutEvent($request);
    //         return $this->sendLockoutResponse($request);
    //     }

    //     if ($this->guard()->validate($this->credentials($request))) {
    //         $user = $this->guard()->getLastAttempted();

    //         if ($user->active && $this->attemptLogin($request)) {
    //             return $this->sendLoginResponse($request);
    //         } else {
                
    //             $this->incrementLoginAttempts($request);
    //             return redirect()
    //                 ->back()
    //                 ->withInput($request->only($this->username(), 'remember'))
    //                 ->withErrors(['active' => 'You must be active to login.']);
    //         }
    //     }

    //     $this->incrementLoginAttempts($request);

    //     return $this->sendFailedLoginResponse($request);
    // }
}
