@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
    <div class="d-flex justify-content-center align-items-center h-100">
        <div class="card shadow-sm p-4" style="min-width: 400px; max-width: 600px;">
            <div class="card-body">
                <h4 class="card-title mb-4 text-center">Edit User</h4>

                <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        {{-- Name --}}
                        <div class="col-md-6">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}"
                                required>
                        </div>

                        {{-- Email --}}
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control"
                                value="{{ old('email', $user->email) }}" required>
                        </div>

                        {{-- Phone --}}
                        <div class="col-md-6">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control"
                                value="{{ old('phone', $user->phone) }}">
                        </div>

                        {{-- Role --}}
                        <div class="col-md-6">
                            <label class="form-label">Role</label>
                            <select name="role" class="form-select" required>
                                <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                            </select>
                        </div>

                        {{-- Verified --}}
                        <div class="col-md-6">
                            <label class="form-label">Verified</label>
                            <select name="is_verified" class="form-select">
                                <option value="0" {{ !$user->is_verified ? 'selected' : '' }}>No</option>
                                <option value="1" {{ $user->is_verified ? 'selected' : '' }}>Yes</option>
                            </select>
                        </div>

                        {{-- Created At --}}
                        <div class="col-md-6">
                            <label class="form-label">Created At</label>
                            <input type="text" class="form-control" value="{{ $user->created_at->format('M d, Y H:i') }}"
                                disabled>
                        </div>

                        {{-- Updated At --}}
                        <div class="col-md-6">
                            <label class="form-label">Last Updated</label>
                            <input type="text" class="form-control" value="{{ $user->updated_at->format('M d, Y H:i') }}"
                                disabled>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center mt-4 gap-2">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Back</a>
                        <button type="submit" class="btn btn-primary">Update User</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
