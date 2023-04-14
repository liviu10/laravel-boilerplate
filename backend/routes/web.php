<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserRoleTypesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ContactController;
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
    // Welcome web route [GET]
    Route::get('/', function () { return view('welcome'); })
        ->name('welcome');

    // Authentication routes
    Auth::routes();

    // Language web routes
    Route::get('lang/{lang}', ['as' => 'lang.switch', 'uses' => 'App\Http\Controllers\LanguageController@switchLang']);

    Route::group([ 'prefix' => '/admin', 'middleware' => 'checkUserRole' ], function () {
        // Dashboard web routes [GET]
        Route::get('/', [HomeController::class, 'index'])->name('home');

        // Profile web routes [GET] and [PUT]
        Route::resource('/profile', ProfileController::class)->only('index', 'update');

        // Users web routes [GET] and [PUT]
        Route::post('/users/filter', [UsersController::class, 'filter'])->name('users.filter');
        Route::resource('/users', UsersController::class)->only('index', 'update');

        // User roles web routes [GET], [POST] and [PUT]
        Route::post('/user-roles/filter', [UserRoleTypesController::class, 'filter'])->name('user-roles.filter');
        Route::resource('/user-roles', UserRoleTypesController::class)->only('index', 'update');

        // Contact messages web routes [GET] and [POST]
        Route::post('/contact/filter', [ContactController::class, 'filter'])->name('contact.filter');
        Route::resource('/contact', ContactController::class)->only('index', 'store', 'update');
    });

