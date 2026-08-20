<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\RegionController;
use App\Http\Controllers\Admin\LanguageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UserDashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [UserDashboardController::class, 'index'])
    ->name('user.dashboard')
    ->middleware('auth');

// Маршруты авторизации
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:superadmin,lawyer'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('categories', CategoryController::class);
    Route::resource('tasks', TaskController::class);
    Route::resource('tags', TagController::class);
    Route::resource('posts', PostController::class);
    Route::post('/posts/upload-image', [PostController::class, 'uploadImage'])->name('posts.upload-image');
    Route::resource('clients', ClientController::class);
    Route::resource('regions', RegionController::class);
    Route::resource('languages', LanguageController::class);
});