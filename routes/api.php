<?php

use App\Http\Controllers\Api\RoleApiController;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

// Auth ...
Route::post('/login', LoginController::class);
Route::post('/register', RegisterController::class);
Route::post('/logout', LogoutController::class);

// Protected by middleware

Route::group(['middleware' => 'auth:sanctum'], function () {
    // Invoke User Function to get User
    Route::get('/user', UserApiController::class);

    // Users
    Route::resource('/users', UserApiController::class);

    // Roles
    Route::resource(
        '/roles',
        RoleApiController::class
    );
});
