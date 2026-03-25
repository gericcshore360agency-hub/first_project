<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Students</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/styles/dashboard.css') }}">
</head>
<body>

<div class="container-fluid">
    <div class="row">

        @include('profile.sidebar')

        <div class="col-md-10 main-content">
            <div class="card shadow-lg card-custom p-4">

                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h2 class="mb-1">Students</h2>
                        <p class="text-muted mb-0">Manage your student list</p>
                    </div>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStudentModal">
                        Add Student
                    </button>
                </div>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <!-- Students Table -->
                <div class="table-responsive">
                    <table class="table table-bordered align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Student Number</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Added by</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($students as $index => $student)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $student->student_number }}</td>
                                    <td>{{ $student->first_name }}</td>
                                    <td>{{ $student->last_name }}</td>
                                    <td>{{ $student->teacher->name ?? '—' }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-warning"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editStudentModal{{ $student->id }}">
                                            Edit
                                        </button>

                                        <button class="btn btn-sm btn-danger"
                                            onclick="if(confirm('Are you sure you want to delete this student?')) document.getElementById('deleteStudentForm{{ $student->id }}').submit()">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-muted">No students found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>
</div>

{{-- Delete Forms — outside the table --}}
@foreach($students as $student)
    <form id="deleteStudentForm{{ $student->id }}"
          action="{{ route("delete_student", $student->id) }}"
          method="POST"
          class="d-none">
        @csrf
        @method('DELETE')
    </form>
@endforeach

{{-- Edit Student Modals --}}
@foreach($students as $student)
<div class="modal fade" id="editStudentModal{{ $student->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('update_student', $student->id) }}" method="POST">

                @csrf

                @method('PUT')
                
                <div class="modal-header">
                    <h5 class="modal-title">Edit Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">First name</label>
                            <input type="text" name="first_name" class="form-control"
                                value="{{ $student->first_name }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Last name</label>
                            <input type="text" name="last_name" class="form-control"
                                value="{{ $student->last_name }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Student number</label>
                        <input type="text" name="student_number" class="form-control"
                            value="{{ $student->student_number }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

{{-- Add Student Modal --}}
<div class="modal fade" id="addStudentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('add_student') }}" method="POST">

                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Add Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">First name</label>
                            <input type="text" name="first_name" class="form-control" placeholder="Juan">
                            @error('first_name')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Last name</label>
                            <input type="text" name="last_name" class="form-control" placeholder="Dela Cruz">
                            @error('last_name')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Student number</label>
                        <input type="text" name="student_number" class="form-control" placeholder="2021-0001">
                        @error('student_number')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Student</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    @if($errors->any())
        var addModal = new bootstrap.Modal(document.getElementById('addStudentModal'));
        addModal.show();
    @endif
</script>
</body>
</html>