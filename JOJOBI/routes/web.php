<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::get('admin/dashboard', [HomeController::class, 'index'])->name('admin.dashboard')->middleware(['auth', 'admin']);

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('view_category', [AdminController::class, 'view_category'])->name('admin.category');
    Route::post('add_category', [AdminController::class, 'add_category'])->name('admin.add_category');
    Route::get('search_category', [AdminController::class, 'search_category'])->name('admin.category.search');
    Route::get('edit_category/{uuid}', [AdminController::class, 'edit_category'])->name('admin.category.edit');
    Route::post('update_category/{uuid}', [AdminController::class, 'update_category'])->name('admin.category.update');
    Route::get('delete_category/{uuid}', [AdminController::class, 'delete_category'])->name('admin.category.delete');
    Route::get('preview-pdf', [AdminController::class, 'previewCategoriesPDF'])->name('admin.preview-pdf');
    Route::get('download-pdf', [AdminController::class, 'downloadCategoriesPDF'])->name('admin.download-pdf');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('add_product', [AdminController::class, 'add_product'])->name('admin.product.add');
    Route::post('upload_product', [AdminController::class, 'upload_product'])->name('admin.product.upload');
    Route::get('view_product', [AdminController::class, 'view_product'])->name('admin.product.view');
    Route::get('search_product', [AdminController::class, 'search_product'])->name('admin.product.search');
    Route::get('delete_product/{uuid}', [AdminController::class, 'delete_product'])->name('admin.product.delete');
    Route::get('update_product/{uuid}', [AdminController::class, 'update_product'])->name('admin.product.update');
    Route::post('edit_product/{uuid}', [AdminController::class, 'edit_product'])->name('admin.product.edit');
});
