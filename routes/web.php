<?php

use App\Http\Controllers\Admin\DocumentController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::group(['prefix' => 'permissions/', 'as' => 'permissions.'], function () {
        Route::get('/', [PermissionController::class, 'index'])->name('index');
        Route::get('/create', [PermissionController::class, 'create'])->name('create');
        Route::post('/store', [PermissionController::class, 'store'])->name('store');
        Route::get('/{role}/edit', [PermissionController::class, 'edit'])->name('edit');
        Route::post('/{role}/update', [PermissionController::class, 'update'])->name('update');
        Route::get('/{role}/delete', [PermissionController::class, 'delete'])->name('delete');
    });

    Route::group(['prefix' => 'documents/', 'as' => 'documents.'], function () {
        Route::get('/', [DocumentController::class, 'index'])->name('index');
        Route::patch('/{document}/update', [DocumentController::class, 'update'])->name('update');
        Route::get('/{document}/delete', [DocumentController::class, 'delete'])->name('delete');
    });

    Route::group(['prefix' => 'settings/', 'as' => 'settings.'], function() {
        Route::get('/', [SettingsController::class, 'index'])->name('index');
        // Categories
        Route::post('/category/{category}/update', [SettingsController::class, 'updateCategory'])->name('category.update');
        Route::post('/category/{category}/delete', [SettingsController::class, 'deleteCategory'])->name('category.delete');
        // Documents
        Route::post('/docuemnt/store', [SettingsController::class, 'documentStore'])->name('document.store');
        Route::get('/document/{document}/edit', [SettingsController::class, 'editDocument'])->name('document.edit');
        Route::patch('/document/{document}/update', [SettingsController::class, 'updateDocument'])->name('document.update');
        Route::get('/document/{document}/delete', [SettingsController::class, 'deleteDocument'])->name('document.delete');
        // Countries and Cities
        Route::get('/country/{country}/edit', [SettingsController::class, 'editCountry'])->name('country.edit');
        Route::post('/country/{country}/update', [SettingsController::class, 'updateCountry'])->name('country.update');
        Route::post('/country/{country}/delete', [SettingsController::class, 'deleteCountry'])->name('country.delete');
        Route::post('/{country}/city/store', [SettingsController::class, 'storeCity'])->name('city.store');
        Route::post('/city/{city}/update', [SettingsController::class, 'updateCity'])->name('city.update');
        Route::get('/city/{city}/delete', [SettingsController::class, 'deleteCity'])->name('city.delete');
    });

    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
