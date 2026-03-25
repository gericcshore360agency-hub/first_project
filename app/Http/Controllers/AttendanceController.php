<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index()
    {

    }

    public function create()
    {

    }

public function store(Request $request)
{
    $data = $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name'  => 'required|string|max:255',
        'date'       => 'required|date',
    ]);

    $student = Student::whereRaw('LOWER(first_name) = ?', [strtolower($data['first_name'])])
                      ->whereRaw('LOWER(last_name) = ?', [strtolower($data['last_name'])])
                      ->first();

    if (!$student) {
        return back()
            ->withInput()
            ->with('error', 'Your name is not in the registered student list.');
    }

    $already = Attendance::where('student_id', $student->id)
                         ->where('date',       $data['date'])
                         ->exists();

    if ($already) {
        return back()->with('error', 'You have already logged attendance for today.');
    }

    Attendance::create([
        'first_name'=> $student->first_name,
        'last_name'=> $student->last_name,
        'student_id' => $student->id,
        'date'       => $data['date'],
    ]);

    return view('success');
}

public function show($date)
    {
        $records = Attendance::whereDate('date', $date)->whereHas('student', 
        function($query){
            $query->where('user_id', Auth::id());
        })->with('student')->get();

        $scanUrl = route('attendance.form', ['date' => $date]);

        $qrCode  = QrCode::size(250)->generate($scanUrl);

        return view('view_attendance', compact('date', 'records', 'qrCode','scanUrl'));
    }

public function attendance_form(Request $request)
    {
        $date = $request->query('date');

        return view('attendance_form', compact('date'));
    }

public function edit(Attendance $attendance)
    {

    }

public function update(Request $request, Attendance $attendance)
    {

    }

public function destroy(Attendance $attendance)
    {


    
    }
}