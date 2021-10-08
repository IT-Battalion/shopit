<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $middleware = 'admin';

    public function ban(Request $request) {

    }

    public function unban(Request $request) {

    }
}
