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

public function load_teacher(Request $request){

    $selectedTeacher = User::where('name', $request->input('teacher_name'))->first();
   
    $totalDays = Attendance::distinct('date')
            ->whereHas('student', function ($query) use ($selectedTeacher) {
                 $query->where('user_id', $selectedTeacher->id);
            })
            ->count('date');

    // Get last 3 days with attendance records for the selected teacher
    $uniqueDates = Attendance::distinct('date')
        ->whereHas('student', function($query) use ($selectedTeacher) {
            $query->where('user_id', $selectedTeacher->id);
        })
        ->orderBy('date', 'desc')
        ->limit(3)
        ->pluck('date')
        ->reverse();

    $recentDays = $uniqueDates->map(function ($date) use ($selectedTeacher) {
        $day = \Carbon\Carbon::parse($date);
        $records = Attendance::whereDate('date', $date)->whereHas('student', 
        function($query) use ($selectedTeacher){
            $query->where('user_id', $selectedTeacher->id);
        })->with('student')->get();
        return [
            'date'           => $day->format('Y-m-d'),
            'day_name'       => $day->format('l'),
            'formatted_date' => $day->format('M d, Y'),
            'count'          => $records->count(),
            'records'        => $records,
        ];
    });

        $students = Student::where('user_id', $selectedTeacher->id)
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
                    'absences'        => $totalDays - $student->attendances_count,
                    'total_days'      => $totalDays,
                    'attendance_rate' => $attendanceRate,
                    'status'          => $attendanceRate >= 80 ? 'Good' : 'At Risk',
                ];
            });

return view('parents.dashboard', compact('selectedTeacher', 'students', 'totalDays', 'recentDays'));
}


}