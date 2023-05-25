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
    use App\Http\Controllers\Admin\Settings\AcceptedDomainController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([ 'prefix' => config('app.version') ], function () {
    // Application's admin api endpoints
    Route::group([ 'prefix' => '/admin' ], function () {
        // Application's settings api endpoints
        Route::group([ 'prefix' => '/settings' ], function () {
            // Accepted domains
            Route::group([ 'prefix' => '/accepted-domains' ], function () {
                Route::get('/restore/{id}', [AcceptedDomainController::class, 'restoreRecord']);
                Route::get('/order/{columnName?}/{orderType?}', [AcceptedDomainController::class, 'orderTableColumn']);
                Route::get('/filter/{columnName?}/{columnValue?}', [AcceptedDomainController::class, 'filterTableColumn']);
            });
            Route::apiResource('/accepted-domains', AcceptedDomainController::class);
        });
    });

    // Application's client api endpoints
    Route::group([ 'prefix' => '/client' ], function () {});
});
