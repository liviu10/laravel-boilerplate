<?php

use Illuminate\Support\Facades\Route;

// Guest controllers
use App\Http\Controllers\GuestController;

// Auth controllers
use Illuminate\Support\Facades\Auth;

// Admin controller
use App\Http\Controllers\AdminController;

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
Route::group(['prefix' => '/'], function () {
    Route::get('/', [GuestController::class, 'index'])
        ->name('guest.index');

    Route::get('/privacy-policy', [GuestController::class, 'privacyPolicy'])
        ->name('guest.privacyPolicy');

    Route::get('/terms-and-conditions', [GuestController::class, 'termsAndConditions'])
        ->name('guest.termsAndConditions');

    Route::get('/data-protection', [GuestController::class, 'dataProtection'])
        ->name('guest.dataProtection');

    Route::get('/{contentSlug}', [GuestController::class, 'renderContentPage'])
        ->name('guest.renderContentPage');
});

Auth::routes();

Route::group(['prefix' => '/admin'], function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');

    // Communication web routes
    require __DIR__ . '/communication.php';

    // Management web routes
    require __DIR__ . '/management.php';

    // Settings web routes
    require __DIR__ . '/settings.php';
});
