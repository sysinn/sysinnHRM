<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    // Show login form
    public function showLoginForm()
    {
        if (auth()->check()) {
            return redirect('/auth/dashboard');
        }
        return view('auth.userslogin');
    }

    // Handle login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = auth()->user();

            // Redirect based on role
            if ($user->roles->contains('id', 9)) {
                return redirect()->route('employee.dashboard');
            }

            return redirect()->route('auth.dashboard');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ])->onlyInput('email');
    }

    // Show register form
    public function showRegisterForm()
    {
        if (auth()->check()) {
            return redirect('/dashboard');
        }

        $roles = Role::all();
        return view('auth.usersregister', compact('roles'));
    }

    // Handle registration
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|confirmed|min:6',
            'role_id' => 'required|array',
            'role_id.*' => 'exists:roles,id',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Handle file upload
        $profilePath = null;
        if ($request->hasFile('profile_picture')) {
            $profilePath = $request->file('profile_picture')->store('profile_pictures', 'public');
        }

        // Create user
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'profile_picture' => $profilePath,
        ]);

        // Assign roles
        $user->roles()->sync($data['role_id']);

        // Auto login
        Auth::login($user);

        return redirect('/auth/dashboard');
    }

    // Handle logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/userslogin');
    }

    // ✅ Show all users in a table
    public function index()
    {
        $users = User::with('roles')->get(); // eager load roles
        return view('auth.userslist', compact('users'));
    }
}
