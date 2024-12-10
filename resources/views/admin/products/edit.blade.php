@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header text-center">
                    <h3 class="font-weight-light my-4 text-primary edit-product-title">Edit Product</h3>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label class="font-weight-bold">Name</label>
                            <input type="text" name="name" value="{{ $product->name }}" class="form-control form-control-lg" placeholder="Product Name" required>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Description</label>
                            <textarea class="form-control form-control-lg" name="description" rows="4" placeholder="Product Description" required>{{ $product->description }}</textarea>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Price</label>
                            <input type="number" step="0.01" name="price" value="{{ $product->price }}" class="form-control form-control-lg" placeholder="Product Price" required>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Quantity</label>
                            <input type="number" name="quantity" value="{{ $product->quantity }}" class="form-control form-control-lg" placeholder="Available Quantity" required>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Category</label>
                            <select name="category_id" class="form-control form-control-lg">
                                <option value="" disabled>Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Current Image</label><br>
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-thumbnail mb-3" style="width: 150px;">
                            @else
                                <p>No image available</p>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Change Image</label>
                            @if ($product->image)
                    <img src="{{ asset($product->image) }}" class="card-img-top img-hover" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                @else
                    <img src="{{ asset('default-image.png') }}" class="card-img-top img-hover" alt="No Image" style="height: 200px; object-fit: cover;">
                @endif
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-success btn-lg px-5 py-2 mt-3">
                                <i class="fas fa-save"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-arrow-left"></i> Back to Products
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .edit-product-title {
        transition: color 0.3s ease;
    }

    .edit-product-title:hover {
        color: #007bff; /* Màu khi hover */
        text-decoration: underline; /* Gạch chân khi hover */
    }
</style>
@endsection

