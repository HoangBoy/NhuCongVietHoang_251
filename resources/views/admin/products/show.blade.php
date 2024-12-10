@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-lg-12 text-center">
            <h2 class="display-4">Show Product</h2>
            <a class="btn btn-primary mt-3" href="{{ route('admin.products.index') }}">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-primary">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Product Details</h5>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <strong class="font-weight-bold">Name:</strong>
                        <p class="lead">{{ $product->name }}</p>
                    </div>

                    <div class="form-group">
                        <strong class="font-weight-bold">Description:</strong>
                        <p>{{ $product->description }}</p>
                    </div>

                    <div class="form-group">
                        <strong class="font-weight-bold">Price:</strong>
                        <p class="text-success">{{ number_format($product->price, 2) }} VND</p>
                    </div>

                    <div class="form-group">
                        <strong class="font-weight-bold">Quantity:</strong>
                        <p>{{ $product->quantity }}</p>
                    </div>

                    <div class="form-group">
                        <strong class="font-weight-bold">Category:</strong>
                        <p>{{ $product->category->name }}</p>
                    </div>

                    <div class="form-group">
                        <strong class="font-weight-bold">Image:</strong>
                        <div class="text-center">
                        @if ($product->image)
                    <img src="{{ asset($product->image) }}" class="card-img-top img-hover" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                @else
                    <img src="{{ asset('default-image.png') }}" class="card-img-top img-hover" alt="No Image" style="height: 200px; object-fit: cover;">
                @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const images = document.querySelectorAll('img');
        images.forEach(image => {
            image.addEventListener('mouseenter', function() {
                image.style.transform = 'scale(1.05)';
                image.style.transition = 'transform 0.3s ease';
            });
            image.addEventListener('mouseleave', function() {
                image.style.transform = 'scale(1)';
            });
        });
    });
</script>
@endsection
@endsection
