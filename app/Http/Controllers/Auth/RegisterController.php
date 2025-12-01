<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\OTPVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth; // IMPORTANT: Add this
use App\Http\Controllers\OTPVerificationController; // Add this

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:20',
            'g-recaptcha-response' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role' => 'user',
            'is_verified' => false,
            'verified_at' => null
        ]);

        // Generate OTP and SEND TO EMAIL
        $otpController = new OTPVerificationController();
        $otpCode = $otpController->generateOTP($user->email);

        // AUTO-LOGIN USER after registration
        Auth::login($user);

        // REDIRECT TO OTP PAGE (without showing OTP code)
        return redirect()->route('otp.verify.show')
            ->with('success', 'Registration successful! Please check your email for the OTP code.');
    }

    // REMOVE THIS METHOD - nasa OTPVerificationController na
    // private function generateOTP(User $user): string
    // {
    //     ...
    // }
}