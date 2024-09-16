<!-- views/products/show.blade.php -->
@extends('layouts.app')
@section('content')
    <h1>{{$product->name}}</h1>
    <p>{{ $product->description }}</p>
    <p>Số lượng: {{ $product->quantity }}</p>
    <p>Giá: {{ $product->price }}</p>
    <p>Danh mục: {{ $product->category->name }}</p>
    @auth
        <!-- Form để thêm sản vào giỏ hàng -->
        <form action="{{ route('cart.add', $product->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary">Thêm vào giỏ hàng</button>
        </form>
    @else
        <p>Vui lòng <a href="{{ route('login') }}">đăng nhập</a> để thêm sản phẩm vào giỏ hàng.</p>
    @endauth
    <a href="{{ route('welcome') }}">Quay lại danh sách</a>
@endsection