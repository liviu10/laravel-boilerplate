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
use App\Http\Controllers\ContactSubjectController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\ContactResponseController;
use App\Http\Controllers\NewsletterCampaignController;
use App\Http\Controllers\NewsletterSubscriberController;
use App\Http\Controllers\ReviewController;
// Import application's management
use App\Http\Controllers\ContentController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AppreciationController;
// import application's reports
use App\Http\Controllers\ReportController;
// Import application's settings
use App\Http\Controllers\AcceptedDomainController;
use App\Http\Controllers\ConfigurationResourceController;
use App\Http\Controllers\ConfigurationTypeController;
use App\Http\Controllers\ConfigurationColumnController;
use App\Http\Controllers\ConfigurationInputController;
use App\Http\Controllers\ConfigurationOptionController;
use App\Http\Controllers\ConfigurationTranslationController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;

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
        // Application's reports api endpoint
        Route::get('/reports', [ReportController::class, 'getReport']);
        // Application's settings api endpoints
        Route::group(['prefix' => '/settings'], function () {
            // TODO: Add routes for google analytics
            // Accepted domains
            Route::apiResource('/accepted-domains', AcceptedDomainController::class);
            // Configurations
            Route::group(['prefix' => '/configuration'], function () {
                // Resources
                Route::get('/get-resource-id', [ConfigurationResourceController::class, 'getConfigurationResourceId']);
                Route::apiResource('/resources', ConfigurationResourceController::class);
                // Types
                Route::apiResource('/types', ConfigurationTypeController::class);
                // Columns
                Route::apiResource('/columns', ConfigurationColumnController::class);
                // Inputs
                Route::apiResource('/inputs', ConfigurationInputController::class);
                // Options
                Route::apiResource('/options', ConfigurationOptionController::class);
                // Translations
                Route::apiResource('/translations', ConfigurationTranslationController::class);
            });
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
