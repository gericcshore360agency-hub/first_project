        <!-- Sidebar (20%) -->
        <div class="col-md-2 sidebar">
            <h1>Menu</h1>

@role('dev|teacher|parent')
            <a href="{{ route('dashboard') }}" class="menu-link">
                <img src="{{ asset('my_resources/dashboard.svg') }}" alt="Dashboard" class="menu-icon">
                Dashboard
            </a>
@endrole



@role('dev|teacher')
            <a href="{{ route('profile.edit') }}" class="menu-link">
                <img src="{{ asset('my_resources/edit.svg') }}" alt="Profile" class="menu-icon">
                Edit Profile
            </a>
@endrole


@role('dev|teacher|parent')
            <a href="{{ route('view_students') }}" class="menu-link">
                <img src="{{ asset('my_resources/view.svg') }}" alt="Students" class="menu-icon">
                View Students
            </a>
@endrole


@role('dev|teacher|parent')
            <a href="{{ route('show_attendance') }}" class="menu-link">
                <img src="{{ asset('my_resources/show.svg') }}" alt="Attendance" class="menu-icon">
                Show Attendance
            </a>
@endrole

@role('dev')
            <a href="{{ route('role_management') }}" class="menu-link">
                <img src="{{ asset('my_resources/settings.svg') }}" alt="Settings" class="menu-icon">
                Role Settings
            </a>
@endrole


@role('dev')
            <a href="{{ route('show_users') }}" class="menu-link">
                <img src="{{ asset('my_resources/users.svg') }}" alt="Users" class="menu-icon">
                Users
            </a>
@endrole



@role('dev')
            <a href="{{ route('history') }}" class="menu-link">
                <img src="{{ asset('my_resources/history.svg') }}" alt="History" class="menu-icon">
                History
            </a>
@endrole


@role('dev')
            <a href="{{ route('practice') }}" class="menu-link">
                <img src="{{ asset('my_resources/history.svg') }}" alt="History" class="menu-icon">
                Query Practice
            </a>
@endrole

            <form method="POST" action="{{ route('logout') }}">

                @csrf

                <button type="submit" class="btn btn-outline-dark btn-sm mt-3 w-100">Logout</button>
            </form>
        </div>