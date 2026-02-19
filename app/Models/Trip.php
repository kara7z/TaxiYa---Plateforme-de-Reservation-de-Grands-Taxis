<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'departure_hour',
        'estimated_arrival_hour',
        'range_of_lateness',
        'price',
        'status',
        'date',
        'route_id',
        'driver_id',
    ];

    public function route(): BelongsTo
    {
        return $this->belongsTo(Route::class);
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    public function taxi(): HasOneThrough
    {
        return $this->hasOneThrough(
            Taxi::class,
            User::class,
            'id',        // Foreign key on users table (matches trips.driver_id)
            'id',        // Foreign key on taxis table (matches users.taxi_id)
            'driver_id', // Local key on trips table
            'taxi_id'    // Local key on users table
        );
    }

    public function isSeatTaken($seatId): bool
    {
        return $this->reservations()
            ->whereHas('seats', function ($query) use ($seatId) {
                $query->where('seats.id', $seatId);
            })
            ->exists();
    }
}
