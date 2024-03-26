<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ContactSubjectController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\ContactResponseController;
use App\Http\Controllers\Admin\NewsletterCampaignController;
use App\Http\Controllers\Admin\NewsletterSubscriberController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\ContentTypeController;
use App\Http\Controllers\Admin\ContentVisibilityController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\MediaTypeController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\CommentTypeController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\AppreciationController;
use App\Http\Controllers\Admin\UserController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => config('app.version')], function () {
    // Application's admin api endpoints
    Route::group(['prefix' => '/admin'], function () {
        // Application's communication endpoints
        Route::group(['prefix' => '/communication'], function () {
            // Contact subject, messages and responses
            Route::group(['prefix' => '/contact'], function () {
                Route::apiResource('/subjects', ContactSubjectController::class);
                Route::apiResource('/messages', ContactMessageController::class);
                Route::apiResource('/responses', ContactResponseController::class);
            });
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
            // Content (types, visibility, pages and articles)
            Route::group(['prefix' => '/'], function () {
                Route::apiResource('/contents/type', ContentTypeController::class);
                Route::apiResource('/contents/visibility', ContentVisibilityController::class);
                Route::apiResource('/contents', ContentController::class);
            });
            // Tags
            Route::apiResource('/tags', TagController::class);
            // Media (types and media)
            Route::group(['prefix' => '/'], function () {
                Route::apiResource('/media/type', MediaTypeController::class);
                Route::apiResource('/media', MediaController::class);
            });
            // Comments (types and comments)
            Route::group(['prefix' => '/'], function () {
                Route::apiResource('/comments/type', CommentTypeController::class);
                Route::apiResource('/comments', CommentController::class);
            });
            // Appreciation
            Route::apiResource('/appreciations', AppreciationController::class);
        });
        // Application's settings api endpoints
        Route::group(['prefix' => '/settings'], function () {
            Route::apiResource('/users', UserController::class);
        });
    });

    // Application's client api endpoints
//    Route::group(['prefix' => '/client'], function () {
//        // Contact message
//        Route::post('/messages', [ContactMessageController::class, 'contactMessage'])->name('contact.messages');
//        // Newsletter
//        Route::post('/subscribe', [NewsletterSubscriberController::class, 'subscribe'])->name('newsletter.subscribe');
//        Route::delete('/unsubscribe/{email}', [NewsletterSubscriberController::class, 'unsubscribe'])->name('newsletter.unsubscribe');
//        // Content (pages and articles)
//        Route::get('/contents', [ContentController::class, 'fetchAllContents'])->name('content.all');
//        Route::get('/contents/{id}', [ContentController::class, 'fetchSingleContent'])->name('content.single');
//        // Resources
//        Route::get('/resources', [ResourceController::class, 'fetchAllResources'])->name('resource.all');
//        // Reviews
//        Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
//    });
});
