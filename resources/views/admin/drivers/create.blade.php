@extends('layouts.app')

@section('title', 'Add Driver')

@section('content')
    <div class="container">

        <h2 class="mb-4">Add Driver</h2>

        <form action="{{ route('admin.drivers.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Phone</label>
                    <input type="text" name="phone" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Vehicle Type</label>
                    <input type="text" name="vehicle_type" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>License Number</label>
                    <input type="text" name="license_number" class="form-control" required>
                </div>
            </div>

            <button class="btn btn-primary">Save</button>
            <a href="{{ route('admin.drivers.index') }}" class="btn btn-secondary">Cancel</a>

        </form>
    </div>
@endsection
