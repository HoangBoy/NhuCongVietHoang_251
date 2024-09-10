<!-- views/cart/index.blade.php -->
@extends('layouts.app')
@section('content')
    <h1>Giỏ hàng của bạn</h1>
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
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
                <a class="btn btn-primary">View Details</a>
                
            </tr>
        </thead>
        <tbody>
        <a class="btn btn-primary">View Details</a>
            @foreach($cart as $id => $details)
            <tr>
            <td>{{ $details['name'] }}</td>
            <td>{{ $details['quantity'] }}</td>
            <td>{{ $details['price'] }}</td>
            <td>{{ $details['category'] }}</td>
            <a class="btn btn-primary">View Details</a>
            <td>
                <!-- <a href="{{ route('products.show', $id) }}" class="btn btn-primary">View Details</a> -->
                <a class="btn btn-primary">View Details</a>
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
