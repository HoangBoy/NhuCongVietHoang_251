<!-- resources/views/emails/payment_confirmation.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Order Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .invoice-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .invoice-header h1 {
            margin: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        .total {
            text-align: right;
            font-weight: bold;
        }
        .summary {
            margin-top: 20px;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            color: white;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="invoice-header">
        <h1>Order Details</h1>
        <p><strong>Order ID:</strong> {{ $invoiceData['id'] }}</p>
        <p><strong>Customer Name:</strong> {{ $invoiceData['customer_name'] }}</p>
        <p><strong>Date:</strong> {{ $invoiceData['date'] }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoiceData['products'] as $product)
                <tr>
                    <td>{{ $product['name'] }}</td>
                    <td>{{ $product['quantity'] }}</td>
                    <td>{{ number_format($product['price'], 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <p class="total">Total Amount: {{ number_format($invoiceData['total_amount'], 2) }}</p>
        @if (!empty($invoiceData['coupon']))
            <p>Coupon Applied: {{ $invoiceData['coupon'] }}</p>
        @endif
    </div>

    <p>Vui lòng xác nhận thanh toán tại đây:
        <form action="{{ route('payment.confirmation') }}"" method='POST' ">
            @csrf
            <input type="hidden" 
                                    name="order_id" 
                                    value="{{ $invoiceData['order_id'] }}" 
                                    min="1" 
                                    class="form-control">
            <input type="hidden" 
                                    name="order_id" 
                                    value="{{ $invoiceData['payment_method'] }}" 
                                    min="1" 
                                    class="form-control">
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Xác nhận thanh toán khi nhận hàng</button>
            </div>
        </form>
    </p>
    <!-- <p>Vui lòng xác nhận thanh toán tại đây: <a href="{{ route('payment.confirmation', ['invoice_id' => $invoiceData['id']]) }}">Xác nhận thanh toán</a></p> -->
</body>
</html>
