<!-- views/layout/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'MyShop')</title>
<!-- Bao gồm Bootstrap CSS hoặc các file CSS khác -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">MyShop</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" ariacontrols="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
    <li class="nav-item active">
    <a class="nav-link" href="{{ url('/') }}">Home <span class="sr-only">(current)</span></a>
    </li>
    <li class="nav-item">
    <a class="nav-link" href="{{ route('admin.products.index') }}">Products</a>
    </li>
    <li class="nav-item">
    <a class="nav-link" href="{{ route('admin.categories.index') }}">Categories</a>
    </li>
    <!-- Cart Link -->
    @auth
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('carts.index') }}">Cart 
                       
                    </a>
                </li>
                @endauth
    <!-- Thêm liên kết đăng ký và đăng nhập -->
    @guest
    <li class="nav-item">
    <a class="nav-link" href="{{ route('register') }}">Register</a>
    </li>
    <li class="nav-item">
    <a class="nav-link" href="{{ route('login') }}">Login</a>
    </li>
    @else
    <li class="nav-item">
    <a class="nav-link" href="{{ route('logout') }}"
    onclick="event.preventDefault();
document.getElementById('logout-form').submit();">
Logout
</a>
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
@csrf
</form>
</li>
@endguest
</ul>
</div>
</nav>
<div class="container mt-4">
@yield('content')
</div>
<!-- Bao gồm các file JS cần thiết -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" ></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
