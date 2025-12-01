@extends('layouts.app')

@section('content')
    <div class="container">

        <h2 class="mb-4">User Details</h2>

        <div class="card">
            <div class="card-body">

                <p><strong>Name:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Joined:</strong> {{ $user->created_at->format('F d, Y') }}</p>

            </div>
        </div>

        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary mt-3">Back</a>

    </div>
@endsection
