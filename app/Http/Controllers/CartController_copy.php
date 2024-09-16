<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
class CartController_copy extends Controller
{
// Hiển thị giỏ hàng
    public function index()
    {
        // saveCartToDatabase();
        // Kiểm tra nếu có giỏ hàng trong session, nếu không, nạp từ DB
        if (!session()->has('cart')) {
            $cart = Cart::where('user_id', auth()->id())->latest()->first();
            if ($cart) {
                $cartItems = $cart->items->mapWithKeys(function ($item) {
                    return [$item->product_id => [
                        "name" => $item->product->name,
                        "quantity" => $item->quantity,
                        "price" => $item->product->price,
                        "category" => $item->product->category->name,
                    ]];
                });
                session()->put('cart', $cartItems);
            } else {
                session()->put('cart', []);
            }
        }
        // $cart = Cart::where('user_id', auth()->id())->first();
        // $cartItems = $cart ? $cart->items : [];
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }
    public function add(Request $request, Product $product)
{
        if (!session()->has('cart')) {
            $cart = Cart::where('user_id', auth()->id())->latest()->first();
            // $cart = Cart::where('user_id', auth()->id())->first();

            if ($cart) {
                $cartItems = $cart->items->mapWithKeys(function ($item) {
                    return [$item->product_id => [
                        "name" => $item->product->name,
                        "quantity" => $item->quantity,
                        "price" => $item->product->price,
                        "category" => $item->product->category->name,
                    ]];
                });
                dd($cartItems);
                session()->put('cart', $cartItems);
            } else {
                session()->put('cart', []);
            }
        }
    // Chuyển đổi mảng thành Collection
    $cart = collect(session()->get('cart', []));
    
    // Kiểm tra số lượng yêu cầu
    $requestedQuantity = $request->input('quantity', 1);
    
    // Kiểm tra nếu số lượng yêu cầu vượt quá số lượng còn lại của sản phẩm
    if ($requestedQuantity > $product->quantity) {
        return redirect()->route('cart.index')->with('message', 'Số lượng yêu cầu vượt quá số lượng còn lại của sản phẩm.');
    }

    // Kiểm tra nếu sản phẩm đã tồn tại trong giỏ hàng
    if ($cart->has($product->id)) {
        // Lấy phần tử hiện tại từ Collection
        $item = $cart->get($product->id);
        // Tăng số lượng sản phẩm
        $item['quantity']++;
        // Cập nhật phần tử trong Collection
        $cart->put($product->id, $item);
    } else {
        // dd($product);
        // Thêm sản phẩm mới vào giỏ hàng
        $cart->put($product->id, [
            "name" => $product->name,
            "quantity" => 1,
            "price" => $product->price,
            "category" => $product->category->name
        ]);
    }

    // Giảm số lượng sản phẩm trong cơ sở dữ liệu
    $product->quantity -= $requestedQuantity;
    $product->save();
    // dd($cart);
    // Lưu giỏ hàng vào session
    session()->put('cart', $cart->all()); // Chuyển đổi Collection thành mảng trước khi lưu vào session

    return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được thêm vào giỏ hàng.');
}
    // Lưu giỏ hàng vào database khi logout
    // Cập nhật giỏ hàng
    public function update(Request $request)
    {
        $cartItems = $request->input('cart', []);
        
        foreach ($cartItems as $id => $item) {
            if ($item['quantity'] < 1) {
                // Xoá sản phẩm nếu số lượng nhỏ hơn 1
                $this->remove(Product::find($id));
            } else {
                // Cập nhật số lượng sản phẩm trong giỏ hàng
                $cart = collect(session()->get('cart', []));
                if ($cart->has($id)) {
                    $item = $cart->get($id);
                    $item['quantity'] = $item['quantity']; // Cập nhật số lượng
                    $cart->put($id, $item);
                }
                session()->put('cart', $cart->all());
            }
        }

        return redirect()->route('cart.index')->with('success', 'Giỏ hàng đã được cập nhật.');
    }
    public function destroy($id)
        {
            // Logic để xóa sản phẩm khỏi giỏ hàng
            // Ví dụ: gọi phương thức remove
            $this->remove(Product::find($id));

            return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được xoá khỏi giỏ hàng.');
        }
    // Xoá sản phẩm khỏi giỏ hàng
public function remove(String $id)
{
    if (is_null($id) || !is_string($id)) {
        return redirect()->route('cart.index')->with('error', 'Sản phẩm không hợp lệ.');
    }
    $cart = session()->get('cart', []);
    if(isset($cart[$id])) 
    {
        unset($cart[$id]);
        session()->put('cart', $cart);
    }
    return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được xoá khỏi giỏ hàng.');
}


    public function saveCartToDatabase()
    {
        $cartItems = session()->get('cart', []);
        if (auth()->check()) {
            $cart = Cart::updateOrCreate(
                ['user_id' => auth()->id()],
                ['user_id' => auth()->id()]
            );

            // Xoá các mục hiện có để cập nhật mới
            $cart->items()->delete();

            foreach ($cartItems as $productId => $details) {
                $cart->items()->create([
                    'product_id' => $productId,
                    'quantity' => $details['quantity']
                ]);
            }
        }
        session()->forget('cart'); // Xoá giỏ hàng trong session
    }
}
