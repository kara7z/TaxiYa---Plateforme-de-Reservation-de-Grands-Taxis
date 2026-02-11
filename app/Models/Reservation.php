<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = ['price', 'status', 'code', 'created_at', 'user_id', 'trip_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function trip() {
        return $this->belongsTo(Trip::class);
    }

    public function seats() {
        return $this->belongsToMany(Seat::class, 'reservation_seat');
    }
}
