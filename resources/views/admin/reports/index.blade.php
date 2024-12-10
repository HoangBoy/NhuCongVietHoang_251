@extends('layouts.app')
@section('title', 'Báo cáo')
@section('content')
<style>
    .container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 20px;
        background-color: #ffffff;
        border-radius: 15px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease-in-out;
    }

    h1 {
        font-size: 36px;
        text-align: center;
        color: #d9534f; /* Màu đỏ */
        text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
        transition: color 0.3s ease-in-out;
    }

    h1:hover {
        color: #c9302c; /* Màu đỏ đậm khi hover */
    }

    h4 {
        font-size: 18px;
        font-weight: bold;
        color: #555;
        transition: transform 0.3s ease-in-out;
    }

    h4:hover {
        transform: scale(1.05);
        color: #d9534f; /* Màu đỏ */
    }

    table {
        width: 100%;
        background-color: #f8f9fa; /* Màu nền cho bảng */
        border-collapse: collapse;
        margin-top: 20px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease-in-out;
    }

    table thead {
        background-color: #d9534f; /* Màu đỏ cho tiêu đề bảng */
        color: white;
        text-transform: uppercase;
    }

    table tbody tr {
        transition: background-color 0.3s ease-in-out;
    }

    table tbody tr:hover {
        background-color: #f1f1f1; /* Màu nền khi hover */
    }

    th, td {
        padding: 15px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th:hover, td:hover {
        color: #c9302c; /* Màu đỏ đậm khi hover */
        cursor: pointer;
    }

    table tbody tr:hover td {
        transform: scale(1.02);
    }

    .accordion-content {
        display: none;
        overflow: hidden;
        transition: all 0.3s ease-in-out;
    }

    .accordion-content.show {
        display: block;
    }

    .accordion-toggle {
        cursor: pointer;
        padding: 10px;
        background-color: #f1f1f1;
        border: 1px solid #ddd;
        margin-bottom: 10px;
        transition: background-color 0.3s ease;
        border-radius: 5px; /* Bo góc cho toggle */
    }

    .accordion-toggle:hover {
        background-color: #d9534f; /* Màu đỏ khi hover */
        color: white;
    }

</style>

<div class="container">
    <h1>Tổng Tiền</h1>

    <div class="mt-4">
        <h4>Tổng số đơn hàng: {{ $totalOrders }}</h4>
        <h4>Tổng số khách hàng: {{ $totalCustomers }}</h4>
    </div>

    <!-- Accordion cho từng phần thống kê -->
    <div class="accordion-toggle">Theo danh mục</div>
    <div class="accordion-content">
        <table class="table">
            <thead>
                <tr>
                    <th></th>
                    <th>Tổng tiền</th>
                </tr>
            </thead>
            <tbody>
                @if($categoryRevenue->isEmpty())
                    <tr>
                        <td colspan="2">Không có dữ liệu cho tổng tiền theo từng danh mục.</td>
                    </tr>
                @else
                    @foreach($categoryRevenue as $revenue)
                    <tr>
                        <td>{{ $revenue->category_id }}</td>
                        <td>{{ number_format($revenue->total_amount, 2) }} VND</td>
                    </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

    <div class="accordion-toggle">Theo ngày</div>
    <div class="accordion-content">
        <table class="table">
            <thead>
                <tr>
                    <th></th>
                    <th>Tổng tiền</th>
                </tr>
            </thead>
            <tbody>
                @if($revenueByDate->isEmpty())
                    <tr>
                        <td colspan="2">Không có dữ liệu cho tổng tiền theo ngày.</td>
                    </tr>
                @else
                    @foreach($revenueByDate as $revenue)
                    <tr>
                        <td>{{ $revenue->date }}</td>
                        <td>{{ number_format($revenue->total_amount, 2) }} VND</td>
                    </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

    <div class="accordion-toggle">Theo tháng</div>
    <div class="accordion-content">
        <table class="table">
            <thead>
                <tr>
                    <th></th>
                    <th>Tổng tiền</th>
                </tr>
            </thead>
            <tbody>
                @if($revenueByMonth->isEmpty())
                    <tr>
                        <td colspan="2">Không có dữ liệu cho tổng tiền theo tháng.</td>
                    </tr>
                @else
                    @foreach($revenueByMonth as $revenue)
                    <tr>
                        <td>{{ $revenue->month }}</td>
                        <td>{{ number_format($revenue->total_amount, 2) }} VND</td>
                    </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

    <div class="accordion-toggle">Theo năm</div>
    <div class="accordion-content">
        <table class="table">
            <thead>
                <tr>
                    <th></th>
                    <th>Tổng tiền</th>
                </tr>
            </thead>
            <tbody>
                @if($revenueByYear->isEmpty())
                    <tr>
                        <td colspan="2">Không có dữ liệu cho tổng tiền theo năm.</td>
                    </tr>
                @else
                    @foreach($revenueByYear as $revenue)
                    <tr>
                        <td>{{ $revenue->year }}</td>
                        <td>{{ number_format($revenue->total_amount, 2) }} VND</td>
                    </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

    <div class="accordion-toggle">Theo phương thức thanh toán</div>
    <div class="accordion-content">
        <table class="table">
            <thead>
                <tr>
                    <th>Phương thức thanh toán</th>
                    <th>Tổng tiền</th>
                </tr>
            </thead>
            <tbody>
                @if($revenueByPaymentMethod->isEmpty())
                    <tr><td colspan="2">Không có dữ liệu cho tổng tiền theo phương thức thanh toán.</td></tr>
                @else
                    @foreach($revenueByPaymentMethod as $revenue)
                    <tr>
                        <td>{{ $revenue->payment_method }}</td>
                        <td>{{ number_format($revenue->total_revenue, 2) }} VND</td>
                    </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>

<!-- JavaScript -->
<script>
    document.querySelectorAll('.accordion-toggle').forEach(item => {
        item.addEventListener('click', function() {
            let content = this.nextElementSibling;
            content.classList.toggle('show');
        });
    });
</script>
@endsection
