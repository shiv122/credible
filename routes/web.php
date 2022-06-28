<?php

namespace App;

use App\Http\Controllers\Admin\BusinessController;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExtraController;
use App\Http\Controllers\Admin\UserController;

Route::prefix('admin')->middleware(['web'])->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
    Route::get('/logout', [LogoutController::class, 'logout'])->name('logout-admin');
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/', [DashboardController::class, 'home'])->name('home');
    });
    Route::get('/work-in-progress', [MiscellaneousController::class, 'workInProgress'])->name('work-in-progress');
});



Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::name('miscellaneous.')->prefix('miscellaneous')->controller(MiscellaneousController::class)->group(function () {
        Route::post('report-error', 'sendReport')->name('report-error');
    });

    Route::name('users.')->prefix('users')->controller(UserController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update', 'update')->name('update');
        Route::put('status', 'status')->name('status');

        Route::name('business.')->prefix('business')->controller(BusinessController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/pending', 'index')->name('index.pending');
            Route::get('/blocked', 'index')->name('index.blocked');
            Route::get('/show/{id}', 'show')->name('show');
            Route::post('update', 'update')->name('update');
            Route::put('status', 'status')->name('status');
        });
    });


    Route::name('extra.')->prefix('extra')->controller(ExtraController::class)->group(function () {

        Route::name('faq.')->prefix('faq')->group(function () {
            Route::get('/', 'faqTable')->name('index');
            Route::post('store', 'faqStore')->name('store');
            Route::put('status', 'faqStatus')->name('status');
        });
    });
});
