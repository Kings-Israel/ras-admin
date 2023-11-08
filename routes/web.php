<?php

use App\Http\Controllers\Admin\DocumentController;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeliveryRequestController;
use App\Http\Controllers\PackagingController;
use App\Http\Controllers\FinancingInstitutionController;
use App\Http\Controllers\FinancingRequestController;
use App\Http\Controllers\InspectionRequestController;
use App\Http\Controllers\InspectorController;
use App\Http\Controllers\LogisticsController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StorageRequestController;
use App\Http\Controllers\StoreRequestController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\WarehouseController;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;


Route::middleware(['auth', 'web'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Warehouses
    Route::group(['prefix' => 'warehouses', 'as' => 'warehouses.'], function () {
        Route::get('/', [WarehouseController::class, 'index'])->name('index');
        Route::get('/create', [WarehouseController::class, 'create'])->name('create');
        Route::post('/store', [WarehouseController::class, 'store'])->name('store');
        Route::get('/{warehouse}/edit', [WarehouseController::class, 'edit'])->name('edit');
        Route::get('/{warehouse}/show', [WarehouseController::class, 'show'])->name('show');
        Route::patch('/{warehouse}/update', [WarehouseController::class, 'update'])->name('update');

<<<<<<< HEAD
        // Storage Requests
        Route::group(['prefix' => '{warehouse}/storage/requests', 'as' => 'storage.requests.'], function () {
            Route::get('/', [StorageRequestController::class, 'index'])->name('index');
        });

        // Orders
        Route::group(['prefix' => 'orders', 'as' => 'orders.'], function () {
            Route::get('/{warehouse}/orders', [WarehouseController::class, 'orders'])->name('index');
        });
    });
=======
    Route::get('/warehouses/storage/requests/{warehouse}', [StoreRequestController::class, 'index'])->name('warehouses.storage.requests');
>>>>>>> 4cd74771837a1a00c6f2f30ac09ef78f8c521ab3

    Route::resource('packaging', PackagingController::class);
    Route::get('/packaging', [PackagingController::class, 'index'])->name('packaging');

    Route::get('/products', [ProductController::class, 'index'])->name('products');

    // Financiers
    // Route::resource('/financing-institutions', FinancingInstitutionController::class);
    Route::group(['prefix' => 'financing/institutions'], function () {
        Route::get('/', [FinancingInstitutionController::class, 'index'])->name('financing.institutions.index');
        Route::get('/create', [FinancingInstitutionController::class, 'create'])->name('financing.institutions.create');
        Route::post('/store', [FinancingInstitutionController::class, 'store'])->name('financing.institutions.store');
        Route::get('/{financing_institution}/edit', [FinancingInstitutionController::class, 'edit'])->name('financing.institutions.edit');
        Route::get('/{financing_institution}/details', [FinancingInstitutionController::class, 'show'])->name('financing.institutions.show');
        Route::patch('/{financing_institution}', [FinancingInstitutionController::class, 'update'])->name('financing.institutions.update');
        Route::delete('/{financing_institution}', [FinancingInstitutionController::class, 'destroy'])->name('financing.institutions.delete');
    });

    // Vendors
    Route::group(['prefix' => '/vendors'], function () {
        Route::get('/', [VendorController::class, 'index'])->name('vendors.index');
        Route::get('/{business}', [VendorController::class, 'show'])->name('vendors.show');
        Route::get('/{business}/verify', [VendorController::class, 'verify'])->name('vendors.verify');
    });

    // Orders
    Route::group(['prefix' => '/orders'], function () {
        Route::get('/', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/{order}', [OrderController::class, 'show'])->name('orders.show');
    });

    // Financing Requests
    Route::group(['prefix' => 'financing/requests'], function () {
        Route::get('/', [FinancingRequestController::class, 'index'])->name('financing.requests.index');
        Route::get('{financing_request}/details', [FinancingRequestController::class, 'show'])->name('financing.requests.show');
        Route::get('{financing_request}/{status}/update', [FinancingRequestController::class, 'update'])->name('financing.requests.update');
    });

    // Inspectors
    Route::resource('/inspectors', InspectorController::class);
    Route::group(['prefix' => 'inspection/requests'], function () {
        Route::get('/', [InspectionRequestController::class, 'index'])->name('inspection.requests.index');
        Route::get('{inspection_request}/details', [InspectionRequestController::class, 'show'])->name('inspection.requests.show');
        Route::post('{inspection_request}/reports/store', [InspectionRequestController::class, 'store'])->name('inspection.requests.reports.store');
    });

    // Inspection Reports
    Route::group(['prefix' => 'inspection/reports'], function () {
        Route::get('/', [InspectionRequestController::class, 'reports'])->name('inspection.reports.index');
    });

    // Logistics
    Route::resource('/logistics', LogisticsController::class);
    Route::group(['prefix' => 'deliveries/', 'as' => 'deliveries.'], function () {
        Route::get('/', [DeliveryRequestController::class, 'index'])->name('index');
        Route::get('{order_delivery_request}', [DeliveryRequestController::class, 'show'])->name('show');
        Route::post('{order_delivery_request}/update', [DeliveryRequestController::class, 'update'])->name('update');
    });

    // Roles and Permissions
    Route::group(['prefix' => 'permissions/', 'as' => 'permissions.'], function () {
        Route::get('/', [PermissionController::class, 'index'])->name('index');
        Route::get('/create', [PermissionController::class, 'create'])->name('create');
        Route::post('/store', [PermissionController::class, 'store'])->name('store');
        Route::get('/{role}/edit', [PermissionController::class, 'edit'])->name('edit');
        Route::post('/{role}/update', [PermissionController::class, 'update'])->name('update');
        Route::get('/{role}/delete', [PermissionController::class, 'delete'])->name('delete');
    });

    // Vendor Registration Documents
    Route::group(['prefix' => 'documents/', 'as' => 'documents.'], function () {
        Route::get('/', [DocumentController::class, 'index'])->name('index');
        Route::patch('/{document}/update', [DocumentController::class, 'update'])->name('update');
        Route::get('/{document}/delete', [DocumentController::class, 'delete'])->name('delete');
    });

    // Settings
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
    Route::get('/vendor-users', [UsersController::class, 'vendors'])->name('users.vendors');
    Route::get('/financiers', [UsersController::class, 'financiers'])->name('users.financiers');
    Route::get('/inspector-users', [UsersController::class, 'inspectors'])->name('users.inspectors');
    Route::get('/warehousemanagers', [UsersController::class, 'warehouseManagers'])->name('users.warehousemanagers');
    Route::get('/drivers', [UsersController::class, 'drivers'])->name('users.drivers');
    Route::get('/user/{user}/details', [UsersController::class, 'show'])->name('users.show');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Logs
    Route::get('/logs', LogController::class)->name('logs');
});

if (config('app.env') == 'production') {
    Livewire::setUpdateRoute(function ($handle) {
        return Route::post('/ras-admin/livewire/update', $handle);
    });
}

require __DIR__.'/auth.php';
