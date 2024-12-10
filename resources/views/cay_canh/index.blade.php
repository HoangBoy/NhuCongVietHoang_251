@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Danh sách cây cảnh</h1>
    <a href="{{ route('cay_canh.create') }}" class="btn btn-primary">Thêm cây cảnh</a>
    @if(session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif
    <table class="table mt-3">
        <thead>
            <tr>
                <th>Mã cây</th>
                <th>Tên cây</th>
                <th>Mô tả</th>
                <th>Số lượng</th>
                <th>Giá</th>
                <th>Ngày tạo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cayCanh as $cay)
            <tr>
                <td>{{ $cay->ma_cay }}</td>
                <td>{{ $cay->ten_cay }}</td>
                <td>{{ $cay->mo_ta }}</td>
                <td>{{ $cay->so_luong }}</td>
                <td>{{ number_format($cay->gia, 0, ',', '.') }} VNĐ</td>
                <td>{{ $cay->ngay_tao }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
