<?php
    use App\Http\Controllers\AdminSettingController;
    use App\Http\Controllers\AdminSettingConfigurationResourceController;
    use App\Http\Controllers\AdminSettingConfigurationTypeController;
    use App\Http\Controllers\AdminSettingConfigurationColumnController;
    use App\Http\Controllers\AdminSettingConfigurationInputController;
    use App\Http\Controllers\AdminSettingConfigurationOptionController;
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
    Route::resource('/settings/configuration/resources', AdminSettingConfigurationResourceController::class)
        ->only('index')
        ->names([
            'index' => 'admin.setting.configuration.resource'
        ]);
    Route::resource('/settings/configuration/types', AdminSettingConfigurationTypeController::class)
        ->only('index')
        ->names([
            'index' => 'admin.setting.configuration.type'
        ]);
    Route::resource('/settings/configuration/columns', AdminSettingConfigurationColumnController::class)
        ->only('index')
        ->names([
            'index' => 'admin.setting.configuration.column'
        ]);
    Route::resource('/settings/configuration/inputs', AdminSettingConfigurationInputController::class)
        ->only('index')
        ->names([
            'index' => 'admin.setting.configuration.input'
        ]);
    Route::resource('/settings/configuration/options', AdminSettingConfigurationOptionController::class)
        ->only('index')
        ->names([
            'index' => 'admin.setting.configuration.option'
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
