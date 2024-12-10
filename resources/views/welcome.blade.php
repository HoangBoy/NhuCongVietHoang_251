@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <!-- Animated and colorful title -->
    <h1 class="mb-4 text-center text-gradient animate__animated animate__bounceIn">📦 CỬA HÀNG CÂY CẢNH 📦</h1>

    @if(request()->has('query') && !$products->isEmpty())
        <h2 class="text-center text-gradient">Kết quả tìm kiếm cho: "<strong>{{ request()->input('query') }}</strong>"</h2>
    @elseif(request()->has('query'))
        <p class="text-center text-danger">Không tìm thấy sản phẩm nào phù hợp.</p>
    @endif

    <!-- Animated Navigation Menu -->
    <div class="text-center mb-4">
   
<a href="{{ route('admin.reports.index') }}" class="btn btn-info btn-lg menu-item animate__animated animate__fadeInUp">Tổng tiền</a> <!-- Nút xem báo cáo -->

    </div>

    <!-- Product Cards -->
    <div class="row">
        @foreach ($products as $product)
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-lg product-card animate__animated animate__zoomIn" style="border: 2px solid #ff6f61;">
                @if ($product->image)
                    <img src="{{ asset($product->image) }}" class="card-img-top img-hover" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                @else
                    <img src="{{ asset('default-image.png') }}" class="card-img-top img-hover" alt="No Image" style="height: 200px; object-fit: cover;">
                @endif
                <div class="card-body text-center bg-gradient">
                    <h5 class="card-title text-uppercase">{{ $product->name }}</h5>
                    <p class="card-text font-italic text-muted">{{ $product->description }}</p>
                    <p class="card-text"><strong>Quantity:</strong> <span class="badge badge-info">{{ $product->quantity }}</span></p>
                    <p class="card-text"><strong>Price:</strong> <span class="badge badge-warning">${{ number_format($product->price, 2) }}</span></p>
                    <p class="card-text"><strong>Category:</strong> <span class="badge badge-pill badge-success">{{ optional($product->category)->name }}</span></p>
                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-outline-primary btn-hover">View Details</a>
                   

                </div>
            </div>
        </div>
        @endforeach
    </div>

    

<!-- CSS Styling for additional effects -->
<style>
/* Title gradient and animation */
.text-gradient {
    background: linear-gradient(90deg, rgba(255,105,180,1) 0%, rgba(255,165,0,1) 50%, rgba(173,216,230,1) 100%);
    background-clip: text;
    -webkit-background-clip: text;
    color: transparent;
}

/* Gradient for card body */
.bg-gradient {
    background: linear-gradient(145deg, rgba(255,255,255,1) 0%, rgba(224,242,254,1) 100%);
}

/* Hover effect for images */
.img-hover:hover {
    filter: brightness(0.8) saturate(1.5);
    transition: all 0.4s ease;
}

/* Menu item hover animation */
.menu-item:hover {
    background-color: #ff6f61;
    color: white !important;
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

/* Product card hover effect */
.product-card:hover {
    transform: rotate(2deg) scale(1.03);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
    transition: all 0.4s ease;
}

/* Button hover effect */
.btn-hover:hover {
    background-color: #ff1493;
    border-color: #ff1493;
    transition: all 0.3s ease;
}

/* Badge styling */
.badge-info {
    background-color: #5bc0de;
    color: white;
}

.badge-warning {
    background-color: #ffc107;
    color: black;
}

.badge-success {
    background-color: #28a745;
    color: white;
}
</style>

<!-- Animate.css for additional animations -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Custom animation when scrolling into view
        document.querySelectorAll('.product-card').forEach(function(card) {
            card.classList.add('animate__animated', 'animate__fadeInUp');
        });
    });
</script>
@endsection
