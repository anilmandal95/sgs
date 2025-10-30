<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\DashboardController;

// Public routes - no token needed
Route::post('sgs/register', [AuthController::class, 'register']);
Route::post('sgs/login', [AuthController::class, 'login']);

// Protected routes - token required
Route::middleware('auth:sanctum')->group(function () {
    // Get current user profile info
    Route::get('sgs/user', function (Request $request) {
        $user = $request->user();
        return response()->json([
            'status' => true,
            'status_code' => 200,
            'message' => 'User profile fetched successfully',
            'data' => [
                'id' => $user->id,
                'fullname' => $user->fullname,
                'email' => $user->email,
                'mobile' => $user->mobile,
                'user_type' => $user->user_type,
                'user_category' => $user->user_category,
                // Add other user fields as needed, but no sensitive data!
            ],
        ]);
    });

    // Dashboard route
    Route::get('sgs/dashboard', [DashboardController::class, 'index']);

    // Logout route
    Route::post('sgs/logout', [AuthController::class, 'logout']);
});
