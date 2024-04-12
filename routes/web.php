<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppreciationController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CommentStatusController;
use App\Http\Controllers\CommentTypeController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\ContactResponseController;
use App\Http\Controllers\ContactSubjectController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\ContentSocialMediaController;
use App\Http\Controllers\ContentTypeController;
use App\Http\Controllers\ContentVisibilityController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\MediaTypeController;
use App\Http\Controllers\NewsletterCampaignController;
use App\Http\Controllers\NewsletterSubscriberController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['prefix' => '/admin'], function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    Route::group(['prefix' => '/communication'], function () {
        Route::group(['prefix' => '/contact'], function () {
            Route::resource('/subjects', ContactSubjectController::class);
            Route::resource('/messages', ContactMessageController::class);
            Route::resource('/responses', ContactResponseController::class);
        });
        Route::group(['prefix' => '/newsletter'], function () {
            Route::resource('/campaigns', NewsletterCampaignController::class);
            Route::resource('/subscribers', NewsletterSubscriberController::class);
        });
        Route::resource('/reviews', ReviewController::class);
    });
    Route::group(['prefix' => '/management'], function () {
        Route::group(['prefix' => '/contents'], function () {
            Route::resource('/types', ContentTypeController::class);
            Route::resource('/visibilities', ContentVisibilityController::class);
            Route::resource('/social', ContentSocialMediaController::class);
            Route::resource('/', ContentController::class);
        });
        Route::resource('/tags', TagController::class);
        Route::group(['prefix' => '/media'], function () {
            Route::resource('/types', MediaTypeController::class);
            Route::resource('/', MediaController::class);
        });
        Route::group(['prefix' => '/comments'], function () {
            Route::resource('/types', CommentTypeController::class);
            Route::resource('/statuses', CommentStatusController::class);
            Route::resource('/', CommentController::class);
        });
        Route::resource('/appreciations', AppreciationController::class);
    });
    Route::group(['prefix' => '/settings'], function () {
        Route::resource('/users', UserController::class);
    });
});
