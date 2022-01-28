<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
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

    use ListensForLdapBindFailure;

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
        $data = $request->validate([
            'username' => 'required',
            'password' => 'required',
            'remember' => 'nullable',
        ]);

        $credentials = [
            'username' => $data['username'],
            'password' => $data['password'],
        ];

        if ( ! Auth::attempt($credentials, $data['remember'])) {
            abort(401);
        }

        return response()->json([
            'redirect_to' => $this->redirectTo,
            ...Auth::user()->only([
                'id',
                'username',
                'name',
                'firstname',
                'lastname',
                'email',
                'employeeType',
                'class',
                'lang',
                'id_admin',
                ]),
        ]);
    }
}
