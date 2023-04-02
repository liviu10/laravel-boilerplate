<?php

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
    // Guest routes
    Route::get('/', function () { return view('welcome'); })->name('welcome');

    // Authentication routes
    Auth::routes();
    Route::get('lang/{lang}', ['as' => 'lang.switch', 'uses' => 'App\Http\Controllers\LanguageController@switchLang']);
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('/profile', App\Http\Controllers\ProfileController::class);
    Route::resource('/users', App\Http\Controllers\UsersController::class)->except('delete');
    Route::resource('/user-roles', App\Http\Controllers\UserRoleTypesController::class)->except('delete');
    Route::resource('/contact', App\Http\Controllers\ContactController::class)->except('update', 'delete');
