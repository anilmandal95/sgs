<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Validate incoming request
        $validatedData = $request->validate([
            'fullname' => 'required|string|max:255',
            'mobile' => 'required|string|max:20|unique:users,mobile',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()->symbols()],
            // optional fields (if you want to allow overrides)
            'user_type' => 'sometimes|integer',
            'user_category' => 'sometimes|string|max:25',
            'auth_level' => 'sometimes|integer',
            'access_level' => 'sometimes|integer',
            'status' => 'sometimes|integer',
        ]);

        // Create user
        $user = User::create([
            'fullname' => $validatedData['fullname'],
            'mobile' => $validatedData['mobile'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'user_type' => $validatedData['user_type'] ?? 7,
            'user_category' => $validatedData['user_category'] ?? 'student',
            'auth_level' => $validatedData['auth_level'] ?? 101,
            'access_level' => $validatedData['access_level'] ?? 201,
            'status' => $validatedData['status'] ?? 1,
        ]);

        // Create token for API
        $token = $user->createToken('api_token')->plainTextToken;

        // Return user data + token
        return response()->json([
            'status' => "User created successfully",
            'status_code' => 201,
            'data' => $user->only('id', 'fullname', 'email', 'mobile', 'user_type', 'user_category', 'auth_level', 'access_level', 'status'),
            'token' => $token,
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required', // email or mobile
            'password' => 'required',
        ]);

        // Find user by email or mobile
        $user = User::where('email', $request->login)
                    ->orWhere('mobile', $request->login)
                    ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => false,
                'status_code' => 401,
                'message' => 'Invalid credentials',
                'data' => []
            ], 401);  // 401 Unauthorized
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => true,
            'status_code' => 200,
            'message' => 'Login successful',
            'data' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',       
        ], 200);  // 200 OK
    }
    public function logout(Request $request)
    {
        // Revoke the token that was used to authenticate the current request
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => true,
            'status_code' => 200,
            'message' => 'Logged out successfully',
        ]);
    }














}
