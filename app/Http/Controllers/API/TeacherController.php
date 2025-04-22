<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
//     public function index()
// {
//     $teachers = User::where('Role', 'teacher')
//         ->select('UserID', 'Name') // Changed from 'id' to 'UserID'
//         ->orderBy('Name')
//         ->get();

//     return response()->json($teachers);
// }

// TeacherController.php
public function index()
{
    $teachers = User::where('Role', 'teacher')
        ->get(['UserID', 'Name']);
    
    return response()->json($teachers);
}

// public function stats(Request $request)
// {
//     $teacher = $request->user();
    
//     return response()->json([
//         'totalStudents' => $teacher->students()->count(),
//         'activeAssignments' => $teacher->assignments()->active()->count(),
//         'upcomingExams' => $teacher->exams()->upcoming()->count(),
//         'todaysClasses' => $teacher->classes()->today()->count(),
//         'teacherName' => $teacher->name
//     ]);
// }

// public function classes(Request $request)
// {
//     return $request->user()->classes()->withCount(['students', 'assignments', 'exams'])->get();
// }

// public function assignments(Request $request)
// {
//     return $request->user()->assignments()
//         ->with('class')
//         ->orderBy('due_date', 'desc')
//         ->limit(5)
//         ->get();
// }


// app/Http/Controllers/API/TeacherController.php
public function stats(Request $request)
{
    $teacher = $request->user();
    
    return response()->json([
        'totalStudents' => $teacher->students()->count(),
        'teacherName' => $teacher->Name
    ]);
}

public function classes(Request $request)
{
    return $request->user()->classes()
        ->withCount(['students'])
        ->get()
        ->map(function ($class) {
            return [
                'ClassID' => $class->ClassID,
                'Name' => $class->Name,
                'student_count' => $class->students_count
            ];
        });
}
public function schedule(Request $request)
{
    return $request->user()->classes()
        ->whereDate('schedule', today())
        ->orderBy('start_time')
        ->get();
}
}