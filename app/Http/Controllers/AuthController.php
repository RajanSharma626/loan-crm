<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return redirect('/leads');
        }
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:users,employee_id',
            'password' => 'required|min:6',
        ]);

        $credentials = [
            'employee_id' => $request->employee_id,
            'password' => $request->password
        ];

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            return redirect()->intended('/leads');
        }

        return back()->with('error', 'Invalid Employee ID or Password');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
