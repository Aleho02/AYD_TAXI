<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'passenger_id',
        'driver_id',
        'origin_address',
        'origin_latitude',
        'origin_longitude',
        'destination_address',
        'destination_latitude',
        'destination_longitude',
        'distance_km',
        'estimated_fare',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'origin_latitude' => 'float',
            'origin_longitude' => 'float',
            'destination_latitude' => 'float',
            'destination_longitude' => 'float',
            'distance_km' => 'float',
            'estimated_fare' => 'float',
        ];
    }

    public function passenger(): BelongsTo
    {
        return $this->belongsTo(User::class, 'passenger_id');
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'driver_id');
    }
}
