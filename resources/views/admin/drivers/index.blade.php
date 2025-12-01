@extends('layouts.app')

@section('content')
    <div class="container">

        <h2 class="mb-3">Drivers</h2>

        <a href="{{ route('admin.drivers.create') }}" class="btn btn-primary mb-3">Add Driver</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Vehicle</th>
                    <th>License</th>
                    <th>Available</th>
                    <th width="200">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($drivers as $driver)
                    <tr>
                        <td>{{ $driver->name }}</td>
                        <td>{{ $driver->email }}</td>
                        <td>{{ $driver->phone }}</td>
                        <td>{{ $driver->vehicle_type }}</td>
                        <td>{{ $driver->license_number }}</td>
                        <td>
                            @if ($driver->is_available)
                                <span class="badge bg-success">Yes</span>
                            @else
                                <span class="badge bg-danger">No</span>
                            @endif
                        </td>

                        <td>
                            <a href="{{ route('admin.drivers.edit', $driver->id) }}" class="btn btn-warning btn-sm">Edit</a>

                            <form action="{{ route('admin.drivers.destroy', $driver->id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">
                            No drivers found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
@endsection
