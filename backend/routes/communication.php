<?php

use App\Http\Controllers\Admin\CommunicationController;
use App\Http\Controllers\Admin\ContactSubjectController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\ContactResponseController;
use App\Http\Controllers\Admin\NewsletterCampaignController;
use App\Http\Controllers\Admin\NewsletterSubscriberController;
use App\Http\Controllers\Admin\ReviewController;
use Illuminate\Support\Facades\Route;

// Communication main routes
    Route::group(
        ['prefix' => '/communication'],
        function () {
            // Index
            Route::get(
                '/',
                [CommunicationController::class, 'index']
            )->name('admin.communication');

            // Contact routes: subjects, messages and responses
            Route::group(
                ['prefix' => '/contact'],
                function () {
                    Route::resource(
                        '/subjects',
                        ContactSubjectController::class
                    );
                    Route::resource(
                        '/messages',
                        ContactMessageController::class
                    );
                    Route::resource(
                        '/responses',
                        ContactResponseController::class
                    );
                }
            );

            // Newsletter routes: campaigns and subscribers
            Route::group(
                ['prefix' => '/newsletter'],
                function () {
                    Route::resource(
                        '/campaigns',
                        NewsletterCampaignController::class
                    );
                    Route::resource(
                        '/subscribers',
                        NewsletterSubscriberController::class
                    );
                }
            );

            // Reviews route
            Route::resource(
                'reviews',
                ReviewController::class
            );
        }
    );
