<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class usersController extends Controller
{

    public function index(Request $request)
    {
        $query = User::whereNull('deleted_at');

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('users_id', 'like', "%{$search}%");
            });
        }

        $emp = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('emp', compact('emp'));
    }

    public function store(Request $request)
    {
        // Restrict Manager from creating users
        if (Auth::user()->role === 'Manager') {
            return redirect()->back()->with('error', 'Managers cannot create users. Only Admin can create users.');
        }

        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255|min:2',
            'email' => 'required|email|unique:users|max:255',
            'position' => 'required|string|in:Admin,Manager,Agent,Underwriter,Collection',
            'password' => 'required|string|min:6|max:255',
        ], [
            'name.required' => 'Name is required.',
            'name.min' => 'Name must be at least 2 characters.',
            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered.',
            'position.required' => 'Position/Role is required.',
            'position.in' => 'Please select a valid role.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 6 characters.',
        ]);

        // Create the users (assuming userss are stored in the users table)
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->position, // Adjust based on your database structure
            'password' => Hash::make($request->password),
        ]);

        // Redirect back with a success message
        return redirect()->route('emp')->with('success', 'users created successfully.');
    }

    public function edit($id)
    {
        $users = User::findOrFail($id);
        return response()->json($users);
    }

    public function update(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $request->id,
            'position' => 'required|string',
            'password' => 'nullable|string|min:6',
        ]);

        // Find the users
        $users = User::findOrFail($request->id);

        // Update the users's details
        $users->name = $request->name;
        $users->email = $request->email;
        $users->role = $request->position;
        $users->status = $request->status;

        if ($request->password) {
            $users->password = Hash::make($request->password);
        }

        $users->save();

        // Redirect back with a success message
        return redirect()->route('emp')->with('success', 'users updated successfully.');
    }

    public function destroy($id)
    {
        // Prevent deleting yourself
        if ($id == Auth::id()) {
            return redirect()->route('emp')->with('error', 'You cannot delete your own account.');
        }

        $user = User::findOrFail($id);
        $user->delete(); // Soft delete

        return redirect()->route('emp')->with('success', 'User deleted successfully.');
    }
}
