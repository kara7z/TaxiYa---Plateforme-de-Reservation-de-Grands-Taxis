<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $fillable = ['departure_hour', 'estimated_arrival_hour', 'range_of_lateness', 'price', 'status', 'date', 'route_id', 'driver_id'];

    public function route() {
        return $this->belongsTo(Route::class);
    }

    public function reservations() {
        return $this->hasMany(Reservation::class);
    }

    public function driver() {
        return $this->belongsTo(User::class, 'driver_id');
    }

    public function getTaxiAttribute() {
        return $this->driver->taxi;
    }
}
