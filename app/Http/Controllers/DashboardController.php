<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Group;
use App\Models\Course;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index()
    {
        // For testing purposes, we'll show some basic stats
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

        return view('dashboard', compact('stats'));
    }
}