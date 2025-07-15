<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Group;
use App\Models\Course;
use App\Models\Role;
use App\Models\Student;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index()
    {
        // Get teachers with their courses and basic stats
        $teacherRole = Role::where('is_teacher', true)->first();
        $teachers = User::where('role_id', $teacherRole->id)
            ->where('is_deleted', false)
            ->with(['teachingCourses', 'teachingCourses.group'])
            ->take(5)
            ->get();

        $stats = [
            'total_teachers' => User::where('role_id', $teacherRole->id)
                                  ->where('is_deleted', false)
                                  ->count(),
            'total_students' => Student::where('is_deleted', false)->count(),
            'total_groups' => Group::where('is_deleted', false)->count(),
            'total_courses' => Course::where('is_deleted', false)->count(),
        ];

        $recentFeedbacks = \App\Models\Feedback::with(['student', 'course', 'course.teacher', 'course.group'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact('stats', 'teachers', 'recentFeedbacks'));
    }
}