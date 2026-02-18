<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Trip;
use App\Models\Route;
use App\Models\Taxi;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TripController extends Controller
{
    public function showCities()
    {
        $cities = City::All();
        return view('driver.trips.create',['cities' => $cities]);
    }
    public function dashboard()
    {
        $driverId = Auth::id();
        
        // Stats
        $tripsCreated = Trip::where('driver_id', $driverId)->count();
        $tripsToday = Trip::where('driver_id', $driverId)->whereDate('date', Carbon::today())->count();
        
        // Reserved seats calculation
        $reservedSeats = Reservation::whereHas('trip', function($query) use ($driverId) {
            $query->where('driver_id', $driverId);
        })->withCount('seats')->get()->sum('seats_count');

        // Estimated revenue
        $revenueEst = Reservation::whereHas('trip', function($query) use ($driverId) {
            $query->where('driver_id', $driverId)->where('status', 'confirmed');
        })->sum('price');

        $stats = [
            'trips_created' => $tripsCreated,
            'trips_today' => $tripsToday,
            'seats_reserved' => $reservedSeats,
            'revenue_est' => $revenueEst
        ];

        // Upcoming trips
        $upcoming = Trip::where('driver_id', $driverId)
            ->whereDate('date', '>=', Carbon::today())
            ->with(['route.startCity', 'route.arrivalCity', 'reservations'])
            ->orderBy('date')
            ->orderBy('departure_hour')
            ->take(5)
            ->get()
            ->map(function($trip) {
                $reservedCount = \DB::table('reservation_seat')
                    ->join('reservations', 'reservation_seat.reservation_id', '=', 'reservations.id')
                    ->where('reservations.trip_id', $trip->id)
                    ->count();

                return [
                    'id' => $trip->id,
                    'from' => $trip->route->startCity->name,
                    'to' => $trip->route->arrivalCity->name,
                    'date' => $trip->date,
                    'time' => Carbon::parse($trip->departure_hour)->format('H:i'),
                    'reserved' => $reservedCount,
                    'status' => $trip->status
                ];
            });

        return view('driver.dashboard', [
            'driver' => Auth::user(),
            'stats' => $stats,
            'upcoming' => $upcoming
        ]);
    }



    public function store(Request $request) {
        $request->validate([
            'from' => 'required|exists:cities,id|different:to',
            'to' => 'required|exists:cities,id',
            'date' => 'required|date|after:today', // Must be strictly after today
            'time' => 'required',
            'price' => 'required|numeric|min:1',
            'range_of_lateness' => 'required|numeric|min:0',
            'estimated_arrival' => 'required',
        ], [
            'date.after' => 'Le trajet doit être prévu pour une date ultérieure à aujourd\'hui.'
        ]);

        $route = Route::where('start_city_id', $request->from)
                      ->where('arrival_city_id', $request->to)
                      ->first();

        if (!$route) {
            return back()->withInput()->withErrors(['route' => 'Ce trajet n\'existe pas dans le système.']);
        }

        if ($request->price < $route->base_price) {
            return back()->withInput()->withErrors(['price' => 'Le prix doit être au moins de ' . $route->base_price . ' DH.']);
        }

        $driver = Auth::user();
        
        $createTrip = function($date) use ($request, $route, $driver) {
             Trip::create([
                'departure_hour' => $request->time,
                'estimated_arrival_hour' => $request->estimated_arrival,
                'range_of_lateness' => Carbon::createFromTime(0, $request->range_of_lateness)->format('H:i:s'),
                'price' => $request->price,
                'status' => 'confirmed',
                'date' => $date,
                'route_id' => $route->id,
                'driver_id' => $driver->id,
            ]);
        };

        // 1. Create the main trip
        $createTrip($request->date);

        // 2. Repeat next 7 days logic
        if ($request->has('repeat_next_7_days')) {
            $startDate = Carbon::parse($request->date);
            for ($i = 1; $i <= 7; $i++) {
                $nextDate = $startDate->copy()->addDays($i)->format('Y-m-d');
                $createTrip($nextDate);
            }
        }

        return redirect()->route('driver.trips.index')->with('success', 'Trajet(s) créé(s) avec succès !');
    }

    public function index()
    {
        $driverId = Auth::id();
        
        $trips = Trip::where('driver_id', $driverId)
            ->orderByDesc('date')
            ->orderByDesc('departure_hour')
            ->with(['route.startCity', 'route.arrivalCity'])
            ->get()
            ->map(function($trip) {
                return [
                    'id' => $trip->id,
                    'from' => $trip->route->startCity->name,
                    'to' => $trip->route->arrivalCity->name,
                    'date' => $trip->date,
                    'time' => Carbon::parse($trip->departure_hour)->format('H:i'),
                    'price' => $trip->price,
                    'status' => $trip->status,
                    'can_cancel' => Carbon::parse($trip->date . ' ' . $trip->departure_hour)->diffInHours(now(), false) <= -48
                ];
            });

        return view('driver.trips.index', ['trips' => $trips]);
    }

    public function destroy(Trip $trip)
    {
        if ($trip->driver_id != Auth::id()) {
            abort(403);
        }

        $tripStart = Carbon::parse($trip->date . ' ' . $trip->departure_hour);
        if (now()->diffInHours($tripStart, false) < 48) {
            return back()->with('error', 'Impossible d\'annuler ce trajet (moins de 48h avant le départ).');
        }

        $trip->delete();
        return back()->with('success', 'Trajet supprimé.');
    }
    public function bookings()
    {
        $driverId = Auth::id();
        
        $bookings = Reservation::whereHas('trip', function($q) use ($driverId) {
                $q->where('driver_id', $driverId);
            })
            ->with(['trip.route.startCity', 'trip.route.arrivalCity', 'user', 'seats'])
            ->orderByDesc('created_at')
            ->get()
            ->map(function($res) {
                return [
                    'id' => $res->id,
                    'trip' => optional($res->trip->route->startCity)->name . ' → ' . optional($res->trip->route->arrivalCity)->name,
                    'time' => Carbon::parse($res->trip->departure_hour)->format('H:i'),
                    'seat' => $res->seats->pluck('seat_number')->join(', '),
                    'name' => $res->user->name,
                    'email' => $res->user->email,
                    'status' => $res->status,
                    'code' => $res->code
                ];
            });

        return view('driver.bookings.index', ['bookings' => $bookings]);
    }

    public function validateBooking(Reservation $booking)
    {
         if ($booking->trip->driver_id != Auth::id()) {
             abort(403);
         }
         
         $booking->update(['status' => 'validated']);
         
         return back()->with('success', 'Réservation validée.');
    }
}















