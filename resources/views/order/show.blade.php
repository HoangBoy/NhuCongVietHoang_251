@extends('layouts.app')

@section('title', 'Chi tiết đơn hàng')

@section('content')
<div class="container-fluid p-5" style="background: radial-gradient(circle, rgba(255,216,155,1) 0%, rgba(255,168,168,1) 100%); min-height: 100vh;">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">
            <div class="order-header text-center mb-5 p-4" style="background: #1a1a1d; color: #fff; border-radius: 20px; box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);">
                <h1 class="text-white text-bold animate__animated animate__fadeInDown" style="font-size: 2.5rem; letter-spacing: 3px;">Đơn hàng #{{ $order->id }}</h1>
                <p class="text-white-50 animate__animated animate__fadeInUp" style="font-size: 1.2rem;">Ngày đặt: {{ $order->created_at->format('d/m/Y H:i') }}</p>
            </div>

            <!-- Customer Info -->
            <div class="card customer-info mb-5 shadow-lg p-4 animate__animated animate__fadeInLeft" style="border-radius: 20px;">
                <h4 class="card-title text-bold mb-4 text-center" style="color: #ff5e62;">Thông tin khách hàng</h4>
                <div class="row">
                    <div class="col-12 col-md-6 mb-3">
                        <p class="card-text"><strong>Tên:</strong> {{ $order->name }}</p>
                        <p class="card-text"><strong>Email:</strong> {{ $order->email }}</p>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <p class="card-text"><strong>Địa chỉ:</strong> {{ $order->address }}</p>
                        <p class="card-text"><strong>Số điện thoại:</strong> {{ $order->phone }}</p>
                    </div>
                    <div class="col-12 text-center">
                        <p class="card-text"><strong>Phương thức thanh toán:</strong> {{ $order->payment_method }}</p>
                        <p class="card-text"><strong>Tổng tiền:</strong> <span style="font-size: 1.2rem; color: #28a745;">{{ number_format($order->total_amount, 2) }} VNĐ</span></p>
                    </div>
                    <div class="col-12 text-center">
                        <p class="card-text"><strong>Đặt hàng thành công:</strong> {{ $order->payment_method }}</p>
                        <p class="card-text"><strong>Tổng tiền:</strong> <span style="font-size: 1.2rem; color: #28a745;">{{ number_format($order->total_amount, 2) }} VNĐ</span></p>
                    </div>
                </div>
            </div>

            <!-- Product Info -->
            <div class="products-info mb-5 p-4 shadow-lg" style="background: #f8f9fa; border-radius: 20px;">
                <h4 class="text-center text-gradient mb-4 animate__animated animate__fadeInRight" style="color: #ff9966; letter-spacing: 2px;">Sản phẩm trong đơn hàng</h4>
                <ul class="list-group list-group-flush">
                    @if($order->products && $order->products->isNotEmpty())
                        @foreach($order->products as $product)
                            <li class="list-group-item product-item d-flex justify-content-between align-items-center mb-3 shadow-sm p-3 rounded animate__animated animate__fadeInUp" style="transition: transform 0.3s;">
                                <div class="d-flex align-items-center">
                                @if ($product->image)
                    <img src="{{ asset($product->image) }}" class="card-img-top img-hover" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                @else
                    <img src="{{ asset('default-image.png') }}" class="card-img-top img-hover" alt="No Image" style="height: 200px; object-fit: cover;">
                @endif
                                    <span style="font-size: 1.1rem; color: #333;">{{ $product->name }} - {{ $product->pivot->quantity }} x {{ number_format($product->price, 2) }} VNĐ</span>
                                </div>
                            </li>
                        @endforeach
                    @else
                        <li class="list-group-item text-center">Không có sản phẩm nào trong đơn hàng.</li>
                    @endif
                </ul>
            </div>

            <!-- Print Button -->
            <div class="text-center mt-4">
                <button onclick="window.print()" class="btn print-btn text-white px-5 py-3 animate__animated animate__pulse" style="background: #ff5e62; border-radius: 50px; font-size: 1.2rem;">In hóa đơn</button>
            </div>
        </div>
    </div>
</div>

<!-- Custom CSS for Unique Layout -->
<style>
    /* Gradient text for unique heading */
    .text-gradient {
        background: -webkit-linear-gradient(#ff9966, #ff5e62);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* Hover effect on product items */
    .product-item:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    /* Custom Button Styling */
    .print-btn:hover {
        background: #28a745;
        color: white;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }

    /* Custom container background */
    .container-fluid {
        border-radius: 30px;
        background-size: cover;
    }

    /* Text Styling */
    .text-bold {
        font-weight: 700;
    }

    /* Card Styling */
    .card {
        border: none;
        border-radius: 20px;
        padding: 20px;
    }
</style>

<!-- Include Animate.css for Animations -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
@endsection





