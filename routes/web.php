<?php

use Illuminate\Support\Facades\Route;

// FRONTEND CONTROLLERS
use App\Http\Controllers\Front\ProductController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\Front\PaymentController;

// =========================
// HALAMAN WELCOME / LANDING PAGE
// =========================
Route::get('/', function () {
    return view('landing');
})->name('home');

// =========================
// PRODUK
// =========================
Route::get('/product', [ProductController::class, 'index'])->name('product.index');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');

// =========================
// CHECKOUT
// =========================
// Use a route parameter so the product is passed explicitly (avoids missing product_id)
Route::get('/checkout/{product}', [CheckoutController::class, 'showCheckoutForm'])
    ->name('checkout.view');

Route::post('/checkout', [CheckoutController::class, 'checkout'])
    ->name('checkout');

Route::get('/payment/upload/{order_id}', function ($order_id) {
    $order = \App\Models\Order::findOrFail($order_id);
    return view('front.payment.upload', compact('order'));
})->name('payment.upload.form');

Route::post('/payment/upload', [PaymentController::class, 'uploadProof'])
    ->name('payment.upload');

Route::get('/checkout/invoice/{order_id}', function ($order_id) {
    $order = \App\Models\Order::with(['customer', 'items.product'])->findOrFail($order_id);
    return view('front.checkout.invoice', compact('order'));
})->name('invoice.show');

// DEV: storage debug route - lists public storage files and product DB image fields
if (app()->environment('local') || app()->environment('development')) {
    Route::get('/dev/storage-debug', function () {
        $files = \Illuminate\Support\Facades\Storage::disk('public')->allFiles('products');
        $products = \App\Models\Product::select('id', 'name', 'image')->get();
        return response()->json([
            'files_in_storage/products' => $files,
            'products' => $products,
        ]);
    });
}


// =========================
// AUTH (FORTIFY ROUTES)
// =========================
use Laravel\Fortify\Fortify;

// Login View
Fortify::loginView(function () {
    return view('auth.login');
});

// Register View
Fortify::registerView(function () {
    return view('auth.register');
});

// =========================
// BUYER DASHBOARD
// =========================
use App\Http\Controllers\Buyer\DashboardController as BuyerDashboardController;

Route::middleware(['auth', 'buyer'])->prefix('buyer')->name('buyer.')->group(function () {
    Route::get('/dashboard', [BuyerDashboardController::class, 'index'])->name('dashboard');
    Route::get('/orders', [BuyerDashboardController::class, 'orders'])->name('orders');
});

// =========================
// ADMIN PANEL
// =========================
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminProductVariantController;
use App\Http\Controllers\Admin\AdminPromoController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\PaymentVerifyController;

Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Products
    Route::resource('products', AdminProductController::class);
    
    // Product Variants
    Route::post('/products/{product}/variants', [AdminProductVariantController::class, 'store'])->name('products.variants.store');
    Route::put('/variants/{variant}', [AdminProductVariantController::class, 'update'])->name('variants.update');
    Route::delete('/variants/{variant}', [AdminProductVariantController::class, 'destroy'])->name('variants.destroy');
    
    // Promos
    Route::post('/variants/{variant}/promos', [AdminPromoController::class, 'store'])->name('variants.promos.store');
    Route::put('/promos/{promo}', [AdminPromoController::class, 'update'])->name('promos.update');
    Route::delete('/promos/{promo}', [AdminPromoController::class, 'destroy'])->name('promos.destroy');
    
    // Orders
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/export-pdf', [AdminOrderController::class, 'exportPdf'])->name('orders.exportPdf');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
    
    // Customers
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/customers/{customer}', [CustomerController::class, 'show'])->name('customers.show');
    
    // Payments
    Route::get('/payments', [PaymentVerifyController::class, 'index'])->name('payments.index');
    Route::post('/payments/{id}/verify', [PaymentVerifyController::class, 'verify'])->name('payments.verify');
    Route::post('/payments/{id}/send-access', [PaymentVerifyController::class, 'sendAccess'])->name('payments.sendAccess');
});

// =========================
// FIX REDIRECT SETELAH LOGIN/REGISTER
// =========================

// /home default Fortify → arahkan ke /product
Route::get('/home', function () {
    return redirect('/product');
})->name('home');
