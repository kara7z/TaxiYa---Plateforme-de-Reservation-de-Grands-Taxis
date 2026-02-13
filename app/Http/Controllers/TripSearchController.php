<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class TripSearchController extends Controller
{
    public function result(Request $request)
    {

        $from = $request->query('from');
        $to   = $request->query('to');
        $date = $request->query('date');


        $tripModels = Trip::with(['route.startCity', 'route.arrivalCity', 'taxi.seats'])
            ->whereDate('date', $date)
            ->whereHas('route', function ($query) use ($from, $to) {
                $query->whereHas('startCity', fn($q) => $q->where('name', $from))
                      ->whereHas('arrivalCity', fn($q) => $q->where('name', $to));
            })
            ->where('status', 'confirmed')
            ->get();

        $trips = $tripModels->map(function ($trip) {

            $takenSeatsCount = DB::table('reservation_seat')
                ->join('reservations', 'reservation_seat.reservation_id', '=', 'reservations.id')
                ->where('reservations.trip_id', $trip->id)
                ->count();

            return [
                'id'        => $trip->id,
                'from'      => $trip->route->startCity->name,
                'to'        => $trip->route->arrivalCity->name,
                'date'      => $trip->date,
                'time'      => Carbon::parse($trip->departure_hour)->format('H:i'),
                'price'     => (int) $trip->price,
                'available' => 6 - $takenSeatsCount, 
                'driver'    => $trip->taxi->model . " (" . $trip->taxi->licence_plate . ")",
                'status'    => 'open',
            ];
        });

        return view('pages.results', compact('trips'));
    }
    function search(){
        return view('pages.search', ['cities' => City::all()]);
    }

    public function show(Trip $trip)
    {
        $trip->load(['taxi.seats', 'route.startCity', 'route.arrivalCity']);
        return view('pages.trip.show', compact('trip'));
    }
}