<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UsersController;

// Landing page
Route::view('/', 'landing.index')->name('home');
Route::view('/products', 'products.index')->name('products');
Route::view('/articles', 'articles.index')->name('articles');
Route::view('/articles/pemasangan-pos-curah-hujan-pch-bendungkaret-tawangsari', 'articles.pch-bendungkaret')
    ->name('articles.pch-bendungkaret');
Route::view('/tutorials', 'tutorials.index')->name('tutorials');
Route::redirect('/Article', '/articles');
Route::redirect('/article/pemasangan-pos-curah-hujan-(pch)-bendungkaret-tawangsari', '/articles/pemasangan-pos-curah-hujan-pch-bendungkaret-tawangsari');
Route::redirect('/Tutorial', '/tutorials');
Route::view('/internship', 'internship.index')->name('internship');

// Map page
Route::view('/map', 'map.index')->name('map');

// Locale switcher
Route::get('/locale/{lang}', [LocaleController::class, 'switch'])
    ->name('locale.switch')
    ->where('lang', 'id|en');


// guest
Route::middleware('guest')->group(function () {

    Route::get('/login', [LoginController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'login'])
        ->name('login.store');
});

// admin
Route::middleware(['auth', 'prevent-back'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

    Route::get('/dashboard', function () {
        return view('admin.dashboard.index');
    })->name('dashboard');
    Route::resource('users', UsersController::class);
    Route::resource('categories', CategoryController::class)->except('show');
    Route::post('/logout', [LoginController::class, 'logout'])
        ->name('logout');
});
