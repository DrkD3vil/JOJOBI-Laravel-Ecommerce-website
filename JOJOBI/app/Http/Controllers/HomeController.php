<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Index Page Admin
    public function index()
    {
        $totalUsers = User::count();
        $totalProducts = Product::count();
        $targetNumber = 100; // Set your target number here

        // Calculate progress percentage and ensure it doesn't exceed 100%
        $progressPercentages = [
            'users' => min(($totalUsers / $targetNumber) * 100, 100),
            'products' => min(($totalProducts / $targetNumber) * 100, 100),
        ];
        return view('admin.index', compact('totalUsers', 'totalProducts','progressPercentages'));
    }
}
