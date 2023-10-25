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

// Application's admin web routes
Route::group(['prefix' => '/admin'], function () {
    // Application's communication web routes
    Route::group(['prefix' => '/communication'], function () {
        // Contact subjects, messages and responses
        Route::group(['prefix' => '/contact'], function () {
            Route::get('/subjects', function () {
                return view('pages.admin.communication.contact.subjects.index');
            });
            Route::get('/messages', function () {
                return view('pages.admin.communication.contact.messages.index');
            });
            Route::get('/responses', function () {
                return view('pages.admin.communication.contact.responses.index');
            });
        });
        // Newsletter campaign and subscribers
        Route::group(['prefix' => '/newsletter'], function () {
            Route::get('/campaigns', function () {
                return view('pages.admin.communication.newsletter.campaigns.index');
            });
            Route::get('/subscribers', function () {
                return view('pages.admin.communication.newsletter.subscribers.index');
            });
        });
        // Reviews
        Route::get('/reviews', function () {
            return view('pages.admin.communication.reviews.index');
        });
    });
    // Application's management web routes
    Route::group(['prefix' => '/management'], function () {
        // Content (pages and articles)
        Route::get('/content', function () {
            return view('pages.admin.management.content.index');
        });
        // Tags
        Route::get('/tags', function () {
            return view('pages.admin.management.tags.index');
        });
        // Media
        Route::get('/media', function () {
            return view('pages.admin.management.media.index');
        });
        // Comments
        Route::get('/comments', function () {
            return view('pages.admin.management.comments.index');
        });
        // Appreciation
        Route::get('/appreciations', function () {
            return view('pages.admin.management.appreciations.index');
        });
    });
    // Application's settings web routes
    Route::group(['prefix' => '/settings'], function () {
        // Accepted domains
        Route::get('/accepted-domains', function () {
            return view('pages.admin.settings.accepted-domains.index');
        });
        // Configuration resources
        Route::get('/configuration-resources', function () {
            return view('pages.admin.settings.configuration-resources.index');
        });
        // General
        Route::get('/general', function () {
            return view('pages.admin.settings.general.index');
        });
        // Notifications
        Route::get('/notifications', function () {
            return view('pages.admin.settings.notifications.index');
        });
        // Resources
        Route::get('/resources', function () {
            return view('pages.admin.settings.resources.index');
        });
        // User roles
        Route::get('/roles', function () {
            return view('pages.admin.settings.roles.index');
        });
        // Users
        Route::get('/users', function () {
            return view('pages.admin.settings.users.index');
        });
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
