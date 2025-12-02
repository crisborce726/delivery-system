@extends('layouts.app')

@section('title', 'Users Management')

@section('content')
    <div class="container">
        <h2 class="mb-3">All Users</h2>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th width="250">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>

                        <td>
                            {{-- View Details --}}
                            <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-info btn-sm">
                                View Details
                            </a>

                            {{-- Edit --}}
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning btn-sm">
                                Edit
                            </a>

                            {{-- Delete --}}
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted">
                            No users found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
