<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('pages.guest');
})->name('guest.index');

Auth::routes();

Route::group(['prefix' => '/admin'], function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::post('/google-maps', [AdminController::class, 'storeGoogleMaps'])->name('storeGoogleMaps');
    Route::put('/google-maps/{google_maps}', [AdminController::class, 'updateGoogleMaps'])->name('updateGoogleMaps');
});
