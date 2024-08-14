<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

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
}
