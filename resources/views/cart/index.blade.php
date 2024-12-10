@extends('layouts.app')

@section('content')
<div class="container-fluid py-5" style="background: linear-gradient(to right, #f7b42c, #fc575e); min-height: 100vh;">
    <div class="container bg-white shadow-lg rounded p-5" style="border-radius: 15px;">
        <h1 class="text-center mb-4 text-gradient" style="font-size: 2.5rem; font-weight: bold;">Giỏ hàng của bạn</h1>

        <!-- Display Success or Error Message -->
        @if (session('success'))
            <div class="alert alert-success animate__animated animate__fadeInDown">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger animate__animated animate__fadeInDown">
                {{ session('error') }}
            </div>
        @endif

        <!-- Check if Cart has items -->
        @if ($cart && count($cart) > 0)
            <div class="table-responsive mb-4">
                <table class="table table-striped">
                    <thead class="thead-light">
                        <tr>
                            <th>Hình ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Giá</th>
                            <th>Thành tiền</th>
                            <th>Danh mục</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cart as $item)
                            <tr id="row-{{ $item['product']->id }}" class="animate__animated animate__fadeInUp">
                                <td>
                                    @if ($item['product']->image)
                                        <img src="{{ asset('storage/' . $item['product']->image) }}" alt="{{ $item['product']->name }}" class="img-fluid rounded" style="max-width: 70px; border: 2px solid #fc575e;">
                                    @endif
                                </td>
                                <td>{{ $item['product']->name }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <button class="btn btn-warning btn-decrease" data-product-id="{{ $item['product']->id }}">-</button>
                                        <span id="quantity-{{ $item['product']->id }}" class="mx-2">{{ $item['quantity'] }}</span>
                                        <button class="btn btn-success btn-increase" data-product-id="{{ $item['product']->id }}">+</button>
                                    </div>
                                </td>
                                <td>{{ number_format($item['price'], 2) }} VND</td>
                                <td id="total-{{ $item['product']->id }}">{{ number_format($item['price'] * $item['quantity'], 2) }} VND</td>
                                <td>{{ $item['product']->category->name }}</td>
                                <td>
                                    <button class="btn btn-danger btn-remove" data-product-id="{{ $item['product']->id }}">Xoá</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Cart Total & Checkout Form -->
            <div class="d-flex justify-content-between align-items-center">
                <h4>Tổng tiền: <span id="cart-total" class="text-danger">{{ number_format($total, 2) }}</span> VND</h4>
                <button onclick="window.print()" class="btn btn-info px-4 py-2" style="border-radius: 30px; font-size: 1.1rem;">In hóa đơn</button>
            </div>

            <form action="{{ route('order.place') }}" method="POST" class="mt-4 animate__animated animate__fadeInRight">
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="name">Họ tên</label>
                        <input type="text" name="name" id="name" class="form-control rounded-pill" placeholder="Nhập họ tên" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control rounded-pill" placeholder="Nhập email" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="phone">Số điện thoại</label>
                        <input type="text" name="phone" id="phone" class="form-control rounded-pill" placeholder="Nhập số điện thoại" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="address">Địa chỉ</label>
                        <textarea name="address" id="address" class="form-control rounded" placeholder="Nhập địa chỉ" rows="2" required></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="payment_method">Phương thức thanh toán</label>
                    <select name="payment_method" id="payment_method" class="form-control rounded-pill" required>
                        <option value="Thẻ tín dụng">Thẻ tín dụng</option>
                        <option value="PayPal">PayPal</option>
                        <option value="Chuyển khoản ngân hàng">Chuyển khoản ngân hàng</option>
                    </select>
                </div>
                <!-- Mã Giảm Giá: Mua 3 Tặng 1 -->
<div class="form-group mt-4">
    <label for="promo_code">Áp dụng mã giảm giá</label>
    <input type="text" name="promo_code" id="promo_code" class="form-control rounded-pill" placeholder="Nhập mã giảm giá (nếu có)">
    <small class="form-text text-muted">Nhập mã <strong>"MUA3TANG1"</strong> để nhận ưu đãi mua 3 tặng 1.</small>
</div>

<script>
    document.getElementById('promo_code').addEventListener('input', function() {
        const promoCode = this.value;
        if (promoCode === "MUA3TANG1") {
            applyDiscount();
        }
    });

    function applyDiscount() {
        fetch(`/cart/apply-discount`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                promo_code: "MUA3TANG1"
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('cart-total').textContent = data.discountedTotal + ' VND';
                alert("Mã giảm giá đã được áp dụng! Mua 3 sản phẩm sẽ được tặng thêm 1 sản phẩm.");
            } else {
                alert('Mã giảm giá không hợp lệ hoặc không đủ điều kiện.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
</script>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-block rounded-pill py-2 px-5" style="font-size: 1.2rem;">Xác nhận đặt hàng</button>
                </div>
            </form>
        @else
            <p class="text-center text-dark mt-5">Giỏ hàng của bạn trống.</p>
        @endif
    </div>
</div>

<!-- Custom Styles -->
<style>
    /* Custom gradient for header */
    .text-gradient {
        background: -webkit-linear-gradient(#fc575e, #f7b42c);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* Button hover effects */
    .btn-decrease, .btn-increase, .btn-remove {
        transition: transform 0.3s ease;
    }
    .btn-decrease:hover, .btn-increase:hover, .btn-remove:hover {
        transform: scale(1.1);
    }

    /* Rounded buttons */
    .btn-decrease, .btn-increase, .btn-remove {
        border-radius: 30px;
    }

    /* Cart total and print button styling */
    .btn-info:hover {
        background-color: #0056b3;
        color: white;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle increase quantity
        document.querySelectorAll('.btn-increase').forEach(function(button) {
            button.addEventListener('click', function() {
                let productId = this.getAttribute('data-product-id');
                let quantityElement = document.getElementById('quantity-' + productId);
                let currentQuantity = parseInt(quantityElement.textContent);

                // Update quantity on UI
                quantityElement.textContent = currentQuantity + 1;

                // Send AJAX request to update quantity on server
                updateCart(productId, currentQuantity + 1);
            });
        });

        // Handle decrease quantity
        document.querySelectorAll('.btn-decrease').forEach(function(button) {
            button.addEventListener('click', function() {
                let productId = this.getAttribute('data-product-id');
                let quantityElement = document.getElementById('quantity-' + productId);
                let currentQuantity = parseInt(quantityElement.textContent);

                // Ensure quantity is at least 1
                if (currentQuantity > 1) {
                    // Update quantity on UI
                    quantityElement.textContent = currentQuantity - 1;

                    // Send AJAX request to update quantity on server
                    updateCart(productId, currentQuantity - 1);
                }
            });
        });

        function updateCart(productId, newQuantity) {
            fetch(`/cart/update/${productId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    quantity: newQuantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Optionally update the total price for this product
                    document.getElementById('total-' + productId).textContent = data.newTotal + ' VND';
                    // Optionally update the overall cart total
                    document.getElementById('cart-total').textContent = data.cartTotal + ' VND';
                } else {
                    alert('Có lỗi xảy ra khi cập nhật số lượng.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    });
</script>
@endsection
