<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ClassController extends Controller
{
    // Get all classes
    // public function index()
    // {
    //     $classes = ClassModel::with(['teacher:UserID,Name', 'students'])
    //         ->get()
    //         ->map(function ($class) {
    //             return [
    //                 'ClassID' => $class->ClassID,
    //                 'Name' => $class->Name,
    //                 'TeacherID' => $class->TeacherID,
    //                 'TeacherName' => $class->teacher->Name,
    //                 'StudentCount' => $class->students->count(),
    //                 'Subjects' => $class->Subjects,
    //             ];
    //         });

    //     return response()->json($classes);
    // }


    // ClassController.php
public function index()
{
    $classes = ClassModel::with(['teacher', 'students'])
        ->get()
        ->map(function ($class) {
            return [
                'ClassID' => $class->ClassID,
                'Name' => $class->Name,
                'TeacherID' => $class->TeacherID,
                'TeacherName' => $class->teacher->Name ?? 'Unknown',
                'StudentCount' => $class->students->count(),
                'Subjects' => $class->Subjects,
            ];
        });

    return response()->json($classes);
}
    // Create a new class
    public function store(Request $request)
{
    try {
        // Validate the request
        $validated = $request->validate([
            'Name' => 'required|string|max:255',
            'TeacherID' => 'required|exists:users,UserID',
            'Subjects' => 'required|array|min:1',
            'Subjects.*' => 'string|max:255',
        ]);

        // Create the class
        $class = ClassModel::create([
            'Name' => $validated['Name'],
            'TeacherID' => $validated['TeacherID'],
            'Subjects' => $validated['Subjects'],
        ]);

        // Load the teacher relationship
        $class->load('teacher');

        return response()->json([
            'ClassID' => $class->ClassID,
            'Name' => $class->Name,
            'TeacherID' => $class->TeacherID,
            'TeacherName' => $class->teacher->Name,
            'StudentCount' => 0, // Default to 0 students
            'Subjects' => $class->Subjects,
        ], 201);

    } catch (\Illuminate\Validation\ValidationException $e) {
        // Handle validation errors
        return response()->json([
            'message' => 'Validation failed',
            'errors' => $e->errors(),
        ], 422);

    } catch (\Exception $e) {
        // Handle other errors
        return response()->json([
            'message' => 'Failed to create class',
            'error' => $e->getMessage(),
        ], 500);
    }
}
    // Delete a class
    public function destroy(ClassModel $class)
    {
        try {
            DB::beginTransaction();

            // Delete the class
            $class->delete();

            DB::commit();

            return response()->noContent();

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to delete class',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}