@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-lg-12 text-center">
            <h2 class="display-4">Create New Product</h2>
            <a class="btn btn-primary mt-3" href="{{ route('admin.products.index') }}">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-primary">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Product Details</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name" class="font-weight-bold">Name:</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Enter product name" required>
                        </div>

                        <div class="form-group">
                            <label for="description" class="font-weight-bold">Description:</label>
                            <textarea id="description" class="form-control" style="height:150px" name="description" placeholder="Enter product description"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="price" class="font-weight-bold">Price:</label>
                            <input type="text" id="price" name="price" class="form-control" placeholder="Enter product price" required>
                        </div>

                        <div class="form-group">
                            <label for="category" class="font-weight-bold">Category:</label>
                            <select id="category" name="category_id" class="form-control">
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="quantity" class="font-weight-bold">Quantity:</label>
                            <input type="number" id="quantity" name="quantity" class="form-control" placeholder="Enter quantity" required min="0">
                        </div>

                        <div class="form-group">
                            <label for="image" class="font-weight-bold">Image:</label>
                            <input type="file" id="image" name="image" class="form-control">
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-success btn-lg">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const submitButton = document.querySelector('.btn-success');
        submitButton.addEventListener('mouseenter', function() {
            submitButton.classList.add('shadow');
        });
        submitButton.addEventListener('mouseleave', function() {
            submitButton.classList.remove('shadow');
        });
    });
</script>
@endsection
@endsection
