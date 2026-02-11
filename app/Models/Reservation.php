<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = ['price', 'status', 'code', 'created_at', 'user_id', 'trip_id'];
}
