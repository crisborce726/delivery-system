<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin; // ← Changed from User to Admin
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.admin-login');
    }

    public function login(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'Email address is required',
            'email.email' => 'Please enter a valid email address',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 6 characters',
        ]);

        // Check validation
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Manual check for admin user - using Admin model now
        $admin = Admin::where('email', $request->email)->first();

        // Check if admin exists
        if (!$admin) {
            return redirect()->back()->with('error', '❌ Invalid admin credentials. Please try again.')->withInput();
        }

        // Check password
        if (!Hash::check($request->password, $admin->password)) {
            return redirect()->back()->with('error', '❌ Invalid admin credentials. Please try again.')->withInput();
        }

        // Manual login using admin guard
        Auth::guard('admin')->login($admin, $request->has('remember'));

        // Redirect to admin dashboard
        return redirect()->route('admin.dashboard')->with('success', 'Welcome back, Admin!');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('admin.login')->with('success', 'Logged out successfully!');
    }
}