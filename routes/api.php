<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\GenderController;
use App\Http\Controllers\API\rolesController;
use App\Http\Controllers\API\OutletsController;
use App\Http\Controllers\API\procatController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\ProductController;

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

Route::prefix('v1')-> middleware('cors')-> group(function () {


    Route::prefix('auth')->group(function (){
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);
        Route::get('/me', [AuthController::class, 'getUser'])->middleware('auth:api'); //Proteksi user
        Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');
        // Route::post('/generate-otp-code', [AuthController::class, 'generateOtp'])->middleware('auth:api');
        // Route::post('/verification-account', [AuthController::class, 'verifikasi'])->middleware('auth:api');
    });



    Route::post('/profile', [ProfileController::class, 'updatecreate'])->middleware('auth:api');
    Route::apiResource('gender', GenderController::  class);
    Route::apiResource('outlets', OutletsController::class);
    Route::apiResource('roles', rolesController::class);
    Route::apiResource('product_category', procatController::class);
    Route::apiResource('products', ProductController::class);

});
