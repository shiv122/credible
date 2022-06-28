<?php

use App\Http\Controllers\API\v1\AuthController;
use App\Http\Controllers\API\v1\BusinessController;
use App\Http\Controllers\API\v1\UserController;
use Illuminate\Support\Facades\Route;



Route::prefix('v1')->group(function () {

    Route::controller(AuthController::class)->group(function () {
        Route::post('generate-otp', 'genOtp');
        Route::post('login', 'login');
    });



    Route::middleware(['auth:api'])->group(function () {
        Route::controller(UserController::class)->prefix('user')->group(function () {
            Route::get('/', 'index');
            Route::post('update', 'update');
            Route::post('test', 'test');
        });


        Route::controller(BusinessController::class)->prefix('business')->group(function () {
            Route::get('/', 'index');
            Route::post('create', 'create');
        });
    });
});
