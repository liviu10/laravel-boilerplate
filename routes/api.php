<?php

use App\Http\Controllers\Admin\Api\AppreciationController;
use App\Http\Controllers\Admin\Api\CommentController;
use App\Http\Controllers\Admin\Api\CommentStatusController;
use App\Http\Controllers\Admin\Api\CommentTypeController;
use App\Http\Controllers\Admin\Api\ContactMessageController;
use App\Http\Controllers\Admin\Api\ContactResponseController;
use App\Http\Controllers\Admin\Api\ContactSubjectController;
use App\Http\Controllers\Admin\Api\ContentController;
use App\Http\Controllers\Admin\Api\ContentSocialMediaController;
use App\Http\Controllers\Admin\Api\ContentTypeController;
use App\Http\Controllers\Admin\Api\ContentVisibilityController;
use App\Http\Controllers\Admin\Api\LogoutController;
use App\Http\Controllers\Admin\Api\MediaController;
use App\Http\Controllers\Admin\Api\MediaTypeController;
use App\Http\Controllers\Admin\Api\NewsletterCampaignController;
use App\Http\Controllers\Admin\Api\NewsletterSubscriberController;
use App\Http\Controllers\Admin\Api\ReviewController;
use App\Http\Controllers\Admin\Api\TagController;
use App\Http\Controllers\Admin\Api\UserController;
use App\Http\Controllers\Client\Api\CommunicationController;
use App\Http\Controllers\Client\Api\LoginController;
use App\Http\Controllers\Client\Api\ManagementController;
use App\Http\Controllers\Client\Api\RegisterController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => config('app.version')], function () {
    // Application's admin api endpoints
    Route::group(['prefix' => '/admin', 'middleware' => 'auth:sanctum'], function () {
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
                Route::group(['prefix' => '/content'], function () {
                    Route::apiResource('/types', ContentTypeController::class);
                    Route::apiResource('/visibilities', ContentVisibilityController::class);
                    Route::apiResource('/social', ContentSocialMediaController::class);
                });
                Route::apiResource('/contents', ContentController::class);
            });
            // Tags
            Route::apiResource('/tags', TagController::class);
            // Media (types and media)
            Route::group(['prefix' => '/'], function () {
                Route::apiResource('/media/types', MediaTypeController::class);
                Route::apiResource('/media', MediaController::class);
            });
            // Comments (types and comments)
            Route::group(['prefix' => '/'], function () {
                Route::apiResource('/comment/types', CommentTypeController::class);
                Route::apiResource('/comment/statuses', CommentStatusController::class);
                Route::apiResource('/comments', CommentController::class);
            });
            // Appreciation
            Route::apiResource('/appreciations', AppreciationController::class);
        });
        // Application's settings api endpoints
        Route::group(['prefix' => '/settings'], function () {
            Route::apiResource('/users', UserController::class);
        });
        // Application's logout endpoint
        Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
    });

    // Application's client api endpoints
    Route::group(['prefix' => '/client'], function () {
        // Authentication and register
        Route::post('/register', [RegisterController::class, 'register'])->name('register');
        Route::post('/login', [LoginController::class, 'login'])->name('login');
        // Communication (contact form, newsletter and reviews)
        Route::group(['prefix' => '/communication'], function () {
            Route::group(['prefix' => '/contact'], function () {
                Route::get(
                    '/subjects',
                    [CommunicationController::class, 'getContactSubjects']
                )->name('contact.subjects');
                Route::post(
                    '/message',
                    [CommunicationController::class, 'sendContactMessage']
                )->name('contact.message');
            });
            Route::group(['prefix' => '/newsletter'], function () {
                Route::get(
                    '/campaigns',
                    [CommunicationController::class, 'getNewsletterCampaigns']
                )->name('newsletter.campaigns');
                Route::post(
                    '/subscribe',
                    [CommunicationController::class, 'newsletterSubscribe']
                )->name('newsletter.subscribe');
                Route::delete(
                    '/unsubscribe/{email}/{newsletterCampaignIds}',
                    [CommunicationController::class, 'newsletterUnsubscribe']
                )->name('newsletter.unsubscribe');
            });
            Route::post(
                '/review',
                [CommunicationController::class, 'sendReview']
            )->name('review');
        });
        // Management (content, comments and appreciations)
        Route::group(['prefix' => '/management'], function () {
            Route::get(
                '/content',
                [ManagementController::class, 'getContent']
            )->name('content');
            Route::group(['prefix' => '/content'], function () {
                Route::post(
                    '/comment',
                    [ManagementController::class, 'saveComment']
                )->name('save.comment');
                Route::put(
                    '/comment',
                    [ManagementController::class, 'editComment']
                )->name('edit.comment');
                Route::post(
                    '/appreciation',
                    [ManagementController::class, 'saveAppreciation']
                )->name('save.appreciation');
                Route::put(
                    '/appreciation',
                    [ManagementController::class, 'editAppreciation']
                )->name('edit.appreciation');
            });
        });
    });
});
