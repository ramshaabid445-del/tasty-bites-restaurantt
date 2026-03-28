<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\MenuItemController;
use App\Http\Controllers\Backend\AddonController;
use App\Http\Controllers\Backend\TableController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Backend\POSController;
use App\Http\Controllers\Backend\KDSController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\ReportController;
use App\Http\Controllers\Backend\RawMaterialController;
use App\Http\Controllers\Backend\SupplierController;
use App\Http\Controllers\Backend\PurchaseOrderController; 
use App\Http\Controllers\Backend\WastageController;
use App\Http\Controllers\Backend\HRController;
use App\Http\Controllers\Backend\CustomerController;
use App\Http\Controllers\Backend\FinanceController;
// Settings Controller Link Kiya
use App\Http\Controllers\Backend\SettingsController; 
use Illuminate\Support\Facades\Route;

// 1. Root Redirect
Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});

// Auth Default Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// ==========================================
// ADMIN / BACKEND MASTER GROUP
// ==========================================
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    
    // 1. Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // 2. Menu Management
    Route::resource('categories', CategoryController::class);
    Route::resource('menu-items', MenuItemController::class);
    Route::resource('addons', AddonController::class);
   // Menu Management section mein line change karein:
    Route::resource('deals',         App\Http\Controllers\Backend\DealController::class);

    // 3. POS Terminal
    Route::prefix('pos')->name('pos.')->group(function () {
        Route::get('/', [POSController::class, 'index'])->name('index');
        Route::post('/store', [POSController::class, 'storeOrder'])->name('store');
        Route::get('/invoice/{id}', [POSController::class, 'showInvoice'])->name('invoice');
    });

    // 4. Order & Kitchen Management
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/live', [OrderController::class, 'live'])->name('live'); 
        Route::get('/dispatch', [OrderController::class, 'dispatchList'])->name('dispatch');
        Route::get('/history', [POSController::class, 'orderHistory'])->name('history');
        Route::get('/show/{id}', [OrderController::class, 'show'])->name('show');
        Route::post('/update-status/{id}', [POSController::class, 'updateStatus'])->name('updateStatus');
    });

    // 5. KDS
    Route::prefix('kds')->name('kds.')->group(function () {
        Route::get('/', [KDSController::class, 'index'])->name('index');
        Route::post('/update-status/{id}', [KDSController::class, 'updateStatus'])->name('updateStatus');
    });

    // 6. Inventory & Stock Management
    Route::prefix('inventory')->name('inventory.')->group(function () {
        Route::resource('raw-materials', RawMaterialController::class);
        Route::resource('suppliers', SupplierController::class);
        Route::resource('purchase-orders', PurchaseOrderController::class);
        Route::get('/wastage', [WastageController::class, 'index'])->name('wastage.index');
        Route::post('/wastage/store', [WastageController::class, 'store'])->name('wastage.store');
    });

    // 7. Table Management
    Route::get('/tables/floor-plans', [TableController::class, 'floorPlans'])->name('tables.floor-plans');
    Route::resource('tables', TableController::class);

    // 8. HR & Staff
    Route::prefix('hr')->name('hr.')->group(function () {
        Route::get('/employees', [HRController::class, 'index'])->name('employees');
        Route::post('/employees/store', [HRController::class, 'store'])->name('employees.store');
        Route::get('/roles', [HRController::class, 'roles'])->name('roles');
        Route::post('/roles/store', [HRController::class, 'storeRole'])->name('roles.store');
        Route::delete('/roles/delete/{id}', [HRController::class, 'destroyRole'])->name('roles.delete');
        Route::get('/attendance', [HRController::class, 'attendance'])->name('attendance');
    });

    // 9. CRM
    Route::prefix('crm')->name('crm.')->group(function () {
        Route::get('/customers', [CustomerController::class, 'index'])->name('customers');
        Route::post('/customers/store', [CustomerController::class, 'store'])->name('customers.store');
        Route::get('/loyalty', [CustomerController::class, 'loyalty'])->name('loyalty');
        Route::get('/feedback', [CustomerController::class, 'feedback'])->name('feedback');
    });

    // Finance & Accounts
Route::prefix('finance')->name('finance.')->group(function () {
    Route::get('/sales', [FinanceController::class, 'salesIndex'])->name('sales');
    Route::get('/expenses', [FinanceController::class, 'expenseIndex'])->name('expenses');
    Route::post('/expenses/store', [FinanceController::class, 'storeExpense'])->name('expenses.store');
    
    Route::get('/taxes', [FinanceController::class, 'taxIndex'])->name('taxes');
    
    // POST ki jagah match use karein taake Method error bypass ho jaye
    Route::match(['get', 'post', 'put'], '/taxes/update', [FinanceController::class, 'taxUpdate'])->name('taxes.update');
});

    // 11. Reports & Analytics
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/daily-sales', [ReportController::class, 'dailySales'])->name('daily-sales');
        Route::get('/best-sellers', [ReportController::class, 'bestSellers'])->name('best-sellers');
        Route::get('/stock', [ReportController::class, 'stockReport'])->name('stock'); 
    });

    // 12. Settings Configuration (FULL UPDATE)
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/general', [SettingsController::class, 'generalInfo'])->name('general');
        Route::get('/payment', [SettingsController::class, 'paymentGateways'])->name('payment');
        Route::get('/printer', [SettingsController::class, 'printerSetup'])->name('printer');
        // Data save karne ke liye POST route
        Route::post('/update', [SettingsController::class, 'update'])->name('update');
    });
});