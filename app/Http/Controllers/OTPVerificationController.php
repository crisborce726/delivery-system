<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\OTPVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class OTPVerificationController extends Controller
{
    // Show OTP verification form
    public function showVerificationForm()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        $user = Auth::user();
        
        // Check if user is verified using direct property access
        if ($user->is_verified && $user->verified_at !== null) {
            return redirect()->route('user.dashboard')->with('info', 'Your account is already verified.');
        }

        return view('auth.otp-verification');
    }

    // Verify OTP
    public function verifyOTP(Request $request)
    {
        $request->validate([
            'otp_code' => 'required|digits:6'
        ]);

        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'Session expired. Please login again.');
        }

        // Find valid OTP for this user
        $otpRecord = OTPVerification::where('user_id', $user->id)
            ->where('otp_code', $request->otp_code)
            ->where('is_used', false)
            ->where('expires_at', '>', now())
            ->first();
            
        if ($otpRecord) {
            // Mark OTP as used using query builder to avoid false errors
            DB::table('otp_verifications')
                ->where('id', $otpRecord->id)
                ->update(['is_used' => true]);
            
            // Activate user account using query builder
            DB::table('users')
                ->where('id', $user->id)
                ->update([
                    'is_verified' => true,
                    'verified_at' => now()
                ]);
                
            // Redirect to dashboard instead of logout
            return redirect()->route('user.dashboard')->with('success', 'Account verified successfully!');
        }
        
        return back()->with('error', 'Invalid or expired OTP. Please try again.');
    }

    // Resend OTP
    public function resendOTP()
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'Session expired. Please login again.');
        }

        // Check if user is already verified
        if ($user->is_verified && $user->verified_at !== null) {
            return redirect()->route('user.dashboard')->with('info', 'Your account is already verified.');
        }

        // Generate new OTP
        $newOtp = $this->generateOTP($user->email);
        
        return back()->with('success', 'New OTP has been sent to your email!');
    }

    // Generate and store OTP
    public function generateOTP($email)
    {
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            return false;
        }

        // Generate 6-digit OTP
        $otpCode = rand(100000, 999999);
        
        // Delete existing OTPs for this user using query builder
        DB::table('otp_verifications')
            ->where('user_id', $user->id)
            ->delete();
        
        // Store OTP in database using query builder
        DB::table('otp_verifications')->insert([
            'user_id' => $user->id,
            'otp_code' => $otpCode,
            'expires_at' => now()->addMinutes(10),
            'is_used' => false,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Send OTP via Email
        $this->sendOTPEmail($user, $otpCode);
        
        return $otpCode;
    }

    // Send OTP via Email
    private function sendOTPEmail(User $user, string $otpCode): void
    {
        $data = [
            'user' => $user,
            'otpCode' => $otpCode,
            'expiresIn' => 10
        ];

        Mail::send('emails.otp', $data, function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Your OTP Verification Code - ' . config('app.name'));
        });
    }

    // Skip OTP (optional - for testing)
    public function skipVerification()
    {
        if (!app()->environment('local')) {
            abort(403, 'This feature is only available in development.');
        }

        $user = Auth::user();
        
        if ($user && !$user->is_verified) {
            // Use query builder to avoid false errors
            DB::table('users')
                ->where('id', $user->id)
                ->update([
                    'is_verified' => true,
                    'verified_at' => now()
                ]);
            
            return redirect()->route('user.dashboard')->with('warning', 'OTP verification skipped (DEV MODE).');
        }

        return redirect()->route('user.dashboard');
    }
}