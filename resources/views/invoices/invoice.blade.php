<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Invoice</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .invoice-box { max-width: 800px; margin: auto; padding: 30px; border: 1px solid #eee; box-shadow: 0 0 10px rgba(0, 0, 0, 0.15); }
        .table { width: 100%; border-collapse: collapse; }
        .table, .table th, .table td { border: 1px solid black; }
        .table th, .table td { padding: 8px; text-align: left; }
    </style>
    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</head>
<body>
    <div class="invoice-box">
        <h2>Hóa Đơn</h2>
        <p><strong>Mã Hóa Đơn:</strong> {{ $invoiceData['id'] }}</p>
        <p><strong>Tên Khách Hàng:</strong> {{ $invoiceData['customer_name'] }}</p>
        <p><strong>Ngày:</strong> {{ $invoiceData['date'] }}</p>
        
        <h3>Chi Tiết Sản Phẩm</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tên Sản Phẩm</th>
                    <th>Số Lượng</th>
                    <th>Giá</th>
                    <th>Thành Tiền</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoiceData['products'] as $index => $product)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $product['name'] }}</td>
                        <td>{{ $product['quantity'] }}</td>
                        <td>{{ number_format($product['price'], 0, ',', '.') }} đ</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h3>Tổng Cộng: {{ number_format($invoiceData['total_amount'], 0, ',', '.') }} đ</h3>
    </div>
</body>
</html>
