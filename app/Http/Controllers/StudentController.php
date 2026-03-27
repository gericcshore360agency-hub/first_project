<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
public function view_students()
    {
        $students = Student::where('user_id', auth()->user()->id)->get();

        return view("student_management.view_students", compact("students"));
    }

public function store_students(Request $request)
    {   
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'student_number' => 'required|unique:students,student_number',
        ]);

        
        Student::create([
            'first_name'=> $request->first_name,
            'last_name'=> $request->last_name,
            'student_number' => $request->student_number,
            'user_id' => auth()->user()->id
        ]);

        return redirect()->route('view_students')->with('success', 'Student added successfully.');
    }

public function edit_student(Request $request, $id){

        $student = Student::where('user_id', auth()->id())->findOrFail($id);

        $request->validate([
            'first_name'     => 'required|string|max:255',
            'last_name'      => 'required|string|max:255',
            'student_number' => 'required|string|unique:students,student_number,' . $id,
        ]);

        $student->update([
            'first_name'=> $request->first_name,
            'last_name'=> $request->last_name,
            'student_number' => $request->student_number,
        ]);

        return redirect()->route('view_students')->with('success','Editing Success');
    }

public function delete_student(Request $request, $id){

            $student = Student::where('user_id', auth()->id())->findOrFail($id);

            $student->delete();

            return redirect()->route('view_students')->with('success','Student Deleted');
    }
}