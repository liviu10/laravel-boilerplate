<?php

use Illuminate\Support\Facades\Route;

// Settings controllers
use App\Http\Controllers\Settings\SettingController;
use App\Http\Controllers\Settings\UserController;
use App\Http\Controllers\Settings\UserProfileController;
use App\Http\Controllers\Settings\ApplicationController;

Route::group(['prefix' => '/settings'], function () {
    // Settings main page
    Route::get('/', [SettingController::class, 'index'])
        ->name('settings.index');
    Route::get('/optimize', [SettingController::class, 'optimize'])
        ->name('settings.optimize');

    // Users group
    Route::resource('/users', UserController::class)
        ->except('delete');

    // User profile group
    Route::resource('/users/profile', UserProfileController::class)
        ->only('edit', 'update');

    // Application settings group
    Route::resource('/application', ApplicationController::class)
        ->except('delete');
});
