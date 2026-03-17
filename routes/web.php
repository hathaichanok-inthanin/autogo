<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\AccountAdminController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Backend\ShopManagementController;
use App\Http\Controllers\Backend\UserManagementController;
use App\Http\Controllers\Backend\MarketingContentController;
use App\Http\Controllers\Backend\AccountingReportController;
use App\Http\Controllers\Backend\SystemSettingController;

use App\Http\Controllers\AuthMember\RegisterController;
use App\Http\Controllers\AuthMember\LoginController;

use App\Http\Controllers\AuthAdmin\RegisterAdminController;
use App\Http\Controllers\AuthAdmin\LoginAdminController;

use App\Http\Controllers\AuthStaff\LoginStaffController;
use App\Http\Controllers\Staff\StaffDashboardController;
use App\Http\Controllers\Staff\StaffOrderController;

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\BranchController;

use App\Http\Controllers\Frontend\TireSizeController;
use App\Http\Controllers\Frontend\SearchController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\PaymentController;
use App\Http\Controllers\Frontend\TireProductController;

Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');
    return 'DONE';
});


Route::get('', [FrontendController::class, 'index'])->name('home');
Route::get('contact-us', [FrontendController::class, 'contactUs'])->name('contact-us');
Route::post('contact-us', [FrontendController::class, 'contactUsPost'])->name('contact-us-post');
Route::get('promotion', [FrontendController::class, 'promotion'])->name('promotion');
Route::get('branch', [FrontendController::class, 'branch'])->name('branch');
Route::get('branch-detail/{id}',[FrontendController::class, 'branchDetail'])->name('branch-detail');
Route::get('about-us', [FrontendController::class, 'aboutUs'])->name('about-us');
Route::get('how-to-order', [FrontendController::class, 'howToOrder'])->name('how-to-order');
Route::get('frequently-asked-questions',[FrontendController::class, 'frequentlyAskedQuestions'])->name('frequently-asked-questions');

Route::get('branch/select/{id}', [BranchController::class, 'selectBranch'])->name('branch.select');


// Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
// Route::post('/login', [LoginController::class, 'login']);
// Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Route::get('register', [RegisterController::class, 'ShowRegisterForm']);
// Route::post('register', [RegisterController::class, 'register'])->name('register');


// ดึงขนาดยาง
Route::get('/get-ratios', [TireSizeController::class, 'getRatios'])->name('get.ratios');
Route::get('/get-rims', [TireSizeController::class, 'getRims'])->name('get.rims');

Route::post('tire-search', [SearchController::class, 'tireSearch'])->name('tires.search');

Route::post('cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('cart', [CartController::class, 'index'])->name('cart.index');
Route::get('cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::patch('update-cart', [CartController::class, 'update'])->name('update.cart');
Route::post('cart/proceed', [CartController::class, 'proceedToCheckout'])->name('cart.proceed');

// Route::middleware(['auth:member'])->group(function () {
    Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/payment/{id}', [CheckoutController::class, 'payment'])->name('checkout.payment');
    Route::get('/checkout/success/{id}', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::post('/payment/upload-slip', [PaymentController::class, 'uploadSlip'])->name('payment.upload-slip');
    Route::get('/checkout/check-status/{id}', [CheckoutController::class, 'checkStatus'])->name('checkout.check_status');

    Route::post('/order/cancel/{id}', [CheckoutController::class, 'cancelOrder'])->name('order.cancel');
// });

// products
Route::get('product/tire/brand', [TireProductController::class, 'productTireBrand'])->name('product.tire.brand');
Route::get('product/tire/brand/{brand}', [TireProductController::class, 'productTireByBrand']);
Route::get('product/tire/model/{brand}/{model}', [TireProductController::class, 'productTireByModel']);

// ยางรันแฟลต
Route::get('product/tire-runflat/brand', [TireProductController::class, 'productTireRunflatBrand']);
Route::get('product/tire-runflat/brand/{brand}', [TireProductController::class, 'productTireRunflatByBrand']);
Route::get('product/tire-runflat/model/{brand}/{model}', [TireProductController::class, 'productTireRunflatByModel']);

// ยาง EV
Route::get('product/tire-ev/brand', [TireProductController::class, 'productTireEVBrand']);
Route::get('product/tire-ev/brand/{brand}', [TireProductController::class, 'productTireEVByBrand']);
Route::get('product/tire-ev/model/{brand}/{model}', [TireProductController::class, 'productTireEVByModel']);


Route::group(['prefix' => 'admin/'], function(){
    // register / login
    Route::get('register', [RegisterAdminController::class, 'ShowRegisterForm']);
    Route::post('register', [RegisterAdminController::class, 'register']);

    Route::get('login', [LoginAdminController::class, 'ShowLoginForm'])->name('admin.login');
    Route::post('login', [LoginAdminController::class, 'login'])->name('admin.login.submit');
    Route::post('logout', [LoginAdminController::class, 'logout'])->name('admin.logout');
});

Route::middleware(['auth:admin', \App\Http\Middleware\LogAdminActivity::class])->group(function () {
    Route::group(['prefix' => 'admin/'], function(){

        // dashboard
        Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('message', [DashboardController::class, 'message'])->name('admin.message');


        // การสั่งซื้อ (Orders)
        Route::group(['prefix' => 'orders/'], function(){
            Route::get('', [OrderController::class, 'orders'])->name('orders.index'); //รายการสั่งซื้อทั้งหมด
            Route::get('pending-payment', [OrderController::class, 'pendingPayment'])->name('orders.pending'); //รอชำระเงิน
            Route::post('/{id}/approve', [OrderController::class, 'approvePayment'])->name('orders.approve');
            Route::get('history', [OrderController::class, 'history'])->name('orders.history');
        });

        // การนัดหมาย (Appointments)
        Route::get('appointments', [OrderController::class, 'appointments'])->name('appointments.index'); //ตารางนัดหมายติดตั้ง
        Route::get('confirm-status/{id}', [OrderController::class, 'confirmStatus']); //อัพเดตสถานะการติดตั้ง
        
        // จัดการสินค้า (Product Management)
        Route::group(['prefix' => 'products/'], function(){
            Route::get('', [ProductController::class, 'products'])->name('products.index'); //สินค้าทั้งหมด
            Route::get('categories', [ProductController::class, 'productCategories'])->name('categories.index'); //หมวดหมู่สินค้า
            Route::post('create-product-categories', [ProductController::class, 'createProductCategories']); //สร้างหมวดหมู่สินค้า
            Route::post('edit-product-categories', [ProductController::class, 'editProductCategories']); //แก้ไขหมวดหมู่สินค้า
            Route::get('delete-product-categories/{id}', [ProductController::class, 'deleteProductCategories']); //ลบหมวดหมู่สินค้า
            Route::get('brands', [ProductController::class, 'productBrand'])->name('brands.index'); //จัดการแบรนด์สินค้า
            Route::post('create-product-brand', [ProductController::class, 'createProductBrand']); //สร้างแบรนด์สินค้า
            Route::get('delete-product-brand/{id}', [ProductController::class, 'deleteProductBrand']); //ลบแบรนด์สินค้า
            Route::post('update-product-brand', [ProductController::class, 'updateProductBrand']);
            Route::get('search-brand', [ProductController::class, 'searchBrand'])->name('search.brand');
            Route::get('models', [ProductController::class, 'productModel'])->name('product_models.index'); //จัดการรุ่นสินค้า
            Route::post('create-product-model', [ProductController::class, 'createProductModel']); //สร้างรุ่นสินค้า
            Route::get('delete-product-model/{id}', [ProductController::class, 'deleteProductModel']);
            Route::post('update-product-model', [ProductController::class, 'updateProductModel']);
            Route::get('search-model', [ProductController::class, 'searchModel'])->name('search.model');
            
            // ลองเขียนแบบใหม่
            Route::get('create', [ProductController::class, 'create'])->name('products.create');
            Route::post('store', [ProductController::class, 'store'])->name('products.store');
            Route::get('edit/{id}', [ProductController::class, 'edit'])->name('products.edit');
            Route::post('update', [ProductController::class, 'update'])->name('products.update');
            Route::delete('destroy/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
            Route::get('history/{id}', [ProductController::class, 'getPriceHistory'])->name('products.history');
            Route::get('tire-sizes', [ProductController::class, 'tireSize'])->name('tire_sizes.index'); //จัดการขนาดยาง
            Route::post('create-tire-size', [ProductController::class, 'createTireSize']); //สร้างขนาดยางรถยนต์
            Route::get('search-size', [ProductController::class, 'searchSize'])->name('search.size');
            Route::get('delete-tire-size/{id}', [ProductController::class, 'deleteTireSize']);
        });

        // จัดการร้านค้าสาขา (Shop Management)
        Route::group(['prefix' => 'shops/'], function(){
            Route::get('', [ShopManagementController::class, 'index'])->name('shops.index'); //รายชื่อร้านค้าทั้งหมด
            Route::post('store', [ShopManagementController::class, 'store'])->name('shops.store');
            Route::delete('destroy/{id}', [ShopManagementController::class, 'destroy'])->name('shops.destroy');
            Route::post('shop-edit', [ShopManagementController::class, 'shopEdit'])->name('shops.edit');
        });

        // ผู้ใช้งาน (User Management)
        Route::group(['prefix' => 'users/'], function(){
            Route::get('admins', [UserManagementController::class, 'admins'])->name('users.admins.index'); //บัญชีของแอดมิน
            Route::get('delete-account-admin/{id}', [UserManagementController::class, 'deleteAccountAdmin']); //ลบบัญชีแอดมิน
            Route::post('edit-account-admin', [UserManagementController::class, 'editAccountAdmin']); //แก้ไขบัญชีแอดมิน
            Route::get('partners', [UserManagementController::class, 'partners'])->name('users.partners.index'); //บัญชีของร้านค้า (Partner)
            Route::post('add-partner', [UserManagementController::class, 'addPartner']);
            Route::post('delete-account-partner/{id}', [UserManagementController::class, 'deleteAccountPartner']);
            Route::post('edit-account-partner', [UserManagementController::class, 'editAccountPartner']);
            Route::get('staffs/{id}', [UserManagementController::class, 'staffs']);
            Route::post('add-staff', [UserManagementController::class, 'addStaff']);
            Route::post('delete-account-staff/{id}', [UserManagementController::class, 'deleteAccountStaff']);
            Route::post('edit-account-staff', [UserManagementController::class, 'editAccountStaff']);
        });

        // การตลาดและเนื้อหา (Marketing & Content)
        Route::group(['prefix' => 'marketing/'], function(){
            Route::get('promotions', [MarketingContentController::class, 'promotions'])->name('marketing.promotions.index'); //โปรโมชั่น
        });

        // บัญชีและรายงาน (Accounting & Reports)
        Route::group(['prefix' => 'reports/'], function(){
            Route::get('sales', [AccountingReportController::class, 'reportSale'])->name('reports.sales'); //รายงานยอดขาย
        });

    }); 

    // Ajax
    Route::get('/get-models/{brand_id}', [AjaxController::class, 'getModelByBrand']);
});

Route::group(['prefix' => 'staff/'], function(){
    Route::get('login', [LoginStaffController::class, 'ShowLoginForm'])->name('staff.login');
    Route::post('login', [LoginStaffController::class, 'login'])->name('staff.login.submit');
    Route::post('logout', [LoginStaffController::class, 'logout'])->name('staff.logout');
});

Route::middleware(['auth:staff', \App\Http\Middleware\LogAdminActivity::class])->group(function () {
    Route::group(['prefix' => 'staff/'], function(){
        // dashboard
        Route::get('dashboard', [StaffDashboardController::class, 'dashboard'])->name('staff.dashboard');
        Route::group(['prefix' => 'orders/'], function(){
            Route::get('', [StaffOrderController::class, 'orders'])->name('orders.index'); //รายการสั่งซื้อทั้งหมด
            Route::get('pending-payment', [StaffOrderController::class, 'pendingPayment'])->name('orders.pending'); //รอชำระเงิน
            Route::post('/{id}/approve', [StaffOrderController::class, 'approvePayment'])->name('orders.approve');
            Route::get('history', [StaffOrderController::class, 'history'])->name('orders.history');
        });
        // การนัดหมาย (Appointments)
        Route::get('appointments', [StaffOrderController::class, 'appointments'])->name('staff.appointments.index'); //ตารางนัดหมายติดตั้ง
        Route::get('confirm-status/{id}', [StaffOrderController::class, 'confirmStatus']); //อัพเดตสถานะการติดตั้ง
    });
});