<?php

namespace App\Services;

use App\Models\OTPVerification;
use Illuminate\Support\Str;

class OTPService
{
    public function generateOtp($email)
    {
        // Delete any existing OTP for this email
        OTPVerification::where('email', $email)->delete();

        // Generate 6-digit OTP
        $otpCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Create OTP record (valid for 10 minutes)
        $otp = OTPVerification::create([
            'email' => $email,
            'otp_code' => $otpCode,
            'expires_at' => now()->addMinutes(10)
        ]);

        return $otpCode;
    }

    // FIXED: Add missing parameters
    public function verifyOtp($email, $otpCode)
    {
        $otp = OTPVerification::where('email', $email)
                    ->where('otp_code', $otpCode)
                    ->where('is_used', false)
                    ->where('expires_at', '>', now())
                    ->first();

        if ($otp) {
            $otp->update(['is_used' => true]);
            return true;
        }

        return false;
    }

    public function getOtpForDisplay($email)
    {
        return OTPVerification::where('email', $email)
                 ->where('is_used', false)
                 ->where('expires_at', '>', now())
                 ->first();
    }
}