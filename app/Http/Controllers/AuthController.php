<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
    // Show Admin Login Page
    public function showAdminLogin(): View
    {
        return view('auth.admin-login');
    }

    // Admin Login
    public function adminLogin(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'password' => 'required|min:6'
        ], [
            'email.required' => '📧 Email address is required.',
            'email.email' => '📧 Please enter a valid email address.',
            'email.max' => '📧 Email address must not exceed 255 characters.',
            'password.required' => '🔑 Password is required.',
            'password.min' => '🔑 Password must be at least 6 characters.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            /** @var User $user */
            $user = Auth::user();
            
            // Check if user is admin
            if (!$user->isAdmin()) {
                Auth::logout();
                return back()->with('error', '🚫 Access denied. Admin privileges required.');
            }

            $request->session()->regenerate();
            return redirect()->route('admin.dashboard')->with('success', '👋 Welcome back, Admin!');
        }

        return back()->with('error', '❌ Invalid admin credentials. Please try again.');
    }

    // Show User Login Page
    public function showUserLogin(): View
    {
        return view('auth.login');
    }

    // User Login
    public function userLogin(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'password' => 'required|min:6'
        ], [
            'email.required' => '📧 Email address is required.',
            'email.email' => '📧 Please enter a valid email address.',
            'email.max' => '📧 Email address must not exceed 255 characters.',
            'password.required' => '🔑 Password is required.',
            'password.min' => '🔑 Password must be at least 6 characters.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            /** @var User $user */
            $user = Auth::user();

            // Check if user is not trying to access user area as admin
            if ($user->isAdmin()) {
                Auth::logout();
                return back()->with('error', '🚫 Please use admin login for admin accounts.');
            }

            // Check if user is verified
            if (!$user->is_verified) {
                Auth::logout();
                return back()->with('error', '📧 Please verify your email address first. Check your email for OTP code.');
            }

            $request->session()->regenerate();
            return redirect()->route('user.dashboard')->with('success', '👋 Welcome back, ' . $user->name . '!');
        }

        return back()->with('error', '❌ Invalid email or password. Please try again.');
    }

    // Show User Registration Page
    public function showUserRegister(): View
    {
        return view('auth.register');
    }

    // User Registration with reCAPTCHA v2 and OTP
    public function userRegister(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|min:2',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20|min:10',
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
            'g-recaptcha-response' => 'required', // ✅ ENABLED reCAPTCHA
        ], [
            // Name validation messages
            'name.required' => '👤 Full name is required.',
            'name.string' => '👤 Full name must be a valid text.',
            'name.max' => '👤 Full name must not exceed 255 characters.',
            'name.min' => '👤 Full name must be at least 2 characters.',

            // Email validation messages
            'email.required' => '📧 Email address is required.',
            'email.email' => '📧 Please enter a valid email address.',
            'email.unique' => '📧 This email is already registered. Please use a different email.',
            'email.max' => '📧 Email address must not exceed 255 characters.',

            // Phone validation messages
            'phone.required' => '📱 Phone number is required.',
            'phone.string' => '📱 Phone number must be a valid text.',
            'phone.max' => '📱 Phone number must not exceed 20 characters.',
            'phone.min' => '📱 Phone number must be at least 10 characters.',

            // Password validation messages
            'password.required' => '🔑 Password is required.',
            'password.min' => '🔑 Password must be at least 8 characters.',
            'password.confirmed' => '🔑 Password confirmation does not match.',
            'password.regex' => '🔑 Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',

            // reCAPTCHA validation messages
            'g-recaptcha-response.required' => '🛡️ Please complete the reCAPTCHA verification.',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', '❌ Please fix the errors below and try again.');
        }

        // ✅ VERIFY reCAPTCHA with Google
        $recaptchaResponse = $request->input('g-recaptcha-response');
        $recaptchaSecret = config('services.recaptcha.secret_key');
        
        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $recaptchaSecret . '&response=' . $recaptchaResponse);
        $responseData = json_decode($verifyResponse);
        
        if (!$responseData->success) {
            return redirect()->back()
                ->with('error', '🛡️ reCAPTCHA verification failed. Please try again.')
                ->withInput();
        }

        try {
            // ✅ CREATE USER BUT DON'T VERIFY - NEED OTP FIRST
            $user = User::create([
                'name' => trim($request->name),
                'email' => strtolower(trim($request->email)),
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'role' => 'user',
                'is_verified' => false,    // ✅ NOT VERIFIED YET
                'verified_at' => null,     // ✅ NO VERIFICATION DATE
                'email_verified_at' => null
            ]);

            // ✅ GENERATE AND SEND OTP
            $otpController = new \App\Http\Controllers\OTPVerificationController();
            $otpCode = $otpController->generateOTP($user->email);

            // ✅ AUTO-LOGIN USER after registration
            Auth::login($user);

            // ✅ REDIRECT TO OTP VERIFICATION PAGE
            return redirect()->route('otp.verify.show')
                ->with('success', '🎉 Registration successful! Please check your email for the OTP code.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', '❌ Registration failed. Please try again.')
                ->withInput();
        }
    }

    // Logout
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', '👋 You have been logged out successfully.');
    }
}