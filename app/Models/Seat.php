<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    protected $fillable = ['seat_number', 'type', 'taxi_id'];

    public function taxi() {
        return $this->belongsTo(Taxi::class);
    }

    public function reservations() {
        return $this->belongsToMany(Reservation::class, 'reservation_seat');
    }
}
