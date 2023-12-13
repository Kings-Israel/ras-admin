<?php

use App\Http\Controllers\Admin\DocumentController;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeliveryRequestController;
use App\Http\Controllers\PackagingController;
use App\Http\Controllers\FinancingInstitutionController;
use App\Http\Controllers\FinancingRequestController;
use App\Http\Controllers\InspectionRequestController;
use App\Http\Controllers\InspectorController;
use App\Http\Controllers\LogisticsController;
use App\Http\Controllers\MarketingController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StorageRequestController;
use App\Http\Controllers\StoreRequestController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\InsuranceController;
use App\Http\Controllers\OrderRequestController;
use App\Http\Controllers\WarehouseProductController;
use App\Http\Controllers\Wing\ShelvesController;
use App\Http\Controllers\Wing\WingController;
use App\Http\Controllers\Wing\WingLocationController;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;


Route::middleware(['auth', 'web'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/conversations/{user?}', [ChatController::class, 'conversations']);
    Route::get('/conversations/order/{order}', [ChatController::class, 'orderConversations']);
    Route::get('/chat/{user?}', [ChatController::class, 'index'])->name('messages');
    Route::get('/messages/chat/{id}', [ChatController::class, 'view'])->name('messages.chat');
    Route::post('/messages/send', [ChatController::class, 'store'])->name('messages.send');

    // Update Order Request
    Route::post('/order-request/{order_request}/update', OrderRequestController::class)->name('order.request.update');

    // Warehouses
    Route::group(['prefix' => 'warehouses', 'as' => 'warehouses.'], function () {
        Route::get('/', [WarehouseController::class, 'index'])->name('index');
        Route::get('/create', [WarehouseController::class, 'create'])->name('create');
        Route::post('/store', [WarehouseController::class, 'store'])->name('store');
        Route::get('/{warehouse}/edit', [WarehouseController::class, 'edit'])->name('edit');
        Route::get('/{warehouse}/show', [WarehouseController::class, 'show'])->name('show');
        Route::patch('/{warehouse}/update', [WarehouseController::class, 'update'])->name('update');

        // Storage Requests
        // Route::group(['prefix' => '{warehouse}/storage/requests', 'as' => 'storage.requests.'], function () {
        //     Route::get('/', [StorageRequestController::class, 'index'])->name('index');
        // });

        // Orders
        Route::group(['prefix' => 'orders', 'as' => 'orders.'], function () {
            Route::get('/buyers/orders/{warehouse?}', [WarehouseController::class, 'buyerOrders'])->name('requests.buyers.index');
            Route::get('/vendors/orders/{warehouse?}', [WarehouseController::class, 'vendorOrders'])->name('requests.vendors.index');
            Route::get('/{order_request}/details', [WarehouseController::class, 'order'])->name('requests.details');

            Route::post('/{release_product_request}/product/release', [OrderController::class, 'releaseProduct'])->name('product.release');
        });
    });

    Route::get('/warehouses/storage/requests/{warehouse}', [StoreRequestController::class, 'index'])->name('warehouses.storage.requests');

    Route::resource('packaging', PackagingController::class);
    Route::resource('payments', PaymentController::class);
    Route::get('/packaging', [PackagingController::class, 'index'])->name('packaging');

    Route::get('/api/products/{id}', [ProductController::class, 'details'])->name('product.details');
    Route::get('/products', [ProductController::class, 'index'])->name('products');
//    Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
    Route::get('/product/store', [ProductController::class, 'store'])->name('product.store');


    Route::post('/products/store', [WarehouseProductController::class, 'store'])->name('products.store');
    Route::get('/{product}/edit', [WarehouseProductController::class, 'edit'])->name('products.edit');
    Route::patch('/{product}/update', [WarehouseProductController::class, 'update'])->name('products.update');


    Route::resource('wings', WingController::class);
    Route::get('wing/locations/{wingid}', [WingController::class, 'show'])->name('wing.locations');
    Route::resource('winglocations', WingLocationController::class);
    Route::resource('locationshelves', ShelvesController::class);
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
        Route::get('/customers', [FinancingInstitutionController::class, 'customers'])->name('financing.institutions.customers');
        Route::geT('/customers/{user}', [FinancingInstitutionController::class, 'customer'])->name('financing.institutions.customer');
    });

    // Vendors
    Route::group(['prefix' => '/vendors'], function () {
        Route::get('/', [VendorController::class, 'index'])->name('vendors.index');
        Route::get('/{business}', [VendorController::class, 'show'])->name('vendors.show');
        Route::post('/{business}/update', [VendorController::class, 'update'])->name('vendors.update');
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
        Route::get('/', [InspectorController::class, 'orders'])->name('inspection.requests.index');
        Route::get('/{order_request}/details', [InspectorController::class, 'order'])->name('inspection.requests.show');
        Route::get('/reports/pending', [InspectorController::class, 'pendingReports'])->name('inspection.requests.reports.pending');
        Route::get('/reports/completed', [InspectorController::class, 'completedReports'])->name('inspection.requests.reports.completed');
        Route::get('/{order_request}/reports/create', [InspectorController::class, 'createReport'])->name('inspection.requests.reports.create');
        Route::post('{order_request}/reports/store', [InspectorController::class, 'storeReport'])->name('inspection.requests.reports.store');
    });

    // Inspection Reports
    Route::group(['prefix' => 'inspection/reports'], function () {
        Route::get('/', [InspectionRequestController::class, 'reports'])->name('inspection.reports.index');
    });

    // Logistics
    Route::resource('/logistics', LogisticsController::class);
    Route::group(['prefix' => 'deliveries/', 'as' => 'deliveries.'], function () {
        Route::group(['prefix' => 'requests/', 'as' => 'requests.'], function () {
            Route::get('/', [LogisticsController::class, 'orders'])->name('index');
            Route::get('{order_request}', [LogisticsController::class, 'order'])->name('show');
            Route::post('{delivery_request}/update', [DeliveryRequestController::class, 'update'])->name('update');
        });
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

    // Insurance Companies
    Route::group(['prefix' => 'insurance', 'as' => 'insurance.'], function () {
        Route::group(['prefix' => '/companies', 'as' => 'companies.'], function () {
            Route::get('/', [InsuranceController::class, 'companies'])->name('index');
            Route::get('/create', [InsuranceController::class, 'createCompany'])->name('create');
            Route::post('/store', [InsuranceController::class, 'storeCompany'])->name('store');
            Route::get('/{insurance_company}', [InsuranceController::class, 'company'])->name('show');
            Route::get('/{insurance_company}/edit', [InsuranceController::class, 'editCompany'])->name('edit');
            Route::put('/{insurance_company}/update', [InsuranceController::class, 'updateCompany'])->name('update');
        });

        Route::group(['prefix' => '/requests', 'as' => 'requests.'], function () {
            Route::get('/', [InsuranceController::class, 'orders'])->name('index');
            Route::get('/{order_request}/details', [InsuranceController::class, 'order'])->name('show');
            Route::put('/{insurance_request}/update', [InsuranceController::class, 'updateRequest'])->name('update');
        });

        Route::group(['prefix' => '/reports', 'as' => 'reports.'], function () {
            Route::get('/', [InsuranceController::class, 'reports'])->name('index');
            Route::post('/store', [InsuranceController::class, 'storeReport'])->name('store');
            Route::put('/{insurance_report}/update', [InsuranceController::class, 'updateReport'])->name('update');
        });
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
        // Service Charges Rate
        Route::post('/services/rate/update', [SettingsController::class, 'updateServiceChargeRate'])->name('rate.update');
    });

    Route::get('/customers', [UsersController::class, 'buyers'])->name('users.buyers');
    Route::get('/vendor-users', [UsersController::class, 'vendors'])->name('users.vendors');
    Route::get('/financiers', [UsersController::class, 'financiers'])->name('users.financiers');
    Route::get('/inspector-users', [UsersController::class, 'inspectors'])->name('users.inspectors');
    Route::get('/warehousemanagers', [UsersController::class, 'warehouseManagers'])->name('users.warehousemanagers');
    Route::get('/drivers', [UsersController::class, 'drivers'])->name('users.drivers');
    Route::get('/drivers/add', [UsersController::class, 'createDriver'])->name('users.drivers.create');
    Route::post('/drivers/store', [UsersController::class, 'storeDriver'])->name('users.drivers.store');
    Route::get('/user/{user}/details', [UsersController::class, 'show'])->name('users.show');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Marketing
    Route::group(['prefix' => 'marketing', 'as' => 'marketing.'], function () {
        Route::get('/', [MarketingController::class, 'index'])->name('index');
        Route::get('/create', [MarketingController::class, 'create'])->name('create');
        Route::post('/store', [MarketingController::class, 'store'])->name('store');
        Route::get('/{marketing_poster}/edit', [MarketingController::class, 'edit'])->name('edit');
        Route::put('/{marketing_poster}/update', [MarketingController::class, 'update'])->name('update');
        Route::get('/{marketing_poster}/delete', [MarketingController::class, 'delete'])->name('delete');
    });

    // Logs
    Route::get('/logs', LogController::class)->name('logs');
});

if (config('app.env') == 'production') {
    Livewire::setUpdateRoute(function ($handle) {
        return Route::post('/livewire/update', $handle);
    });
}

require __DIR__.'/auth.php';
