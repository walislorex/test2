<?php

namespace App\Http\Controllers;

// app/Http/Controllers/AuthController.php

// app/Http/Controllers/AuthController.php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller {



    // Add this new method for admin login
    public function adminLogin(Request $request)
    {
        try {
            $request->validate([
                'Email' => 'required|email',
                'password' => 'required'
            ]);
    
            $user = User::where('Email', $request->Email)->first();
    
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json(['error' => 'Invalid credentials'], 401);
            }
    
            if ($user->Role !== 'admin') {
                return response()->json(['error' => 'Admin access required'], 403);
            }
    
            // Revoke existing tokens
            $user->tokens()->delete();
            
            $token = $user->createToken('admin-token')->plainTextToken;
    
            return response()->json([
                'user' => [
                    'id' => $user->id,
                    'name' => $user->Name,
                    'email' => $user->Email,
                    'role' => $user->Role
                ],
                'token' => $token
            ]);
    
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Login failed: ' . $e->getMessage()
            ], 500);
        }
    }
// teacher login
    public function teacherLogin(Request $request)
{
    $request->validate([
        'Email' => 'required|email',
        'password' => 'required'
    ]);

    $user = User::where('Email', $request->Email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['error' => 'Invalid credentials'], 401);
    }

    if ($user->Role !== 'teacher') {
        return response()->json(['error' => 'Teacher access required'], 403);
    }

    // Revoke existing tokens
    $user->tokens()->delete();
    
    $token = $user->createToken('teacher-token')->plainTextToken;

    return response()->json([
        'user' => [
            'id' => $user->UserID,
            'name' => $user->Name,
            'email' => $user->Email
        ],
        'token' => $token
    ]);
}
    // Inscription
    public function register(Request $request) {
        $request->validate([
            'Name' => 'required|string',       // Majuscule
            'Email' => 'required|email|unique:users', // Majuscule
            'password' => 'required|min:8',
            'Role' => 'required|in:student,teacher,admin', // Majuscule
        ]);
    
        $user = User::create([
            'Name' => $request->Name,          // Majuscule
            'Email' => $request->Email,        // Majuscule
            'password' => Hash::make($request->password),
            'Role' => $request->Role,          // Majuscule
        ]);

        return response()->json([
            'user' => $user,
            'token' => $user->createToken('auth_token')->plainTextToken,
        ], 201);
    }

    // Connexion
    public function login(Request $request) {
        $request->validate([
            'Email' => 'required|email',   // Clé "Email" en majuscules
            'password' => 'required',
        ]);
    
        $credentials = $request->only('Email', 'password');
    
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'user' => $user,
                'token' => $token,
            ]);
        }
    
        return response()->json(['error' => 'Identifiants invalides'], 401);
    }

    public function user(Request $request) {
        return response()->json($request->user());
    }

    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Déconnexion réussie']);
    }
}