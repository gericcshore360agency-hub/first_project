<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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

                // Prevent duplicate entry for same name + date
                $already = Attendance::where('first_name', $data['first_name'])
                                    ->where('last_name',  $data['last_name'])
                                    ->where('date',        $data['date'])
                                    ->exists();

                if ($already) {
                    return back()->with('error', 'You have already logged attendance for today.');
                }

                Attendance::create($data);

                return view('success');
    }

    public function show($date)
    {
        $records = Attendance::whereDate('date', $date)->get();

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