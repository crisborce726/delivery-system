@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <!-- Edit Category Form (Left) -->
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header fw-bold">Edit Category</div>
                    <div class="card-body">
                        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="name" class="form-label">Category Name</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ $category->name }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description (optional)</label>
                                <textarea name="description" id="description" class="form-control" rows="3">{{ $category->description }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Update Category</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Category List (Right) -->
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header fw-bold">Categories List</div>
                    <div class="card-body">
                        @if ($categories->count() > 0)
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th width="180">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $cat)
                                        <tr>
                                            <td>{{ $cat->name }}</td>
                                            <td>{{ $cat->description ?? '-' }}</td>
                                            <td>
                                                <a href="{{ route('admin.categories.edit', $cat->id) }}"
                                                    class="btn btn-warning btn-sm">Edit</a>
                                                <form action="{{ route('admin.categories.destroy', $cat->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="text-muted">No categories found.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
