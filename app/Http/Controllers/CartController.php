<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;

class CartController extends Controller
{
    // Danh sách đơn hàng
    public function index()
    {
        // Kiểm tra nếu có giỏ hàng trong session, nếu không, nạp từ DB
        if (!session()->has('carts')) {
            $carts = Cart::where('user_id', auth()->id())->latest()->first();
            if ($carts) {
                $cartItems = $carts->items->mapWithKeys(function ($item) {
                    return [$item->product_id => [
                        "name" => $item->product->name,
                        "quantity" => $item->quantity,
                        "price" => $item->product->price,
                        "category" => $item->product->category->name,
                    ]];
                });
                session()->put('carts', $cartItems);
            } else {
                session()->put('carts', []);
            }
        }

        $carts = session()->get('carts', []);
        return view('carts.index', compact('carts'));
    }

    // Xem chi tiết đơn hàng
    public function show($id)
    {
        $carts = Cart::find($id);
        if ($carts) {
            return response()->json(['data' => $carts]);
        }
        return response()->json(['message' => 'Order not found'], 404);
    }

    // Tạo đơn hàng
    public function store(Request $request,Product $product)
    {   
        $product = Product::find($request->id);
        if (!$product) {
            return redirect()->route('carts.index')->with('error', 'Product not found.');
        }

        $cart = collect(session()->get('carts', []));
        $requestedQuantity = $request->input('quantity', 1);
        if ($requestedQuantity > $product->quantity) {
            return redirect()->route('carts.index')->with('message', 'Số lượng yêu cầu vượt quá số lượng còn lại của sản phẩm.');
        }

        if ($carts->has($product->id)) {
            $item = $cart->get($product->id);
            $item['quantity']++;
            $carts->put($product->id, $item);
        } else {
            $carts->put($product->id, [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "category" => $product->category->name
            ]);
        }

        $product->quantity -= $requestedQuantity;
        $product->save();
        session()->put('carts', $carts->all());

        // Save cart to database when creating an order
        $this->saveCartToDatabase();

        return redirect()->route('carts.index')->with('success', 'Sản phẩm đã được thêm vào giỏ hàng.');
    }

    // Cập nhật giỏ hàng
    public function update(Request $request)
    {
        $cartItems = $request->input('carts', []);
        foreach ($cartItems as $id => $item) {
            if ($item['quantity'] < 1) {
                $this->remove($id);
            } else {
                $carts = collect(session()->get('carts', []));
                if ($carts->has($id)) {
                    $existingItem = $carts->get($id);
                    $existingItem['quantity'] = $item['quantity'];
                    $carts->put($id, $existingItem);
                }
                session()->put('carts', $carts->all());
            }
        }
        return redirect()->route('carts.index')->with('success', 'Giỏ hàng đã được cập nhật.');
    }

    // Xoá sản phẩm khỏi giỏ hàng
    public function destroy($id)
    {
        if (is_null($id) || !is_string($id)) {
            return redirect()->route('carts.index')->with('error', 'Sản phẩm không hợp lệ.');
        }

        $carts = session()->get('carts', []);
        if (isset($carts[$id])) {
            unset($carts[$id]);
            session()->put('carts', $carts);
            $message = 'Sản phẩm đã được xoá khỏi giỏ hàng.';
        } else {
            $message = 'Sản phẩm không tìm thấy trong giỏ hàng.';
        }

        return redirect()->route('carts.index')->with('success', $message);
    }


    // Tìm kiếm đơn hàng
    public function search(Request $request)
    {
        $query = Cart::query();
        if ($request->has('status')) {
            $query->where('status', $request->input('status'));
        }
        if ($request->has('date')) {
            $query->whereDate('created_at', $request->input('date'));
        }
        $carts = $query->get();
        return response()->json(['data' => $carts]);
    }

    // Xem lịch sử trạng thái đơn hàng
    public function history($id)
    {
        $carts = Cart::find($id);
        if ($carts) {
            $history = $carts->history;
            return response()->json(['data' => $history]);
        }
        return response()->json(['message' => 'Order not found'], 404);
    }

    // Thay đổi trạng thái đơn hàng
    public function updateStatus(Request $request, $id)
    {
        $carts = Cart::find($id);
        if ($carts) {
            $validated = $request->validate([
                'status' => 'required|string'
            ]);
            $carts->status = $validated['status'];
            $carts->save();
            return response()->json(['data' => $carts]);
        }
        return response()->json(['message' => 'Order not found'], 404);
    }

    // Lưu giỏ hàng vào cơ sở dữ liệu khi tạo đơn hàng
    private function saveCartToDatabase()
    {
        $cartItems = session()->get('carts', []);
        if (auth()->check()) {
            $carts = Cart::updateOrCreate(
                ['user_id' => auth()->id()],
                ['user_id' => auth()->id()]
            );

            $carts->items()->delete();
            foreach ($cartItems as $productId => $details) {
                $cart->items()->create([
                    'product_id' => $productId,
                    'quantity' => $details['quantity']
                ]);
            }
        }
    }
}
