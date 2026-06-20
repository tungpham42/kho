<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StockTransferController;
use App\Http\Controllers\StocktakeController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\EmployeeController;

Route::get('/', function () {
    return view('welcome');
});

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Protected Routes (Tenant & Authorized Employees)
Route::middleware('auth:web,employee')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', function () { return view('dashboard'); })->name('dashboard');

    // === NHÓM QUYỀN: QUẢN LÝ SẢN PHẨM (manage_products) ===
    Route::middleware('role:manage_products')->group(function () {
        Route::get('products/export', [ProductController::class, 'export'])->name('products.export');
        Route::post('products/import', [ProductController::class, 'import'])->name('products.import');
        Route::get('products/template', [ProductController::class, 'downloadTemplate'])->name('products.template');
        Route::resource('warehouses', WarehouseController::class)->except(['create', 'show', 'edit']);
        Route::resource('partners', PartnerController::class)->except(['create', 'show', 'edit']);
        Route::resource('products', ProductController::class)->except(['create', 'show', 'edit']);
    });

    // === NHÓM QUYỀN: QUẢN LÝ ĐƠN HÀNG (manage_orders) ===
    Route::middleware('role:manage_orders')->group(function () {
        Route::resource('orders', OrderController::class)->only(['index', 'create', 'store', 'destroy']);
        Route::post('orders/{order}/approve', [OrderController::class, 'approve'])->name('orders.approve');
    });

    // === NHÓM QUYỀN: QUẢN LÝ TỒN KHO (manage_inventory) ===
    Route::middleware('role:manage_inventory')->group(function () {
        Route::resource('transfers', StockTransferController::class)->only(['index', 'create', 'store']);
        Route::post('transfers/{transfer}/approve', [StockTransferController::class, 'approve'])->name('transfers.approve');

        Route::resource('stocktakes', StocktakeController::class)->only(['index', 'create', 'store', 'destroy']);
        Route::post('stocktakes/{stocktake}/approve', [StocktakeController::class, 'approve'])->name('stocktakes.approve');
    });

    // === NHÓM QUYỀN: XEM BÁO CÁO (view_reports) ===
    Route::middleware('role:view_reports')->group(function () {
        Route::get('/inventories', [InventoryController::class, 'index'])->name('inventories.index');
    });

    // === CÁC CHỨC NĂNG CHỈ DÀNH RIÊNG CHO TENANT (Chủ doanh nghiệp) ===
    // Bạn có thể viết riêng một middleware 'tenant.only' hoặc lợi dụng role rỗng/không tồn tại cho nhân viên.
    // Tốt nhất là tạo riêng một route group chỉ cho auth:web
});

// Nhóm chỉ dành cho Web Guard (Chủ doanh nghiệp)
Route::middleware('auth:web')->group(function () {
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'store'])->name('settings.store');
    Route::resource('employees', EmployeeController::class)->except(['show']);
});
