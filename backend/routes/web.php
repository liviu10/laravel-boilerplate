<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// Import application's home
use App\Http\Controllers\HomeController;
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
// Import application's settings
use App\Http\Controllers\AcceptedDomainController;
use App\Http\Controllers\ConfigurationResourceController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;

// Application's admin web routes
Route::group(['prefix' => '/admin'], function () {
    // Application's home web route
    Route::get('/', [HomeController::class, 'index']);
    // Application's communication web routes
    Route::group(['prefix' => '/communication'], function () {
        // Contact subjects, messages and responses
        Route::group(['prefix' => '/contact'], function () {
            Route::resource('/subjects', ContactSubjectController::class);
            Route::resource('/messages', ContactMessageController::class);
            Route::resource('/responses', ContactResponseController::class);
        });
        // Newsletter campaign and subscribers
        Route::group(['prefix' => '/newsletter'], function () {
            Route::resource('/campaigns', NewsletterCampaignController::class);
            Route::resource('/subscribers', NewsletterSubscriberController::class);
        });
        // Reviews
        Route::resource('/reviews', ReviewController::class);
    });
    // Application's management web routes
    Route::group(['prefix' => '/management'], function () {
        // Content (pages and articles)
        Route::resource('/content', ContentController::class);
        // Tags
        Route::resource('/tags', TagController::class);
        // Media
        Route::resource('/media', MediaController::class);
        // Comments
        Route::resource('/comments', CommentController::class);
        // Appreciation
        Route::resource('/appreciations', AppreciationController::class);
    });
    // Application's settings web routes
    Route::group(['prefix' => '/settings'], function () {
        // Accepted domains
        Route::resource('/accepted-domains', AcceptedDomainController::class);
        // Configuration resources
        Route::resource('/configuration-resources', ConfigurationResourceController::class);
        // General
        Route::resource('/general', GeneralController::class);
        // Notifications
        Route::resource('/notifications', NotificationController::class);
        // Resources
        Route::resource('/resources', ResourceController::class);
        // User roles
        Route::resource('/roles', RoleController::class);
        // Users
        Route::resource('/users', UserController::class);
    });
});

// // Application's client web routes
// Route::group(['prefix' => '/'], function () {
//     // Contact message
//     Route::post('/messages');
//     // Newsletter
//     Route::post('/subscribe');
//     Route::delete('/unsubscribe');
//     // Content (pages and articles)
//     Route::get('/contents');
//     Route::get('/contents/{id}');
//     // Resources
//     Route::get('/resources');
//     // Reviews
//     Route::post('/reviews');
// });
