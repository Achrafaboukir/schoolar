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
    // Display a listing of the teachers
    public function index()
    {
        $teacherRole = Role::where('is_teacher', true)->first();
        $teachers = User::where('role_id', $teacherRole->id)
                       ->where('is_deleted', false)
                       ->paginate(10);
        $groups = Group::where('is_deleted', false)->get();
        return view('teachers.index', compact('teachers', 'groups'));
    }

    // Show the form for creating a new teacher
    public function create()
    {
        $groups = Group::where('is_deleted', false)->get();
        return view('teachers.create', compact('groups'));
    }

    // AJAX method to return create form for modal
    public function createForm()
    {
        $groups = Group::where('is_deleted', false)->get();
        return view('teachers.create-ajax', compact('groups'));
    }

    // Store a newly created teacher in storage
    public function store(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'number' => 'required|string|unique:users,number',
            'group_id' => 'required|exists:groups,id',
            'date_of_birth' => 'required|date',
            'photo' => 'nullable|image|max:2048',
            'cv' => 'nullable|file|max:5120',
            'status' => 'boolean'
        ]);

        $teacherRole = Role::where('is_teacher', true)->first();
        
        $data = $request->all();
        $data['role_id'] = $teacherRole->id;
        $data['password'] = Hash::make(Str::random(10));

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('teachers/photos', 'public');
        }

        if ($request->hasFile('cv')) {
            $data['cv'] = $request->file('cv')->store('teachers/documents', 'public');
        }

        User::create($data);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Teacher created successfully.']);
        }

        return redirect()->route('teachers.index')->with('success', 'Teacher created successfully.');
    }

    // Display the specified teacher
    public function show(Teacher $teacher)
    {
        return view('teachers.show', compact('teacher'));
    }

    // Show the form for editing the specified teacher
    public function edit($id)
    {
        $teacher = User::findOrFail($id);
        $groups = Group::where('is_deleted', false)->get();
        return view('teachers.edit', compact('teacher', 'groups'));
    }

    // AJAX method to return edit form for modal
    public function editForm($id)
    {
        $teacher = User::findOrFail($id);
        $groups = Group::where('is_deleted', false)->get();
        return view('teachers.edit-ajax', compact('teacher', 'groups'));
    }

    // Update the specified teacher in storage
    public function update(Request $request, $id)
    {
        $teacher = User::findOrFail($id);
        
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $teacher->id,
            'number' => 'required|string|unique:users,number,' . $teacher->id,
            'group_id' => 'required|exists:groups,id',
            'date_of_birth' => 'required|date',
            'photo' => 'nullable|image|max:2048',
            'cv' => 'nullable|file|max:5120',
            'status' => 'boolean'
        ]);

        $data = $request->all();

        if ($request->hasFile('photo')) {
            if ($teacher->photo) {
                Storage::disk('public')->delete($teacher->photo);
            }
            $data['photo'] = $request->file('photo')->store('teachers/photos', 'public');
        }

        if ($request->hasFile('cv')) {
            if ($teacher->cv) {
                Storage::disk('public')->delete($teacher->cv);
            }
            $data['cv'] = $request->file('cv')->store('teachers/documents', 'public');
        }

        $teacher->update($data);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Teacher updated successfully.']);
        }

        return redirect()->route('teachers.index')->with('success', 'Teacher updated successfully.');
    }

    // Remove the specified teacher from storage
    public function destroy($id)
    {
        $teacher = User::findOrFail($id);
        $teacher->update(['is_deleted' => true]);
        return redirect()->route('teachers.index')->with('success', 'Teacher deleted successfully.');
    }
}
