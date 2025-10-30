<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\User;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->user_category === 'student') {
            $dashboardData = [
                'welcome_message' => "Welcome back, {$user->fullname}!",
                'enrolled_courses' => $user->courses()->select('id', 'title', 'description')->get(),
                'notifications' => [], // add notification logic later
            ];
        } elseif ($user->user_category === 'instructor') {
            $dashboardData = [
                'welcome_message' => "Welcome Instructor, {$user->fullname}!",
                'my_courses' => $user->instructedCourses()->select('id', 'title')->get(),
            ];
        } else {
            // Admin or others
            $dashboardData = [
                'welcome_message' => "Welcome Admin, {$user->fullname}!",
                'total_users' => User::count(),
                'total_courses' => Course::count(),
            ];
        }

        return response()->json([
            'status' => true,
            'status_code' => 200,
            'message' => 'Dashboard data fetched successfully',
            'data' => $dashboardData,
        ]);
    }
}
