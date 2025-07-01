<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Group;


class StudentController extends Controller
{
    /**
     * Display a listing of students.
     */
    public function index()
    {
        $query = Student::query();
        if (request()->has('search') && request('search')) {
            $search = request('search');
            $query->where(function($q) use ($search) {
                $q->where('firstname', 'like', "%$search%")
                  ->orWhere('lastname', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhere('student_number', 'like', "%$search%")
                ;
            });
        }
        $students = $query->paginate(10);
        $groups = Group::all();
        return view('students.index', compact('students', 'groups'));
    }

    /**
     * Show the form for creating a new student.
     */
    public function create()
    {
        $groups = Group::all();
        return view('students.create', compact('groups'));
    }

    /**
     * AJAX method to return create form for modal
     */
    public function createForm()
    {
        $groups = Group::all();
        return view('students.create-ajax', compact('groups'));
    }

    /**
     * Store a new student.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:students',
            'number' => 'required|string|max:20',
            'group' => 'required|string|max:50',
            'status' => 'required|integer|in:0,1', 
            'date_of_birth' => 'required|date',
            'picture' => 'nullable|image|max:2048',
            'baccaloriat' => 'nullable|file|max:2048'
        ]);

        // Handle file uploads
        if ($request->hasFile('picture')) {
            $picture = $request->file('picture');
            $pictureName = time() . '_' . Str::slug($validated['firstname']) . '.' . $picture->getClientOriginalExtension();
            $picture->move(public_path('uploads/students/pictures'), $pictureName);
            $validated['photo'] = 'uploads/students/pictures/' . $pictureName;
        }

        if ($request->hasFile('baccaloriat')) {
            $baccaloriat = $request->file('baccaloriat');
            $baccaloriatName = time() . '_' . Str::slug($validated['firstname']) . '.' . $baccaloriat->getClientOriginalExtension();
            $baccaloriat->move(public_path('uploads/students/documents'), $baccaloriatName);
            $validated['baccaloriat'] = 'uploads/students/documents/' . $baccaloriatName;
        }

        // Map the form fields to database fields
        $studentData = [
            'firstname' => $validated['firstname'],
            'lastname' => $validated['lastname'],
            'email' => $validated['email'],
            'student_number' => $validated['number'],
            'group_id' => $validated['group'],
            'status' => strtoupper($validated['status']),
            'date_of_birth' => $validated['date_of_birth'],
            'password' => Hash::make(Str::random(10)), // Generate a random password
            'photo' => $validated['photo'] ?? null
        ];

        Student::create($studentData);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Student created successfully.']);
        }

        return redirect()->route('students.index')
            ->with('success', 'Student created successfully.');
    }

    /**
     * Show the form for editing the specified student.
     */
    public function edit(Student $student)
    {
        $groups = Group::all();
        return view('students.edit', compact('student', 'groups'));
    }

    /**
     * AJAX method to return edit form for modal
     */
    public function editForm(Student $student)
    {
        $groups = Group::all();
        return view('students.edit-ajax', compact('student', 'groups'));
    }

    /**
     * Update the specified student.
     */
    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $student->id,
            'number' => 'required|string|max:20',
            'group' => 'required|string|max:50',
            'status' => 'required|in:active,inactive',
            'date_of_birth' => 'required|date',
            'picture' => 'nullable|image|max:2048',
            'baccaloriat' => 'nullable|file|max:2048'
        ]);

        // Handle file uploads
        if ($request->hasFile('picture')) {
            $picture = $request->file('picture');
            $pictureName = time() . '_' . Str::slug($validated['firstname']) . '.' . $picture->getClientOriginalExtension();
            $picture->move(public_path('uploads/students/pictures'), $pictureName);
            $validated['photo'] = 'uploads/students/pictures/' . $pictureName;
        }

        if ($request->hasFile('baccaloriat')) {
            $baccaloriat = $request->file('baccaloriat');
            $baccaloriatName = time() . '_' . Str::slug($validated['firstname']) . '.' . $baccaloriat->getClientOriginalExtension();
            $baccaloriat->move(public_path('uploads/students/documents'), $baccaloriatName);
            $validated['baccaloriat'] = 'uploads/students/documents/' . $baccaloriatName;
        }

        // Map the form fields to database fields
        $studentData = [
            'firstname' => $validated['firstname'],
            'lastname' => $validated['lastname'],
            'email' => $validated['email'],
            'student_number' => $validated['number'],
            'group_id' => $validated['group'],
            'status' => strtoupper($validated['status']),
            'date_of_birth' => $validated['date_of_birth']
        ];

        // Only update photo if a new one was uploaded
        if (isset($validated['photo'])) {
            $studentData['photo'] = $validated['photo'];
        }

        $student->update($studentData);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Student updated successfully.']);
        }

        return redirect()->route('students.index')
            ->with('success', 'Student updated successfully.');
    }

    /**
     * Remove the specified student.
     */
    public function destroy(Student $student)
    {
        // Delete associated files if they exist
        if ($student->photo && file_exists(public_path($student->photo))) {
            unlink(public_path($student->photo));
        }
        if ($student->baccaloriat && file_exists(public_path($student->baccaloriat))) {
            unlink(public_path($student->baccaloriat));
        }

        $student->delete();

        return redirect()->route('students.index')
            ->with('success', 'Student deleted successfully.');
    }
} 