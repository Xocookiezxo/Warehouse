<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


// UserModels
Route::resource('user_models', App\Http\Controllers\Admin\UserModelController::class);


// Branches
Route::resource('branches', App\Http\Controllers\Admin\BranchesController::class);

// ProductCategories
Route::resource('product_categories', App\Http\Controllers\Admin\ProductCategoriesController::class);

// Providers
Route::resource('providers', App\Http\Controllers\Admin\ProvidersController::class);

// Products
Route::resource('products', App\Http\Controllers\Admin\ProductsController::class);


// ProductCategories
Route::resource('product_categories', App\Http\Controllers\Admin\ProductCategoryController::class);

// Providers
Route::resource('providers', App\Http\Controllers\Admin\ProviderController::class);

// Products
Route::resource('products', App\Http\Controllers\Admin\ProductController::class);


// Branches
Route::resource('branches', App\Http\Controllers\Admin\BranchController::class);

// BranchHaveProducts
Route::resource('branch_have_products', App\Http\Controllers\Admin\BranchHaveProductController::class);


// Supplies
Route::resource('supplies', App\Http\Controllers\Admin\SupplyController::class);

// SupplyProducts
Route::resource('supply_products', App\Http\Controllers\Admin\SupplyProductController::class);