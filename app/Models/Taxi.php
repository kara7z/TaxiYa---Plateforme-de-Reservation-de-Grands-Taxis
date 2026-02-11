<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Taxi extends Model
{
    protected $fillable = ['model', 'color', 'licence_plate'];

    public function seats() {
        return $this->hasMany(Seat::class);
    }

    public function trips() {
        return $this->hasMany(Trip::class);
    }
}
