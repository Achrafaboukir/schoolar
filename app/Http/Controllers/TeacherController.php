<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Group;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{
    /**
     * Display a listing of teachers.
     */
    public function index()
    {
        $teacherRole = Role::where('is_teacher', true)->first();
        $teachers = User::where('role_id', $teacherRole->id)->paginate(10);
        return view('teachers.index', compact('teachers'));
    }

    /**
     * Store a new teacher.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'number' => 'required|string|max:20',
            'department' => 'required|string|max:100',
            'status' => 'required|in:active,inactive',
            'date_of_birth' => 'required|date',
            'picture' => 'nullable|image|max:2048',
            'cv' => 'nullable|file|max:5120'
        ]);

        // Handle file uploads
        if ($request->hasFile('picture')) {
            $picture = $request->file('picture');
            $pictureName = time() . '_' . Str::slug($validated['firstname']) . '.' . $picture->getClientOriginalExtension();
            $picture->move(public_path('uploads/teachers/pictures'), $pictureName);
            $validated['photo'] = 'uploads/teachers/pictures/' . $pictureName;
        }

        if ($request->hasFile('cv')) {
            $cv = $request->file('cv');
            $cvName = time() . '_' . Str::slug($validated['firstname']) . '.' . $cv->getClientOriginalExtension();
            $cv->move(public_path('uploads/teachers/documents'), $cvName);
            $validated['cv'] = 'uploads/teachers/documents/' . $cvName;
        }

        // Get teacher role
        $teacherRole = Role::where('is_teacher', true)->first();

        // Map the form fields to database fields
        $teacherData = [
            'role_id' => $teacherRole->id,
            'firstname' => $validated['firstname'],
            'lastname' => $validated['lastname'],
            'email' => $validated['email'],
            'number' => $validated['number'],
            'department' => $validated['department'],
            'status' => strtoupper($validated['status']),
            'date_of_birth' => $validated['date_of_birth'],
            'password' => Hash::make(Str::random(10)), // Generate a random password
            'photo' => $validated['photo'] ?? null,
            'cv' => $validated['cv'] ?? null
        ];

        User::create($teacherData);

        return redirect()->route('teachers.index')
            ->with('success', 'Teacher created successfully.');
    }

    /**
     * Update the specified teacher.
     */
    public function update(Request $request, User $teacher)
    {
        $validated = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $teacher->id,
            'number' => 'required|string|max:20',
            'department' => 'required|string|max:100',
            'status' => 'required|in:active,inactive',
            'date_of_birth' => 'required|date',
            'picture' => 'nullable|image|max:2048',
            'cv' => 'nullable|file|max:5120'
        ]);

        // Handle file uploads
        if ($request->hasFile('picture')) {
            // Delete old picture if exists
            if ($teacher->photo && file_exists(public_path($teacher->photo))) {
                unlink(public_path($teacher->photo));
            }
            
            $picture = $request->file('picture');
            $pictureName = time() . '_' . Str::slug($validated['firstname']) . '.' . $picture->getClientOriginalExtension();
            $picture->move(public_path('uploads/teachers/pictures'), $pictureName);
            $validated['photo'] = 'uploads/teachers/pictures/' . $pictureName;
        }

        if ($request->hasFile('cv')) {
            // Delete old CV if exists
            if ($teacher->cv && file_exists(public_path($teacher->cv))) {
                unlink(public_path($teacher->cv));
            }
            
            $cv = $request->file('cv');
            $cvName = time() . '_' . Str::slug($validated['firstname']) . '.' . $cv->getClientOriginalExtension();
            $cv->move(public_path('uploads/teachers/documents'), $cvName);
            $validated['cv'] = 'uploads/teachers/documents/' . $cvName;
        }

        // Map the form fields to database fields
        $teacherData = [
            'firstname' => $validated['firstname'],
            'lastname' => $validated['lastname'],
            'email' => $validated['email'],
            'number' => $validated['number'],
            'department' => $validated['department'],
            'status' => strtoupper($validated['status']),
            'date_of_birth' => $validated['date_of_birth']
        ];

        // Only update files if new ones were uploaded
        if (isset($validated['photo'])) {
            $teacherData['photo'] = $validated['photo'];
        }
        if (isset($validated['cv'])) {
            $teacherData['cv'] = $validated['cv'];
        }

        $teacher->update($teacherData);

        return redirect()->route('teachers.index')
            ->with('success', 'Teacher updated successfully.');
    }

    /**
     * Remove the specified teacher.
     */
    public function destroy(User $teacher)
    {
        // Delete associated files if they exist
        if ($teacher->photo && file_exists(public_path($teacher->photo))) {
            unlink(public_path($teacher->photo));
        }
        if ($teacher->cv && file_exists(public_path($teacher->cv))) {
            unlink(public_path($teacher->cv));
        }

        $teacher->delete();

        return redirect()->route('teachers.index')
            ->with('success', 'Teacher deleted successfully.');
    }

    /**
     * Display teacher dashboard
     */
    public function dashboard()
    {
        // Temporarily using first teacher for testing
        $teacher = User::whereHas('role', function($query) {
            $query->where('is_teacher', true);
        })->first();

        $groups = Group::withCount('students')->get();
        $courses = Course::with('group')->get();
        
        return view('teachers.dashboard', compact('groups', 'courses'));
    }

    /**
     * Display teacher's courses
     */
    public function myCourses()
    {
        $courses = Course::with(['group', 'group.students'])->paginate(10);
        return view('teachers.courses.index', compact('courses'));
    }

    /**
     * Show form to create a new course
     */
    public function createCourse()
    {
        $groups = Group::all();
        return view('teachers.courses.create', compact('groups'));
    }

    /**
     * Store a new course
     */
    public function storeCourse(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'group_id' => 'required|exists:groups,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        // Temporarily using first teacher for testing
        $teacher = User::whereHas('role', function($query) {
            $query->where('is_teacher', true);
        })->first();

        $course = Course::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'teacher_id' => $teacher->id,
            'group_id' => $validated['group_id'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'status' => 'active'
        ]);

        return redirect()->route('teachers.courses.index')
                        ->with('success', 'Course created successfully');
    }

    /**
     * Show teacher's groups
     */
    public function myGroups()
    {
        $groups = Group::withCount('students')
                    ->with('courses')
                    ->paginate(10);

        return view('teachers.groups.index', compact('groups'));
    }

    /**
     * Show specific group details
     */
    public function showGroup(Group $group)
    {
        $group->load(['students', 'courses']);
        return view('teachers.groups.show', compact('group'));
    }

    /**
     * Show teacher's profile
     */
    public function profile()
    {
        // Temporarily using first teacher for testing
        $teacher = User::whereHas('role', function($query) {
            $query->where('is_teacher', true);
        })->first();

        return view('teachers.profile', compact('teacher'));
    }

    /**
     * Update teacher's profile
     */
    public function updateProfile(Request $request)
    {
        // Temporarily using first teacher for testing
        $teacher = User::whereHas('role', function($query) {
            $query->where('is_teacher', true);
        })->first();
        
        $validated = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $teacher->id,
            'number' => 'required|string|max:20',
            'date_of_birth' => 'required|date',
            'photo' => 'nullable|image|max:2048',
            'cv' => 'nullable|file|max:5120'
        ]);

        // Handle file uploads
        if ($request->hasFile('photo')) {
            if ($teacher->photo) {
                Storage::disk('public')->delete($teacher->photo);
            }
            
            $photo = $request->file('photo');
            $photoPath = $photo->store('users/photos', 'public');
            $validated['photo'] = $photoPath;
        }

        if ($request->hasFile('cv')) {
            if ($teacher->cv) {
                Storage::disk('public')->delete($teacher->cv);
            }
            
            $cv = $request->file('cv');
            $cvPath = $cv->store('users/documents', 'public');
            $validated['cv'] = $cvPath;
        }

        $teacher->update($validated);

        return redirect()->route('teachers.profile')
            ->with('success', 'Profile updated successfully.');
    }

    /**
     * Update teacher's password
     */
    public function updatePassword(Request $request)
    {
        // Temporarily using first teacher for testing
        $teacher = User::whereHas('role', function($query) {
            $query->where('is_teacher', true);
        })->first();

        $validated = $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $teacher->update([
            'password' => Hash::make($validated['password'])
        ]);

        return redirect()->route('teachers.profile')
            ->with('success', 'Password updated successfully.');
    }
} 