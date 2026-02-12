<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    protected $fillable = ['start_city_id', 'arrival_city_id', 'base_price'];

    public function startCity() {
        return $this->belongsTo(City::class, 'start_city_id');
    }

    public function arrivalCity() {
        return $this->belongsTo(City::class, 'arrival_city_id');
    }

    public function trips() {
        return $this->hasMany(Trip::class);
    }
}
