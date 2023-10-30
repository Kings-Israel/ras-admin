<?php

use App\Http\Controllers\Admin\DocumentController;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PackagingController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StoreRequestController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\WarehouseController;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;


Route::middleware(['auth', 'web'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/warehouses', [WarehouseController::class, 'index'])->name('warehouses');
    Route::get('/warehouses/create', [WarehouseController::class, 'create'])->name('warehouses.create');
    Route::post('warehouses/store', [WarehouseController::class, 'store'])->name('warehouses.store');
    Route::get('/warehouses/{warehouse}/edit', [WarehouseController::class, 'edit'])->name('warehouses.edit');
    Route::patch('/warehouses/{warehouse}/update', [WarehouseController::class, 'update'])->name('warehouses.update');

    Route::get('/warehouses/{warehouse}/storagerequests', [StoreRequestController::class, 'index'])->name('warehouses.storagerequests');

    Route::resource('packaging', PackagingController::class);
    Route::get('/packaging', [PackagingController::class, 'index'])->name('packaging');

    Route::get('/products', [ProductController::class, 'index'])->name('products');

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
        // Measurement Units
        Route::post('/units/{unit}/update', [SettingsController::class, 'updateUnit'])->name('unit.update');
        Route::get('/units/{unit}/delete', [SettingsController::class, 'deleteUnit'])->name('unit.delete');
    });

    Route::get('/customers', [UsersController::class, 'buyers'])->name('users.buyers');
    Route::get('/vendors', [UsersController::class, 'vendors'])->name('users.vendors');
    Route::get('/financiers', [UsersController::class, 'financiers'])->name('users.financiers');
    Route::get('/inspectors', [UsersController::class, 'inspectors'])->name('users.inspectors');
    Route::get('/warehousemanagers', [UsersController::class, 'warehouseManagers'])->name('users.warehousemanagers');
    Route::get('/drivers', [UsersController::class, 'drivers'])->name('users.drivers');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/logs', LogController::class)->name('logs');
});

if (config('app.env') == 'production') {
    Livewire::setUpdateRoute(function ($handle) {
        return Route::post('/ras-admin/livewire/update', $handle);
    });
}

require __DIR__.'/auth.php';
