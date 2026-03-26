<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
public function index(){

    if(Auth::user()->hasRole("parent")){

        return view("parents.select_teacher");

} else{

    // Get last 3 days with attendance records (scoped to logged-in user)
        $uniqueDates = Attendance::distinct('date')
            ->whereHas('student', function($query) {
                $query->where('user_id', Auth::id());
            })
            ->orderBy('date', 'desc')
            ->limit(3)
            ->pluck('date')
            ->reverse();

        $recentDays = $uniqueDates->map(function ($date) {
            $day = \Carbon\Carbon::parse($date);
            $records = Attendance::whereDate('date', $date)->whereHas('student', 
                function($query){
                        $query->where('user_id', Auth::id());
            })->with('student')->get();
            return [
                'date'           => $day->format('Y-m-d'),
                'day_name'       => $day->format('l'),
                'formatted_date' => $day->format('M d, Y'),
                'count'          => $records->count(),
                'records'        => $records,
            ];
        });

        // Total unique days scoped to logged-in user
        $totalDays = Attendance::distinct('date')
            ->whereHas('student', function($query) {
                $query->where('user_id', Auth::id());
            })
            ->count('date');

        // Get students with their attendance counts
        $students = Student::where('user_id', Auth::id())
            ->withCount('attendances')
            ->get()
            ->map(function ($student) use ($totalDays) {
                $attendanceRate = $totalDays > 0
                    ? round(($student->attendances_count / $totalDays) * 100, 2)
                    : 0;

                return [
                    'id'              => $student->id,
                    'name'            => $student->first_name . ' ' . $student->last_name,
                    'student_number'  => $student->student_number,
                    'present'         => $student->attendances_count,
                    'total_days'      => $totalDays,
                    'attendance_rate' => $attendanceRate,
                    'status'          => $attendanceRate >= 80 ? 'Good' : 'At Risk',
                ];
            });

        return view('my_dashboard', compact('recentDays', 'students', 'totalDays'));
    }
  }

    public function load_teacher(Request $request)
    {
        $request->validate([
            'teacher_name' => 'required|string',
            'student_name' => 'required|string',
        ]);

        // Find teacher
        $selectedTeacher = User::where('name', $request->teacher_name)->first();

        if (!$selectedTeacher) {
            return back()
                ->withErrors(['teacher_name' => 'Teacher not found.'])
                ->withInput();
        }

        // Total class days for this teacher
        $totalDays = Attendance::distinct('date')
            ->whereHas('student', function ($query) use ($selectedTeacher) {
                $query->where('user_id', $selectedTeacher->id);
            })
            ->count('date');

        // Find student under this teacher
            $selectedStudent = Student::where('user_id', $selectedTeacher->id)
                ->where(function ($query) use ($request) {
                    $name = strtolower($request->student_name);
                    $query->whereRaw("LOWER(CONCAT(first_name, ' ', last_name)) like ?", ["%$name%"])
                        ->orWhereRaw('LOWER(first_name) like ?', ["%$name%"])
                        ->orWhereRaw('LOWER(last_name) like ?', ["%$name%"]);
                })
                ->withCount('attendances')
                ->first();

        if (!$selectedStudent) {
            return back()
                ->withErrors(['student_name' => 'Student not found under this teacher.'])
                ->withInput();
        }

        // Get student's attendance records
        $studentAttendance = Attendance::where('student_id', $selectedStudent->id)
            ->orderBy('date', 'desc')
            ->get();

        // Calculate attendance rate
        $attendanceRate = $totalDays > 0
            ? round(($selectedStudent->attendances_count / $totalDays) * 100, 2)
            : 0;

        return view('parents.dashboard', compact(
            'selectedTeacher',
            'selectedStudent',
            'studentAttendance',
            'attendanceRate',
            'totalDays'
        ));
    }





































    

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// In DashboardController
public function fetching_practice(Request $request)
{
    $request->validate([
        'query' => 'nullable|string',
        'search_term' => 'nullable|string',
        'start_date' => 'nullable|date',
        'end_date' => 'nullable|date',
        'custom_query' => 'nullable|string',
    ]);

    $results = collect();
    $queryCode = '';
    $count = 0;
    $error = null;

    $query = $request->query('query');
    $searchTerm = $request->input('search_term');
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');
    $customQuery = trim($request->input('custom_query', ''));

    if ($customQuery !== '') {
        $query = 'custom_query';
    }

    switch ($query) {

        case 'all_users':
            $queryCode = "User::all()";
            $results = User::all();
            break;

        case 'users_with_roles':
            $queryCode = "User::with('roles')->get()";
            $results = User::with('roles')->get();
            break;

        case 'teachers_only':
            $queryCode = "User::role('teacher')->get()";
            $results = User::role('teacher')->get();
            break;

        case 'parents_only':
            $queryCode = "User::role('parent')->get()";
            $results = User::role('parent')->get();
            break;

        case 'all_students':
            $queryCode = "Student::all()";
            $results = Student::all();
            break;

        case 'students_with_teacher':
            $queryCode = "Student::with('teacher')->get()";
            $results = Student::with('teacher')->get();
            break;

        case 'students_with_attendance':
            $queryCode = "Student::withCount('attendances')->get()";
            $results = Student::withCount('attendances')->get();
            break;

        case 'at_risk_students':
            $queryCode = "Student::withCount('attendances')->having('attendances_count', 0)->get()";
            $results = Student::withCount('attendances')->having('attendances_count', 0)->get();
            break;

        case 'student_search':
            $queryCode = "Student::where('first_name', 'like', '%{$searchTerm}%')->orWhere('last_name', 'like', '%{$searchTerm}%')->get()";
            $results = Student::where('first_name', 'like', "%{$searchTerm}%")
                ->orWhere('last_name', 'like', "%{$searchTerm}%")
                ->get();
            break;

        case 'teachers_with_student_count':
            $queryCode = "User::role('teacher')->withCount('students')->orderBy('students_count', 'desc')->get()";
            $results = User::role('teacher')->withCount('students')->orderBy('students_count', 'desc')->get();
            break;

        case 'attendance_between':
            if (!$startDate || !$endDate) {
                $error = 'Please provide both start and end date for attendance_between.';
                break;
            }
            $queryCode = "Attendance::whereBetween('date', ['{$startDate}', '{$endDate}'])->with('student')->get()";
            $results = Attendance::whereBetween('date', [$startDate, $endDate])->with('student')->get();
            break;

        case 'latest_10_students':
            $queryCode = "Student::latest()->limit(10)->get()";
            $results = Student::latest()->limit(10)->get();
            break;

        case 'top_students_by_attendance':
            $queryCode = "Student::withCount('attendances')->orderBy('attendances_count', 'desc')->limit(10)->get()";
            $results = Student::withCount('attendances')->orderBy('attendances_count', 'desc')->limit(10)->get();
            break;

        case 'all_attendance':
            $queryCode = "Attendance::with('student')->latest()->get()";
            $results = Attendance::with('student')->latest()->get();
            break;

        case 'attendance_today':
            $queryCode = "Attendance::whereDate('date', today())->with('student')->get()";
            $results = Attendance::whereDate('date', today())->with('student')->get();
            break;

        case 'attendance_per_day':
            $queryCode = "Attendance::selectRaw('date, COUNT(*) as total')->groupBy('date')->orderBy('date', 'desc')->get()";
            $results = Attendance::selectRaw('date, COUNT(*) as total')->groupBy('date')->orderBy('date', 'desc')->get();
            break;

        case 'recent_3_days':
            $queryCode = "Attendance::distinct('date')->orderBy('date', 'desc')->limit(3)->get()";
            $results = Attendance::distinct('date')->orderBy('date', 'desc')->limit(3)->get();
            break;

        case 'custom_query':
            switch (strtolower($customQuery)) {
                case 'latest_10_students':
                    $queryCode = "Student::latest()->limit(10)->get()";
                    $results = Student::latest()->limit(10)->get();
                    break;

                case 'top_students_by_attendance':
                    $queryCode = "Student::withCount('attendances')->orderBy('attendances_count', 'desc')->limit(10)->get()";
                    $results = Student::withCount('attendances')->orderBy('attendances_count', 'desc')->limit(10)->get();
                    break;

                case 'average_attendance_per_student':
                    $queryCode = "Student::withCount('attendances')->get()->map(fn($s)=>['id'=>$s->id,'name'=>$s->first_name.' '.$s->last_name,'avg'=>($s->attendances_count)] )";
                    $results = Student::withCount('attendances')->get();
                    break;

                default:
                    $error = "Unknown custom query key: {$customQuery}. Try latest_10_students, top_students_by_attendance, or average_attendance_per_student.";
                    break;
            }
            break;

        default:
            if ($query !== null) {
                $error = 'The selected query is not available. Please choose a valid query option.';
            }
            break;
    }

    $count = $results instanceof \Illuminate\Support\Collection ? $results->count() : (is_array($results) ? count($results) : 0);

    return view('practice', compact('results', 'queryCode', 'count', 'error', 'searchTerm', 'startDate', 'endDate', 'customQuery'));
}

}