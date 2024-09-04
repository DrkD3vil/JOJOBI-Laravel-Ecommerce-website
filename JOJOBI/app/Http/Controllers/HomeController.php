<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class HomeController extends Controller
{
    // Index Page Admin
    public function index()
    {
        // Clear the session variable when the user visits the home page
        session()->forget('came_from_all_products');
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

    public function home(Request $request)
    {
        // Number of products to display per page for "Show More"
        $perPage = 3;
    
        // Search for products
        $searchQuery = trim($request->get('search', ''));
    
        // Prepare an array to hold category-wise products
        $categoryProducts = [];
    
        if (!empty($searchQuery)) {
            // Get categories that have products matching the search query
            $categories = Category::whereHas('products', function ($query) use ($searchQuery) {
                $query->where('product_name', 'LIKE', "%{$searchQuery}%")
                    ->orWhere('description', 'LIKE', "%{$searchQuery}%");
            })->get();
    
            foreach ($categories as $category) {
                $products = $category->products()
                    ->where(function ($query) use ($searchQuery) {
                        $query->where('product_name', 'LIKE', "%{$searchQuery}%")
                            ->orWhere('description', 'LIKE', "%{$searchQuery}%");
                    })
                    ->latest()
                    ->paginate($perPage);
    
                $categoryProducts[$category->category_name] = $products;
            }
        } else {
            // Fetch all categories in random order
            $categories = Category::inRandomOrder()->take(3)->get();
    
            foreach ($categories as $category) {
                $products = $category->products()
                    ->latest()
                    ->paginate($perPage);
    
                $categoryProducts[$category->category_name] = $products;
            }
        }
    
        // Handle AJAX requests for "Show More" functionality
        if ($request->ajax()) {
            return response()->json([
                'html' => view('home.products.topProducts', compact('categoryProducts'))->render()
            ]);
        }
    
        return view('home.index', compact('categoryProducts'));
    }
    
    


    public function allProductsByCategory($categoryid, Request $request)
    {
        $perPage = 4; // Number of products per page
    
        // Fetch products with pagination
        $products = Product::where('categoryid', $categoryid)
            ->latest()
            ->paginate($perPage);
    
        // Fetch category details
        $category = Category::where('categoryid', $categoryid)->firstOrFail();

        session(['came_from_all_products' => true]);
    
        // Check if request is AJAX
        if ($request->ajax()) {
            return view('home.products.topProduct', compact('products'))->render();
        }
    
        return view('home.products.allProducts', compact('products', 'category'));
    }
    public function productdetail($uuid)
    {
        // Fetch product using UUID
    $product = Product::where('uuid', $uuid)->firstOrFail();

        return view('home.products.product_detail', compact('product'));
    }

    public function productcheckout()
    {
        return view('home.checkout');
    }
    

    



}


    
    



