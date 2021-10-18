<?php

namespace App\Http\Controllers;

class AdminController extends Controller
{
    protected $middleware = 'admin';

    public function show() {
        return view('admin');
    }
}
