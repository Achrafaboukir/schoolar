<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::where('is_deleted', false)->paginate(10);
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        return view('roles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'permissions' => 'required|array',
        ]);
        $role = new Role();
        $role->name = $validated['name'];
        $role->permissions = json_encode($validated['permissions']);
        $role->is_deleted = 0;
        $role->save();
        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    public function edit(Role $role)
    {
        return view('roles.edit', compact('role'));
    }

    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'permissions' => 'required|array',
        ]);
        $role->name = $validated['name'];
        $role->permissions = json_encode($validated['permissions']);
        $role->save();
        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }

    public function destroy(Role $role)
    {
        $role->is_deleted = 1;
        $role->save();
        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }

    public function createForm()
    {
        return view('roles._form', [
            'action' => route('roles.store'),
            'method' => 'POST',
            'submitLabel' => 'Save Role',
        ]);
    }

    public function editForm(Role $role)
    {
        return view('roles._form', [
            'action' => route('roles.update', $role),
            'method' => 'PUT',
            'submitLabel' => 'Update Role',
            'role' => $role
        ]);
    }

    // Add a show method to satisfy resourceful route requirements
    public function show(Role $role)
    {
        // You can customize this as needed, for now just show the edit view or a simple view
        return redirect()->route('roles.edit', $role);
    }
}
