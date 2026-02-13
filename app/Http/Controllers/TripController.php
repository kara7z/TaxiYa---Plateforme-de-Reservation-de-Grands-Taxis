<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\City;

class TripController extends Controller
{
    public function showCities()
    {
        $cities = City::All();
        return view('driver.trips.create',['cities' => $cities]);
    }
    function create(){
        
    }
}















