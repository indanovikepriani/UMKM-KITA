<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\ContactSupportController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Umkm\DashboardController as UmkmDashboardController;
use App\Http\Controllers\Umkm\StoreController as UmkmStoreController;
use App\Http\Controllers\Umkm\ProductController as UmkmProductController;
use App\Http\Controllers\Umkm\OrderController as UmkmOrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\StoreController;

use App\Http\Controllers\FaqController;
use App\Http\Controllers\TermsController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\WishlistController;

// --- FRONTEND ROUTES (Publik) ---
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/faq', [FaqController::class, 'index'])->name('faq.index');
Route::get('/terms', [TermsController::class, 'index'])->name('terms.index');
Route::get('/tracking', [TrackingController::class, 'index'])->name('tracking.index');
Route::get('/tracking/search', [TrackingController::class, 'search'])->name('tracking.search');
Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
Route::get('/menu/{slug}', [MenuController::class, 'show'])->name('menu.show');
Route::get('/stores', [StoreController::class, 'index'])->name('stores.index');
Route::get('/stores/{slug}', [StoreController::class, 'show'])->name('stores.show');
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');
Route::get('/testimonials', [TestimonialController::class, 'index'])->name('testimonials.index');

// --- AUTHENTICATION ROUTES ---
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- PASSWORD RESET ---
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// --- CUSTOMER ROUTES (Harus Login) ---
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{id}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');

    // --- ACCOUNT (Halaman Akun Saya) ---
    Route::get('/account', [AccountController::class, 'index'])->name('account.index');
    Route::put('/account/profile', [AccountController::class, 'updateProfile'])->name('account.updateProfile');
    Route::post('/account/avatar', [AccountController::class, 'updateAvatar'])->name('account.updateAvatar');
    Route::put('/account/password', [AccountController::class, 'updatePassword'])->name('account.updatePassword');

    Route::get('/testimonials/create/{orderId}', [TestimonialController::class, 'create'])->name('testimonials.create');
    Route::post('/testimonials', [TestimonialController::class, 'store'])->name('testimonials.store');

    // Direct review (tanpa order)
    Route::post('/reviews/direct', [ReviewController::class, 'storeDirect'])->name('reviews.storeDirect');

    // Wishlist
    Route::get('/wishlists', [WishlistController::class, 'index'])->name('wishlists.index');
    Route::post('/wishlists/toggle', [WishlistController::class, 'toggle'])->name('wishlists.toggle');
});

// --- ADMIN ROUTES (Harus Login & Role = Admin) ---
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);

    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{order}/edit', [AdminOrderController::class, 'edit'])->name('orders.edit');
    Route::put('/orders/{order}', [AdminOrderController::class, 'update'])->name('orders.update');

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
    Route::get('/reports/monthly', [ReportController::class, 'monthly'])->name('reports.monthly');
    Route::get('/reports/stock', [ReportController::class, 'stock'])->name('reports.stock');

    Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/edit', [UserManagementController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserManagementController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');

    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');

    Route::get('/contact-support', [ContactSupportController::class, 'index'])->name('contact-support.index');

    // Admin Reviews Management
    Route::get('/reviews', [ReviewController::class, 'adminIndex'])->name('reviews.index');
    Route::get('/reviews/{review}/edit', [ReviewController::class, 'adminEdit'])->name('reviews.edit');
    Route::put('/reviews/{review}', [ReviewController::class, 'adminUpdate'])->name('reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'adminDestroy'])->name('reviews.destroy');
});

// --- UMKM ROUTES (Harus Login & Role = UMKM) ---
Route::middleware(['auth', 'umkm'])->prefix('umkm')->name('umkm.')->group(function () {
    Route::get('/dashboard', [UmkmDashboardController::class, 'index'])->name('dashboard');

    Route::get('/store', [UmkmStoreController::class, 'index'])->name('store.index');
    Route::get('/store/create', [UmkmStoreController::class, 'create'])->name('store.create');
    Route::post('/store', [UmkmStoreController::class, 'store'])->name('store.store');
    Route::get('/store/edit', [UmkmStoreController::class, 'edit'])->name('store.edit');
    Route::put('/store', [UmkmStoreController::class, 'update'])->name('store.update');

    Route::get('/products', [UmkmProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [UmkmProductController::class, 'create'])->name('products.create');
    Route::post('/products', [UmkmProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [UmkmProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [UmkmProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [UmkmProductController::class, 'destroy'])->name('products.destroy');

    Route::get('/orders', [UmkmOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [UmkmOrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{order}/status', [UmkmOrderController::class, 'updateStatus'])->name('orders.updateStatus');
});
