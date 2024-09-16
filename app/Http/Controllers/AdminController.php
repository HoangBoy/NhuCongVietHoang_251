<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
class AdminController extends Controller
{
    public function dashboard()
    {
    return view('admin.dashboard');
    }
    public function products()
    {
    return app(ProductController::class)->index();
    }
    public function categories()
    {
    return app(CategoryController::class)->index();
    }
    //Người bình thường
    public function show_normal(Product $product)
    {
    // Trả về view cho người dùng bình thường
    return view('products.show', compact('product'));
    }
}

    
