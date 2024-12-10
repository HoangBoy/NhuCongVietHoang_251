@extends('layouts.app')

@section('title', 'Danh Sách Đơn Hàng')

@section('content')
<div class="container mt-4">
    <h1 class="text-center mb-4 text-gradient animate__animated animate__zoomIn">📦 Danh Sách Đơn Hàng 📦</h1>

    @if($orders->isEmpty())
        <p class="text-center text-danger animate__animated animate__shakeX">Không có đơn hàng nào.</p>
    @else
        <table class="table table-striped table-hover">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Email</th>
                    <th>Thời gian đặt</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr class="table-row">
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->name }}</td>
                        <td>{{ $order->email }}</td>
                        <td>{{ $order->created_at->format('d-m-Y H:i') }}</td>
                        <td><strong>{{ number_format($order->total_amount, 2) }} VNĐ</strong></td>
                        <td>
                            <span class="badge badge-status {{ $order->status }}">{{ ucfirst($order->status) }}</span>
                        </td>
                        <td>
                            <a href="{{ route('orders.show', $order) }}" class="btn btn-info btn-sm btn-hover">Xem</a>
                            <form action="{{ route('orders.destroy', $order) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm btn-hover" onclick="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này?');">Xóa</button>
                            </form>
                            <form action="{{ route('orders.updateStatus', $order) }}" method="POST" style="display:inline;">
                                @csrf
                                <select name="status" class="form-control form-control-sm status-select" onchange="this.form.submit()">
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

<!-- Style Section -->
<style>
/* Title with gradient effect */
.text-gradient {
    background: linear-gradient(to right, #ff9966, #ff5e62);
    background-clip: text;
    -webkit-background-clip: text;
    color: transparent;
}

/* Table row hover effect */
.table-hover tbody tr:hover {
    background-color: #f8f9fa;
    transition: background-color 0.3s ease;
}

/* Animated buttons */
.btn-hover:hover {
    background-color: #28a745;
    border-color: #28a745;
    color: white;
    transform: scale(1.05);
    transition: all 0.3s ease;
}

/* Badge styling based on order status */
.badge-status.pending {
    background-color: #ffc107;
    color: white;
}
.badge-status.processing {
    background-color: #17a2b8;
    color: white;
}
.badge-status.shipped {
    background-color: #007bff;
    color: white;
}
.badge-status.delivered {
    background-color: #28a745;
    color: white;
}

/* Dropdown styling for status select */
.status-select {
    width: 150px;
    display: inline-block;
    border-radius: 5px;
    transition: all 0.2s ease;
}
.status-select:hover {
    background-color: #f1f1f1;
}

/* Animation for table rows */
.table-row {
    animation: fadeInUp 0.5s ease-in-out;
}

/* Keyframes for table row animation */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>

<!-- Animate.css for animations -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<script>
    // Optional: Any additional JavaScript for interaction
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.table-row').forEach(function(row) {
            row.classList.add('animate__animated', 'animate__fadeIn');
        });
    });
</script>
@endsection
