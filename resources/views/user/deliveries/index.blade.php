@extends('layouts.app')

@section('title', 'My Deliveries')

@section('content')
    <div class="container mt-4">

        <div class="d-flex justify-content-between mb-4">
            <h2>My Deliveries</h2>
            <a href="{{ route('user.deliveries.create') }}" class="btn btn-primary">+ Add New Delivery</a>
        </div>

        @if ($deliveries->isEmpty())
            <div class="alert alert-info">You have no deliveries yet.</div>
        @else
            <div class="row g-4">
                @foreach ($deliveries as $delivery)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">Tracking #: {{ $delivery->tracking_number }}</h5>
                                <h6 class="card-subtitle mb-2 text-muted">
                                    {{ $delivery->category->name ?? 'N/A' }}
                                </h6>

                                <p class="card-text mb-1"><strong>Description:</strong> {{ $delivery->description }}</p>
                                <p class="card-text mb-1"><strong>Address:</strong> {{ $delivery->delivery_address }}</p>

                                <p class="mt-2 mb-2">
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
                                    <div class="mt-auto">
                                        <strong>Assigned Driver(s):</strong>
                                        <ul class="list-unstyled mb-0">
                                            @foreach ($delivery->drivers as $driver)
                                                <li>
                                                    {{ $driver->name }}
                                                    <span class="badge bg-secondary">
                                                        {{ ucfirst($driver->pivot->assignment_status) }}
                                                    </span>
                                                    @if ($driver->pivot->completed_at)
                                                        <small>(Completed:
                                                            {{ \Carbon\Carbon::parse($driver->pivot->completed_at)->format('M d, Y') }})</small>
                                                    @endif
                                                    @if ($driver->pivot->notes)
                                                        <br><small>Notes: {{ $driver->pivot->notes }}</small>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @else
                                    <small class="text-muted mt-auto">No driver assigned yet.</small>
                                @endif

                                <small class="text-muted d-block mt-2">
                                    Created: {{ $delivery->created_at->format('M d, Y') }}
                                </small>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
@endsection
