<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
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
            'position' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        // Create the employee (assuming employees are stored in the users table)
        User::create([
            'name' => $request->name,
            'role' => $request->position, // Adjust based on your database structure
            'password' => Hash::make($request->password),
        ]);

        // Redirect back with a success message
        return back()->with('success', 'Employee created successfully.');
    }
}
