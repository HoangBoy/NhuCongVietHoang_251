<!-- {{-- resources/views/orders/index.blade.php --}} -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Danh Sách Đơn Hàng</h1>

    @if($orders->count())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Mã Đơn Hàng</th>
                    <th>Khách Hàng</th>
                    <th>Tổng Tiền</th>
                    <th>Trạng Thái</th>
                    <th>Ngày Đặt Hàng</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->txn_ref }}</td>
                        <td>
                            @if(Auth::user()->is_admin)
                                {{ $order->user->name }} ({{ $order->user->email }})
                            @else
                                {{ $order->customer_name }}
                            @endif
                        </td>
                        <td>{{ number_format($order->amount, 0, ',', '.') }} VND</td>
                        <td>{{ ucfirst($order->status) }}</td>
                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-info btn-sm">Xem Chi Tiết</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $orders->links() }} <!-- Hiển thị pagination -->
    @else
        <p>Không có đơn hàng nào để hiển thị.</p>
    @endif
</div>
@endsection
