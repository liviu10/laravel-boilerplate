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
    use App\Http\Controllers\Admin\Management\ContentController;
    use App\Http\Controllers\Admin\Management\TagController;
    use App\Http\Controllers\Admin\Management\MediaController;
    use App\Http\Controllers\Admin\Management\CommentController;
    use App\Http\Controllers\Admin\Management\AppreciationController;
// Import application's communication
    use App\Http\Controllers\Admin\Communication\ContactMessageController;
    use App\Http\Controllers\Admin\Communication\ContactSubjectController;
    use App\Http\Controllers\Admin\Communication\NewsletterCampaignController;
    use App\Http\Controllers\Admin\Communication\NewsletterSubscriberController;
// Import application's reports
    use App\Http\Controllers\Admin\Reports\ReportController;
// Import application's user settings
    use App\Http\Controllers\Admin\Settings\UserController;
    use App\Http\Controllers\Admin\Settings\RoleController;
// Import application's settings
    use App\Http\Controllers\Admin\ApplicationSettings\GeneralController;
    use App\Http\Controllers\Admin\ApplicationSettings\AcceptedDomainController;
    use App\Http\Controllers\Admin\ApplicationSettings\NotificationController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([ 'prefix' => config('app.version') ], function () {
    // Application's admin api endpoints
    Route::group([ 'prefix' => '/admin' ], function () {
        // Application's management endpoints
        Route::group([ 'prefix' => '/management' ], function () {
            // Pages
            Route::apiResource('/contents', ContentController::class);
            // Tags
            Route::apiResource('/tags', TagController::class);
            // Media
            Route::apiResource('/media', MediaController::class);
            // Comments
            Route::apiResource('/comments', CommentController::class);
            // Appreciation
            Route::apiResource('/appreciations', AppreciationController::class);
        });
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
                Route::apiResource('/subscribers', NewsletterSubscriberController::class);
            });
        });
        // Application's reports endpoints
        Route::group([ 'prefix' => '/' ], function () {
            // Reports
            Route::get('/reports', [ReportController::class, 'show']);
        });
        // Application's user settings api endpoints
        Route::group([ 'prefix' => '/settings' ], function () {
            // Users
            Route::get('/users/current-auth', [UserController::class, 'currentAuthUser']);
            Route::apiResource('/users', UserController::class);
            // User role types
            Route::apiResource('/roles', RoleController::class);
        });
        // Application's settings endpoints
        Route::group([ 'prefix' => '/application-settings' ], function () {
            // General
            Route::apiResource('/general', GeneralController::class);
            // Accepted domains
            Route::apiResource('/accepted-domains', AcceptedDomainController::class);
            // Notifications
            Route::apiResource('/notifications', NotificationController::class);
        });
    });

    // Application's client api endpoints
    Route::group([ 'prefix' => '/client' ], function () {});
});
