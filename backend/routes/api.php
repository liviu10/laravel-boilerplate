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
use App\Http\Controllers\API\UserController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => config('app.version')], function () {
    // Application's admin api endpoints
    Route::group(['prefix' => '/admin'], function () {
        // Application's settings api endpoints
        Route::group(['prefix' => '/settings'], function () {
            // Users
            Route::group(['prefix' => '/'], function () {
                Route::put('/users/profile/{id}', [UserController::class, 'profile'])->name('users.profile');
                Route::apiResource('/users', UserController::class);
            });
        });
    });

    // Application's client api endpoints
});
