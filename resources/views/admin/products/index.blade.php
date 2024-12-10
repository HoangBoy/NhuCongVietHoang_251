@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-lg-12 text-center">
            <h2 class="display-4">Products</h2>
            <a class="btn btn-success mt-3" href="{{ route('admin.products.create') }}">
                <i class="fas fa-plus-circle"></i> Create New Product
            </a>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success fade show" role="alert">
            <p>{{ $message }}</p>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Category</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr class="product-row">
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->description }}</td>
                        <td>{{ number_format($product->price, 2) }} VND</td>
                        <td>{{ $product->quantity }}</td>
                        <td>{{ $product->category->name }}</td>
                        <td>
                        @if ($product->image)
                    <img src="{{ asset($product->image) }}" class="card-img-top img-hover" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                @else
                    <img src="{{ asset('default-image.png') }}" class="card-img-top img-hover" alt="No Image" style="height: 200px; object-fit: cover;">
                @endif
                        </td>
                        <td>
                            <a class="btn btn-info" href="{{ route('admin.products.show', $product->id) }}">
                                <i class="fas fa-eye"></i> Show
                            </a>
                            <a class="btn btn-primary" href="{{ route('admin.products.edit', $product->id) }}">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this product?');">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const productRows = document.querySelectorAll('.product-row');
        productRows.forEach(row => {
            row.addEventListener('mouseenter', function() {
                row.classList.add('table-primary');
            });
            row.addEventListener('mouseleave', function() {
                row.classList.remove('table-primary');
            });
        });
    });
</script>
@endsection
@endsection
