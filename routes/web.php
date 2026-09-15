<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LocaleController;

// Landing page
Route::view('/', 'landing.index')->name('home');

// Map page
Route::view('/map', 'map.index')->name('map');

// Locale switcher
Route::get('/locale/{lang}', [LocaleController::class, 'switch'])
    ->name('locale.switch')
    ->where('lang', 'id|en');
