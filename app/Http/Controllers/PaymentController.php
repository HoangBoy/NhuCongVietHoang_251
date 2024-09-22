<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function process(Request $request)
{
    $selectedProducts = $request->input('selected_products');
    $quantities = $request->input('quantity');
    $coupon = $request->input('coupon');
    $paymentMethod = $request->input('payment_method');

    if (!$selectedProducts) {
        return redirect()->route('carts.index')->with('error', 'Bạn chưa chọn sản phẩm nào.');
    }

    // Tính tổng tiền, áp dụng mã giảm giá (nếu có) và xử lý thanh toán
    $totalAmount = 0;
    foreach ($selectedProducts as $productId) {
        // Lấy thông tin chi tiết sản phẩm (giả sử $product là đối tượng sản phẩm)
        $quantity = $quantities[$productId];
        $productPrice = 100000; // giá sản phẩm (lấy từ database hoặc giỏ hàng)
        $totalAmount += $productPrice * $quantity;
    }

    // Áp dụng mã giảm giá
    if ($coupon == 'DISCOUNT10') {
        $totalAmount *= 0.9; // Giảm 10%
    }

    // Gọi API hoặc xử lý thanh toán theo phương thức đã chọn
    // Ví dụ xử lý với `$paymentMethod`

    return redirect()->route('home')->with('success', 'Thanh toán thành công. Tổng số tiền: ' . number_format($totalAmount, 0, ',', '.') . ' đ');
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
    $productDetails = [];

    foreach ($selectedProducts as $id => $details) {
        $details = json_decode($details, true); // Giải mã JSON thành mảng
        $quantity = $details['quantity']; // Lấy số lượng từ input

        


        $price = $details['price'];

        $totalPrice = $quantity * $price;
        $totalAmount += $totalPrice;

        $productDetails[] = [
            'id' => $id,
            'name' => $details['name'],
            'quantity' => $quantity,
            'price' => $price,
            'total_price' => $totalPrice,
        ];
    }

    return view('payment.index', compact('productDetails'));
}



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
