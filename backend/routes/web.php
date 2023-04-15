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
        Route::group([ 'prefix' => '/' ], function () {
            Route::get('/users/{id?}/{full_name?}/{email?}/{nickname?}/{user_role_type_id?}', [UsersController::class, 'index'])->name('users.index');
            Route::put('/users/{user}', [UsersController::class, 'update'])->name('users.update');
        });

        // User roles web routes [GET] and [PUT]
        Route::group([ 'prefix' => '/' ], function () {
            Route::get('/user-roles/{id?}/{user_role_name?}/{is_active?}', [UserRoleTypesController::class, 'index'])->name('user-roles.index');
            Route::put('/user-roles/{user-role}', [UserRoleTypesController::class, 'update'])->name('user-roles.update');
        });

        // Contact messages web routes [GET], [POST] and [PUT]
        Route::group([ 'prefix' => '/' ], function () {
            Route::get('/contact/{id?}/{full_name?}/{email?}/{phone?}/{contact_subject_id?}/{privacy_policy?}', [ContactController::class, 'index'])->name('contact.index');
            Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
            Route::put('/contact/{contact}', [ContactController::class, 'update'])->name('contact.update');
        });
    });

