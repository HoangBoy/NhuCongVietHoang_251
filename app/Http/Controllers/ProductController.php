<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Hiển thị danh sách tất cả các sản phẩm
    public function index()
    {
        $products = Product::with('category')->get(); // Lấy tất cả sản phẩm cùng với danh mục
        return view('admin.products.index', compact('products')); // Truyền biến $products vào view
    }

    public function create()
    {
        $categories = Category::all(); // Lấy tất cả danh mục từ cơ sở dữ liệu
        // dd($categories);
        return view('admin.products.create', compact('categories')); // Truyền biến $categories vào view
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        Product::create($request->all());

        return redirect()->route('admin.products.index')
                         ->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
        // dd($product);
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
        ]);

        $product->update($request->all());

        return redirect()->route('admin.products.index')
                         ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')
                         ->with('success', 'Product deleted successfully.');
    }
    //Người bình thường
public function show_normal(Product $product)
{
// Trả về view cho người dùng bình thường
return view('products.show', compact('product'));
}
}
