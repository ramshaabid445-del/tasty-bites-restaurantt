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
use App\Http\Controllers\Frontend\AboutController as FrontendAboutController;
use App\Http\Controllers\Frontend\BlogController as FrontendBlogController;
use App\Http\Controllers\Frontend\CartController as FrontendCartController;
use App\Http\Controllers\Frontend\CheckoutController as FrontendCheckoutController;
use App\Http\Controllers\Frontend\ContactController as FrontendContactController;
use App\Http\Controllers\Frontend\HomeController as FrontendHomeController;
use App\Http\Controllers\Frontend\MenuItemController as FrontendMenuItemController;
use App\Http\Controllers\Frontend\ReservationController as FrontendReservationController;
use App\Http\Controllers\Frontend\SearchController as FrontendSearchController;
use App\Http\Controllers\Frontend\ShopController as FrontendShopController;
// Settings Controller Link Kiya
use App\Http\Controllers\Backend\SettingsController; 
use Illuminate\Support\Facades\Route;

// Customer-facing frontend
Route::name('frontend.')->group(function () {
    Route::get('/', FrontendHomeController::class)->name('home');
    Route::get('/about', FrontendAboutController::class)->name('about');
    Route::get('/shop', [FrontendShopController::class, 'index'])->name('shop.index');
    Route::get('/menu/{menuItem:slug}', [FrontendMenuItemController::class, 'show'])->name('menu.show');
    Route::get('/search/menu-items', FrontendSearchController::class)->name('search.menu-items');

    Route::get('/cart', [FrontendCartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [FrontendCartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/{rowId}', [FrontendCartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{rowId}', [FrontendCartController::class, 'destroy'])->name('cart.destroy');
    Route::get('/cart-summary', [FrontendCartController::class, 'summary'])->name('cart.summary');

    Route::get('/checkout', [FrontendCheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [FrontendCheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/order-confirmation/{order}', [FrontendCheckoutController::class, 'confirmation'])->name('orders.confirmation');

    Route::get('/reservation', [FrontendReservationController::class, 'create'])->name('reservation.create');
    Route::post('/reservation', [FrontendReservationController::class, 'store'])->name('reservation.store');

    Route::get('/blog', [FrontendBlogController::class, 'index'])->name('blog.index');
    Route::get('/blog/{post:slug}', [FrontendBlogController::class, 'show'])->name('blog.show');

    Route::get('/contact', [FrontendContactController::class, 'index'])->name('contact.index');
    Route::post('/contact', [FrontendContactController::class, 'store'])->name('contact.store');
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
        
        // 1. Live orders page load karne ke liye
        Route::get('/live', [OrderController::class, 'live'])->name('live'); 
        
        // 2. Ready to Dispatch page load karne ke liye (Ab 404 error nahi aayega)
        Route::get('/dispatch', [OrderController::class, 'dispatchList'])->name('dispatch');
        
        // 3. Order History page load karne ke liye
        Route::get('/history', [OrderController::class, 'history'])->name('history');
        
        // 4. Kisi specific order ki details dekhne ke liye
        Route::get('/show/{id}', [OrderController::class, 'show'])->name('show');
        
        // 5. Dispatch button dabane par order status update karne ke liye (POST aur PUT dono support karega)
        Route::match(['POST', 'PUT'], '/update-status/{id}', [OrderController::class, 'updateStatus'])->name('updateStatus');
        
    });

    // 5. KDS
    Route::prefix('kds')->name('kds.')->group(function () {
        Route::get('/', [KDSController::class, 'index'])->name('index');
        Route::post('/update-status/{id}', [KDSController::class, 'updateStatus'])->name('updateStatus');
    });

    // 6. Inventory & Stock Management
    Route::prefix('inventory')->name('inventory.')->group(function () {
    // 1. Raw Materials
    Route::resource('raw-materials', RawMaterialController::class);
    // 2. Suppliers
    Route::resource('suppliers', SupplierController::class);
    // 3. Purchase Orders (YEH HAI ASLI FIX)
    Route::resource('purchase-orders', PurchaseOrderController::class);
    
    Route::get('/wastage', [WastageController::class, 'index'])->name('wastage.index');
    Route::post('/wastage/store', [WastageController::class, 'store'])->name('wastage.store');
  });

    // 7. Table Management
    Route::get('/tables/floor-plans', [TableController::class, 'floorPlans'])->name('tables.floor-plans');
    Route::resource('tables', TableController::class);

    // 8. HR & Staff (Blade Files Ke Purane Names Ke Saath Sahi Mapping)
    Route::prefix('hr')->group(function () {
        
        // Employees & Roles (Yeh pehle se sahi chal rahe the)
        Route::get('/employees', [HRController::class, 'index'])->name('hr.employees');
        Route::post('/employees/store', [HRController::class, 'store'])->name('hr.employees.store');
        Route::get('/roles', [HRController::class, 'roles'])->name('hr.roles');
        Route::post('/roles/store', [HRController::class, 'storeRole'])->name('hr.roles.store');
        Route::delete('/roles/delete/{id}', [HRController::class, 'destroyRole'])->name('hr.roles.delete');
        
        // Attendance - Inke names ke sath 'admin.' khud lag jayega, aur blade file se match ho jayega
        Route::get('/attendance', [HRController::class, 'attendance'])->name('attendance');
        Route::post('/attendance/store', [HRController::class, 'storeAttendance'])->name('attendance.store');
        Route::put('/attendance/checkout/{id}', [HRController::class, 'updateCheckout'])->name('attendance.checkout');
        Route::delete('/attendance/destroy/{id}', [HRController::class, 'destroyAttendance'])->name('attendance.destroy');
    });

    // 9. CRM
   Route::prefix('crm')->name('crm.')->group(function () {
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers');
    Route::post('/customers/store', [CustomerController::class, 'store'])->name('customers.store');
    Route::get('/loyalty', [CustomerController::class, 'loyalty'])->name('loyalty');
    
    // Add this line below
    Route::post('/loyalty/add', [CustomerController::class, 'addLoyaltyPoints'])->name('loyalty.add');

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
         // Ye lazmi add karein toggle functionality ke liye
        Route::post('/toggle-status/{id}', [ReportController::class, 'toggleStatus'])->name('toggle-status');
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
