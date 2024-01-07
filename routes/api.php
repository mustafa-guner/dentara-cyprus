<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ResourceController;
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

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::post('logout', 'logout');
        Route::post('me', 'me');
    });
});

Route::group(['middleware' => 'auth:sanctum'], function () {

    //Resource routes
    Route::controller(ResourceController::class)->group(function () {
        Route::get('genders', 'getGenders');
        Route::post('roles', 'getRoles');
        Route::get('user-types', 'getUserTypes');
    });
});
