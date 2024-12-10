<!-- resources/views/login.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container-fluid" style="background: linear-gradient(to bottom right, #4e54c8, #8f94fb); min-height: 100vh; display: flex; align-items: center; justify-content: center;">
    <div class="card p-5 shadow-lg" style="width: 100%; max-width: 450px; border-radius: 20px; background-color: white;">
        <h2 class="text-center mb-4" style="color: #4e54c8; font-weight: bold;">Đăng nhập</h2>
        
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

        <!-- Login Form -->
        <form action="{{ url('login') }}" method="POST" class="animate__animated animate__fadeInUp">
            @csrf
            <div class="form-group">
                <label for="email" class="form-label" style="color: #4e54c8;">Email</label>
                <input type="email" name="email" id="email" class="form-control rounded-pill" placeholder="Nhập email" required style="border: 2px solid #8f94fb;">
            </div>
            <div class="form-group mt-3">
                <label for="password" class="form-label" style="color: #4e54c8;">Mật khẩu</label>
                <input type="password" name="password" id="password" class="form-control rounded-pill" placeholder="Nhập mật khẩu" required style="border: 2px solid #8f94fb;">
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary btn-block rounded-pill" style="background-color: #4e54c8; border: none; padding: 10px 0; font-size: 1.1rem;">Đăng nhập</button>
            </div>

            <div class="text-center mt-3">
                <a href="{{ url('password/reset') }}" class="text-secondary" style="text-decoration: none; font-size: 0.9rem;">Quên mật khẩu?</a>
            </div>
        </form>
    </div>
</div>

<!-- Custom Styles -->
<style>
    /* Gradient background for the login page */
    body {
        background: linear-gradient(to bottom right, #4e54c8, #8f94fb);
    }

    /* Animate.css */
    .animate__animated {
        animation-duration: 1s;
        animation-fill-mode: both;
    }

    /* Custom Input Styles */
    .form-control {
        font-size: 1rem;
        padding: 12px 15px;
    }

    /* Button hover effect */
    .btn-primary:hover {
        background-color: #373baf;
    }

    /* Add focus styles */
    .form-control:focus {
        border-color: #4e54c8;
        box-shadow: none;
    }

    /* Centering the form container */
    .container-fluid {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
    }
</style>
@endsection
