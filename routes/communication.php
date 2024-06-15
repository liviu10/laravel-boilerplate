<?php

use Illuminate\Support\Facades\Route;

// Communication controllers
use App\Http\Controllers\Communication\CommunicationController;
use App\Http\Controllers\Communication\ContactSubjectController;
use App\Http\Controllers\Communication\ContactMessageController;
use App\Http\Controllers\Communication\NewsletterCampaignController;
use App\Http\Controllers\Communication\NewsletterSubscriberController;
use App\Http\Controllers\Communication\ReviewController;

Route::group(['prefix' => '/communication'], function () {
    Route::get('/', [CommunicationController::class, 'index'])
        ->name('communication.index');
    Route::group(['prefix' => '/contact'], function () {
        Route::resource('/subjects', ContactSubjectController::class)
            ->except('delete');
        Route::post('/messages/respond', [ContactMessageController::class, 'messageResponse'])
            ->name('messages.messageResponse');
        Route::resource('/messages', ContactMessageController::class)
            ->only('index', 'show');
    });
    Route::group(['prefix' => '/newsletter'], function () {
        Route::resource('/campaigns', NewsletterCampaignController::class)
            ->except('delete');
        Route::resource('/subscribers', NewsletterSubscriberController::class)
            ->only('index', 'show', 'edit', 'update');
    });
    Route::get('/reviews/send-review', [ReviewController::class, 'sendReview']);
    Route::resource('/reviews', ReviewController::class)
        ->only('index', 'edit', 'update');
});
