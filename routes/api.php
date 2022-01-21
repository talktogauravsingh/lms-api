<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\RentManagmentController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::controller(UserController::class)->group(function () {
    // Route::get('/orders/{id}', 'show');
    Route::post('/login', 'login');
    Route::post('/register', 'register');
});

Route::controller(BookController::class)->group(function () {
    Route::post('/book/create', 'create');
    Route::get('/book/getAll/{bookId?}', 'getAll');
    Route::post('/book/update', 'update');
    Route::post('/book/delete', 'delete');
});

Route::controller(RentManagmentController::class)->group(function () {
    Route::post('/buyBookOnRent', 'buyBookOnRent');
    Route::post('/returnRentedBook', 'returnRentedBook');
});
