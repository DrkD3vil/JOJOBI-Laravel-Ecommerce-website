<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Index Page Admin
    public function index()
    {
        return view('admin.index');
    }
}
