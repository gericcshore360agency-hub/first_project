<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('my_resources/logo.png') }}">
    <title>History</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('styles/dashboard.css') }}">
</head>
<body>

<div class="container-fluid">
    <div class="row">

        @include('profile.sidebar')
        
        <div class="col-md-10 main-content d-flex align-items-center justify-content-center" style="min-height: 100vh;">
            <div class="card shadow-lg card-custom p-4 w-100 flex-grow-1 d-flex flex-column justify-content-start" style="min-height: auto;">

                <!-- Header -->
                <div class="mb-4">
                    <h2 class="mb-1">History</h2>
                    <p class="text-muted mb-0">Track system activity and deleted records</p>
                </div>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <!-- Tab Buttons -->
                <div class="d-flex gap-2 mb-4">
                    <button class="btn btn-primary" id="btnActivity" onclick="showTab('activity')">
                        Activity Log
                    </button>
                    <button class="btn btn-outline-secondary" id="btnDeletes" onclick="showTab('deletes')">
                        Deletes
                    </button>
                </div>

                {{-- Activity Log Tab --}}
                <div id="tabActivity">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Done by</th>
                                    <th>Action</th>
                                    <th>Model</th>
                                    <th>Description</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($activities as $index => $activity)
                                    <tr>
                                        <td>{{ $activities->firstItem() + $index }}</td>
                                        <td>{{ $activity->causer?->name ?? 'System' }}</td>
                                        <td>
                                            <span class="badge 
                                                @if($activity->event === 'created') bg-success
                                                @elseif($activity->event === 'updated') bg-warning text-dark
                                                @elseif($activity->event === 'deleted') bg-danger
                                                @else bg-secondary
                                                @endif">
                                                {{ $activity->event ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td>{{ class_basename($activity->subject_type ?? 'N/A') }}</td>
                                        <td>{{ $activity->description }}</td>
                                        <td>{{ $activity->created_at->format('M d, Y h:i A') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-muted">No activity recorded yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination links --}}
                    <div class="mt-3">
                        {{ $activities->appends(['tab' => 'activity'])->links() }}
                    </div>
                </div>

                {{-- Deletes Tab --}}
                <div id="tabDeletes" style="display: none;">

                    {{-- Deleted Users --}}
                    <h5 class="mb-3">Deleted Users</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Deleted at</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($deletedUsers as $index => $user)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->deleted_at->format('M d, Y h:i A') }}</td>
                                        <td>
                                            <form action="{{ route('restore.user', $user->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button class="btn btn-sm btn-success">Restore</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-muted">No deleted users.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function showTab(tab) {
    document.getElementById('tabActivity').style.display = tab === 'activity' ? 'block' : 'none';
    document.getElementById('tabDeletes').style.display  = tab === 'deletes'  ? 'block' : 'none';
    document.getElementById('btnActivity').className = tab === 'activity' ? 'btn btn-primary' : 'btn btn-outline-secondary';
    document.getElementById('btnDeletes').className  = tab === 'deletes'  ? 'btn btn-primary' : 'btn btn-outline-secondary';
}

const urlParams = new URLSearchParams(window.location.search);
const activeTab = urlParams.get('tab') || 'activity';
showTab(activeTab);
</script>
</body>
</html>