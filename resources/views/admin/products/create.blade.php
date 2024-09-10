@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Create New Product</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('admin.products.index') }}"> Back</a>
            </div>
        </div>
    </div>

    <form id="product-form" action="{{ route('admin.products.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Name:</strong>
                    <input type="text" name="name" class="form-control" placeholder="Name" required>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Description:</strong>
                    <textarea class="form-control" style="height:150px" name="description" placeholder="Description"></textarea>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Price:</strong>
                    <input type="number" name="price" class="form-control" placeholder="Price" required>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Quantity:</strong>
                    <input type="number" name="quantity" class="form-control" placeholder="Quantity" required>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Category:</strong>
                    <select name="category_id" class="form-control" required>
                        <option value="">Select Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
</div>

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Include jQuery Validation Plugin -->
<script src="https://cdn.jsdelivr.net/jquery.validation/1.19.5/jquery.validate.min.js"></script>

<script>
$(document).ready(function() {
    $("#product-form").validate({
        rules: {
            name: {
                required: true,
                minlength: 3 // The name must be at least 3 characters long
            },
            description: {
                required: false, // Description is optional
                minlength: 10 // Minimum length if provided
            },
            price: {
                required: true,
                number: true, // Must be a number
                min: 0 // Must be greater than or equal to 0
            },
            category_id: {
                required: true // Category selection is required
            }
        },
        messages: {
            name: {
                required: "Please enter the product name",
                minlength: "The name must be at least 3 characters long"
            },
            description: {
                minlength: "The description must be at least 10 characters long"
            },
            price: {
                required: "Please enter the price",
                number: "Please enter a valid number",
                min: "The price must be at least 0"
            },
            category_id: {
                required: "Please select a category"
            }
        },
        errorElement: "span",
        errorPlacement: function(error, element) {
            error.addClass("invalid-feedback");
            element.closest(".form-group").append(error);
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass("is-invalid").removeClass("is-valid");
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).addClass("is-valid").removeClass("is-invalid");
        }
    });
});
</script>
@endsection
