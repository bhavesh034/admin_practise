<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DispatchController extends Controller
{
    public function dashboard()
    {
        return view('dispatch.dashboard');
    }
}
