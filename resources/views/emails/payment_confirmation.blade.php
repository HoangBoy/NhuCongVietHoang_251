<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Xác Nhận Thanh Toán</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { max-width: 600px; margin: auto; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid #ddd; }
        th, td { padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            font-size: 16px;
            color: #fff;
            background-color: #28a745;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Chi Tiết Đơn Hàng</h2>
        <p><strong>Mã Đơn Hàng:</strong> {{ $orderData['id'] }}</p>
        <p><strong>Tên Khách Hàng:</strong> {{ $orderData['customer_name'] }}</p>
        <p><strong>Ngày:</strong> {{ $orderData['date'] }}</p>
        
        <h3>Chi Tiết Sản Phẩm</h3>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tên Sản Phẩm</th>
                    <th>Số Lượng</th>
                    <th>Giá (VND)</th>
                    <th>Thành Tiền (VND)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orderData['products'] as $index => $product)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $product['name'] }}</td>
                        <td>{{ $product['quantity'] }}</td>
                        <td>{{ number_format($product['price'], 0, ',', '.') }} đ</td>
                        <td>{{ number_format($product['price'] * $product['quantity'], 0, ',', '.') }} đ</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p><strong>Tổng Cộng:</strong> {{ number_format($orderData['total_amount'], 0, ',', '.') }} đ</p>

        @if (!empty($orderData['coupon']))
            <p><strong>Mã Giảm Giá:</strong> {{ $orderData['coupon'] }}</p>
        @endif

        <a href="{{ $orderData['confirm_url'] }}" class="button">Xác nhận thanh toán khi nhận hàng</a>

        <p>Thanks,<br>{{ config('app.name') }}</p>
    </div>
</body>
</html>
