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
            'users_id' => 'required|exists:users,users_id',
            'password' => 'required|min:6',
        ]);

        $user = \App\Models\User::where('users_id', $request->users_id)->first();

        if ($user->status != 'Active') {
            return back()->with('error', 'Your account is Deactive. Please contact admin.');
        }

        $credentials = [
            'users_id' => $request->users_id,
            'password' => $request->password
        ];

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            // Redirect based on user role
            $role = Auth::user()->role;
            
            switch ($role) {
                case 'Admin':
                    return redirect('/leads');
                case 'Manager':
                    return redirect('/leads');
                case 'Agent':
                    return redirect('/leads');
                case 'Underwriter':
                    return redirect('/underwriting');
                case 'Collection':
                    return redirect('/collection');
                default:
                    return redirect('/leads');
            }
        }

        return back()->with('error', 'Invalid users ID or Password');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
