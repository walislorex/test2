<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with(['class'])
            ->orderBy('created_at', $request->input('sort', 'desc'))
            ->limit($request->input('limit', 10));

        $users = $query->get()->map(function ($user) {
            return [
                'UserID' => $user->UserID,
                'Name' => $user->Name,
                'Email' => $user->Email,
                'Role' => $user->Role,
                'ClassID' => $user->ClassID,
                'class' => $user->class ? ['Name' => $user->class->Name] : null,
                'created_at' => $user->created_at
            ];
        });

        return response()->json([
            'data' => $users,
            'total' => User::count()
        ]);
    }
public function user(Request $request)
    {
        $query = User::query()
            ->with(['class:ClassID,Name'])
            ->select('UserID', 'Name', 'Email', 'Role', 'ClassID')
            ->orderBy('Name');

        if ($request->has('role') && $request->role !== 'all') {
            $query->where('Role', $request->role);
        }

        return response()->json(
            $query->get()->map(function ($user) {
                return [
                    'UserID' => $user->UserID,
                    'Name' => $user->Name,
                    'Email' => $user->Email,
                    'Role' => $user->Role,
                    'ClassID' => $user->ClassID,
                    'ClassName' => $user->class->Name ?? null
                ];
            })
        );
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,Email',
        'role' => ['required', Rule::in(['student', 'teacher', 'admin'])],
        'class_id' => 'nullable|exists:classes,ClassID',
        'password' => 'required|string|min:8'
    ]);

    $user = User::create([
        'Name' => $validated['name'],
        'Email' => $validated['email'],
        'Role' => $validated['role'],
        'ClassID' => $validated['class_id'],
        'password' => Hash::make($validated['password']),
    ]);

    // Load class relationship
    $user->load('class');

    return response()->json([
        'UserID' => $user->UserID,
        'Name' => $user->Name,
        'Email' => $user->Email,
        'Role' => $user->Role,
        'ClassID' => $user->ClassID,
        'ClassName' => $user->class?->Name // Add class name to response
    ], 201);
}

    public function destroy(User $user)
    {
        $user->delete();
        return response()->noContent();
    }
}
