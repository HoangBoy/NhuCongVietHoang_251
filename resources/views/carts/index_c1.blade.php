@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h1 class="text-center mb-4">Giỏ hàng của bạn</h1>
        
        <!-- Display Success, Error, or Information Messages -->
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

        <!-- Check if Cart is not Empty -->
        @if(count($carts) > 0)
            <form action="{{ route('payment.index') }}" method="POST">
                @csrf
                <table class="table table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>Chọn</th>
                            <th>Hình ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Giá</th>
                            <th>Danh mục</th>
                            <th>Trạng thái</th> 
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($carts as $id => $details)
                            <tr class="{{ $details['status'] == 'In Stock' ? 'table-success' : 'table-warning' }}">
                                <td>
                                    <input type="checkbox" name="selected_products[{{ $id }}]" value="{{ json_encode($details) }}" id="product_{{ $id }}">
                                </td>
                                <td>
                                    <img src="{{ $details['image_url'] ?? 'default.jpg' }}" alt="{{ $details['name'] }}" width="50" height="50" class="img-thumbnail">
                                </td>
                                <td>{{ $details['name'] }}</td>
                                <td>
                                    <form action="{{ route('carts.store', $id) }}" method="POST" style="display:inline;" onsubmit="return handleUpdate(event)">
                                        @csrf
                                        <input type="number" 
                                               name="quantity" 
                                               value="{{ $details['quantity'] }}" 
                                               min="1" 
                                               class="form-control w-50 d-inline">
                                        <input type="hidden" name="quantityCurrent" value="{{ $details['quantity'] }}">
                                        <button type="submit" class="btn btn-secondary mt-2">Cập nhật</button>
                                    </form>
                                </td>
                                <td>{{ number_format($details['price'], 2) }} VND</td>
                                <td>{{ $details['category'] }}</td>
                                <td>
                                    <span class="badge badge-{{ $details['status'] == 'Available' ? 'success' : 'danger' }}">
                                        {{ $details['status'] ?? 'Chưa xác định' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('products.show', $id) }}" class="btn btn-info btn-sm">Xem chi tiết</a>
                                    <form action="{{ route('carts.destroy', $id) }}" method="POST" style="display:inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>    
                </table>
                <div class="text-center">
                    <button type="submit" class="btn btn-success btn-lg">Tiến hành thanh toán</button>
                </div>
            </form>
        @else
            <p class="text-center">Giỏ hàng của bạn trống.</p>
        @endif

        <div class="text-center mt-4">
            <a href="{{ route('welcome') }}" class="btn btn-primary">Tiếp tục mua sắm</a>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function handleUpdate(event) {
            event.preventDefault(); 

            const form = event.target;
            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload(); 
                } else {
                    alert(data.message); 
                }
            })
            .catch(error => console.error('Error:', error));
        }
    </script>
@endsection
