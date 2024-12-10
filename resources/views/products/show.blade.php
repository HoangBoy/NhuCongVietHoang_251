@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header text-center">
                    <h1 class="font-weight-bold text-primary">{{ $product->name }}</h1>
                </div>
                <div class="card-body text-center">
                @if ($product->image)
                    <img src="{{ asset($product->image) }}" class="card-img-top img-hover" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                @else
                    <img src="{{ asset('default-image.png') }}" class="card-img-top img-hover" alt="No Image" style="height: 200px; object-fit: cover;">
                @endif
                    <p class="font-italic">{{ $product->description }}</p>
                    <p class="font-weight-bold">Quantity: <span class="text-success">{{ $product->quantity }}</span></p>
                    <p class="font-weight-bold">Price: <span class="text-danger">${{ number_format($product->price, 2) }}</span></p>
                    <p class="font-weight-bold">Category: <span class="text-info">{{ $product->category->name }}</span></p>

                    <div class="mt-4">
                        <a href="{{ route('welcome') }}" class="btn btn-outline-secondary">Quay lại danh sách</a>

                        @auth
                            <!-- Form để thêm sản phẩm vào giỏ hàng -->
                            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-primary add-to-cart">Thêm vào giỏ hàng</button>
                            </form>
                        @else
                            <p class="mt-2">Vui lòng <a href="{{ route('login') }}">đăng nhập</a> để thêm sản phẩm vào giỏ hàng.</p>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    // Hiệu ứng hover cho nút "Thêm vào giỏ hàng"
    const addToCartButton = document.querySelector('.add-to-cart');
    if (addToCartButton) {
        addToCartButton.addEventListener('mouseover', function() {
            this.style.backgroundColor = '#0056b3'; // Màu nền khi hover
            this.style.color = '#fff'; // Màu chữ khi hover
            this.style.transform = 'scale(1.05)'; // Tăng kích thước
        });

        addToCartButton.addEventListener('mouseout', function() {
            this.style.backgroundColor = ''; // Trở về màu gốc
            this.style.color = ''; // Trở về màu chữ gốc
            this.style.transform = 'scale(1)'; // Trở về kích thước gốc
        });
    }
</script>
@endsection
@endsection
