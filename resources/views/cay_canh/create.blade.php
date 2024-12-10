@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Thêm cây cảnh</h1>
    <form action="{{ route('cay_canh.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="ten_cay" class="form-label">Tên cây</label>
            <input type="text" class="form-control" id="ten_cay" name="ten_cay" value="{{ old('ten_cay') }}" required>
            @error('ten_cay')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <label for="mieu_ta" class="form-label">Mô tả</label>
            <textarea class="form-control" id="mieu_ta" name="mo_ta">{{ old('mieu_ta') }}</textarea>
            @error('mieu_ta')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <label for="so_luong" class="form-label">Số lượng</label>
            <input type="number" class="form-control" id="so_luong" name="so_luong" value="{{ old('so_luong') }}" required>
            @error('so_luong')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <label for="gia" class="form-label">Giá</label>
            <input type="number" class="form-control" id="gia" name="gia" value="{{ old('gia') }}" required>
            @error('gia')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <label for="ngay_tao" class="form-label">Ngày tạo</label>
            <input type="date" class="form-control" id="ngay_tao" name="ngay_tao" value="{{ old('ngay_tao') }}">
            @error('ngay_tao')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <button type="submit" class="btn btn-success">Lưu</button>
    </form>
</div>
@endsection
