@extends('layouts.app')

@section('content')
<div class="container mt-5">
	<div class="row justify-content-center">
		<div class="col-lg-8">
			<div class="card shadow-sm">
				<div class="card-header bg-primary text-white text-center">
					<h2 class="mb-0">Create New Category</h2>
				</div>
				<div class="card-body">
					<form action="{{ route('categories.store') }}" method="POST">
						@csrf
						<div class="form-group mb-3">
							<label for="name" class="form-label"><strong>Category Name:</strong></label>
							<input type="text" name="name" id="name" class="form-control" placeholder="Enter category name" required>
						</div>
						<div class="d-grid gap-2">
							<button type="submit" class="btn btn-primary">Submit</button>
						</div>
					</form>
				</div>
			</div>
			<div class="mt-3 text-center">
				<a class="btn btn-secondary" href="{{ route('categories.index') }}">Back to Categories</a>
			</div>
		</div>
	</div>
</div>
@endsection
