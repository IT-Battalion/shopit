<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $middleware = 'admin';

    public function ban(Request $request) {
        $user = $request['user']; //can be email, username
        $db_user = User::where('username', $user)->orWhere('email', $user);
        $db_user->enabled = false;
        $db_user->update();

    }

    public function unban(Request $request) {
        $user = $request['user']; //can be email, username
        $db_user = User::where('username', $user)->orWhere('email', $user);
        $db_user->enabled = true;
        $db_user->update();
    }
}
