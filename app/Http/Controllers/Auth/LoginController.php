<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    /**
     * Handle user login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // Attempt login
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();

            // Regenerate session for security
            $request->session()->regenerate();

            // Check if email is verified
            if (is_null($user->email_verified_at)) {
                // Redirect to OTP verification page
                return redirect()->route('otp.verify.show')
                    ->with('error', '📧 Please verify your email address first. Check your email for OTP code.');
            }

            // Redirect to user dashboard if verified
            return redirect()->route('user.dashboard');
        }

        // Failed login
        return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }

    /**
     * Handle user logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Logged out successfully.');
    }
}
