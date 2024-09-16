<?php

use Illuminate\Support\Facades\Route;
// Import controllers
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;


// Trang chủ welcome
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

// Đăng ký và đăng nhập người dùng
Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout')->middleware('saveCart');

// Route dành cho admin (sử dụng middleware để kiểm tra quyền)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Route quản lý sản phẩm
    Route::resource('/products', ProductController::class);

    // Route quản lý danh mục
    Route::resource('/categories', CategoryController::class);
    //Route quản lý giỏ hàng
    Route::resource('/cart', CartController::class)->middleware(['auth']);
});

// Route cho người dùng bình thường
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [WelcomeController::class, 'index'])->name('home'); // Đã thêm route home
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{product}', [ProductController::class, 'show_normal'])->name('products.show');
    //Route quản lý giỏ hàng
    Route::resource('/cart', CartController::class)->middleware(['auth']);
    // Route để cập nhật giỏ hàng
    // Route::middleware(['auth'])->post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    // Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
});
//thêm route cho giỏ hàng
// Route để thêm sản phẩm vào giỏ hàng
// Route::middleware(['auth'])->post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
// Route để cập nhật giỏ hàng
// Route::middleware(['auth'])->post('/cart/update', [CartController::class, 'update'])->name('cart.update');
// Route để hiển thị giỏ hàng
// Route::middleware(['auth'])->get('/cart', [CartController::class, 'index'])->name('cart.index');
// Route để xoá sản phẩm khỏi giỏ hàng
// Route::middleware(['auth'])->delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
