<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use App\Models\CartItem;
use App\Mail\PaymentConfirmationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;


class PaymentController extends Controller
{
    public function confirmPayment($invoice_id)
    {
        // Tìm kiếm đơn hàng trong database bằng order_id
        $order = Order::find($order_id);

        // Kiểm tra xem đơn hàng có tồn tại không
        if (!$order) {
            return redirect()->route('home')->with('error', 'Order not found.');
        }

        // Cập nhật trạng thái thanh toán của đơn hàng
        $order->status = 'confirmed'; // hoặc bất kỳ trạng thái nào bạn muốn
        $order->save();

        // Gửi thông báo hoặc redirect tới trang khác
        return redirect()->route('home')->with('success', 'Payment confirmed successfully.');
    }
    public function process(Request $request)
{  
    $quantities = $request->input('quantity');
    $coupon = $request->input('coupon');
    $paymentMethod = $request->input('payment_method');
    $cartItemDetails = $request->input('cartItemDetails');
    $totalAmount = $request->input('totalAmount');

    // Kiểm tra xem có sản phẩm nào được chọn không
    if (empty($quantities) || empty($cartItemDetails)) {
        return redirect()->route('carts.index')->with('error', 'Bạn chưa chọn sản phẩm nào.');
    }

    // Áp dụng mã giảm giá nếu có
    if ($coupon == 'DISCOUNT10') {
        $totalAmount *= 0.9; // Giảm giá 10%
    }

    // Sử dụng transaction để đảm bảo tính toàn vẹn của dữ liệu
    DB::beginTransaction();

    try {
        $products = [];
        foreach ($cartItemDetails as $cartItemId => $cartItemDetailJson) {
            $cartItemDetail = json_decode($cartItemDetailJson, true);
            $productId = $cartItemDetail['product_id'];
            $quantity = $quantities[$productId] ?? 0; // Sử dụng product_id để lấy quantity

            if ($quantity <= 0) {
                throw new \Exception('Số lượng sản phẩm không hợp lệ.');
            }

            $price = $cartItemDetail['price'];
            $totalPrice = $quantity * $price;

            // Giảm số lượng sản phẩm trong database
            $product = Product::find($productId);
            if ($product) {
                if ($product->quantity >= $quantity) {
                    $product->quantity -= $quantity;
                    $product->save();
                } else {
                    throw new \Exception('Số lượng sản phẩm "' . $product->name . '" không đủ trong kho.');
                }
            } else {
                throw new \Exception('Sản phẩm không tồn tại.');
            }

            $products[] = [
                'id' => $productId,
                'name' => $cartItemDetail['name'],
                'description' => $cartItemDetail['description'] ?? '',
                'price' => $price,
                'quantity' => $quantity,
                'image' => $cartItemDetail['image'] ?? '',
                'category_id' => $cartItemDetail['category_id'] ?? null,
            ];
        }

        // Tạo id hóa đơn dựa trên thời gian hiện tại
        $invoiceId = 'invoice-' . now()->format('YmdHis');

        // Lấy tên khách hàng từ thông tin người dùng đã xác thực
        $customerName = Auth::user()->name;

        // Tạo hoá đơn
        $invoiceData = [
            'id' => $invoiceId,
            'customer_name' => $customerName,
            'products' => $products,
            'total_amount' => $totalAmount,
            'coupon' => $coupon,
            'payment_method' => $paymentMethod,
            'date' => now()->format('d/m/Y')
        ];

        // Tạo bản ghi đơn hàng trong DB
        $order = new Order();
        $order->txn_ref = uniqid(); // Tạo mã giao dịch duy nhất
        $order->user_id = auth()->id(); // Lấy ID người dùng đã đăng nhập
        // $order->order_info = json_encode($invoiceData, JSON_UNESCAPED_UNICODE); // Lưu thông tin đơn hàng
        $order->amount = $totalAmount;
        $order->customer_name = $customerName; // Lấy tên khách hàng
        $order->status = 'pending'; // Trạng thái đơn hàng
        $order->save();

        // Lưu OrderItem
        foreach ($products as $product) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product['id'],
                'name' => $product['name'],
                'quantity' => $product['quantity'],
                'price' => $product['price'],
                'total_price' => $product['price'] * $product['quantity'],
            ]);
        }
        // Sử dụng switch case để xử lý phương thức thanh toán
        switch ($paymentMethod) {
            case 'cash_on_delivery':
                // Gửi email xác nhận thanh toán
                Mail::to($request->user()->email)->send(new PaymentConfirmationMail($invoiceData));
                break;

            case 'VNPay':
                DB::commit(); // Commit transaction trước khi redirect
                return redirect()->route('vnpay.pay', ['invoice_id' => $invoiceId]);

            case 'credit_card':
            case 'bank_transfer':
            case 'paypal':
                // Thực hiện thanh toán qua phương thức thanh toán tương ứng
                // Ví dụ: gọi hàm xử lý thanh toán ở đây
                break;

            default:
                throw new \Exception('Phương thức thanh toán không hợp lệ.');
        }

        // Xóa các mục trong giỏ hàng theo `cart_item_id`
        foreach ($cartItemDetails as $cartItemId => $cartDetail) {
            CartItem::where('id', $cartItemId)->delete();
        }

        // Xóa giỏ hàng trong session
        session()->forget('carts'); // Hoặc session()->flush(); để xóa tất cả

        // Tạo PDF hóa đơn
        $pdf = Pdf::loadView('invoices.invoice', ['invoiceData' => $invoiceData]);

        DB::commit(); // Commit transaction

        // Tải hóa đơn dưới dạng PDF với thông báo thành công
        return $pdf->download('invoice.pdf');
    } catch (\Exception $e) {
        DB::rollBack(); // Rollback transaction nếu có lỗi
        return redirect()->route('carts.index')->with('error', $e->getMessage());
    }
}


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $selectedCartItems = $request->input('selected_cartItems');

    // Kiểm tra xem có sản phẩm nào được chọn không
    if (empty($selectedCartItems) || !is_array($selectedCartItems)) {
        return redirect()->route('carts.index')->with('error', 'Bạn chưa chọn sản phẩm nào.');
    }

    // Lấy cart_id của người dùng một lần
    $cartId = Cart::where('user_id', auth()->id())->value('id');

    if (!$cartId) {
        return redirect()->route('carts.index')->with('error', 'Giỏ hàng của bạn không tồn tại.');
    }

    // Khởi tạo thông tin giỏ hàng
    $cartItemDetails = collect($selectedCartItems)->map(function ($cartItemJson, $id) use ($cartId) {
        $cartItem = json_decode($cartItemJson, true);
        $quantity = $cartItem['quantity'];
        $price = $cartItem['price'];
        $totalPrice = $quantity * $price;

        return [
            'id' => $id,
            'cart_id' => $cartId,
            'product_id' => $cartItem['product_id'],
            'name' => $cartItem['name'],
            'quantity' => $quantity,
            'price' => $price,
            'total_price' => $totalPrice,
        ];
    });

    // Truyền dữ liệu vào view
    return view('payment.index', ['cartItemDetails' => $cartItemDetails]);
}


    // Các phương thức khác trong Controller không thay đổi
}
