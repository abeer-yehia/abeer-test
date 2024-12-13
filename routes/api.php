<?php

use App\Http\Controllers\API\AuthApiController;
use App\Http\Controllers\API\HomeApiController;
use App\Http\Controllers\API\UserApiController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/register', [AuthApiController::class, 'register']);
    Route::post('/login', [AuthApiController::class, 'login'])->middleware('throttle:5,1');
    Route::post('/logout', [AuthApiController::class, 'logout'])->middleware('auth:api');
});


Route::group(['middleware' => 'auth:api'], function ($router) {
    Route::get('/home', [HomeApiController::class, 'home']);
    Route::get('/profile', [UserApiController::class, 'profile']);
    Route::put('/update_profile', [UserApiController::class, 'update_profile']);   

});


