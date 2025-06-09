<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index()
    {
        $users = User::with('role')
            ->whereHas('role', function($query) {
                $query->where('is_admin', true);
            })
            ->paginate(10);

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $roles = \App\Models\Role::where('is_deleted', false)->get();
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'role_id' => 'required|exists:roles,id',
            'number' => 'required|string|max:20',
            'department' => 'required_if:is_teacher,true|string|max:100|nullable',
            'status' => 'required|in:active,inactive',
            'date_of_birth' => 'required|date',
            'photo' => 'nullable|image|max:2048',
            'cv' => 'nullable|file|max:5120'
        ]);

        // Handle file uploads
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoPath = $photo->store('users/photos', 'public');
            $validated['photo'] = $photoPath;
        }

        if ($request->hasFile('cv')) {
            $cv = $request->file('cv');
            $cvPath = $cv->store('users/documents', 'public');
            $validated['cv'] = $cvPath;
        }

        // Generate random password
        $validated['password'] = Hash::make(str_random(10));

        User::create($validated);

        return redirect()->route('users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        if ($user->isSuperAdmin()) {
            abort(403);
        }
        $roles = \App\Models\Role::where('is_deleted', false)->get();
        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        if ($user->isSuperAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'role_id' => 'required|exists:roles,id',
            'number' => 'required|string|max:20',
            'department' => 'required_if:is_teacher,true|string|max:100|nullable',
            'status' => 'required|in:active,inactive',
            'date_of_birth' => 'required|date',
            'photo' => 'nullable|image|max:2048',
            'cv' => 'nullable|file|max:5120'
        ]);

        // Handle file uploads
        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            
            $photo = $request->file('photo');
            $photoPath = $photo->store('users/photos', 'public');
            $validated['photo'] = $photoPath;
        }

        if ($request->hasFile('cv')) {
            // Delete old CV
            if ($user->cv) {
                Storage::disk('public')->delete($user->cv);
            }
            
            $cv = $request->file('cv');
            $cvPath = $cv->store('users/documents', 'public');
            $validated['cv'] = $cvPath;
        }

        $user->update($validated);

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        if ($user->isSuperAdmin()) {
            abort(403);
        }

        // Delete associated files
        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
        }
        if ($user->cv) {
            Storage::disk('public')->delete($user->cv);
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully.');
    }

    /**
     * Reset password for the specified user.
     */
    public function resetPassword(User $user)
    {
        if ($user->isSuperAdmin()) {
            abort(403);
        }

        $newPassword = str_random(10);
        $user->update([
            'password' => Hash::make($newPassword)
        ]);

        // Here you would typically send an email to the user with their new password
        // For now, we'll just flash it to the session
        return redirect()->route('users.index')
            ->with('success', "Password reset successfully. New password: {$newPassword}");
    }
}