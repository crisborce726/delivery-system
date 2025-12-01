<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
        'is_verified',
        'verified_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'verified_at' => 'datetime',
        'is_verified' => 'boolean',
    ];

    // One-to-Many relationship with deliveries
    public function deliveries(): HasMany
    {
        return $this->hasMany(Delivery::class);
    }

    // One-to-Many relationship with OTP verifications
    public function otpVerifications(): HasMany
    {
        return $this->hasMany(OTPVerification::class);
    }

    // FIXED METHODS:

    /**
     * Check if user is verified
     */
    public function isVerified(): bool
    {
        return $this->is_verified && $this->verified_at !== null;
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is regular user
     */
    public function isUser(): bool
    {
        return $this->role === 'user' || $this->role === null;
    }

    /**
     * Get the user's role with default
     */
    public function getRoleAttribute($value): string
    {
        return $value ?? 'user';
    }

    /**
     * Mark user as verified
     */
    public function markAsVerified(): void
    {
        $this->update([
            'is_verified' => true,
            'verified_at' => now()
        ]);
    }

    /**
     * Get pending deliveries count.
     */
    public function getPendingDeliveriesCount(): int
    {
        return $this->deliveries()->where('status', 'pending')->count();
    }

    /**
     * Get completed deliveries count.
     */
    public function getCompletedDeliveriesCount(): int
    {
        return $this->deliveries()->where('status', 'delivered')->count();
    }

    /**
     * Get in-transit deliveries count.
     */
    public function getInTransitDeliveriesCount(): int
    {
        return $this->deliveries()->where('status', 'in_transit')->count();
    }

    /**
     * Get cancelled deliveries count.
     */
    public function getCancelledDeliveriesCount(): int
    {
        return $this->deliveries()->where('status', 'cancelled')->count();
    }

    /**
     * Get recent deliveries (last 5)
     */
    public function getRecentDeliveries($limit = 5)
    {
        return $this->deliveries()
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Get delivery statistics
     */
    public function getDeliveryStats(): array
    {
        return [
            'pending' => $this->getPendingDeliveriesCount(),
            'completed' => $this->getCompletedDeliveriesCount(),
            'in_transit' => $this->getInTransitDeliveriesCount(),
            'cancelled' => $this->getCancelledDeliveriesCount(),
            'total' => $this->deliveries()->count(),
        ];
    }

    /**
     * Check if user has any deliveries
     */
    public function hasDeliveries(): bool
    {
        return $this->deliveries()->exists();
    }

    /**
     * Get active deliveries (pending or in_transit)
     */
    public function getActiveDeliveries()
    {
        return $this->deliveries()
            ->whereIn('status', ['pending', 'in_transit'])
            ->get();
    }
}