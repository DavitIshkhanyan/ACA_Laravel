<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;


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

Route::group(['middleware' => 'api'], function ($router) {

    Route::group(['prefix' => 'auth'], function ($router) {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::post('me', [AuthController::class, 'me']);
    });

    Route::group(['middleware' => 'userType:seller'], function ($type) {
        Route::Resource('users', UserController::class);
        Route::Resource('categories', CategoryController::class);
        Route::Resource('shops', ShopController::class);
        Route::Resource('products', ProductController::class);
    });

    Route::group(['middleware' => 'userType:buyer'], function ($type) {
        Route::Resource('categories', CategoryController::class)->only(['index', 'show']);
        Route::Resource('shops', ShopController::class)->only(['index', 'show']);
        Route::Resource('products', ProductController::class)->only(['index', 'show']);
    });

});
