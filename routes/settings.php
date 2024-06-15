<?php

use Illuminate\Support\Facades\Route;

// Settings controllers
use App\Http\Controllers\Settings\SettingsController;
use App\Http\Controllers\Settings\UserProfileController;
use App\Http\Controllers\Settings\UserController;

Route::group(['prefix' => '/settings'], function () {
    Route::get('/', [SettingsController::class, 'index'])
        ->name('settings.index');
    Route::resource('/users', UserController::class)
        ->except('delete');
    Route::resource('/users/profile', UserProfileController::class)
        ->only('edit', 'update');
});
