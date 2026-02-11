<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $fillable = ['departure_hour', 'estimated_arrival_hour', 'range_of_lateness', 'price', 'status', 'date', 'route_id'];
}
