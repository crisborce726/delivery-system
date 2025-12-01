<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];

    // Many-to-Many relationship with Deliveries
    public function deliveries()
    {
        return $this->belongsToMany(Delivery::class, 'delivery_category');
    }
}