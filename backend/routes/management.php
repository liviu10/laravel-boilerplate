<?php
    use App\Http\Controllers\AdminManagementController;
    use App\Http\Controllers\AdminManagementContentController;
    use App\Http\Controllers\AdminManagementTagController;
    use App\Http\Controllers\AdminManagementMediaController;
    use App\Http\Controllers\AdminManagementCommentController;
    use App\Http\Controllers\AdminManagementAppreciationController;
    use Illuminate\Support\Facades\Route;

    Route::resource('/management', AdminManagementController::class)
        ->only('index')
        ->names([
            'index' => 'admin.management'
        ]);
    Route::resource('/management/contents', AdminManagementContentController::class)
        ->only('index')
        ->names([
            'index' => 'admin.management.content'
        ]);
    Route::resource('/management/tags', AdminManagementTagController::class)
        ->only('index')
        ->names([
            'index' => 'admin.management.tag'
        ]);
    Route::resource('/management/media', AdminManagementMediaController::class)
        ->only('index')
        ->names([
            'index' => 'admin.management.media'
        ]);
    Route::resource('/management/comments', AdminManagementCommentController::class)
        ->only('index')
        ->names([
            'index' => 'admin.management.comment'
        ]);
    Route::resource('/management/appreciations', AdminManagementAppreciationController::class)
        ->only('index')
        ->names([
            'index' => 'admin.management.appreciation'
        ]);
