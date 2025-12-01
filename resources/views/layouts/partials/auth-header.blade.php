<!-- Header with Logout Button and Theme Toggle -->
<div class="row mb-4 header-gradient rounded p-3">
    <div class="col-md-8">
        <h1 class="fw-bold">
            {{ Auth::check() && Auth::user()->role === 'user' ? 'User' : 'Admin' }} Dashboard
        </h1>

        <p class="text-muted mb-0">Real-time System Statistics</p>
    </div>
    <div class="col-md-4 text-end">
        <div class="d-flex justify-content-end align-items-center gap-3">
            <span class="me-3">Welcome, <strong>{{ Auth::check() ? Auth::user()->name : 'Guest' }}</strong></span>

            {{-- Logout --}}
            @if (Auth::guard('admin')->check())
                <form method="POST" action="{{ route('admin.logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            @elseif (Auth::check())
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
