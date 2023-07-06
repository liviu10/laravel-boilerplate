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
// Import application's settings
    use App\Http\Controllers\Admin\Settings\UserController;
    use App\Http\Controllers\Admin\Settings\UserRoleTypeController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([ 'prefix' => config('app.version') ], function () {
    // Application's admin api endpoints
    Route::group([ 'prefix' => '/admin' ], function () {
        // Application's settings api endpoints
        Route::group([ 'prefix' => '/settings' ], function () {
            // Users
            Route::get('/users/current-auth', [UserController::class, 'currentAuthUser']);
            Route::apiResource('/users', UserController::class);
            // User role types
            Route::group([ 'prefix' => '/user-role-types' ], function () {
                Route::get('/order', [UserRoleTypeController::class, 'orderTableColumn']);
                Route::get('/filter', [UserRoleTypeController::class, 'filterTableColumn']);
            });
            Route::apiResource('/user-role-types', UserRoleTypeController::class)->only(['index', 'show']);
        });
    });

    // Application's client api endpoints
    Route::group([ 'prefix' => '/client' ], function () {});
});
