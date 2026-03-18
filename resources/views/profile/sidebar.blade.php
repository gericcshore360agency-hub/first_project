        <!-- Sidebar (20%) -->
        <div class="col-md-2 sidebar">
            <h1>Menu</h1>

            <a href="{{ route('dashboard') }}" class="menu-link">
                <img src="{{ asset('my_resources/dashboard.svg') }}" alt="Dashboard" class="menu-icon">
                Dashboard
            </a>

            <a href="{{ route('profile.edit') }}" class="menu-link">
                <img src="{{ asset('icons/profile.svg') }}" alt="Profile" class="menu-icon">
                Edit Profile
            </a>

            <a href="{{ route('show_attendance') }}" class="menu-link">
                <img src="{{ asset('icons/attendance.svg') }}" alt="Attendance" class="menu-icon">
                Show Attendance
            </a>

            <a href="#" class="menu-link">
                <img src="{{ asset('icons/settings.svg') }}" alt="Settings" class="menu-icon">
                Settings
            </a>

            <a href="#" class="menu-link">
                <img src="{{ asset('icons/users.svg') }}" alt="Users" class="menu-icon">
                Users
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-dark btn-sm mt-3 w-100">Logout</button>
            </form>
        </div>