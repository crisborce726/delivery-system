<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="userNavbar">
            <ul class="navbar-nav me-auto">

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.dashboard') }}">Dashboard</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.deliveries.index') }}">My Deliveries</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.profile.show') }}">Profile</a>
                </li>

            </ul>
        </div>
    </div>
</nav>
