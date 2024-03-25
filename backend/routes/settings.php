<?php

use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\GeneralController;
use App\Http\Controllers\Admin\NotificationTypeController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\ResourceController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

// Management main routes
Route::group(
    ['prefix' => '/settings'],
    function () {
        // Index
        Route::get(
            '/',
            [SettingController::class, 'index']
        )->name('admin.settings');

        // General route
        Route::resource(
            '/general',
            GeneralController::class
        );

        // Notification routes: types, and notifications
        Route::group(
            ['prefix' => '/'],
            function () {
                Route::resource(
                    '/notification/types',
                    NotificationTypeController::class
                );
                Route::resource(
                    '/notifications',
                    NotificationController::class
                );
            }
        );

        // Resource route
        Route::resource(
            '/resources',
            ResourceController::class
        );

        // Users route
        Route::resource(
            '/users',
            UserController::class
        );
    }
);
