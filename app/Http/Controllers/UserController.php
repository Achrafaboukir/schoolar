<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Course;
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
        $query = User::with('role')
            ->whereHas('role', function($query) {
                $query->where('is_admin', true);
            });
        if (request()->has('search') && request('search')) {
            $search = request('search');
            $query->where(function($q) use ($search) {
                $q->where('firstname', 'like', "%$search%")
                  ->orWhere('lastname', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhereHas('role', function($r) use ($search) {
                      $r->where('name', 'like', "%$search%") ;
                  });
            });
        }
        $users = $query->paginate(10);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $roles = Role::where('is_deleted', false)->get();
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
            'status' => 'required|in:1,0',
            'date_of_birth' => 'required|date',
            'photo' => 'nullable|image|max:2048',
            'cv' => 'nullable|file|max:5120',
            'password' => 'required|string|min:6',
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


        User::create($validated);

        return redirect()->route('users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        
        $roles = Role::where('is_deleted', false)->get();
        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {

        $validated = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'role_id' => 'required|exists:roles,id',
            'number' => 'required|string|max:20',
            'department' => 'required_if:is_teacher,true|string|max:100|nullable',
            'status' => 'required|in:1,0',
            'date_of_birth' => 'required|date',
            'photo' => 'nullable|image|max:2048',
            'cv' => 'nullable|file|max:5120',
            'password' => 'nullable|string|min:6',
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

        // Only update password if provided
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
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

    // Add a show method to satisfy resourceful route requirements
    public function show(User $user)
    {
        return redirect()->route('users.edit', $user);
    }

    // AJAX form for modal: create user
    public function createForm()
    {
        $roles =Role::where('is_deleted', false)->get();
        return view('users._form', [
            'action' => route('users.store'),
            'method' => 'POST',
            'submitLabel' => 'Save User',
            'roles' => $roles,
        ]);
    }

    // AJAX form for modal: edit user
    public function editForm(User $user)
    {
        $roles =Role::where('is_deleted', false)->get();
        return view('users._form', [
            'action' => route('users.update', $user),
            'method' => 'PUT',
            'submitLabel' => 'Update User',
            'user' => $user,
            'roles' => $roles,
        ]);
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'teacher_id');
    }

    /**
     * Show the user's profile page.
     */
    public function profile()
    {
        $user = auth()->user();
        return view('users.profile', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'number' => 'required|string|max:20',
            'date_of_birth' => 'required|date',
            'photo' => 'nullable|image|max:2048',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            
            $photo = $request->file('photo');
            $photoPath = $photo->store('users/photos', 'public');
            $validated['photo'] = $photoPath;
        }

        $user->update($validated);

        return redirect()->route('profile')
            ->with('success', 'Profile updated successfully.');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user->update([
            'password' => Hash::make($validated['password'])
        ]);

        return redirect()->route('profile')
            ->with('success', 'Password updated successfully.');
    }
}