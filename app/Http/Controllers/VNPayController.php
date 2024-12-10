<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class VNPayController extends Controller
{
    /**
     * Hiển thị trang checkout với nút thanh toán.
     */
    public function checkout()
    {
        return view('vnpay.checkout');
    }

    /**
     * Xử lý thanh toán VNPay.
     */
    public function pay(Request $request)
    {
        // Thông tin đơn hàng
        $vnp_Url = config('vnpay.vnp_Url');
        $vnp_Returnurl = config('vnpay.vnp_ReturnUrl');
        $vnp_TmnCode = config('vnpay.vnp_TmnCode'); // Mã TMN từ VNPay
        $vnp_HashSecret = config('vnpay.vnp_HashSecret'); // Chuỗi bí mật từ VNPay
        // Thông tin đơn hàng từ form
        $vnp_TxnRef = 'REF' . time(); // Mã đơn hàng (unique)
        $vnp_OrderInfo = 'Thanh toán đơn hàng #' . $vnp_TxnRef;
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $request->input('amount') * 100; // VNPay yêu cầu đơn vị là VND và nhân với 100

        $vnp_Locale = 'vn';
        $vnp_BankCode = $request->input('bank_code') ?? '';

        $vnp_IpAddr = $request->ip();

        $vnp_ExpireDate = date('YmdHis', strtotime('+15 minutes')); // Thời gian hết hạn

        // Tạo mảng tham số để gửi tới VNPay
        $inputData = [
            "vnp_Version"       => "2.1.0",
            "vnp_TmnCode"       => $vnp_TmnCode,
            "vnp_Amount"        => $vnp_Amount,
            "vnp_Command"       => "pay",
            "vnp_CreateDate"    => date('YmdHis'),
            "vnp_CurrCode"      => "VND",
            "vnp_IpAddr"        => $vnp_IpAddr,
            "vnp_Locale"        => $vnp_Locale,
            "vnp_OrderInfo"     => $vnp_OrderInfo,
            "vnp_OrderType"     => $vnp_OrderType,
            "vnp_ReturnUrl"     => $vnp_Returnurl,
            "vnp_TxnRef"        => $vnp_TxnRef,
            "vnp_ExpireDate"    => $vnp_ExpireDate,
        ];

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        // Sắp xếp các tham số theo thứ tự alphabet
        ksort($inputData);

        $query = "";
        $hashdata = "";
        // dd($inputData);

        foreach ($inputData as $key => $value) {
            if ($key !== 'vnp_SecureHash') {
                $hashdata .= $key . "=" . $value . "&";
                $query .= urlencode($key) . "=" . urlencode($value) . "&";
            }
        }

        $query = rtrim($query, "&");
        $hashdata = rtrim($hashdata, "&");

        // Tạo hash với SHA256
        $secureHash = hash_hmac('sha256', $hashdata, $vnp_HashSecret);
        $vnp_Url .= "?" . $query . '&vnp_SecureHash=' . $secureHash;
        Log::info('hashdata: ' . $hashdata);
        Log::info('secureHash: ' . $secureHash);
        // dd($vnp_Url);
        return redirect()->away($vnp_Url);
    }

    /**
     * Nhận kết quả thanh toán từ VNPay.
     */
    public function return(Request $request)
    {
        $vnp_SecureHash = $request->input('vnp_SecureHash');

        // Loại bỏ vnp_SecureHash khỏi mảng
        $inputData = $request->all();
        unset($inputData['vnp_SecureHash']);

        // Sắp xếp lại mảng theo thứ tự key tăng dần
        ksort($inputData);

        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($key !== 'vnp_SecureHash' && strlen($value) > 0) {
                $hashData .= $key . "=" . $value . "&";
            }
        }
        $hashData = rtrim($hashData, "&");

        // Tạo hash để so sánh
        $vnp_HashSecret = config('vnpay.vnp_HashSecret');
        $secureHash = hash_hmac('sha256', $hashData, $vnp_HashSecret);

        if ($vnp_SecureHash === $secureHash) {
            if ($request->input('vnp_ResponseCode') == '00') {
                // Thanh toán thành công
                // Cập nhật trạng thái đơn hàng trong database
                $orderId = substr($request->input('vnp_TxnRef'), 3); // Giả sử order ID là sau 'REF'
                $order = \App\Models\Order::find($orderId);
                if ($order) {
                    $order->status = 'paid';
                    $order->payment_date = now();
                    $order->save();
                }

                return view('vnpay.success');
            } else {
                // Thanh toán thất bại
                return view('vnpay.fail');
            }
        } else {
            // Có sự cố trong việc xác thực hash
            return view('vnpay.invalid');
        }
    }
}
