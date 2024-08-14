<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    //
    public function view_category()
    {
        $data = Category::paginate(10);
        return view('admin.category', compact('data'));
    }

    // Add Category
    public function add_category(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'category_name' => 'required|string|max:255',
            'category_barcode' => 'required|string|max:255|unique:categories,category_barcode',
        ]);

        // Create and save the category
        $category = new Category;
        $category->category_name = $request->category_name;
        $category->category_barcode = $request->category_barcode;
        $category->save();

        // Redirect with success message
        return redirect()->route('admin.category')->with('success', 'Category added successfully');
    }

    // Delete category
    public function delete_category($uuid)
    {
        // Find the category by UUID
        $data = Category::where('uuid', $uuid)->firstOrFail();

        // Delete the category
        $data->delete();

        // Redirect with success message
        return redirect('/view_category')->with('success', 'Category deleted successfully');
    }

    // Edit Category
    public function edit_category($uuid)
    {
        $data = Category::where('uuid', $uuid)->firstOrFail();
        return view('admin.edit_category', compact('data'));
    }

    // Update Category
    public function update_category(Request $request, $uuid)
    {
        $data = Category::where('uuid', $uuid)->firstOrFail();
        $data->category_name = $request->category_name;
        $data->category_barcode = $request->category_barcode;
        $data->save();

        return redirect('/view_category')->with('success', 'Category updated successfully');
    }
    // Search Categories
    public function search_category(Request $request)
    {
        $searchTerm = $request->input('search_term');
        $dateInput = $request->input('search_date');
        $query = Category::query();

        if (!empty($searchTerm)) {
            $query->where(function ($query) use ($searchTerm) {
                $query->where('categoryid', 'like', '%' . $searchTerm . '%')
                    ->orWhere('category_name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('category_barcode', 'like', '%' . $searchTerm . '%');
            });
        }

        if ($dateInput) {
            try {
                // Parse the date using the format 'Y-m-d'
                $parsedDate = Carbon::createFromFormat('Y-m-d', $dateInput)->format('Y-m-d');
                $query->whereDate('created_at', $parsedDate);
            } catch (\Exception $e) {
                // Handle invalid date format
                return redirect()->back()->with('error', 'Invalid date format.');
            }
        }

        try {
            $data = $query->paginate(10);
        } catch (\Exception $e) {
            Log::error('Search query failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while performing the search. Please try again.');
        }

        return view('admin.category', compact('data'));
    }

    // Export Categories
    public function previewCategoriesPDF()
    {
        $categories = Category::all();
        $pdf = PDF::loadView('admin.categories-pdf', compact('categories'));

        // Render the PDF in the browser
        return $pdf->stream('categories-preview.pdf');
    }

    public function downloadCategoriesPDF()
    {
        $categories = Category::all();
        $pdf = PDF::loadView('admin.categories-pdf', compact('categories'));

        // Download the PDF
        return $pdf->download('categories-list.pdf');
    }

    public function add_product()
    {
        // Fetch categories to populate the category dropdown
        $categories = Category::all();
        return view('admin.add_product', compact('categories'));
    }

    public function upload_product(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'product_barcode' => 'required|unique:products|string|max:255',
            'product_name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'product_image' => 'nullable|image',
            'status' => 'required|in:is_new,is_on_discount',
            'category' => 'nullable|string|max:255',
            'categoryid' => 'nullable|exists:categories,categoryid',
            'original_price' => 'nullable|numeric|min:0',
            'sell_price' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'brand' => 'nullable|string|max:255',
            'supplier' => 'nullable|string|max:255',
            'quantity' => 'nullable|integer|min:1',
        ]);

        // Create a new product instance
        $product = new Product;
        $product->product_barcode = $validated['product_barcode'];
        $product->product_name = $validated['product_name'] ?? null;
        $product->description = $validated['description'] ?? null;

        // Handle image upload
        if ($request->hasFile('product_image')) {
            $image = $request->file('product_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('jojobi_images/product_images'), $imageName);
            $product->product_image = 'jojobi_images/product_images/' . $imageName;
        }

        // Handle status fields
        $status = $validated['status'];
        $product->is_new = ($status === 'is_new') ? 1 : 0;
        $product->is_on_discount = ($status === 'is_on_discount') ? 1 : 0;

        $product->original_price = $validated['original_price'] ?? null;
        $product->sell_price = $validated['sell_price'] ?? null;
        $product->discount = $validated['discount'] ?? null;
        $product->categoryid = $validated['categoryid'] ?? null; // Use categoryid for the relationship
        $product->brand = $validated['brand'] ?? null;
        $product->supplier = $validated['supplier'] ?? null;
        $product->quantity = $validated['quantity'] ?? null;

        $product->save();

        return redirect()->back()->with('success', 'Product added successfully');
    }


    public function view_product()
    {
        $products = Product::with('category')->paginate(10);
        return view('admin.view_product', compact('products'));
    }

    public function search_product(Request $request)
    {
        $searchTerm = $request->input('search_term');
        $dateInput = $request->input('search_date');
        $query = Product::query();

        if (!empty($searchTerm)) {
            $query->where(function ($query) use ($searchTerm) {
                $query->where('productid', 'like', '%' . $searchTerm . '%')
                    ->orWhere('product_name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('product_barcode', 'like', '%' . $searchTerm . '%')
                    ->orWhereHas('category', function ($categoryQuery) use ($searchTerm) {
                        $categoryQuery->where('category_name', 'like', '%' . $searchTerm . '%')
                            ->orWhere('categoryid', 'like', '%' . $searchTerm . '%');
                    });
            });
        }

        if ($dateInput) {
            try {
                $parsedDate = \Carbon\Carbon::createFromFormat('Y-m-d', $dateInput)->format('Y-m-d');
                $query->whereDate('created_at', $parsedDate);
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Invalid date format.');
            }
        }

        try {
            $products = $query->with('category')->paginate(10);
        } catch (\Exception $e) {
            Log::error('Search query failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while performing the search. Please try again.');
        }

        return view('admin.view_product', compact('products'));
    }

    //   Delete a product
    public function delete_product($uuid)
    {
        $data = Product::where('uuid', $uuid)->first();
    
        if ($data) {
            // Optional: delete associated cart entries if needed
            // DB::table('carts')->where('product_id', $uuid)->delete();
    
            // Check if the product has an associated image
            if (!empty($data->product_image)) {
                // Get the image path
                $image_path = public_path($data->product_image);
    
                // Log the image path for troubleshooting
                Log::info('Attempting to delete image at path: ' . $image_path);
    
                // Check if the file exists
                if (file_exists($image_path)) {
                    // Attempt to delete the file
                    try {
                        unlink($image_path);
                        Log::info('File deleted successfully.');
                    } catch (\Exception $e) {
                        // Log the error message for troubleshooting
                        Log::error('Failed to delete image: ' . $e->getMessage());
    
                        // Redirect back with error message
                        return redirect()->back()->with('error', 'Failed to delete product image.');
                    }
                } else {
                    // Log the file not found case for troubleshooting
                    Log::warning('File not found at path: ' . $image_path);
                }
            }
    
            // Delete the product record
            $data->delete();
    
            // Redirect back with success message
            return redirect()->back()->with('success', 'Product deleted successfully');
        } else {
            // Redirect back with error message if product not found
            return redirect()->back()->with('error', 'Product not found');
        }
    }
    


    // Update product

    public function update_product($uuid)
    {
        $product = Product::where('uuid', $uuid)->firstOrFail();
        $categories = Category::all();

        return view('admin.update_product', compact('product', 'categories'));
    }

    public function edit_product(Request $request, $uuid)
    {
        $data = Product::where('uuid', $uuid)->firstOrFail();
    
        // Validate the request
        $request->validate([
            'product_barcode' => 'required|string|max:255',
            'product_name' => 'required|string|max:255',
            'description' => 'required|string',
            'original_price' => 'required|numeric|min:0',
            'sell_price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'categoryid' => 'required|exists:categories,categoryid',
            'product_quantity' => 'required|integer|min:1',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_new' => 'nullable|boolean',
            'is_on_discount' => 'nullable|boolean'
        ]);
    
        // Update product details
        $data->product_barcode = $request->product_barcode;
        $data->product_name = $request->product_name;
        $data->description = $request->description;
        $data->original_price = $request->original_price;
        $data->sell_price = $request->sell_price;
        $data->discount = $request->discount;
        $data->categoryid = $request->categoryid;
        $data->quantity = $request->product_quantity;
        $data->is_new = $request->has('is_new');
        $data->is_on_discount = $request->has('is_on_discount');
    
        // Handle image upload
        if ($request->hasFile('product_image')) {
            // Delete the old image if it exists
            if ($data->product_image && File::exists(public_path($data->product_image))) {
                File::delete(public_path($data->product_image));
            }
    
            // Save the new image
            $image = $request->file('product_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('product_images'), $imageName);
            $data->product_image = 'product_images/' . $imageName;
        }
    
        // Save the updated product
        $data->save();
    
        return redirect()->back()->with('success', 'Product updated successfully');
    }
    



}
