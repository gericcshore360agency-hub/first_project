        <!-- Sidebar (20%) -->
        <div class="col-md-2 sidebar">
            <h4>Menu</h4>
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <a href="{{ route('profile.edit') }}">Edit Profile</a>
            <a href="{{ route('show_attendance') }}">Show Attendance</a>
            <a href="#">Settings</a>
            <a href="#">Users</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm mt-3 w-100">Logout</button>
            </form>
        </div>