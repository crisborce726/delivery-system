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
        'category_id',   // ← missing comma fixed
        'tracking_number',
        'description',
        'delivery_address',
        'status',
        'delivered_at',
    ];

    protected $casts = [
        'delivered_at' => 'datetime',
    ];

    /**
     * Belongs to: User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Belongs to: Category
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * MANY-TO-MANY: Delivery can have multiple drivers via delivery_driver table
     */
    public function drivers(): BelongsToMany
    {
        return $this->belongsToMany(Driver::class, 'delivery_driver')
            ->withPivot('assignment_status', 'completed_at', 'notes')
            ->withTimestamps();
    }

    /**
     * Check status helpers
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isInTransit(): bool
    {
        return $this->status === 'in_transit';
    }

    public function isDelivered(): bool
    {
        return $this->status === 'delivered';
    }

    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    public static function generateTrackingNumber(): string
    {
        do {
            $trackingNumber = 'DLV-' . strtoupper(uniqid());
        } while (self::where('tracking_number', $trackingNumber)->exists());

        return $trackingNumber;
    }
}
