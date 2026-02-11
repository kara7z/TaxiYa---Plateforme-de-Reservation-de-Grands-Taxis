<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    protected $fillable = ['start_city_id', 'arrival_city_id', 'base_price'];
}
