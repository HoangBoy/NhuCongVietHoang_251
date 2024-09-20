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

    @if(count($carts) > 0)
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
            @foreach($carts as $id => $details)
                <tr>
                    <td>{{ $details['name'] }}</td>
                    <td>
                        <!-- Form để cập nhật số lượng -->
                        <form action="{{ route('carts.store', $id) }}" method="POST">
                            @csrf
                            <input type="number" 
                                   name="quantity" 
                                   value="{{ $details['quantity'] }}" 
                                   min="1" 
                                   class="form-control">
                            <input type="hidden" 
                                name="quantityCurrent" 
                                value="{{ $details['quantity'] }}" 
                                min="1" 
                                class="form-control">
                            <button type="submit" class="btn btn-secondary mt-2">Cập nhật</button>
                        </form>
                    </td>
                    <td>{{ $details['price'] }}</td>
                    <td>{{ $details['category'] }}</td>
                    <td>
                        <a href="{{ route('products.show', $id) }}" class="btn btn-primary">Xem chi tiết</a>
                        <form action="{{ route('carts.destroy', $id) }}" method="POST" style="display:inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Xóa</button>
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

    @push('scripts')
<script>
//     const updateUrl = '{{ route('carts.store', ':product') }}'; // Tạo URL với placeholder

//     function updateCart(productId, quantity) {
//         const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
//         console.log('info productId:', productId, '; quantity:', quantity);
        
//         const formData = new FormData();
//         formData.append('cart[' + productId + '][quantity]', quantity);

//         // Thay thế ':product' bằng productId
//         const url = updateUrl.replace(':product', productId);
//         console.log('url', url);
        
//         fetch(url, {
//             method: 'POST',
//             body: formData,
//             headers: {
//                 'X-CSRF-TOKEN': csrfToken
//         }
// })
// .then(response => {
//     console.log('Response:', response); // Kiểm tra phản hồi
//     return response.json(); // Phân tích phản hồi thành JSON
// })
// .then(data => {
//     if (data.success) {
//         console.log(data.message);
//     } else {
//         console.error(data.message);
//     }
// })
// .catch(error => {
//     console.error('Error:', error);
// });
//     }

</script>
@endpush

@endsection
