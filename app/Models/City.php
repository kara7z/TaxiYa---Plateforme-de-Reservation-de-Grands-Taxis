<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = ['name'];

    public function outboundRoutes() {
        return $this->hasMany(Route::class, 'start_city_id');
    }   

    public function inboundRoutes() {
        return $this->hasMany(Route::class, 'arrival_city_id');
    }
}
