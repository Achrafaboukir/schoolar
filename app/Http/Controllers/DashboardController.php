<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Group;
use App\Models\Course;
use App\Models\Role;

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
            ->with(['teachingCourses', 'teachingCourses.group'])
            ->take(5)
            ->get();

        $stats = [
            'total_teachers' => User::whereHas('role', function($query) {
                $query->where('is_teacher', true);
            })->count(),
            'total_students' => User::whereHas('role', function($query) {
                $query->where('is_student', true);
            })->count(),
            'total_groups' => Group::count(),
            'total_courses' => Course::count(),
        ];

        return view('dashboard', compact('stats', 'teachers'));
    }
}