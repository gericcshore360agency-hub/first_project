<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('my_resources/logo.png') }}">
    <title>Eloquent Practice</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('styles/dashboard.css') }}">
</head>
<body>

    <style>
        
    </style>

<div class="container-fluid">
    <div class="row">

        @include('profile.sidebar')

        <div class="col-10 col-md-10 main-content">
            <div class="card shadow-lg card-custom p-4">

                <h2 class="mb-1">Eloquent Practice</h2>
                <p class="text-muted mb-4">Pick a query below and see the raw results from your database.</p>

                {{-- Query Selector + Inputs --}}
                <form method="GET" action="{{ route('fetching_practice') }}">
                    <div class="row g-2 align-items-end mb-3">
                        <div class="col-12 col-md-5">
                            <label class="form-label">Select a Query</label>
                            <select name="query" class="form-select">
                                <optgroup label="Users">
                                    <option value="all_users"                {{ request('query') === 'all_users' ? 'selected' : '' }}>All Users</option>
                                    <option value="users_with_roles"         {{ request('query') === 'users_with_roles' ? 'selected' : '' }}>Users with Roles</option>
                                    <option value="teachers_only"            {{ request('query') === 'teachers_only' ? 'selected' : '' }}>Teachers Only</option>
                                    <option value="parents_only"             {{ request('query') === 'parents_only' ? 'selected' : '' }}>Parents Only</option>
                                </optgroup>
                                <optgroup label="Students">
                                    <option value="all_students"             {{ request('query') === 'all_students' ? 'selected' : '' }}>All Students</option>
                                    <option value="students_with_teacher"    {{ request('query') === 'students_with_teacher' ? 'selected' : '' }}>Students with Teacher</option>
                                    <option value="students_with_attendance" {{ request('query') === 'students_with_attendance' ? 'selected' : '' }}>Students with Attendance Count</option>
                                    <option value="at_risk_students"         {{ request('query') === 'at_risk_students' ? 'selected' : '' }}>Students with 0 Attendance</option>
                                    <option value="student_search"           {{ request('query') === 'student_search' ? 'selected' : '' }}>Student Search</option>
                                    <option value="latest_10_students"       {{ request('query') === 'latest_10_students' ? 'selected' : '' }}>Latest 10 Students</option>
                                    <option value="top_students_by_attendance" {{ request('query') === 'top_students_by_attendance' ? 'selected' : '' }}>Top 10 Students by Attendance</option>
                                </optgroup>
                                <optgroup label="Attendance">
                                    <option value="all_attendance"           {{ request('query') === 'all_attendance' ? 'selected' : '' }}>All Attendance Records</option>
                                    <option value="attendance_today"         {{ request('query') === 'attendance_today' ? 'selected' : '' }}>Attendance Today</option>
                                    <option value="attendance_per_day"       {{ request('query') === 'attendance_per_day' ? 'selected' : '' }}>Attendance Count Per Day</option>
                                    <option value="attendance_between"       {{ request('query') === 'attendance_between' ? 'selected' : '' }}>Attendance Between Dates</option>
                                    <option value="recent_3_days"            {{ request('query') === 'recent_3_days' ? 'selected' : '' }}>Recent 3 Days</option>
                                </optgroup>
                                <optgroup label="Teacher Metrics">
                                    <option value="teachers_with_student_count" {{ request('query') === 'teachers_with_student_count' ? 'selected' : '' }}>Teachers with Student Count</option>
                                </optgroup>
                            </select>
                        </div>
                        <div class="col-12 col-md-7">
                            <div class="row g-2">
                                <div class="col-12 col-md-4">
                                    <label class="form-label">Search Term (for Student Search)</label>
                                    <input name="search_term" type="text" value="{{ old('search_term', $searchTerm ?? request('search_term')) }}" class="form-control" placeholder="e.g. Maria" />
                                </div>
                                <div class="col-6 col-md-3">
                                    <label class="form-label">Start Date</label>
                                    <input name="start_date" type="date" value="{{ old('start_date', $startDate ?? request('start_date')) }}" class="form-control" />
                                </div>
                                <div class="col-6 col-md-3">
                                    <label class="form-label">End Date</label>
                                    <input name="end_date" type="date" value="{{ old('end_date', $endDate ?? request('end_date')) }}" class="form-control" />
                                </div>
                                <div class="col-12 col-md-2">
                                    <label class="form-label">Custom Key</label>
                                    <input name="custom_query" type="text" value="{{ old('custom_query', $customQuery ?? request('custom_query')) }}" class="form-control" placeholder="latest_10_students" />
                                </div>
                            </div>
                        </div>

                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary">Run Query</button>
                        </div>
                        @if(request('query') || request('custom_query'))
                            <div class="col-auto">
                                <a href="{{ route('practice') }}" class="btn btn-outline-secondary">Reset</a>
                            </div>
                        @endif
                    </div>
                </form>

                @if(isset($error) && $error)
                    <div class="alert alert-warning">{{ $error }}</div>
                @endif

                @if(request('query'))

                    {{-- Show the actual Eloquent code --}}
                    <div class="mb-4">
                        <label class="form-label fw-600">Eloquent Code Used</label>
                        <pre class="bg-dark text-success p-3 rounded" style="font-size:0.85rem;">{{ $queryCode }}</pre>
                    </div>

                    {{-- Results --}}
                    <h6 class="mb-3">Results <span class="text-muted" style="font-size:0.8rem;">({{ $count }} records)</span></h6>

                    @if($results->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle text-center">
                                <thead class="table-light">
                                    <tr>
                                        @foreach(array_keys($results->first()->toArray()) as $column)
                                            <th>{{ $column }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($results as $row)
                                        <tr>
                                            @foreach($row->toArray() as $value)
                                                <td style="max-width:200px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                                                    @if(is_array($value))
                                                        {{ json_encode($value) }}
                                                    @else
                                                        {{ $value ?? 'NULL' }}
                                                    @endif
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">No records returned.</p>
                    @endif

                @else
                    <div class="text-center py-5 text-muted">
                        <p>Select a query above and hit <strong>Run Query</strong> to see results.</p>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>