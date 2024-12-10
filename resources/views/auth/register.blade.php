<!-- resources/views/register.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container-fluid" style="background: linear-gradient(to bottom right, #ff9966, #ff5e62); min-height: 100vh; display: flex; align-items: center; justify-content: center;">
    <div class="card p-5 shadow-lg" style="width: 100%; max-width: 500px; border-radius: 25px; background-color: white;">
        <h2 class="text-center mb-4" style="color: #ff5e62; font-weight: bold;">Đăng ký tài khoản</h2>

        <!-- Success and Error Messages -->
        @if (session('success'))
            <div class="alert alert-success animate__animated animate__fadeInDown">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger animate__animated animate__fadeInDown">
                {{ session('error') }}
            </div>
        @endif

        <!-- Registration Form -->
        <form action="{{ url('register') }}" method="POST" class="animate__animated animate__fadeInUp">
            @csrf
            <div class="form-group">
                <label for="name" class="form-label" style="color: #ff5e62;">Tên</label>
                <input type="text" name="name" id="name" class="form-control rounded-pill" placeholder="Nhập tên của bạn" required style="border: 2px solid #ff9966;">
            </div>

            <div class="form-group mt-3">
                <label for="email" class="form-label" style="color: #ff5e62;">Email</label>
                <input type="email" name="email" id="email" class="form-control rounded-pill" placeholder="Nhập email" required style="border: 2px solid #ff9966;">
            </div>

            <div class="form-group mt-3">
                <label for="phone" class="form-label" style="color: #ff5e62;">Số điện thoại</label>
                <input type="text" name="phone" id="phone" class="form-control rounded-pill" placeholder="Nhập số điện thoại" required style="border: 2px solid #ff9966;">
            </div>

            <div class="form-group mt-3">
                <label for="address" class="form-label" style="color: #ff5e62;">Địa chỉ</label>
                <input type="text" name="address" id="address" class="form-control rounded-pill" placeholder="Nhập địa chỉ" required style="border: 2px solid #ff9966;">
            </div>

            <div class="form-group mt-3">
                <label for="password" class="form-label" style="color: #ff5e62;">Mật khẩu</label>
                <input type="password" name="password" id="password" class="form-control rounded-pill" placeholder="Nhập mật khẩu" required style="border: 2px solid #ff9966;">
            </div>

            <div class="form-group mt-3">
                <label for="password_confirmation" class="form-label" style="color: #ff5e62;">Xác nhận mật khẩu</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control rounded-pill" placeholder="Nhập lại mật khẩu" required style="border: 2px solid #ff9966;">
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary btn-block rounded-pill" style="background-color: #ff5e62; border: none; padding: 10px 0; font-size: 1.1rem;">Đăng ký</button>
            </div>
        </form>
    </div>
</div>

<!-- Custom Styles -->
<style>
    /* Fullscreen gradient background */
    body {
        background: linear-gradient(to bottom right, #ff9966, #ff5e62);
    }

    /* Animate.css */
    .animate__animated {
        animation-duration: 1s;
        animation-fill-mode: both;
    }

    /* Form styles */
    .form-control {
        font-size: 1rem;
        padding: 12px 15px;
    }

    /* Button hover effect */
    .btn-primary:hover {
        background-color: #ff4d4d;
    }

    /* Input focus effect */
    .form-control:focus {
        border-color: #ff5e62;
        box-shadow: none;
    }

    /* Aligning form container */
    .container-fluid {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
    }
</style>
@endsection
