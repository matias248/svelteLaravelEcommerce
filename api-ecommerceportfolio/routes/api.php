<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/stores', [StoreController::class, 'createStore']);
Route::get('/stores', [StoreController::class, 'listStores']);
Route::get('/stores/{id}', [StoreController::class, 'getStore']);


Route::prefix('/stores/{store_id}')->group(function () {
    Route::post('/products', [ProductController::class,'createProduct']);
    Route::get('/products', [ProductController::class,'listProducts']);
    Route::get('/products/{id}', [ProductController::class,'getProduct']);
    Route::patch('/products/{id}', [ProductController::class,'updateProduct']);
    Route::delete('/products/{id}', [ProductController::class,'deleteProduct']);
});

Route::get('/products/public', [ProductController::class,'publicProducts']);

Route::delete('/stores/{id}', [StoreController::class, 'deleteStore']);

Route::patch('/stores/{id}', [StoreController::class, 'updateStore']);
