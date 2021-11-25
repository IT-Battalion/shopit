<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LdapRecord\Laravel\Auth\ListensForLdapBindFailure;

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

    use ListensForLdapBindFailure, ApiResponder;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            return $this->success([
                'redirect_to' => $this->redirectTo,
                'username' => Auth::user()->username,
                'name' => Auth::user()->name,
                'firstname' => Auth::user()->firstname,
                'lastname' => Auth::user()->lastname,
                'email' => Auth::user()->email,
                'employeeType' => Auth::user()->employeeType,
                'class' => Auth::user()->class,
                'lang' => Auth::user()->lang,
                'isAdmin' => Auth::user()->isAdmin,
            ], 'Successfully authenticated');
        }

        return $this->error(401, 'Username or password are invalid');
    }
}
