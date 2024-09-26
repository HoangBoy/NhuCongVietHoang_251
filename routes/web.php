<?php

use Illuminate\Support\Facades\Route;
// Import controllers
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;
use App\Mail\PaymentConfirmationMail;

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
    
    Route::resources([
        // Route quản lý sản phẩm
        '/products' => ProductController::class,
        // Route quản lý danh mục
        '/categories' => CategoryController::class,
    ]);
    
});

// Route cho người dùng bình thường
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [WelcomeController::class, 'index'])->name('home'); // Đã thêm route home
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{product}', [ProductController::class, 'show_normal'])->name('products.show');
    
    Route::resource('carts', CartController::class)
        ->only(['index','update', 'destroy']);

    //success route model binding
    Route::post('/carts/{product}', [CartController::class, 'store'])->name('carts.store');
    Route::get('/carts', [CartController::class, 'index'])->name('carts.index');

    Route::post('/payment', [PaymentController::class, 'index'])->name('payment.index');
    Route::post('/payment/process', [PaymentController::class, 'process'])->name('payment.process');
    Route::get('/sendEmail', function () {
        $invoiceData = [
            'products' => [
                ['name' => 'Product 1', 'quantity' => 2, 'price' => 100, 'total_price' => 200],
                ['name' => 'Product 2', 'quantity' => 1, 'price' => 150, 'total_price' => 150],
                // ... các sản phẩm khác
            ],
            'total_amount' => 200,
            'coupon' => 'coupon',
            'id' => 'invoice_id',
            'customer_name' => 'custom_name',
            'date' => now()->format('d/m/Y')
        ];
        // dd(env('DB_DATABASE')); 
        //dd(env('MAIL_HOST')); 

        // Tạo một instance của PaymentConfirmationMail
        Mail::to('nvhai227@gmail.com')->send(new PaymentConfirmationMail($invoiceData));
        
        return 'Email sent successfully!'; // Trả về thông báo sau khi gửi email
    });

    Route::get('/payment/{invoice_id}', [PaymentController::class, 'confirmPayment'])->name('payment.confirmation');
    
});

