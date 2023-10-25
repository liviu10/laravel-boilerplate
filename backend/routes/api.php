<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckAuthentication;

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
// Import application's communication
use App\Http\Controllers\Api\ContactSubjectController;
use App\Http\Controllers\Api\ContactMessageController;
use App\Http\Controllers\Api\ContactResponseController;
use App\Http\Controllers\Api\NewsletterCampaignController;
use App\Http\Controllers\Api\NewsletterSubscriberController;
use App\Http\Controllers\Api\ReviewController;
// Import application's management
use App\Http\Controllers\Api\ContentController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\MediaController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\AppreciationController;
// Import application's settings
use App\Http\Controllers\Api\AcceptedDomainController;
use App\Http\Controllers\Api\ConfigurationResourceController;
use App\Http\Controllers\Api\GeneralController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\ResourceController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => config('app.version')], function () {
    // Application's admin api endpoints
    Route::group(['prefix' => '/admin', 'middleware' => CheckAuthentication::class], function () {
        // Application's communication endpoints
        Route::group(['prefix' => '/communication'], function () {
            // Contact subject, messages and responses
            Route::group(['prefix' => '/contact'], function () {
                Route::apiResource('/subjects', ContactSubjectController::class);
                Route::apiResource('/messages', ContactMessageController::class);
                Route::apiResource('/responses', ContactResponseController::class);
            });
            // TODO: Add routes for social media (facebook pages, linkedin articles)
            // Newsletter campaign and subscribers
            Route::group(['prefix' => '/newsletter'], function () {
                Route::apiResource('/campaigns', NewsletterCampaignController::class);
                Route::apiResource('/subscribers', NewsletterSubscriberController::class);
            });
            // Reviews
            Route::apiResource('/reviews', ReviewController::class);
        });
        // Application's management endpoints
        Route::group(['prefix' => '/management'], function () {
            // Content (pages and articles)
            Route::apiResource('/contents', ContentController::class);
            // Tags
            Route::apiResource('/tags', TagController::class);
            // Media
            Route::apiResource('/media', MediaController::class);
            // Comments
            Route::apiResource('/comments', CommentController::class);
            // Appreciation
            Route::apiResource('/appreciations', AppreciationController::class);
            // TODO: Add routes for products, categories and cart
        });
        // Application's settings api endpoints
        Route::group(['prefix' => '/settings'], function () {
            // TODO: Add routes for google analytics
            // Accepted domains
            Route::apiResource('/accepted-domains', AcceptedDomainController::class);
            // Configuration resources
            Route::apiResource('/configuration-resources', ConfigurationResourceController::class);
            // General
            Route::apiResource('/general', GeneralController::class);
            // Notifications
            Route::apiResource('/notifications', NotificationController::class);
            // Resources
            Route::apiResource('/resources', ResourceController::class);
            // User role
            Route::apiResource('/roles', RoleController::class);
            // Users
            // TODO: Improve this when finishing with the login system
            // Route::get('/users/current-auth', [UserController::class, 'currentAuthUser']);
            Route::apiResource('/users', UserController::class);
        });
    });

    // Application's client api endpoints
    Route::group(['prefix' => '/client'], function () {
        // Contact message
        Route::post('/messages', [ContactMessageController::class, 'contactMessage'])->name('contact.messages');
        // Newsletter
        Route::post('/subscribe', [NewsletterSubscriberController::class, 'subscribe'])->name('newsletter.subscribe');
        Route::delete('/unsubscribe/{email}', [NewsletterSubscriberController::class, 'unsubscribe'])->name('newsletter.unsubscribe');
        // Content (pages and articles)
        Route::get('/contents', [ContentController::class, 'fetchAllContents'])->name('content.all');
        Route::get('/contents/{id}', [ContentController::class, 'fetchSingleContent'])->name('content.single');
        // Resources
        Route::get('/resources', [ResourceController::class, 'fetchAllResources'])->name('resource.all');
        // Reviews
        Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    });
});
