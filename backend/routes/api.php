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
// Import application's management
use App\Http\Controllers\ContentController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AppreciationController;
// Import application's communication
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\ContactSubjectController;
use App\Http\Controllers\NewsletterCampaignController;
use App\Http\Controllers\NewsletterSubscriberController;
// Import application's settings
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\AcceptedDomainController;
use App\Http\Controllers\NotificationController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => config('app.version')], function () {
    // Application's admin api endpoints
    Route::group(['prefix' => '/admin'], function () {
        // Application's management endpoints
        Route::group(['prefix' => '/management'], function () {
            // Pages
            Route::apiResource('/contents', ContentController::class);
            // Tags
            Route::apiResource('/tags', TagController::class);
            // Media
            Route::apiResource('/media', MediaController::class);
            // Comments
            Route::apiResource('/comments', CommentController::class);
            // Appreciation
            Route::apiResource('/appreciations', AppreciationController::class);
        });
        // Application's communication endpoints
        Route::group(['prefix' => '/communication'], function () {
            // Contact subject, messages and responses
            Route::group(['prefix' => '/contact'], function () {
                Route::apiResource('/subjects', ContactSubjectController::class);
                Route::apiResource('/messages', ContactMessageController::class);
            });
            // Newsletter campaign and subscribers
            Route::group(['prefix' => '/newsletter'], function () {
                Route::apiResource('/campaigns', NewsletterCampaignController::class)->only('index', 'store', 'update');
                Route::apiResource('/subscribers', NewsletterSubscriberController::class)->only('index', 'show', 'update');
            });
        });
        // Application's user settings api endpoints
        Route::group(['prefix' => '/settings'], function () {
            // Accepted domains
            Route::apiResource('/accepted-domains', AcceptedDomainController::class);
            // General
            Route::apiResource('/general', GeneralController::class)->only('index', 'store', 'update');
            // Notifications
            Route::apiResource('/notifications', NotificationController::class)->only('index', 'store', 'update');
            // Application resources
            Route::apiResource('/resources', ResourceController::class)->only('index', 'store', 'update');
            // User role types
            Route::apiResource('/roles', RoleController::class)->only('index', 'store', 'update');
            // Users
            // TODO: Improve this when finishing with the login system
            // Route::get('/users/current-auth', [UserController::class, 'currentAuthUser']);
            Route::apiResource('/users', UserController::class)->only('index', 'store', 'update');
        });
    });

    // Application's client api endpoints
    Route::group(['prefix' => '/client'], function () {
        // Subscribe / unsubscribe to / from newsletter
        Route::apiResource('/subscribe', NewsletterSubscriberController::class)->only('store');
        Route::apiResource('/unsubscribe', NewsletterSubscriberController::class)->only('destroy');
    });
});
