@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Kết quả tìm kiếm cho: <strong>{{ request()->input('query') }}</strong></h1>

    @if($products->isEmpty())
        <div class="alert alert-warning">Không tìm thấy sản phẩm nào.</div>
    @else
        <ul class="list-group">
            @foreach($products as $product)
                <li class="list-group-item d-flex justify-content-between align-items-center hover-effect">
                    <div>
                        <strong>{{ $product->name }}</strong><br>
                        <span class="text-muted">{{ $product->category->name }}</span>
                    </div>
                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-info">Xem chi tiết</a>
                </li>
            @endforeach
        </ul>
    @endif
</div>

<style>
.hover-effect {
    transition: background-color 0.3s, transform 0.3s;
}
.hover-effect:hover {
    background-color: #f8f9fa; /* Thay đổi màu nền khi hover */
    transform: scale(1.02); /* Tăng kích thước một chút khi hover */
}
</style>

<script>
    // Bạn có thể thêm hiệu ứng JavaScript tùy chọn ở đây
    document.querySelectorAll('.hover-effect').forEach(item => {
        item.addEventListener('mouseenter', () => {
            item.style.cursor = 'pointer'; // Hiển thị con trỏ chuột như pointer
        });
    });
</script>
@endsection
