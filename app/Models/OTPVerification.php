<?php
// app/Models/OTPVerification.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OTPVerification extends Model
{
    use HasFactory;

    // ✅ ADD THIS LINE TO FIX THE TABLE NAME ISSUE
    protected $table = 'otp_verifications';

    protected $fillable = [
        'user_id',
        'otp_code',
        'is_used',
        'expires_at'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_used' => 'boolean'
    ];

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scope for valid OTPs
    public function scopeValid($query, $userId, $otpCode)
    {
        return $query->where('user_id', $userId)
                    ->where('otp_code', $otpCode)
                    ->where('is_used', false)
                    ->where('expires_at', '>', now());
    }

    // Mark OTP as used
    public function markAsUsed()
    {
        $this->update(['is_used' => true]);
    }

    // Check if OTP is expired
    public function isExpired()
    {
        return $this->expires_at->isPast();
    }

    // ✅ ADD THIS METHOD: Check if OTP is valid (not used and not expired)
    public function isValid()
    {
        return !$this->is_used && !$this->isExpired();
    }
}