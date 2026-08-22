<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\RegionController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\TranslatorController;
use App\Http\Controllers\Admin\PoligraphyController;
use App\Http\Controllers\Translator\DashboardController as TranslatorDashboardController;
use App\Http\Controllers\Client\DashboardController as ClientDashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Admin\NomenclatureController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\TranslationOrderController;

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
    Route::delete('orders/files/{fileId}/destroy', [TranslatorDashboardController::class, 'destroyTranslation'])->name('orders.destroy-translation');
    
    // Маршрут для загрузки перевода переводчиком
    Route::post('/orders/{fileId}/upload', [TranslatorDashboardController::class, 'uploadTranslation'])->name('orders.upload');

    Route::get('/prices', [TranslatorDashboardController::class, 'prices'])->name('prices');
    Route::put('/prices/{pair}', [TranslatorDashboardController::class, 'updatePrice'])->name('prices.update');
    Route::get('/profile', [TranslatorDashboardController::class, 'profile'])->name('profile');
    Route::put('/profile', [TranslatorDashboardController::class, 'updateProfile'])->name('profile.update');
});

// Маршруты кабинета клиента
Route::prefix('client')->name('client.')->middleware(['auth:client'])->group(function () {
    Route::get('/dashboard', [ClientDashboardController::class, 'index'])->name('dashboard');
    Route::get('/orders', [ClientDashboardController::class, 'orders'])->name('orders');
    Route::get('/profile', [ClientDashboardController::class, 'profile'])->name('profile');
    Route::put('/profile', [ClientDashboardController::class, 'updateProfile'])->name('profile.update');
});

// Маршруты администратора / юриста
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin,lawyer'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Кастомные маршруты для переводов ставим на самый верх
    Route::get('translations/get-translator-rate', [TranslationOrderController::class, 'getTranslatorRate'])->name('translations.get-translator-rate');
    Route::get('translations/get-translator-services', [TranslationOrderController::class, 'getTranslatorServices'])->name('translations.get-translator-services');
    Route::post('translations/parse-file', [TranslationOrderController::class, 'parseFileChars'])->name('translations.parse-file');
    Route::post('translations/files/{fileId}/upload', [TranslationOrderController::class, 'uploadTranslation'])->name('translations.files.upload');
    Route::delete('translations/files/{fileId}', [TranslationOrderController::class, 'destroyFile'])->name('translations.files.destroy');
    Route::patch('translations/{translation}/toggle-payment', [TranslationOrderController::class, 'togglePayment'])->name('translations.toggle-payment');

    // Ресурсные маршруты идут ниже
    Route::resource('translations', TranslationOrderController::class);
    Route::resource('nomenclatures', NomenclatureController::class);
    Route::resource('departments', DepartmentController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('tasks', TaskController::class);
    Route::resource('tags', TagController::class);
    Route::resource('posts', PostController::class);
    Route::resource('regions', RegionController::class);
    Route::resource('languages', LanguageController::class);
    Route::resource('translators', TranslatorController::class);
    Route::resource('clients', ClientController::class);

    // Остальные кастомные POST/PUT маршруты
    Route::post('/posts/upload-image', [PostController::class, 'uploadImage'])->name('posts.upload-image');
    Route::post('nomenclatures/{nomenclature}/bom', [NomenclatureController::class, 'storeBom'])->name('nomenclatures.bom.store');
    Route::delete('nomenclatures/bom/{bom}', [NomenclatureController::class, 'destroyBom'])->name('nomenclatures.bom.destroy');
    Route::post('translators/{translator}/add-pair', [TranslatorController::class, 'addLanguagePair'])->name('translators.add-pair');
    Route::post('translators/pair/{pair}/update-price', [TranslatorController::class, 'updatePrice'])->name('translators.update-price');

    // Управление полиграфией (покупки и быстрые продажи)
    Route::prefix('poligraphy')->name('poligraphy.')->group(function () {
        Route::get('/purchases', [PoligraphyController::class, 'purchasesIndex'])->name('purchases.index');
        Route::post('/purchases', [PoligraphyController::class, 'purchasesStore'])->name('purchases.store');
        
        Route::get('/sales', [PoligraphyController::class, 'salesIndex'])->name('sales.index');
        Route::post('/sales', [PoligraphyController::class, 'salesStore'])->name('sales.salesStore');
    });
});