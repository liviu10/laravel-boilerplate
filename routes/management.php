<?php

use Illuminate\Support\Facades\Route;

// Management controllers
use App\Http\Controllers\Management\ManagementController;
use App\Http\Controllers\Management\CommentStatusController;
use App\Http\Controllers\Management\CommentTypeController;
use App\Http\Controllers\Management\ContentController;
use App\Http\Controllers\Management\ContentCategoryController;
use App\Http\Controllers\Management\ContentTypeController;
use App\Http\Controllers\Management\ContentVisibilityController;
use App\Http\Controllers\Management\MediaController;
use App\Http\Controllers\Management\MediaTypeController;
use App\Http\Controllers\Management\TagController;

Route::group(['prefix' => '/management'], function () {
    Route::get('/', [ManagementController::class, 'index'])->name('management.index');
    Route::group(['prefix' => '/'], function () {
        Route::group(['prefix' => '/content'], function () {
            Route::resource('/categories', ContentCategoryController::class)->except('show', 'delete')
                ->names([
                    'index' => 'contentCategories.index',
                    'create' => 'contentCategories.create',
                    'store' => 'contentCategories.store',
                    'show' => 'contentCategories.show',
                    'edit' => 'contentCategories.edit',
                    'update' => 'contentCategories.update',
                ]);
            Route::resource('/types', ContentTypeController::class)->except('show', 'delete')
                ->names([
                    'index' => 'contentTypes.index',
                    'create' => 'contentTypes.create',
                    'store' => 'contentTypes.store',
                    'show' => 'contentTypes.show',
                    'edit' => 'contentTypes.edit',
                    'update' => 'contentTypes.update',
                ]);
            Route::resource('/visibilities', ContentVisibilityController::class)->except('show', 'delete')
                ->names([
                    'index' => 'contentVisibilities.index',
                    'create' => 'contentVisibilities.create',
                    'store' => 'contentVisibilities.store',
                    'show' => 'contentVisibilities.show',
                    'edit' => 'contentVisibilities.edit',
                    'update' => 'contentVisibilities.update',
                ]);
        });
        Route::group(['prefix' => '/comment'], function () {
            Route::resource('/types', CommentTypeController::class)->except('show', 'delete')
                ->names([
                    'index' => 'commentTypes.index',
                    'create' => 'commentTypes.create',
                    'store' => 'commentTypes.store',
                    'show' => 'commentTypes.show',
                    'edit' => 'commentTypes.edit',
                    'update' => 'commentTypes.update',
                ]);
            Route::resource('/statuses', CommentStatusController::class)->except('show', 'delete')
                ->names([
                    'index' => 'commentStatuses.index',
                    'create' => 'commentStatuses.create',
                    'store' => 'commentStatuses.store',
                    'show' => 'commentStatuses.show',
                    'edit' => 'commentStatuses.edit',
                    'update' => 'commentStatuses.update',
                ]);
        });
        Route::resource('/content', ContentController::class)->except('delete');
    });
    Route::resource('/tags', TagController::class)->except('show', 'delete');
    Route::group(['prefix' => '/'], function () {
        Route::resource('/media/types', MediaTypeController::class)->except('show', 'delete')
            ->names([
                'index' => 'mediaTypes.index',
                'create' => 'mediaTypes.create',
                'store' => 'mediaTypes.store',
                'show' => 'mediaTypes.show',
                'edit' => 'mediaTypes.edit',
                'update' => 'mediaTypes.update',
            ]);
        Route::resource('/media', MediaController::class)->except('show', 'delete');
    });
});
