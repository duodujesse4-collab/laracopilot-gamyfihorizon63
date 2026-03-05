<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccountController;

// Public
Route::get('/', [ShopController::class, 'home'])->name('home');
Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/shop/{slug}', [ShopController::class, 'show'])->name('shop.show');
Route::get('/category/{slug}', [ShopController::class, 'category'])->name('shop.category');

// Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Account
Route::get('/account', [AccountController::class, 'index'])->name('account');
Route::get('/account/orders', [AccountController::class, 'orders'])->name('account.orders');
Route::get('/account/orders/{id}', [AccountController::class, 'orderDetail'])->name('account.orders.show');
Route::get('/account/profile', [AccountController::class, 'profile'])->name('account.profile');
Route::put('/account/profile', [AccountController::class, 'updateProfile'])->name('account.profile.update');

// Cart
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::put('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{rowId}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// Checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');

// Admin Auth
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Admin Dashboard
Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

// Admin Products
Route::get('/admin/products', [AdminProductController::class, 'index'])->name('admin.products.index');
Route::get('/admin/products/create', [AdminProductController::class, 'create'])->name('admin.products.create');
Route::post('/admin/products', [AdminProductController::class, 'store'])->name('admin.products.store');
Route::get('/admin/products/{id}/edit', [AdminProductController::class, 'edit'])->name('admin.products.edit');
Route::put('/admin/products/{id}', [AdminProductController::class, 'update'])->name('admin.products.update');
Route::delete('/admin/products/{id}', [AdminProductController::class, 'destroy'])->name('admin.products.destroy');

// Admin Categories
Route::get('/admin/categories', [AdminCategoryController::class, 'index'])->name('admin.categories.index');
Route::get('/admin/categories/create', [AdminCategoryController::class, 'create'])->name('admin.categories.create');
Route::post('/admin/categories', [AdminCategoryController::class, 'store'])->name('admin.categories.store');
Route::get('/admin/categories/{id}/edit', [AdminCategoryController::class, 'edit'])->name('admin.categories.edit');
Route::put('/admin/categories/{id}', [AdminCategoryController::class, 'update'])->name('admin.categories.update');
Route::delete('/admin/categories/{id}', [AdminCategoryController::class, 'destroy'])->name('admin.categories.destroy');

// Admin Orders
Route::get('/admin/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
Route::get('/admin/orders/{id}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
Route::put('/admin/orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');

// Admin Users
Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users.index');
Route::get('/admin/users/{id}', [AdminUserController::class, 'show'])->name('admin.users.show');
Route::delete('/admin/users/{id}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');