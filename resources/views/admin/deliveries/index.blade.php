@extends('layouts.app')

@section('title', 'Deliveries Management')

@section('content')
    <div class="container mt-4">

        <h2 class="mb-4">All Deliveries</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="row g-4">
            @foreach ($deliveries as $delivery)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">Tracking #: {{ $delivery->tracking_number }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">{{ $delivery->category->name ?? 'N/A' }}</h6>

                            <p class="card-text mb-1"><strong>Description:</strong> {{ $delivery->description }}</p>
                            <p class="card-text mb-1"><strong>Address:</strong> {{ $delivery->delivery_address }}</p>

                            <p class="mb-2">
                                <span
                                    class="badge 
                                {{ $delivery->status === 'pending'
                                    ? 'bg-warning'
                                    : ($delivery->status === 'in_transit'
                                        ? 'bg-info'
                                        : ($delivery->status === 'delivered'
                                            ? 'bg-success'
                                            : 'bg-danger')) }}">
                                    {{ ucfirst($delivery->status) }}
                                </span>
                            </p>

                            {{-- Assigned Drivers --}}
                            @if ($delivery->drivers->isNotEmpty())
                                <div class="mb-2">
                                    <strong>Assigned Driver(s):</strong>
                                    <ul class="list-unstyled mb-0">
                                        @foreach ($delivery->drivers as $driver)
                                            <li>
                                                {{ $driver->name }}
                                                <span
                                                    class="badge bg-secondary">{{ ucfirst($driver->pivot->assignment_status) }}</span>
                                                @if ($driver->pivot->notes)
                                                    <br><small>Notes: {{ $driver->pivot->notes }}</small>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @else
                                <small class="text-muted">No driver assigned yet.</small>
                            @endif

                            {{-- Assign / Update Driver Form --}}
                            @php
                                $hasCompletedDriver = $delivery->drivers->contains(function ($driver) {
                                    return $driver->pivot->assignment_status === 'completed';
                                });
                            @endphp

                            @if (!$hasCompletedDriver)
                                <form action="{{ route('admin.deliveries.assignDriver', $delivery->id) }}" method="POST"
                                    class="mt-auto">
                                    @csrf
                                    <div class="input-group input-group-sm mb-2">
                                        <select name="driver_id" class="form-select" required>
                                            <option value="">-- Select Driver --</option>
                                            @foreach ($availableDrivers as $driver)
                                                <option value="{{ $driver->id }}"
                                                    @if ($delivery->drivers->contains($driver->id)) selected @endif>
                                                    {{ $driver->name }} ({{ $driver->vehicle_type }})
                                                </option>
                                            @endforeach
                                        </select>
                                        <input type="text" name="notes" class="form-control"
                                            placeholder="Notes (optional)"
                                            value="{{ $delivery->drivers->first()?->pivot->notes }}">
                                        <button type="submit"
                                            class="btn btn-{{ $delivery->drivers->isNotEmpty() ? 'warning' : 'success' }}">
                                            {{ $delivery->drivers->isNotEmpty() ? 'Update Driver' : 'Assign' }}
                                        </button>
                                    </div>
                                </form>
                            @endif

                            <small class="text-muted">Created: {{ $delivery->created_at->format('M d, Y') }}</small>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
@endsection
