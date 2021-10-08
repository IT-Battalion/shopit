<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $middleware = 'admin';

    public function show() {
        return view('admin');
    }
}
