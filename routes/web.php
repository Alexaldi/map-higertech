<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LocaleController;

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
