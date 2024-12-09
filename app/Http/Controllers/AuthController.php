<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
        // Show login form
        public function showLoginForm()
        {
            return view('auth.login');
        }
    
        // Handle login
        public function login(Request $request)
        {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);
    
            if (Auth::attempt($request->only('email', 'password'))) {
                return redirect()->route('home')->with('success', 'You are logged in!');
            }
    
            return back()->withErrors([
                'email' => 'Invalid credentials.',
            ]);
        }
    
        // Show registration form
        public function showRegistrationForm()
        {
            return view('auth.register');
        }
    
        // Handle registration
        public function register(Request $request)
        {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6|confirmed',
            ]);
    
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
    
            Auth::login($user);
    
            return redirect()->route('login')->with('success', 'Registration successful!');
        }
    
        // Handle logout
        public function logout(Request $request)
        {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
    
            return redirect('/login')->with('success', 'You are logged out!');
        }
}