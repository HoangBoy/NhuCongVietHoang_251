<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Hiển thị danh sách các đơn hàng.
     */
    public function index()
    {
        $user = Auth::user();

        // Kiểm tra nếu người dùng là admin
        if ($user->is_admin) {
            // Admin xem tất cả đơn hàng
            $orders = Order::with('orderItems', 'user')->orderBy('created_at', 'desc')->paginate(20);
        } else {
            // Người dùng xem đơn hàng của chính họ
            $orders = Order::with('orderItems')
                           ->where('user_id', $user->id)
                           ->orderBy('created_at', 'desc')
                           ->paginate(20);
        }

        return view('orders.index', compact('orders'));
    }

    /**
     * Hiển thị chi tiết đơn hàng.
     */
    public function show($id)
    {
        $user = Auth::user();

        // Tìm đơn hàng
        $order = Order::with('orderItems.product')->findOrFail($id);

        // Kiểm tra quyền truy cập
        if (!$user->is_admin && $order->user_id !== $user->id) {
            abort(403, 'Bạn không có quyền truy cập đơn hàng này.');
        }

        return view('orders.show', compact('order'));
    }

    // Các phương thức khác (create, store, edit, update, destroy) có thể được thêm nếu cần
}