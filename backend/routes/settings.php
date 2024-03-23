<?php
    use App\Http\Controllers\AdminSettingController;
    use App\Http\Controllers\AdminSettingGeneralController;
    use App\Http\Controllers\AdminSettingNotificationController;
    use App\Http\Controllers\AdminSettingResourceController;
    use App\Http\Controllers\AdminSettingUserController;
    use Illuminate\Support\Facades\Route;

    Route::resource('/settings', AdminSettingController::class)
        ->only('index')
        ->names([
            'index' => 'admin.settings'
        ]);
    Route::resource('/settings/general', AdminSettingGeneralController::class)
        ->only('index')
        ->names([
            'index' => 'admin.setting.general'
        ]);
    Route::resource('/settings/notifications', AdminSettingNotificationController::class)
        ->only('index')
        ->names([
            'index' => 'admin.setting.notification'
        ]);
    Route::resource('/settings/resources', AdminSettingResourceController::class)
        ->only('index')
        ->names([
            'index' => 'admin.setting.resource'
        ]);
    Route::resource('/settings/users', AdminSettingUserController::class)
        ->only('index')
        ->names([
            'index' => 'admin.setting.user'
        ]);
