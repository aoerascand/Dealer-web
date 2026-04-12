<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransactionController;

Route::get('/', [ProductController::class, 'landingPage'])->name('landing'); // Halaman depan untuk umum

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Midtrans Callback (No Auth Required, No CSRF)
Route::post('/api/midtrans/callback', [OrderController::class, 'callback']);

Route::middleware(['auth'])->group(function () {
    
    // --- KHUSUS ADMIN ---
    Route::middleware(['role:admin'])->prefix('admin')->group(function () {
        Route::resource('products', ProductController::class);
    });

    // --- KHUSUS KARYAWAN ---
    Route::middleware(['role:karyawan'])->prefix('staff')->group(function () {
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::post('/orders/{id}/complete', [OrderController::class, 'complete'])->name('orders.complete');
        // Karyawan entry order baru
        Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
        Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
        
        // Transaksi manual / bayar di tempat
        Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
    });

    // --- KHUSUS PELANGGAN ---
    // Note: Karyawan juga butuh checkout logic, tapi kita sekat biar rapi. Pelanggan punya role khusus ini.
    Route::middleware(['role:pelanggan'])->group(function () {
        Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout');
        Route::get('/my-orders', [OrderController::class, 'myOrders'])->name('my-orders');
        Route::get('/orders/{id}/payment', [OrderController::class, 'payment'])->name('orders.payment');
    });

    // --- KHUSUS BOS ---
    Route::middleware(['role:bos'])->group(function () {
        Route::get('/boss/dashboard', [DashboardController::class, 'index'])->name('boss.index');
    });

});