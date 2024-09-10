<!-- views/cart/index.blade.php -->
@extends('layouts.app')
@section('content')
    <h1>Giỏ hàng của bạn</h1>
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    <!-- <h1>error</h1> -->
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    @if(session('message'))
        <div class="alert alert-info">
            {{ session('message') }}
        </div>
    @endif
    @if(count($cart) > 0)
        <table class="table">
        <thead>
            <tr>
                <th>Tên sản phẩm</th>
                <th>Số lượng</th>
                <th>Giá</th>
                <th>Danh mục</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cart as $id => $details)
            <tr>
            <td>{{ $details['name'] }}</td>
            <td>{{ $details['quantity'] }}</td>
            <td>{{ $details['price'] }}</td>
            <td>{{ $details['category'] }}</td>
            <td>
            <a href="{{ route('products.show', $id) }}" class="btn btn-primary">View Details</a>
                <form action="{{ route('cart.remove', $id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Xoá</button>
                </form>
            </td>
    </tr>
    @endforeach
</tbody>    
    </table>
@else
    <p>Giỏ hàng của bạn trống.</p>
@endif

    <a href="{{ route('welcome') }}" class="btn btn-primary">Tiếp tục mua sắm</a>
@endsection
