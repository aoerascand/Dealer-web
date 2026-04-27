<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\EmployeeController;

Route::get('/', [ProductController::class, 'landingPage'])->name('landing'); // Halaman depan untuk umum
Route::view('/about', 'about')->name('about');
Route::get('/kategori', [ProductController::class, 'kategori'])->name('kategori');
Route::view('/contact', 'contact')->name('contact');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Product Detail (Public)
Route::get('/product/{product}', [ProductController::class, 'show'])->name('product.show');

Route::middleware(['auth'])->group(function () {
    
    // --- KHUSUS ADMIN ---
    Route::middleware(['role:admin'])->prefix('admin')->group(function () {
        Route::resource('products', ProductController::class);
        Route::post('products/{product}/variants', [ProductController::class, 'storeVariant'])->name('products.variants.store');
        Route::put('variants/{variant}', [ProductController::class, 'updateVariant'])->name('variants.update');
        Route::delete('variants/{variant}', [ProductController::class, 'destroyVariant'])->name('variants.destroy');
         Route::resource('employees', EmployeeController::class);
    });

    // --- KHUSUS KARYAWAN ---
    Route::middleware(['role:karyawan'])->prefix('staff')->group(function () {
        Route::get('/dashboard', [OrderController::class, 'dashboard'])->name('staff.dashboard');
        Route::get('/produk', [OrderController::class, 'produk'])->name('staff.produk');
        
        Route::get('/entry', [OrderController::class, 'create'])->name('staff.entry');
        Route::post('/entry', [OrderController::class, 'store'])->name('staff.store');
        
        Route::post('/orders/{id}/complete', [OrderController::class, 'complete'])->name('orders.complete');
        Route::post('/orders/{id}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
        // Transaksi manual / bayar di tempat
        Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
    });

    // --- KHUSUS PELANGGAN ---
    // Note: Karyawan juga butuh checkout logic, tapi kita sekat biar rapi. Pelanggan punya role khusus ini.
    Route::middleware(['role:pelanggan'])->group(function () {
        Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout');
        Route::get('/my-orders', [OrderController::class, 'myOrders'])->name('my-orders');
        Route::get('/my-orders/{order}/receipt', [OrderController::class, 'receipt'])->name('orders.receipt');
    });

    Route::middleware(['auth', 'role:admin,bos'])->group(function () {
    Route::get('/laporan', [DashboardController::class, 'laporan'])->name('laporan');

});

    Route::middleware(['auth', 'role:bos'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
});