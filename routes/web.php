<?php

use Illuminate\Support\Facades\Route;

// Guest controllers
use App\Http\Controllers\GuestController;

// Auth controllers
use Illuminate\Support\Facades\Auth;

// Admin controller
use App\Http\Controllers\AdminController;

// Communication controllers
use App\Http\Controllers\Communication\CommunicationController;
use App\Http\Controllers\Communication\ContactSubjectController;
use App\Http\Controllers\Communication\ContactMessageController;
use App\Http\Controllers\Communication\NewsletterCampaignController;
use App\Http\Controllers\Communication\NewsletterSubscriberController;
use App\Http\Controllers\Communication\ReviewController;

// Settings controllers
use App\Http\Controllers\Settings\SettingsController;
use App\Http\Controllers\Settings\UserProfileController;
use App\Http\Controllers\Settings\UserController;

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
    Route::get('/data-protection', [GuestController::class, 'dataProtection'])->name('guest.dataProtection');
});

Auth::routes();

Route::group(['prefix' => '/admin'], function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');

    // Communication web routes
    Route::group(['prefix' => '/communication'], function () {
        Route::get('/', [CommunicationController::class, 'index'])->name('communication.index');
        Route::group(['prefix' => '/contact'], function () {
            Route::resource('/subjects', ContactSubjectController::class)->except('delete');
            Route::post('/messages/respond', [ContactMessageController::class, 'messageResponse'])->name('messages.messageResponse');
            Route::resource('/messages', ContactMessageController::class)->only('index', 'show');
        });
        Route::group(['prefix' => '/newsletter'], function () {
            Route::resource('/campaigns', NewsletterCampaignController::class)->except('delete');
            Route::resource('/subscribers', NewsletterSubscriberController::class)->only('index', 'show', 'edit', 'update');
        });
        Route::get('/reviews/send-review', [ReviewController::class, 'sendReview']);
        Route::resource('/reviews', ReviewController::class)->only('index', 'edit', 'update');
    });

    // Management web routes
    require __DIR__ . '/management.php';

    // Settings web routes
    Route::group(['prefix' => '/settings'], function () {
        Route::get('/', [SettingsController::class, 'index'])->name('settings.index');
        Route::resource('/users', UserController::class)->except('delete');
        Route::resource('/users/profile', UserProfileController::class)->only('edit', 'update');
    });
});
