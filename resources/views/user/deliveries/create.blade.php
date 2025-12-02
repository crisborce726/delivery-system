@extends('layouts.app')

@section('title', 'Create New Delivery')

@section('content')
    <div class="container mt-4">

        <div class="d-flex justify-content-between mb-4">
            <h2>Create New Delivery</h2>
            <a href="{{ route('user.deliveries.index') }}" class="btn btn-secondary">My Deliveries</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('user.deliveries.store') }}" method="POST">
            @csrf

            <!-- Description -->
            <div class="mb-3">
                <label class="form-label">Description</label>
                <input type="text" name="description" class="form-control @error('description') is-invalid @enderror"
                    value="{{ old('description') }}" required>

                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Delivery Address -->
            <div class="mb-3">
                <label class="form-label">Delivery Address</label>
                <textarea name="delivery_address" rows="3" class="form-control @error('delivery_address') is-invalid @enderror"
                    required>{{ old('delivery_address') }}</textarea>

                @error('delivery_address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Category -->
            <div class="mb-3">
                <label class="form-label">Category</label>
                <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                    <option value="">-- Select Category --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                @error('category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Create Delivery</button>
        </form>
    </div>
@endsection
