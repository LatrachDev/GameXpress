<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6'
            // 'role' => 'required|string|exists:roles,name',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        if (User::count() === 0)
        {
            $user->assignRole('super_admin');
        }

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password))
        {
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        }

        $token = $user->createToken($user->email)->plainTextToken; // plainTextToken -> extracts the raw token value
        return response()->json([
            'message' => 'User logged in successfully',
            'user' => $user,
            'token' => $token
        ]);
        
    }

    public function logout()
    {
        if (auth('sanctum') -> check())
        {
            auth('sanctum') -> user()-> tokens() -> delete();
            return response() -> json([
                "message" => "Logged out successfully"
            ]);
        }
    }
}
