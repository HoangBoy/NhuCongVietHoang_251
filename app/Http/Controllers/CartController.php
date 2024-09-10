<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
class CartController extends Controller
{
// Hiển thị giỏ hàng
    public function index()
    {
        // $cart = Cart::where('user_id', auth()->id())->first();
        // $cartItems = $cart ? $cart->items : [];
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }
// Thêm sản phẩm vào giỏ hàng
    public function add(Request $request, Product $product)
    {
        $cart = session()->get('cart', []);
        // Check the quantity requested
        $requestedQuantity = $request->input('quantity', 1);
        // Check if the requested quantity exceeds the available stock
        if ($requestedQuantity > $product->quantity) {
            return redirect()->route('cart.index')->with('message', 'Số lượng yêu cầu vượt quá số lượng còn lại của sản phẩm.');
        }
        //check if cart product id exist
        if(isset($cart[$product->id])) {
        $cart[$product->id]['quantity']++;
    } else {
        $cart[$product->id] = [
        "name" => $product->name,
        "quantity" => 1,
        "price" => $product->price,
        "category" => $product->category->name
        ];
    }
    // Decrease the product quantity in the database
    $product->quantity -= $requestedQuantity;
    $product->save();
    session()->put('cart', $cart);
        return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được thêm vào giỏ hàng.');
    }
// Xoá sản phẩm khỏi giỏ hàng
    public function remove(Product $product)
    {
        $cart = session()->get('cart', []);
        if(isset($cart[$product->id])) 
        {
            unset($cart[$product->id]);
            session()->put('cart', $cart);
        }
        return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được xoá khỏi giỏ hàng.');
    }
}
