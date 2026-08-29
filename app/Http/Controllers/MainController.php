<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function dashboard() {
        if (!session()->has('user')) {
            return redirect()->route('login');
        }
        return view('dashboard');
    }
}