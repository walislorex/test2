<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\User;
use App\Models\Assignment;
use App\Models\ClassModel;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    
    public function stats()
{
    return response()->json([
        'totalStudents' => User::where('Role', 'student')->count(),
        'totalTeachers' => User::where('Role', 'teacher')->count(),
        'totalClasses' => ClassModel::count(),
        'activeAssignments' => Assignment::where('DueDate', '>', now())->count(),
        'upcomingExams' => Exam::where('Date', '>', now())->count(),
    ]);
}
}
