<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\AuthAdminController;
use App\Http\Controllers\AuthCustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\ChatAIController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

Route::get('/register', [AuthCustomerController::class, 'registerForm'])->name('register.form');
Route::post('/register', [AuthCustomerController::class, 'register'])->name('register');
Route::get('/login', [AuthCustomerController::class, 'loginForm'])->name('login.form');
Route::post('/login', [AuthCustomerController::class, 'login'])->name('login');
Route::get('/logout', [AuthCustomerController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::get('/admin/login', [AuthAdminController::class, 'loginForm'])->name('admin.login.form');
Route::post('/admin/login', [AuthAdminController::class, 'login'])->name('admin.login');
Route::get('/admin/logout', [AuthAdminController::class, 'logout'])->name('admin.logout');

Route::middleware('admin.auth')->prefix('admin')->group(function () {

    // Produk
    Route::get('/products', [AdminProductController::class, 'index'])->name('admin.products.index');
    Route::get('/products/create', [AdminProductController::class, 'create'])->name('admin.products.create');
    Route::post('/products', [AdminProductController::class, 'store'])->name('admin.products.store');
    Route::get('/products/{id}/edit', [AdminProductController::class, 'edit'])->name('admin.products.edit');
    Route::post('/products/{id}', [AdminProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/products/{id}', [AdminProductController::class, 'destroy'])->name('admin.products.destroy');

    // Pesanan
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/orders/{id}', [AdminOrderController::class, 'show'])->name('admin.orders.show'); 
    Route::post('/orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.status');

    // Laporan
    Route::get('/reports', [ReportController::class, 'index'])->name('admin.reports.index');
    Route::get('/reports/pdf', [ReportController::class, 'downloadPdf'])->name('admin.reports.pdf');
});


/*
|--------------------------------------------------------------------------
| Customer Routes
|--------------------------------------------------------------------------
*/
Route::middleware('customer.auth')->group(function () {

    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product_id}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update/{product_id}', [CartController::class, 'updateQty'])->name('cart.update');
    Route::post('/cart/remove/{product_id}', [CartController::class, 'remove'])->name('cart.remove');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'checkoutForm'])->name('checkout.form');
    Route::post('/checkout', [CheckoutController::class, 'processCheckout'])->name('checkout.process');

    // Payment
    Route::get('/payments/{order_id}', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/payments/{order_id}', [PaymentController::class, 'store'])->name('payments.store');

    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

/*
|--------------------------------------------------------------------------
| Chat AI
|--------------------------------------------------------------------------
*/
Route::get('/chat-ai', [App\Http\Controllers\ChatAIController::class, 'index'])
    ->name('chat.index');
Route::post('/chat-ai/send', [App\Http\Controllers\ChatAIController::class, 'sendMessage'])
    ->name('chat.send');

/*
|--------------------------------------------------------------------------
| Checkout Success Page
|--------------------------------------------------------------------------
*/
Route::get('/checkout/success', fn() => view('orders.success'))->name('checkout.success');
