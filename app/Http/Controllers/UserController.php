<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    // Show user view
    public function index()
    {
        $user = Auth::user(); // Get the currently logged-in user
        return view('user', compact('user'));
    }

    // Update user
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'User updated successfully!');
    }

    // Delete user
    public function destroy(Request $request)
    {
        $user = Auth::user();

        // Logout the user
        Auth::logout();

        // Delete the user
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/register')->with('success', 'Your account has been deleted.');
    }
}
