<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Tìm kiếm sản phẩm
    public function leducanhsearch(Request $request)
    {
        $query = $request->input('query');

        // Tìm kiếm sản phẩm theo tên hoặc mô tả
        $products = Product::where('name', 'LIKE', "%{$query}%")
                           ->orWhere('description', 'LIKE', "%{$query}%")
                           ->with('category') // Lấy thêm danh mục cho các sản phẩm
                           ->get();

        return view('welcome', compact('products')); // Trả về view với danh sách sản phẩm tìm được
    }
    
    // Hiển thị danh sách tất cả các sản phẩm
    public function index()
    {
        $products = Product::with('category')->get(); // Lấy tất cả sản phẩm cùng với danh mục
        return view('admin.products.index', compact('products')); // Truyền biến $products vào view
    }

    public function create()
    {
        $categories = Category::all(); // Lấy tất cả danh mục từ cơ sở dữ liệu
        return view('admin.products.create', compact('categories')); // Truyền biến $categories vào view
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category_id' => 'nullable|exists:categories,id',
            'quantity' => 'required|integer|min:0', // Thêm validation cho quantity
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate ảnh
        ]);

        // Tạo sản phẩm mới
        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->category_id = $request->category_id;
        $product->quantity = $request->quantity;

        // Xử lý ảnh
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName); // Di chuyển ảnh vào thư mục public/images
            $product->image = 'images/' . $imageName; // Lưu địa chỉ hình ảnh vào cơ sở dữ liệu
        }

        $product->save(); // Lưu sản phẩm vào cơ sở dữ liệu

        return redirect()->route('admin.products.index')
                         ->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all(); // Lấy tất cả danh mục để hiển thị trong form chỉnh sửa
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric',
        'category_id' => 'required|integer|exists:categories,id',
        'quantity' => 'required|integer|min:0', // Thêm validation cho quantity
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validation cho image
    ]);

    // Cập nhật thông tin sản phẩm, ngoại trừ trường image
    $product->name = $request->name;
    $product->description = $request->description;
    $product->price = $request->price;
    $product->category_id = $request->category_id;
    $product->quantity = $request->quantity;

    // Xử lý ảnh nếu có
    if ($request->hasFile('image')) {
        // Xóa ảnh cũ nếu có
        if ($product->image) {
            \File::delete(public_path($product->image));
        }

        // Tạo tên mới cho ảnh
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('images'), $imageName); // Di chuyển ảnh vào thư mục public/images
        $product->image = 'images/' . $imageName; // Lưu địa chỉ hình ảnh vào cơ sở dữ liệu
    }

    $product->save(); // Lưu sản phẩm vào cơ sở dữ liệu

    return redirect()->route('admin.products.index')
                     ->with('success', 'Product updated successfully.');
}


    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')
                         ->with('success', 'Product deleted successfully.');
    }

    // Người bình thường
    public function show_normal(Product $product)
    {
        // Trả về view cho người dùng bình thường
        return view('products.show', compact('product'));
    }
}