<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AuthController, CompanyController};

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

# Auth
Route::group(['prefix' => 'auth'], function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('logout', [AuthController::class, 'logout']);
    });
});

# Protected
Route::group(['middleware' => 'auth:api'], function () {
    Route::resource('companies', CompanyController::class);
});

# Public
Route::get('companies', [CompanyController::class, 'index']);


# reserved System
Route::get('/{any}', function ($any) {
    return response()->json(['name' => "Welcome to API REST Laravel 8", 'version' => 1.0, 'path' => "/$any"]);
})->where('any', '.*');

Route::get('/', function () {
    return response()->json(['name' => "Welcome to API REST Laravel 8", 'version' => 1.0]);
});
