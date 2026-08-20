<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\PostController;
// use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\RegionController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\TranslatorController;
use App\Http\Controllers\Translator\DashboardController as TranslatorDashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\Auth\VerificationController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/verify', [VerificationController::class, 'notice'])->name('verification.notice');
Route::post('/verify', [VerificationController::class, 'verify'])->name('verification.verify');

Route::get('/signup', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/signup', [AuthController::class, 'register'])->name('register');

Route::get('/dashboard', [UserDashboardController::class, 'index'])
    ->name('user.dashboard')
    ->middleware('auth');

// Маршруты авторизации
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Маршруты дашборда переводчика
Route::prefix('translator')->name('translator.')->middleware(['auth:translator'])->group(function () {
   Route::get('/dashboard', [TranslatorDashboardController::class, 'index'])->name('dashboard');
    Route::get('/orders', [TranslatorDashboardController::class, 'orders'])->name('orders');
    Route::get('/prices', [TranslatorDashboardController::class, 'prices'])->name('prices');
    Route::put('/prices/{pair}', [TranslatorDashboardController::class, 'updatePrice'])->name('prices.update');
    Route::get('/profile', [TranslatorDashboardController::class, 'profile'])->name('profile');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin,lawyer'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('categories', CategoryController::class);
    Route::resource('tasks', TaskController::class);
    Route::resource('tags', TagController::class);
    Route::resource('posts', PostController::class);
    Route::post('/posts/upload-image', [PostController::class, 'uploadImage'])->name('posts.upload-image');
    // Route::resource('clients', ClientController::class);
    Route::resource('regions', RegionController::class);
    Route::resource('languages', LanguageController::class);

    // Управление переводчиками
    Route::resource('translators', TranslatorController::class);
    Route::post('translators/{translator}/add-pair', [TranslatorController::class, 'addLanguagePair'])->name('translators.add-pair');
    Route::post('translators/pair/{pair}/update-price', [TranslatorController::class, 'updatePrice'])->name('translators.update-price');
});