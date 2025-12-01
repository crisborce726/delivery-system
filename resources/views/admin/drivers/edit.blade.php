@extends('layouts.app')

@section('content')
    <div class="container">

        <h2 class="mb-4">Edit Driver</h2>

        <form action="{{ route('admin.drivers.update', $driver->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Name</label>
                    <input type="text" name="name" value="{{ $driver->name }}" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ $driver->email }}" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Phone</label>
                    <input type="text" name="phone" value="{{ $driver->phone }}" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Vehicle Type</label>
                    <input type="text" name="vehicle_type" value="{{ $driver->vehicle_type }}" class="form-control"
                        required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>License Number</label>
                    <input type="text" name="license_number" value="{{ $driver->license_number }}" class="form-control"
                        required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Available</label><br>
                    <select name="is_available" class="form-select">
                        <option value="1" {{ $driver->is_available ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ !$driver->is_available ? 'selected' : '' }}>No</option>
                    </select>
                </div>
            </div>

            <button class="btn btn-warning">Update</button>
            <a href="{{ route('admin.drivers.index') }}" class="btn btn-secondary">Cancel</a>

        </form>

    </div>
@endsection
