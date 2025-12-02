@extends('layouts.app')

@section('title', 'User Details')

@section('content')
    <div class="d-flex justify-content-center align-items-center h-100">
        <div class="card shadow-sm p-4" style="min-width: 400px; max-width: 600px;">
            <div class="card-body">
                <h4 class="card-title mb-4 text-center">User Details</h4>

                <div class="row g-3">
                    {{-- Name --}}
                    <div class="col-md-6">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" value="{{ $user->name }}" disabled>
                    </div>

                    {{-- Email --}}
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="text" class="form-control" value="{{ $user->email }}" disabled>
                    </div>

                    {{-- Phone --}}
                    <div class="col-md-6">
                        <label class="form-label">Phone</label>
                        <input type="text" class="form-control" value="{{ $user->phone ?? 'N/A' }}" disabled>
                    </div>

                    {{-- Role --}}
                    <div class="col-md-6">
                        <label class="form-label">Role</label>
                        <input type="text" class="form-control" value="{{ ucfirst($user->role) }}" disabled>
                    </div>

                    {{-- Verified --}}
                    <div class="col-md-6">
                        <label class="form-label">Verified</label>
                        <input type="text" class="form-control"
                            value="{{ $user->is_verified ? 'Yes (' . $user->verified_at?->format('M d, Y H:i') . ')' : 'No' }}"
                            disabled>
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
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning">Edit</a>
                </div>
            </div>
        </div>
    </div>
@endsection
