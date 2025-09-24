<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class usersController extends Controller
{

    public function index()
    {
        $emp = User::whereNull('deleted_at')->get();

        return view('emp', compact('emp'));
    }

    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'position' => 'required|string',
            'password' => 'required|string|min:6',
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
}
