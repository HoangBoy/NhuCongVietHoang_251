<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class WelcomeController extends Controller
{
    // Phương thức để hiển thị trang chủ với danh sách sản phẩm
    public function index()
    {
        // Lấy tất cả sản phẩm từ database và phân trang
        $products = Product::with('category')->paginate(10);
        // Kiểm tra đường dẫn hình ảnh cho từng sản phẩm
        // foreach ($products as $product) {
        //     dd(asset($product->image)); // Hoặc bạn có thể kiểm tra đường dẫn hoàn chỉnh: asset('images/' . $product->image)
        // }
        // Trả về view 'welcome' với dữ liệu sản phẩm
        return view('welcome', compact('products'));
    }
}
