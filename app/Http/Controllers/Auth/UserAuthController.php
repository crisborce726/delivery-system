<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class UserAuthController extends Controller
{
    /**
     * Show user login form
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Show user registration form
     */
    public function showSignupForm()
    {
        return view('auth.register');
    }

    /**
     * Handle user registration (Auto-verify, No OTP)
     */
    public function signup(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'required|string|max:20',
            'password' => 'required|min:6|confirmed',
            // 'g-recaptcha-response' => ['required', new RecaptchaRule], // Commented out for now
        ], [
            'name.required' => 'Full name is required',
            'email.required' => 'Email address is required',
            'email.email' => 'Please enter a valid email address',
            'email.unique' => 'This email is already registered',
            'phone.required' => 'Phone number is required',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 6 characters',
            'password.confirmed' => 'Passwords do not match',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Start database transaction
        DB::beginTransaction();

        try {
            // Create user (auto-verified)
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'role' => 'user',
                'is_verified' => true,  // Auto-verify
                'verified_at' => now(), // Set verification timestamp
                'email_verified_at' => now(),
            ]);

            // Commit transaction
            DB::commit();

            // Auto-login the user
            Auth::login($user);
            $request->session()->regenerate();

            // Redirect to dashboard
            return redirect()->route('user.dashboard')->with([
                'success' => 'Registration successful! Welcome, ' . $user->name . '!'
            ]);

        } catch (Exception $e) {
            // Rollback transaction on error
            DB::rollBack();
            
            Log::error('Registration Error: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Registration failed. Please try again.')
                ->withInput();
        }
    }

    /**
     * Handle user login (Simplified - No OTP)
     */
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

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Get credentials
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        // Attempt to authenticate user
        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            // Check if user is admin (redirect to admin login)
            if ($user->role === 'admin') {
                Auth::logout();
                return redirect()->route('admin.login')
                    ->with('error', 'Please use admin login for admin accounts.');
            }

            // Regenerate session for security
            $request->session()->regenerate();

            // Redirect to dashboard
            return redirect()->route('user.dashboard')
                ->with('success', 'Welcome back, ' . $user->name . '!');

        } else {
            // Authentication failed
            return redirect()->back()
                ->with('error', 'Invalid email or password!')
                ->withInput();
        }
    }

    /**
     * Handle user logout
     */
    public function logout(Request $request)
    {
        // Logout user
        Auth::logout();
        
        // Invalidate session and regenerate token
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login')
            ->with('success', 'Logged out successfully!');
    }

    /**
     * Show user dashboard
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Double-check user has user role
        if ($user->role !== 'user') {
            Auth::logout();
            return redirect()->route('login')
                ->with('error', 'Access denied.');
        }

        return view('user.dashboard', compact('user'));
    }
}