<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use App\Models\CartItem;

class PaymentController extends Controller
{
    public function process(Request $request)
    {
        $quantities = $request->input('quantity');
        $coupon = $request->input('coupon');
        $paymentMethod = $request->input('payment_method');
        $cartDetails = $request->input('cartDetails');

        if (empty($quantities) || empty($cartDetails)) {
            return redirect()->route('carts.index')->with('error', 'Bạn chưa chọn sản phẩm nào.');
        }

        $totalAmount = 0;
        $products = [];
        foreach ($cartDetails as $productId => $cartDetail) {
            $cartDetail = json_decode($cartDetail, true);
            $quantity = $quantities[$productId];

            $price = $cartDetail['price'];
            $totalPrice = $quantity * $price;
            $totalAmount += $totalPrice;

            // Giảm số lượng sản phẩm trong database
            $product = Product::find($productId);
            if ($product) {
                if ($product->quantity >= $quantity) {
                    $product->quantity -= $quantity;
                    $product->save();
                } else {
                    return redirect()->route('carts.index')->with('error', 'Số lượng sản phẩm "' . $product->name . '" không đủ trong kho.');
                }
            }

            $products[] = [
                'id' => $productId,
                'name' => $cartDetail['name'],
                'quantity' => $quantity,
                'price' => $price,
                'total_price' => $totalPrice,
            ];
        }

        // Áp dụng mã giảm giá nếu có
        if ($coupon == 'DISCOUNT10') {
            $totalAmount *= 0.9; // Giảm giá 10%
        }

        // Tạo id hóa đơn dựa trên thời gian hiện tại
        $invoiceId = 'invoice-' . now()->format('YmdHis');

        // Lấy tên khách hàng từ thông tin người dùng đã xác thực
        $customerName = Auth::user()->name;

        // Tạo hoá đơn
        $invoiceData = [
            'products' => $products,
            'total_amount' => $totalAmount,
            'coupon' => $coupon,
            'id' => $invoiceId,
            'customer_name' => $customerName,
            'date' => now()->format('d/m/Y')
        ];
        // Xóa các mục trong giỏ hàng theo `cart_item_id`
        //trích xuất thuoccj tính trong $productId để frame work tạo tạo cartDetail dựa trên khoá ngoại
        foreach ($cartDetails as $cartItemId => $cartDetail) {

            // $cartDetailArray = json_decode($cartDetail, true);
            CartItem::where('id', $cartItemId)->delete();
        }
        // Xóa giỏ hàng trong session
        session()->forget('carts'); // Hoặc session()->flush(); để xóa tất cả
        $pdf = Pdf::loadView('invoices.invoice', compact('invoiceData'));

        // Tải hóa đơn dưới dạng PDF
        return $pdf->download('invoice.pdf');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $selectedProducts = $request->input('selected_products');
        if (empty($selectedProducts)) {
            return redirect()->route('carts.index')->with('error', 'Bạn chưa chọn sản phẩm nào.');
        }

        $totalAmount = 0;
        $cartDetails = [];

        foreach ($selectedProducts as $id => $details) {
            $details = json_decode($details, true); // Giải mã JSON thành mảng
            $quantity = $details['quantity']; // Lấy số lượng từ input

            $price = $details['price'];
            $totalPrice = $quantity * $price;
            $totalAmount += $totalPrice;

            $cartDetails[] = [
                'id' => $id,
                'name' => $details['name'],
                'quantity' => $quantity,
                'price' => $price,
                'total_price' => $totalPrice,
            ];
        }

        return view('payment.index', compact('cartDetails'));
    }

    // Các phương thức khác trong Controller không thay đổi
}
