<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Delivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tracking_number',
        'description',
        'delivery_address',
        'delivered_at'
    ];

    protected $casts = [
        'estimated_delivery' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    /**
     * Get the user that owns the delivery.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * MANY-TO-MANY: Delivery can have multiple drivers
     */
    public function drivers(): BelongsToMany
    {
        return $this->belongsToMany(Driver::class, 'delivery_driver')
                    ->withPivot('assignment_status', 'assigned_at', 'completed_at', 'notes')
                    ->withTimestamps();
    }

    /**
     * Check if delivery is pending.
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if delivery is in transit.
     */
    public function isInTransit(): bool
    {
        return $this->status === 'in_transit';
    }

    /**
     * Check if delivery is delivered.
     */
    public function isDelivered(): bool
    {
        return $this->status === 'delivered';
    }

    /**
     * Check if delivery is cancelled.
     */
    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    /**
     * Get assigned drivers count
     */
    public function getAssignedDriversCount(): int
    {
        return $this->drivers()->count();
    }

    /**
     * Get active assigned drivers (not completed/cancelled)
     */
    public function getActiveDrivers()
    {
        return $this->drivers()
                    ->wherePivotIn('assignment_status', ['assigned', 'in_progress'])
                    ->get();
    }

    /**
     * Assign a driver to this delivery
     */
    public function assignDriver(Driver $driver, string $notes = null): void
    {
        $this->drivers()->attach($driver->id, [
            'assignment_status' => 'assigned',
            'notes' => $notes,
            'assigned_at' => now()
        ]);
    }

    /**
     * Generate a unique tracking number.
     */
    public static function generateTrackingNumber(): string
    {
        do {
            $trackingNumber = 'DLV-' . strtoupper(uniqid());
        } while (self::where('tracking_number', $trackingNumber)->exists());

        return $trackingNumber;
    }
}