<?php

use App\Http\Controllers\Admin\ManagementController;
use App\Http\Controllers\Admin\ContentTypeController;
use App\Http\Controllers\Admin\ContentVisibilityController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\MediaTypeController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\AppreciationController;
use Illuminate\Support\Facades\Route;

// Management main routes
    Route::group(
        ['prefix' => '/management'],
        function () {
            // Index
            Route::get(
                '/',
                [ManagementController::class, 'index']
            )->name('admin.management');

            // Content routes: types, visibility and content
            Route::group(
                ['prefix' => '/'],
                function () {
                    Route::resource(
                        '/content/types',
                        ContentTypeController::class
                    );
                    Route::resource(
                        '/content/visibility',
                        ContentVisibilityController::class
                    );
                    Route::resource(
                        '/content',
                        ContentController::class
                    );
                }
            );

            // Tag route
            Route::resource(
                '/tags',
                TagController::class
            );

            // Media routes: types and media
            Route::group(
                ['prefix' => '/'],
                function () {
                    Route::resource(
                        '/media/types',
                        MediaTypeController::class
                    );
                    Route::resource(
                        '/media',
                        MediaController::class
                    );
                }
            );

            // Comment route
            Route::resource(
                '/comments',
                CommentController::class
            );

            // Appreciation route
            Route::resource(
                '/appreciations',
                AppreciationController::class
            );
        }
    );
