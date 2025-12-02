<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Driver extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'vehicle_type',
        'license_number',
        'is_available'
    ];

    protected $casts = [
        'is_available' => 'boolean',
    ];

    /**
     * MANY-TO-MANY: Driver can have multiple deliveries
     */
    public function deliveries(): BelongsToMany
    {
        return $this->belongsToMany(Delivery::class, 'delivery_driver')
            ->withPivot('assignment_status', 'assigned_at', 'completed_at', 'notes')
            ->withTimestamps();
    }

    /**
     * Check if driver is available for new assignments
     */
    public function isAvailable(): bool
    {
        // Count deliveries that are currently assigned or in progress
        $activeDeliveriesCount = $this->deliveries()
            ->wherePivotIn('assignment_status', ['assigned', 'in_progress'])
            ->count();

        // Driver is available if marked available and has less than 3 active deliveries
        return $this->is_available && $activeDeliveriesCount < 3;
    }

    /**
     * Get completed deliveries count
     */
    public function getCompletedDeliveriesCount(): int
    {
        return $this->deliveries()
            ->wherePivot('assignment_status', 'completed')
            ->count();
    }
}
