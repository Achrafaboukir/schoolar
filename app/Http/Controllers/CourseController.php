<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Role;

class CourseController extends Controller
{
    public function index()
    {
        $query = Course::with(['teacher', 'group'])->where('is_deleted', false);
        if (request()->has('search') && request('search')) {
            $search = request('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                  ->orWhereHas('teacher', function($t) use ($search) {
                      $t->where('firstname', 'like', "%$search%")
                        ->orWhere('lastname', 'like', "%$search%");
                  })
                  ->orWhereHas('group', function($g) use ($search) {
                      $g->where('name', 'like', "%$search%") ;
                  });
            });
        }
        $courses = $query->paginate(10);
        
        $teacherRole = Role::where('is_teacher', true)->first();
        $teachers = User::where('role_id', $teacherRole->id)
            ->where('is_deleted', false)
            ->get();
        
        $groups = Group::where('is_deleted', false)->get();
        
        return view('courses.index', compact('courses', 'teachers', 'groups'));
    }

    public function create()
    {
        $teacherRole = Role::where('is_teacher', true)->first();
        $teachers = User::where('role_id', $teacherRole->id)
            ->where('is_deleted', false)
            ->get();
        
        $groups = Group::where('is_deleted', false)->get();
        
        return view('courses.create', compact('teachers', 'groups'));
    }

    public function createForm()
    {
        $teacherRole = Role::where('is_teacher', true)->first();
        $teachers = User::where('role_id', $teacherRole->id)
            ->where('is_deleted', false)
            ->get();
        
        $groups = Group::where('is_deleted', false)->get();
        
        return view('courses.create-ajax', compact('teachers', 'groups'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'teacher_id' => 'required|exists:users,id',
            'group_id' => 'required|exists:groups,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'boolean',
            'documents.*.title' => 'nullable|string|max:255',
            'documents.*.description' => 'nullable|string',
            'documents.*.file_type' => 'nullable|in:video,image,pdf',
            'documents.*.file' => 'nullable|file|max:102400'
        ]);

        $course = Course::create($request->except('documents'));

        // Handle document uploads
        if ($request->has('documents')) {
            foreach ($request->documents as $document) {
                if (isset($document['file']) && $document['file']->isValid()) {
                    $path = $document['file']->store("courses/{$course->id}/documents", 'public');
                    
                    $course->documents()->create([
                        'title' => $document['title'],
                        'description' => $document['description'],
                        'file_type' => $document['file_type'],
                        'file_path' => $path,
                        'mime_type' => $document['file']->getMimeType(),
                        'file_size' => $document['file']->getSize()
                    ]);
                }
            }
        }

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Course created successfully.']);
        }

        return redirect()->route('courses.index')
            ->with('success', 'Course created successfully.');
    }

    public function edit($id)
    {
        $course = Course::findOrFail($id);
        
        $teacherRole = Role::where('is_teacher', true)->first();
        $teachers = User::where('role_id', $teacherRole->id)
            ->where('is_deleted', false)
            ->get();
        
        $groups = Group::where('is_deleted', false)->get();
        
        return view('courses.edit', compact('course', 'teachers', 'groups'));
    }

    public function editForm($id)
    {
        $course = Course::findOrFail($id);
        
        $teacherRole = Role::where('is_teacher', true)->first();
        $teachers = User::where('role_id', $teacherRole->id)
            ->where('is_deleted', false)
            ->get();
        
        $groups = Group::where('is_deleted', false)->get();
        
        return view('courses.edit-ajax', compact('course', 'teachers', 'groups'));
    }

    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'teacher_id' => 'required|exists:users,id',
            'group_id' => 'required|exists:groups,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'boolean',
            'documents.*.title' => 'nullable|string|max:255',
            'documents.*.description' => 'nullable|string',
            'documents.*.file_type' => 'nullable|in:video,image,pdf',
            'documents.*.file' => 'nullable|file|max:102400'
        ]);

        $course->update($request->except('documents'));

        // Handle document uploads
        if ($request->has('documents')) {
            foreach ($request->documents as $document) {
                if (isset($document['file']) && $document['file']->isValid()) {
                    $path = $document['file']->store("courses/{$course->id}/documents", 'public');
                    
                    $course->documents()->create([
                        'title' => $document['title'],
                        'description' => $document['description'],
                        'file_type' => $document['file_type'],
                        'file_path' => $path,
                        'mime_type' => $document['file']->getMimeType(),
                        'file_size' => $document['file']->getSize()
                    ]);
                }
            }
        }

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Course updated successfully.']);
        }

        return redirect()->route('courses.index')
            ->with('success', 'Course updated successfully.');
    }

    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $course->update(['is_deleted' => true]);
        return redirect()->route('courses.index')
            ->with('success', 'Course deleted successfully.');
    }
}
