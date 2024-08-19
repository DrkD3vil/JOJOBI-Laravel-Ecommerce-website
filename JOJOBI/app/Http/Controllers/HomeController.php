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

        // Fetch all categories in random order
        $categories = Category::inRandomOrder()->take(3)->get();

        // Prepare an array to hold category-wise products
        $categoryProducts = [];

        foreach ($categories as $category) {
            // Fetch the latest 30 products by category
            $latestProducts = Product::where('categoryid', $category->categoryid)
                ->latest()
                ->take(30)
                ->get()
                ->shuffle();

            // Get current page number from request or default to 1
            $currentPage = (int) $request->get('page', 1);

            // Calculate the offset and slice the collection for the current page
            $offset = ($currentPage - 1) * $perPage;
            $products = $latestProducts->slice($offset, $perPage);

            // If there are not enough products to fill the page, repeat products
            if ($products->count() < $perPage) {
                $repeatCount = $perPage - $products->count();
                $products = $products->concat($latestProducts->take($repeatCount));
            }

            // Create a length-aware paginator
            $paginator = new LengthAwarePaginator(
                $products,
                $latestProducts->count(),
                $perPage,
                $currentPage,
                ['path' => $request->url(), 'query' => array_merge($request->query(), ['category' => $category->categoryid])]
            );

            // Store the paginator with the category name
            $categoryProducts[$category->category_name] = $paginator;
        }

        // Handle AJAX requests for "Show More" functionality
        if ($request->ajax()) {
            $categoryid = $request->get('category');
            $currentPage = $request->get('page', 1);

            // Fetch the correct paginator for the requested category
            foreach ($categories as $category) {
                if ($category->categoryid == $categoryid) {
                    $paginator = $categoryProducts[$category->category_name];
                    break;
                }
            }

            return view('home.products.topProducts', ['products' => $paginator])->render();
        }

        return view('home.index', ['categoryProducts' => $categoryProducts]);
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


    
    



