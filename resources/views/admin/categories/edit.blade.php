<!-- resources/views/categories/edit.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-lg-12 text-center">
            <h2 class="display-4">Edit Category</h2>
            <a class="btn btn-primary mt-3" href="{{ route('admin.categories.index') }}">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-primary">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Edit Category Details</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name" class="font-weight-bold">Name:</label>
                            <input type="text" id="name" name="name" value="{{ $category->name }}" class="form-control" placeholder="Enter category name" required>
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
