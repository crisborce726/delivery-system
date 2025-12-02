<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryDriver extends Model
{
    protected $table = 'delivery_driver'; // pivot table name

    protected $fillable = [
        'delivery_id',
        'driver_id',
        'assignment_status',
        'completed_at',
        'notes',
    ];

    public function delivery()
    {
        return $this->belongsTo(Delivery::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}
