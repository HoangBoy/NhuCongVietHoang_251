<!-- resources/views/categories/show.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-lg-12 text-center">
            <h2 class="display-4">Show Category</h2>
            <a class="btn btn-primary mt-3" href="{{ route('admin.categories.index') }}">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-info">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Category Details</h5>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <strong>Name:</strong>
                        <p class="lead">{{ $category->name }}</p>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <a class="btn btn-secondary" href="{{ route('admin.categories.index') }}">
                        <i class="fas fa-list"></i> View All Categories
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const card = document.querySelector('.card');
        card.addEventListener('mouseenter', function() {
            card.classList.add('shadow-lg');
            card.classList.add('border-warning');
        });
        card.addEventListener('mouseleave', function() {
            card.classList.remove('border-warning');
        });
    });
</script>
@endsection
@endsection
