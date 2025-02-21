<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        if (Auth::user()->role !== 'admin') {
            return redirect('/user-dashboard')->with('error', 'You do not have permission to access this page.');
        }

        $users = User::all();
        return view('usermanagement', compact('users'));
    }

    public function accessDashboard()
    {
        if (Auth::user()->role !== 'admin') {
            return redirect('/user-dashboard')->with('error', 'You are redirected back to the user dashboard.');
        }

        return view('dashboard');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'role' => 'required|string',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        // Log user creation with specific details
        ActivityLogController::log(
            'Create User',
            "Created new user with details:\n" .
            "- Name: {$user->name}\n" .
            "- Email: {$user->email}\n" .
            "- Role: {$user->role}"
        );

        return redirect()->route('user.management')->with('success', 'User created successfully!');
    }

    public function edit(User $user)
    {
        return response()->json($user);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|string',
            'password' => 'nullable|string|min:8',
        ]);

        // Store old values for logging
        $oldValues = [
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role
        ];

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
        ]);

        // Prepare changes log
        $changes = [];
        if ($oldValues['name'] != $user->name) {
            $changes[] = "Name changed from '{$oldValues['name']}' to '{$user->name}'";
        }
        if ($oldValues['email'] != $user->email) {
            $changes[] = "Email changed from '{$oldValues['email']}' to '{$user->email}'";
        }
        if ($oldValues['role'] != $user->role) {
            $changes[] = "Role changed from '{$oldValues['role']}' to '{$user->role}'";
        }
        if ($request->password) {
            $changes[] = "Password was updated";
        }

        // Log user update with specific changes
        ActivityLogController::log(
            'Update User',
            'Updated user #' . $user->id . ":\n- " . implode("\n- ", $changes)
        );

        return redirect()->route('user.management')->with('success', 'User updated successfully!');
    }

    public function destroy(User $user)
    {
        // Prevent self-deletion
        if ($user->id === Auth::id()) {
            return redirect()->route('user.management')
                ->with('error', 'You cannot delete your own account!');
        }

        // Store user details for logging before deletion
        $userDetails = [
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role
        ];

        // Delete the user
        $user->delete();

        // Log the deletion
        ActivityLogController::log(
            'Delete User',
            "Deleted user with details:\n" .
            "- Name: {$userDetails['name']}\n" .
            "- Email: {$userDetails['email']}\n" .
            "- Role: {$userDetails['role']}"
        );

        return redirect()->route('user.management')
            ->with('success', 'User deleted successfully!');
    }
}
