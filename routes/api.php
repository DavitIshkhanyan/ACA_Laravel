<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
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

Route::get('/barev', function () {
    return 'Barev Ashxarh';
});

//Route::get('/users', [ApiController::class, 'index']);
//Route::get('/users/{id}', [ApiController::class, 'show'])->name('show');

//Route::prefix('users')->group(function () {
//    Route::get('/', [ApiController::class, 'index']);
//    Route::get('/{id?}', [ApiController::class, 'show'])->name('show');
//});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/user/create', [UserController::class, 'create']);
//Route::get('/users', [UserController::class, 'showAll']); ///////////
Route::get('/users/{id}', [UserController::class, 'find']);
Route::post('/users/{id}', [UserController::class, 'update']);
Route::delete('/users/{id}', [UserController::class, 'delete']);


Route::resource('categories', CategoryController::class);

Route::get('/shops/populars', [ShopController::class, 'getPopulars']);
Route::apiResource('shops', ShopController::class);
Route::get('/products/populars', [ProductController::class, 'getPopulars']);
Route::apiResource('products', ProductController::class);



Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    //    Route::post('login', 'AuthController@login');
    Route::post('login', [AuthController::class, 'login']);
    Route::post('registration', [AuthController::class, 'registration']);
    Route::post('logout', 'AuthController@logout'); ////
    Route::post('refresh', 'AuthController@refresh'); /////
    Route::post('me', 'AuthController@me'); //////

    Route::apiResource('carts', CartController::class);
    Route::post('carts/checkOut', [CartController::class, 'checkOut']);

    Route::group(['middleware' => 'userType:seller'], function () {
        Route::get('users', [UserController::class, 'showAll']);
    });
});
