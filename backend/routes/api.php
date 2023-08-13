<?php

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
// Import application's management
    use App\Http\Controllers\Admin\Management\PageController;
    use App\Http\Controllers\Admin\Management\TagController;
    use App\Http\Controllers\Admin\Management\ArticleController;
    use App\Http\Controllers\Admin\Management\MediaController;
    use App\Http\Controllers\Admin\Management\CommentController;
// Import application's communication
    use App\Http\Controllers\Admin\Communication\ContactMessageController;
    use App\Http\Controllers\Admin\Communication\ContactSubjectController;
    use App\Http\Controllers\Admin\Communication\NewsletterCampaignController;
// Import application's reports
    use App\Http\Controllers\Admin\Report\ReportController;
// Import application's documentation
    use App\Http\Controllers\Admin\Documentation\DocumentationController;
// Import application's user settings
    use App\Http\Controllers\Admin\Settings\UserController;
    use App\Http\Controllers\Admin\Settings\RoleController;
// Import application's settings
    use App\Http\Controllers\Admin\ApplicationSettings\GeneralController;
    use App\Http\Controllers\Admin\ApplicationSettings\PerformanceController;
    use App\Http\Controllers\Admin\ApplicationSettings\AcceptedDomainController;
    use App\Http\Controllers\Admin\ApplicationSettings\NotificationController;
    use App\Http\Controllers\Admin\ApplicationSettings\EmailController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([ 'prefix' => config('app.version') ], function () {
    // Application's admin api endpoints
    Route::group([ 'prefix' => '/admin' ], function () {
        // Application's management endpoints
        // Route::group([ 'prefix' => '/management' ], function () {
        //     // Pages
        //     Route::apiResource('/pages', PageController::class);
        //     // Tags
        //     Route::apiResource('/tags', TagController::class);
        //     // Articles
        //     Route::apiResource('/articles', ArticleController::class);
        //     // Media
        //     Route::apiResource('/media', MediaController::class);
        //     // Comments
        //     Route::apiResource('/comments', CommentController::class);
        // });
        // Application's communication endpoints
        Route::group([ 'prefix' => '/communication' ], function () {
            // Contact subject, messages and responses
            Route::group([ 'prefix' => '/contact' ], function () {
                Route::apiResource('/subjects', ContactSubjectController::class);
                Route::apiResource('/messages', ContactMessageController::class);
            });
            // Newsletter campaign and subscribers
            Route::group([ 'prefix' => '/newsletter' ], function () {
                Route::apiResource('/campaigns', NewsletterCampaignController::class);
                // Route::apiResource('/subscribers', NewsletterSubscriberController::class);
            });
        });
        // Application's reports endpoints
        // Route::group([ 'prefix' => '/' ], function () {
        //     // Reports
        //     Route::apiResource('/reports', ReportController::class);
        // });
        // Application's documentation endpoints
        // Route::group([ 'prefix' => '/' ], function () {
        //     // Reports
        //     Route::apiResource('/documentation', DocumentationController::class);
        // });
        // Application's user settings api endpoints
        Route::group([ 'prefix' => '/settings' ], function () {
            // Users
            Route::get('/users/current-auth', [UserController::class, 'currentAuthUser']);
            Route::apiResource('/users', UserController::class);
            // User role types
            Route::apiResource('/roles', RoleController::class);
        });
        // Application's settings endpoints
        // Route::group([ 'prefix' => '/application-settings' ], function () {
        //     // General
        //     Route::apiResource('/general', GeneralController::class);
        //     // Performance
        //     Route::apiResource('/performance', PerformanceController::class);
        //     // Accepted domains
        //     Route::apiResource('/accepted-domains', AcceptedDomainController::class);
        //     // Notifications
        //     Route::apiResource('/notifications', NotificationController::class);
        //     // Emails
        //     Route::apiResource('/emails', EmailController::class);
        // });
    });

    // Application's client api endpoints
    Route::group([ 'prefix' => '/client' ], function () {});
});
