<!DOCTYPE html>
<html>
<head>
    <title>Thanh Toán Thành Công</title>
</head>
<body>
    <h1>Thanh Toán Thành Công</h1>
    <p>Mã đơn hàng: {{ $data['vnp_TxnRef'] }}</p>
    <p>Số tiền: {{ number_format($data['vnp_Amount'] / 100, 0, ',', '.') }} VND</p>
</body>
</html>
