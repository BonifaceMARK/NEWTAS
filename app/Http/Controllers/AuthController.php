<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    // Load login view
    public function loadlogin()
    {
        return view('login');
    }

    // Load register view
    public function loadregister()
    {
        return view('register');
    }

    // Handle login
    public function login(Request $request)
    {
        try {
            // Validate input
            $request->validate([
                'username' => 'required',
                'password' => 'required',
            ]);

            $username = $request->input('username');
            $password = $request->input('password');

            // Find user by username
            $user = User::where('username', $username)->first();

            if ($user && Hash::check($password, $user->password)) {
                // Login user
                Auth::login($user);
                $user->update(['isactive' => 1]);

                return redirect($this->redirectDash());
            } else {
                throw new \Exception('Invalid credentials. Please try again.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    // Redirect based on role
    public function redirectDash()
    {
        if (Auth::user() && Auth::user()->role == 0) {
            return '/user/index';
        }
        return '/dashboard'; // Admin dashboard
    }

    // Handle registration
    public function register(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8',
            'email' => 'required|email|unique:users',
        ]);

        try {
            User::create([
                'fullname' => $request->fullname,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password), // secure hashing
                'email_verified_at' => now(),
            ]);

            return redirect()->route('login')->with('success', 'Registration successful');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Registration failed: ' . $e->getMessage());
        }
    }

    // Logout
    public function logoutx()
    {
        $user = Auth::user();
        if ($user) {
            $user->update(['isactive' => 0]);
        }
        Session::flush();
        Auth::logout();
        return redirect('/');
    }
}
