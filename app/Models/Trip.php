<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $fillable = ['departure_hour', 'estimated_arrival_hour', 'range_of_lateness', 'price', 'status', 'date', 'route_id', 'taxi_id'];

    public function route() {
        return $this->belongsTo(Route::class);
    }

    public function reservations() {
        return $this->hasMany(Reservation::class);
    }

    public function taxi() {
        return $this->belongsTo(Taxi::class);
    }

    public function isSeatTaken($seatId)
    {
        return $this->reservations()
            ->whereHas('seats', function($query) use ($seatId) {
                $query->where('seats.id', $seatId);
            })->exists();
    }
}
