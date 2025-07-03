<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;

class StudentAuthController extends Controller
{
    /**
     * Show the student login form.
     */
    public function showLoginForm()
    {
        return view('student.auth.login');
    }

    /**
     * Handle student login.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $student = Student::where('email', $request->email)->first();

        if (!$student || !Hash::check($request->password, $student->password)) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->withInput($request->only('email'));
        }

        if (!$student->status) {
            return back()->withErrors([
                'email' => 'Your account is inactive. Please contact administrator.',
            ])->withInput($request->only('email'));
        }

        // Store student in session
        session(['student_id' => $student->id]);
        session(['student_name' => $student->full_name]);

        return redirect()->intended(route('student.dashboard'));
    }

    /**
     * Handle student logout.
     */
    public function logout(Request $request)
    {
        $request->session()->forget(['student_id', 'student_name']);
        return redirect()->route('student.login');
    }

    /**
     * Show student dashboard.
     */
    public function dashboard()
    {
        // Simple session check
        if (!session('student_id')) {
            return redirect()->route('student.login');
        }

        $student = Student::with(['group.courses.documents', 'feedback'])->find(session('student_id'));
        
        if (!$student) {
            session()->forget(['student_id', 'student_name']);
            return redirect()->route('student.login');
        }

        $courses = $student->group->courses ?? collect();
        
        return view('student.dashboard', compact('student', 'courses'));
    }

    /**
     * Show student courses.
     */
    public function courses()
    {
        // Simple session check
        if (!session('student_id')) {
            return redirect()->route('student.login');
        }

        $student = Student::with(['group.courses.documents'])->find(session('student_id'));
        
        if (!$student) {
            session()->forget(['student_id', 'student_name']);
            return redirect()->route('student.login');
        }

        $courses = $student->group->courses ?? collect();
        
        return view('student.courses', compact('student', 'courses'));
    }

    /**
     * Show course details with documents.
     */
    public function courseDetails($courseId)
    {
        // Simple session check
        if (!session('student_id')) {
            return redirect()->route('student.login');
        }

        $student = Student::with(['group.courses.documents'])->find(session('student_id'));
        
        if (!$student) {
            session()->forget(['student_id', 'student_name']);
            return redirect()->route('student.login');
        }

        $course = $student->group->courses->where('id', $courseId)->first();
        
        if (!$course) {
            return redirect()->route('student.courses')->with('error', 'Course not found.');
        }

        return view('student.course-details', compact('student', 'course'));
    }

    /**
     * Show feedback form.
     */
    public function showFeedbackForm($courseId)
    {
        // Simple session check
        if (!session('student_id')) {
            return redirect()->route('student.login');
        }

        $student = Student::with(['group.courses'])->find(session('student_id'));
        
        if (!$student) {
            session()->forget(['student_id', 'student_name']);
            return redirect()->route('student.login');
        }

        $course = $student->group->courses->where('id', $courseId)->first();
        
        if (!$course) {
            return redirect()->route('student.courses')->with('error', 'Course not found.');
        }

        return view('student.feedback-form', compact('student', 'course'));
    }

    /**
     * Submit feedback.
     */
    public function submitFeedback(Request $request, $courseId)
    {
        // Simple session check
        if (!session('student_id')) {
            return redirect()->route('student.login');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'rating' => 'required|integer|between:1,5',
            'is_anonymous' => 'boolean'
        ]);

        $student = Student::with(['group.courses'])->find(session('student_id'));
        
        if (!$student) {
            session()->forget(['student_id', 'student_name']);
            return redirect()->route('student.login');
        }

        $course = $student->group->courses->where('id', $courseId)->first();
        
        if (!$course) {
            return redirect()->route('student.courses')->with('error', 'Course not found.');
        }

        // Check if student already submitted feedback for this course
        $existingFeedback = \App\Models\Feedback::where('student_id', session('student_id'))
            ->where('course_id', $courseId)
            ->first();

        if ($existingFeedback) {
            return redirect()->route('student.course.details', $courseId)
                ->with('error', 'You have already submitted feedback for this course.');
        }

        \App\Models\Feedback::create([
            'student_id' => session('student_id'),
            'course_id' => $courseId,
            'title' => $request->title,
            'content' => $request->content,
            'rating' => $request->rating,
            'is_anonymous' => $request->has('is_anonymous')
        ]);

        return redirect()->route('student.course.details', $courseId)
            ->with('success', 'Feedback submitted successfully!');
    }

    /**
     * Show student profile.
     */
    public function profile()
    {
        // Simple session check
        if (!session('student_id')) {
            return redirect()->route('student.login');
        }

        $student = Student::with(['group', 'feedback.course'])->find(session('student_id'));
        
        if (!$student) {
            session()->forget(['student_id', 'student_name']);
            return redirect()->route('student.login');
        }

        return view('student.profile', compact('student'));
    }
}
