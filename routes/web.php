<?php

// Guest controller
use App\Http\Controllers\GuestController;

// Admin controller
use App\Http\Controllers\AdminController;

// Communication controllers
use App\Http\Controllers\Communication\CommunicationController;
use App\Http\Controllers\Communication\ContactSubjectController;
use App\Http\Controllers\Communication\ContactMessageController;
use App\Http\Controllers\Communication\ContactResponseController;
use App\Http\Controllers\Communication\NewsletterCampaignController;
use App\Http\Controllers\Communication\NewsletterSubscriberController;
use App\Http\Controllers\Communication\ReviewController;

// Management controllers
use App\Http\Controllers\Management\ManagementController;
use App\Http\Controllers\Management\CommentStatusController;
use App\Http\Controllers\Management\CommentTypeController;
use App\Http\Controllers\Management\ContentController;
use App\Http\Controllers\Management\ContentSocialMediaController;
use App\Http\Controllers\Management\ContentTypeController;
use App\Http\Controllers\Management\ContentVisibilityController;
use App\Http\Controllers\Management\MediaController;
use App\Http\Controllers\Management\MediaTypeController;
use App\Http\Controllers\Management\TagController;

// Settings controllers
use App\Http\Controllers\Settings\SettingsController;
use App\Http\Controllers\Settings\UserController;

use Illuminate\Support\Facades\Auth;
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
Route::group(['prefix' => '/'], function () {
    Route::get('/', [GuestController::class, 'index'])->name('guest.index');
    Route::get('/privacy-policy', [GuestController::class, 'privacyPolicy'])->name('guest.privacyPolicy');
    Route::get('/terms-and-conditions', [GuestController::class, 'termsAndConditions'])->name('guest.termsAndConditions');
});

Auth::routes();

Route::group(['prefix' => '/admin'], function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');

    // Communication web routes
    Route::group(['prefix' => '/communication'], function () {
        Route::get('/', [CommunicationController::class, 'index'])->name('communication.index');
        Route::group(['prefix' => '/contact'], function () {
            Route::resource('/subjects', ContactSubjectController::class)->except('delete');
            Route::resource('/messages', ContactMessageController::class)->only('index', 'show');
            Route::resource('/responses', ContactResponseController::class)->only('store');
        });
        Route::group(['prefix' => '/newsletter'], function () {
            Route::resource('/campaigns', NewsletterCampaignController::class)->except('delete');
            Route::resource('/subscribers', NewsletterSubscriberController::class)->only('index', 'show', 'update');
        });
        Route::get('/reviews/send-review', [ReviewController::class, 'sendReview']);
        Route::resource('/reviews', ReviewController::class)->only('index', 'update');
    });

    // Management web routes
    Route::group(['prefix' => '/management'], function () {
        Route::get('/', [ManagementController::class, 'index'])->name('management.index');
        Route::group(['prefix' => '/'], function () {
            Route::group(['prefix' => '/content'], function () {
                Route::resource('/types', ContentTypeController::class)->except('show', 'delete');
                Route::resource('/visibilities', ContentVisibilityController::class)->except('show', 'delete');
                Route::resource('/social', ContentSocialMediaController::class)->except('show', 'delete');
            });
            Route::group(['prefix' => '/comment'], function () {
                Route::resource('/types', CommentTypeController::class)->except('show', 'delete');
                Route::resource('/statuses', CommentStatusController::class)->except('show', 'delete');
            });
            Route::resource('/content', ContentController::class)->except('delete');
        });
        Route::resource('/tags', TagController::class)->except('show', 'delete');
        Route::group(['prefix' => '/'], function () {
            Route::resource('/media/types', MediaTypeController::class)->except('show', 'delete');
            Route::resource('/media', MediaController::class)->only('index');
        });
    });

    // Settings web routes
    Route::group(['prefix' => '/settings'], function () {
        Route::get('/', [SettingsController::class, 'index'])->name('settings.index');
        Route::resource('/users', UserController::class);
    });
});
