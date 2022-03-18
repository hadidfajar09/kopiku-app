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
Route::post('user/login', [AuthController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    //produk
    Route::resource('produk', ProductController::class);
    Route::post('produk/{id}', [ProductController::class, 'update']);


    //toko
    Route::resource('toko', TokoController::class);
});
