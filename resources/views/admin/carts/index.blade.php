<!-- views/cart/index.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Giỏ hàng của bạn</h1>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

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
        <form action="{{ route('carts.store') }}" method="POST">
            @csrf
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
            <td>
                            <input type="number" name="cart[{{ $id }}][quantity]" value="{{ $details['quantity'] }}" min="1" class="form-control">
                            <input type="hidden" name="cart[{{ $id }}][id]" value="{{ $id }}">
            </td>
                        <td>{{ $details['price'] }}</td>
                        <td>{{ $details['category'] }}</td>
            <td>
                            <a href="{{ route('products.show', $id) }}" class="btn btn-primary">Xem chi tiết</a>
                            <form action="{{ route('carts.destroy',$id) }}" method="POST" style="display:inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Xóa</button>
                            </form>
            </td>
        </tr>
    @endforeach


                </tbody>    
            </table>

            <button type="submit" class="btn btn-success">Cập nhật giỏ hàng</button>
        </form>
    @else
        <p>Giỏ hàng của bạn trống.</p>
    @endif

    <a href="{{ route('welcome') }}" class="btn btn-primary">Tiếp tục mua sắm</a>
@endsection
