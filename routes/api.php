<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\TokoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//login
Route::post('user/register', [AuthController::class, 'register']);
Route::post('user/login', [AuthController::class, 'login']);


//produk
Route::get('produk', [ProductController::class, 'index']);
Route::get('produk/all', [ProductController::class, 'getAllProduk']);
Route::get('produk/{id}', [ProductController::class, 'show']);

//toko
Route::get('toko', [TokoController::class, 'index']);
Route::get('toko/{id}', [TokoController::class, 'show']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    // Route::resource('produk', ProductController::class);
    Route::post('produk', [ProductController::class, 'store']);
    Route::post('produk/{id}', [ProductController::class, 'update']);
    Route::delete('produk/{id}', [ProductController::class, 'destroy']);
    Route::post('produk-by-toko', [ProductController::class, 'getByToko']);

    //toko
    Route::post('toko', [TokoController::class, 'store']);
    Route::post('toko/{id}', [TokoController::class, 'update']);
    Route::delete('toko/{id}', [TokoController::class, 'destroy']);

    //user
    Route::get('user', [AuthController::class, 'getUser']);


    //logout
    Route::post('user/logout', [AuthController::class, 'logout']);
});
