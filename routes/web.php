<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ClientPartnerController;
use App\Http\Controllers\Admin\InternshipApplicationController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\TutorialController as AdminTutorialController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\TutorialController;

// Landing page
Route::view('/', 'landing.index')->name('home');
Route::view('/products', 'products.index')->name('products');
Route::get('/articles', [ArticleController::class, 'index'])->name('articles');
Route::get('/articles/pemasangan-pos-curah-hujan-pch-bendungkaret-tawangsari', [ArticleController::class, 'show'])
    ->defaults('slug', 'pemasangan-pos-curah-hujan-pch-bendungkaret-tawangsari')
    ->name('articles.pch-bendungkaret');
Route::get('/articles/{slug}', [ArticleController::class, 'show'])->name('articles.show');
Route::get('/tutorials', [TutorialController::class, 'index'])->name('tutorials');
Route::get('/tutorials/{slug}', [TutorialController::class, 'show'])->name('tutorials.show');
Route::redirect('/Article', '/articles');
Route::redirect('/article/pemasangan-pos-curah-hujan-(pch)-bendungkaret-tawangsari', '/articles/pemasangan-pos-curah-hujan-pch-bendungkaret-tawangsari');
Route::redirect('/Tutorial', '/tutorials');
// Internship routes
Route::get('/internship', [\App\Http\Controllers\InternshipController::class, 'index'])->name('internship');
Route::post('/internship/apply', [\App\Http\Controllers\InternshipController::class, 'apply'])->name('internship.apply');
Route::get('/internship/track', [\App\Http\Controllers\InternshipController::class, 'track'])->name('internship.track');
Route::get('/internship/letter/{code}', [\App\Http\Controllers\InternshipController::class, 'downloadLetter'])->name('internship.letter');

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
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');
    Route::resource('categories', CategoryController::class)->except('show');
    Route::resource('clients', ClientPartnerController::class)->except('show');
    Route::resource('articles', AdminArticleController::class);
    Route::resource('tutorials', AdminTutorialController::class);
    Route::get('internships/{internship}/letter', [InternshipApplicationController::class, 'downloadLetter'])->name('internships.letter');
    Route::get('internships/{internship}/letter/preview', [InternshipApplicationController::class, 'previewLetter'])->name('internships.letter.preview');
    Route::resource('internships', InternshipApplicationController::class)->except(['create', 'store', 'edit']);
    Route::post('/logout', [LoginController::class, 'logout'])
        ->name('logout');
});
