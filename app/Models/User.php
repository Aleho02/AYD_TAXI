<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'license_number',
        'photo_path',
        'latitude',
        'longitude',
        'is_available',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_available' => 'boolean',
            'latitude' => 'float',
            'longitude' => 'float',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isConductor(): bool
    {
        return $this->role === 'conductor';
    }

    public function isPasajero(): bool
    {
        return $this->role === 'pasajero';
    }

    public function vehicle(): HasOne
    {
        return $this->hasOne(Vehicle::class, 'driver_id');
    }

    public function passengerTrips(): HasMany
    {
        return $this->hasMany(Trip::class, 'passenger_id');
    }

    public function driverTrips(): HasMany
    {
        return $this->hasMany(Trip::class, 'driver_id');
    }
}
