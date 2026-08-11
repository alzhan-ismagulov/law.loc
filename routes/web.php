<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\TagController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {
    // Главная страница дашборда (распределяется по ролям в контроллере)
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Управление категориями (Categories)
    Route::resource('categories', CategoryController::class);
    // Управление задачами (Tasks)
    Route::resource('tasks', TaskController::class);
    Route::resource('tags', TagController::class);

});