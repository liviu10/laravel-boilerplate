<?php

use Illuminate\Http\Request;
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
use App\Http\Controllers\API\GeneralController;
use App\Http\Controllers\API\NotificationTypeController;
use App\Http\Controllers\API\NotificationConditionController;
use App\Http\Controllers\API\NotificationTemplateController;
use App\Http\Controllers\API\UserController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => config('app.version')], function () {
    // Application's admin api endpoints
    Route::group(['prefix' => '/admin'], function () {
        // Application's settings api endpoints
        Route::group(['prefix' => '/settings'], function () {
            // General: model names, apply migrations, apply seeders, optimize application and others
            Route::group(['prefix' => '/'], function () {
                Route::group(['prefix' => '/general'], function () {
                    Route::get('/models', [GeneralController::class, 'fetchModelNames'])
                        ->name('models');
                    Route::get('/migrations', [GeneralController::class, 'applyMigrations'])
                        ->name('migrations');
                    Route::get('/seeders', [GeneralController::class, 'applySeeders'])
                        ->name('seeders');
                    Route::get('/optimize', [GeneralController::class, 'optimizeApplication'])
                        ->name('optimize');
                });
                Route::apiResource('/general', GeneralController::class)->except('destroy');
            });
            // Notifications: types, conditions and templates
            Route::group(['prefix' => '/notification'], function () {
                Route::apiResource('/types', NotificationTypeController::class);
                Route::apiResource('/conditions', NotificationConditionController::class);
                Route::apiResource('/templates', NotificationTemplateController::class);
            });
            // Users
            Route::group(['prefix' => '/'], function () {
                Route::put('/users/profile/{id}', [UserController::class, 'profile'])
                    ->name('users.profile');
                Route::apiResource('/users', UserController::class);
            });
        });
    });
});
