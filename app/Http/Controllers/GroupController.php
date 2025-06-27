<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\Department;

class GroupController extends Controller
{
    // Display a listing of the groups
    public function index()
    {
        $groups = Group::paginate(10);
        $departments = Department::all();
        return view('groups.index', compact('groups', 'departments'));
    }

    // Show the form for creating a new group
    public function create()
    {
        $departments = Department::all();
        return view('groups.create', compact('departments'));
    }

    // AJAX method to return create form for modal
    public function createForm()
    {
        $departments = Department::all();
        return view('groups.create-ajax', compact('departments'));
    }

    // Store a newly created group in storage
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'year' => 'required|integer',
            'status' => 'required|integer|in:0,1', // Assuming status is an integer (0 for inactive, 1 for active)
        ]);

        Group::create([
            'name' => $request->name,
            'department_id' => $request->department_id,
            'year' => $request->year,
            'status' => $request->status,
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Group created successfully.']);
        }

        return redirect()->route('groups.index')->with('success', 'Group created successfully.');
    }

    // Display the specified group
    public function show(Group $group)
    {
        return view('groups.show', compact('group'));
    }

    // Show the form for editing the specified group
    public function edit(Group $group)
    {
        $departments = Department::all();
        return view('groups.edit', compact('group', 'departments'));
    }

    // AJAX method to return edit form for modal
    public function editForm(Group $group)
    {
        $departments = Department::all();
        return view('groups.edit-ajax', compact('group', 'departments'));
    }

    // Update the specified group in storage
    public function update(Request $request, Group $group)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'year' => 'required|integer',
            'status' => 'required|in:active,inactive,completed',
        ]);

        $group->update([
            'name' => $request->name,
            'department_id' => $request->department_id,
            'year' => $request->year,
            'status' => $request->status,
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Group updated successfully.']);
        }

        return redirect()->route('groups.index')->with('success', 'Group updated successfully.');
    }

    // Remove the specified group from storage
    public function destroy(Group $group)
    {
        $group->delete();

        return redirect()->route('groups.index')->with('success', 'Group deleted successfully.');
    }
}
