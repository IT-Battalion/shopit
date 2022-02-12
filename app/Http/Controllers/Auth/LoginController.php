<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;
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
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $data = $request->validated();

        $credentials = [
            'username' => $data['username'],
            'password' => $data['password'],
        ];

        if (!Auth::attempt($credentials, $data['remember'] ?? false)) {
            abort(401, 'Benutzername oder Passwort ist falsch.');
        }

        return response()->json([
            ...Auth::user()->only([
                'id',
                'username',
                'firstname',
                'lastname',
                'email',
                'lang',
                'isAdmin',
                'enabled',
            ]),
        ]);
    }
}
