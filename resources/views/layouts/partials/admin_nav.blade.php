<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-3">
    <div class="container-fluid">

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar"
            aria-controls="adminNavbar" aria-expanded="false">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="adminNavbar">
            <ul class="navbar-nav me-auto">

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{  route('admin.users.index') }}">Users</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{  route('admin.drivers.index') }}">Drivers</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{  route('admin.categories.index') }}">Categories</a>
                </li>

            </ul>
        </div>

    </div>
</nav>
