<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VNPayController extends Controller
{
    public function createPayment(Request $request)
    {
        $vnp_Url = config('vnpay.url');
        $vnp_Returnurl = config('vnpay.return_url');
        $vnp_TmnCode = config('vnpay.tmn_code');
        $vnp_HashSecret = config('vnpay.hash_secret');

        $vnp_TxnRef = 'REF' . time(); // Mã đơn hàng
        $vnp_OrderInfo = 'Thanh toan don hang';
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $request->amount * 100; // VNPay yêu cầu đơn vị là VND * 100
        $vnp_Locale = 'vn';
        $vnp_BankCode = 'NCB';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

        $inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
            // "vnp_BankCode" => $vnp_BankCode, // Optional
        ];

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        // Sort the data by key
        ksort($inputData);
        $query = "";
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($key !== 'vnp_SecureHash') {
                $query .= urlencode($key) . "=" . urlencode($value) . "&";
                $hashdata .= $key . "=" . $value . '&';
            }
        }

        // Remove the trailing &
        $query = rtrim($query, '&');
        $hashdata = rtrim($hashdata, '&');

        // Create secure hash
        $secureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
        $vnp_Url = $vnp_Url . "?" . $query . "&vnp_SecureHash=" . $secureHash;

        return redirect($vnp_Url);
    }

    public function returnPayment(Request $request)
    {
        $vnp_HashSecret = config('vnpay.hash_secret');

        // Lấy tất cả các tham số trả về từ VNPay
        $inputData = $request->all();

        if (isset($inputData['vnp_SecureHash'])) {
            $vnp_SecureHash = $inputData['vnp_SecureHash'];
            unset($inputData['vnp_SecureHash']);
        } else {
            $vnp_SecureHash = null;
        }

        // Sort theo thứ tự a-z
        ksort($inputData);
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($key !== 'vnp_SecureHash') {
                $hashData .= $key . "=" . $value . '&';
            }
        }
        $hashData = rtrim($hashData, '&');

        // Tạo secure hash để so sánh
        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        if ($secureHash === $vnp_SecureHash) {
            if ($inputData['vnp_ResponseCode'] == '00') {
                // Thanh toán thành công
                // Cập nhật trạng thái đơn hàng trong database
                // $order = Order::where('txn_ref', $inputData['vnp_TxnRef'])->first();
                // $order->status = 'paid';
                // $order->save();

                return view('vnpay.success', ['data' => $inputData]);
            } else {
                // Thanh toán không thành công
                return view('vnpay.fail', ['data' => $inputData]);
            }
        } else {
            // Dữ liệu bị thay đổi hoặc không hợp lệ
            return view('vnpay.invalid', ['data' => $inputData]);
        }
    }
}
