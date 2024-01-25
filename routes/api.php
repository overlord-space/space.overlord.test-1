<?php

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

Route::middleware('guest')->group(function () {
    Route::post('/login', ['App\Http\Controllers\Api\AuthController', 'login']);
});

Route::middleware('auth.api-token')->group(function () {
    Route::apiResource('advertisements', 'App\Http\Controllers\Api\AdvertisementController')->only(['index', 'store', 'show', 'update', 'destroy']);
    Route::post('advertisements/{advertisement}/activate', ['App\Http\Controllers\Api\AdvertisementController', 'activate']);

    Route::apiResource('bids', 'App\Http\Controllers\Api\BidController')->only(['index', 'store', 'show']);
});
