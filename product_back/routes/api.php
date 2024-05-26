<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::post('/login', [App\Http\Controllers\API\UserAPIController::class, 'login']);
Route::post('/signup', [App\Http\Controllers\API\UserAPIController::class, 'store']);


Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('user_models', App\Http\Controllers\API\UserAPIController::class)->names('api.user_models');

    Route::group(['prefix' => 'admin'], function () {
        Route::resource('user_models', App\Http\Controllers\API\UserModelAPIController::class);
    });



    Route::group(['prefix' => 'admin'], function () {
        Route::resource('product_categories', App\Http\Controllers\API\ProductCategoryAPIController::class);
    });


    Route::group(['prefix' => 'admin'], function () {
        Route::resource('providers', App\Http\Controllers\API\ProviderAPIController::class);
    });


    Route::group(['prefix' => 'admin'], function () {
        Route::get('/uldegdel/{branch_id}', [App\Http\Controllers\API\ProductAPIController::class, 'uldegdel']);
        Route::resource('products', App\Http\Controllers\API\ProductAPIController::class);
    });


    Route::group(['prefix' => 'admin'], function () {
        Route::resource('branches', App\Http\Controllers\API\BranchAPIController::class);
    });


    Route::group(['prefix' => 'admin'], function () {
        Route::resource('branch_have_products', App\Http\Controllers\API\BranchHaveProductAPIController::class);
    });


    Route::group(['prefix' => 'admin'], function () {
        Route::put('/supplies/{branch_id}/done', [App\Http\Controllers\API\SupplyAPIController::class, 'done']);
        Route::resource('supplies', App\Http\Controllers\API\SupplyAPIController::class);
    });


    Route::group(['prefix' => 'admin'], function () {
        Route::resource('supply_products', App\Http\Controllers\API\SupplyProductAPIController::class);
    });
});
