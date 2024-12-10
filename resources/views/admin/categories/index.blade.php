<!-- resources/views/categories/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-lg-12 text-center">
            <h2 class="display-4">Categories</h2>
            <a class="btn btn-success mt-3" href="{{ route('admin.categories.create') }}">
                <i class="fas fa-plus-circle"></i> Create New Category
            </a>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered table-hover">
        <thead>
            <tr class="table-dark">
                <th>ID</th>
                <th>Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr class="category-row">
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>
                        <a class="btn btn-info" href="{{ route('admin.categories.show', $category->id) }}">
                            <i class="fas fa-eye"></i> Show
                        </a>
                        <a class="btn btn-primary" href="{{ route('admin.categories.edit', $category->id) }}">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger delete-btn">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.delete-btn');
        deleteButtons.forEach(button => {
            button.addEventListener('mouseenter', function() {
                button.classList.add('bg-danger');
                button.classList.add('text-white');
            });
            button.addEventListener('mouseleave', function() {
                button.classList.remove('bg-danger');
                button.classList.remove('text-white');
            });
        });

        const categoryRows = document.querySelectorAll('.category-row');
        categoryRows.forEach(row => {
            row.addEventListener('mouseenter', function() {
                row.classList.add('table-secondary');
            });
            row.addEventListener('mouseleave', function() {
                row.classList.remove('table-secondary');
            });
        });
    });
</script>
@endsection
@endsection
