<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Shop\ShopController;
use App\Http\Controllers\Shop\CartController;
use App\Http\Controllers\Shop\CheckoutController;
use App\Http\Controllers\Shop\AccountController;

// Public routes
Route::get('/', [ShopController::class, 'home'])->name('home');
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/product/{id}', [ShopController::class, 'show'])->name('shop.product');
Route::get('/shop/category/{id}', [ShopController::class, 'category'])->name('shop.category');
Route::get('/shop/search', [ShopController::class, 'search'])->name('shop.search');

// Customer Auth
Route::get('/login', [AccountController::class, 'showLogin'])->name('login');
Route::post('/login', [AccountController::class, 'login']);
Route::get('/register', [AccountController::class, 'showRegister'])->name('register');
Route::post('/register', [AccountController::class, 'register']);
Route::post('/logout', [AccountController::class, 'logout'])->name('logout');
Route::get('/account', [AccountController::class, 'dashboard'])->name('account.dashboard');
Route::get('/account/orders', [AccountController::class, 'orders'])->name('account.orders');
Route::get('/account/orders/{id}', [AccountController::class, 'orderDetail'])->name('account.order.detail');

// Cart
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::put('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// Checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/checkout/success/{orderId}', [CheckoutController::class, 'success'])->name('checkout.success');

// Admin Auth
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Admin Dashboard
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

// Admin Products
Route::get('/admin/products', [ProductController::class, 'index'])->name('admin.products.index');
Route::get('/admin/products/create', [ProductController::class, 'create'])->name('admin.products.create');
Route::post('/admin/products', [ProductController::class, 'store'])->name('admin.products.store');
Route::get('/admin/products/{id}', [ProductController::class, 'show'])->name('admin.products.show');
Route::get('/admin/products/{id}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
Route::put('/admin/products/{id}', [ProductController::class, 'update'])->name('admin.products.update');
Route::delete('/admin/products/{id}', [ProductController::class, 'destroy'])->name('admin.products.destroy');

// Admin Categories
Route::get('/admin/categories', [CategoryController::class, 'index'])->name('admin.categories.index');
Route::get('/admin/categories/create', [CategoryController::class, 'create'])->name('admin.categories.create');
Route::post('/admin/categories', [CategoryController::class, 'store'])->name('admin.categories.store');
Route::get('/admin/categories/{id}/edit', [CategoryController::class, 'edit'])->name('admin.categories.edit');
Route::put('/admin/categories/{id}', [CategoryController::class, 'update'])->name('admin.categories.update');
Route::delete('/admin/categories/{id}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');

// Admin Orders
Route::get('/admin/orders', [OrderController::class, 'index'])->name('admin.orders.index');
Route::get('/admin/orders/{id}', [OrderController::class, 'show'])->name('admin.orders.show');
Route::put('/admin/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.status');

// Admin Customers
Route::get('/admin/customers', [CustomerController::class, 'index'])->name('admin.customers.index');
Route::get('/admin/customers/{id}', [CustomerController::class, 'show'])->name('admin.customers.show');

// Admin Inventory
Route::get('/admin/inventory', [InventoryController::class, 'index'])->name('admin.inventory.index');
Route::put('/admin/inventory/{id}', [InventoryController::class, 'update'])->name('admin.inventory.update');