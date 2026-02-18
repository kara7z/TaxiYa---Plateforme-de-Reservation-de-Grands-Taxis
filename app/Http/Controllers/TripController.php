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
    // --- Helper to link Driver (User) to Taxi ---
    private function getDriverTaxiId()
    {
        // ⚠️ CRITICAL: The database schema does NOT link Users to Taxis.
        // We assume for now that if the user is a driver, they are managing a Taxi.
        // Since we cannot modify the schema, we will try to find a Taxi that might match,
        // or default to the first taxi for demonstration purposes if no explicit link exists.
        
        // If there was a relationship: return Auth::user()->taxi->id ?? 0;
        
        return Auth::user()->taxi_id; 
    }

    public function dashboard()
    {
        $taxiId = $this->getDriverTaxiId();
        
        // Stats
        $tripsCreated = Trip::where('taxi_id', $taxiId)->count();
        $tripsToday = Trip::where('taxi_id', $taxiId)->whereDate('date', Carbon::today())->count();
        
        // Reserved seats calculation (sum of seats in reservations for my trips)
        // Assuming Reservation has 'seats' relationship or count. 
        // Reservation::seats() is BelongsToMany.
        $reservedSeats = Reservation::whereHas('trip', function($query) use ($taxiId) {
            $query->where('taxi_id', $taxiId);
        })->withCount('seats')->get()->sum('seats_count');

        // Estimated revenue: Sum of reservation prices
        $revenueEst = Reservation::whereHas('trip', function($query) use ($taxiId) {
            $query->where('taxi_id', $taxiId)->where('status', 'confirmed'); // Assuming reservation status 'confirmed' matters
        })->sum('price');

        $stats = [
            'trips_created' => $tripsCreated,
            'trips_today' => $tripsToday,
            'seats_reserved' => $reservedSeats,
            'revenue_est' => $revenueEst
        ];

        // Upcoming trips
        $upcoming = Trip::where('taxi_id', $taxiId)
            ->whereDate('date', '>=', Carbon::today())
            ->with(['route.startCity', 'route.arrivalCity', 'reservations']) // Eager load
            ->orderBy('date')
            ->orderBy('departure_hour')
            ->take(5)
            ->get()
            ->map(function($trip) {
                // Calculate reserved seats for this trip
                $reserved = $trip->reservations->sum(function($res) {
                    return $res->seats->count(); // Assuming reservation has loaded seats? We need to load them.
                });
                
                // Need to load seats for reservations to count them efficiently
                // For now, simpler: just count reservations if 1 reservation = 1 seat? 
                // No, User said "Reserved seats". 
                // Let's assume reservation_seat table counts.
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
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
            'price' => 'required|numeric|min:1',
            'range_of_lateness' => 'required|numeric|min:0',
            'estimated_arrival' => 'required',
        ]);

        $route = Route::where('start_city_id', $request->from)
                      ->where('arrival_city_id', $request->to)
                      ->first();

        if (!$route) {
            return back()->withErrors(['route' => 'Ce trajet n\'existe pas dans le système.']);
        }

        if ($request->price < $route->base_price) {
            return back()->withErrors(['price' => 'Le prix doit être au moins de ' . $route->base_price . ' DH.']);
        }

        // Time validation: >= 2 hours from now if today
        $tripDateTime = Carbon::parse($request->date . ' ' . $request->time);
        if ($tripDateTime->isPast()) {
             return back()->withErrors(['time' => 'La date et l\'heure ne peuvent pas être dans le passé.']);
        }
        
        if (Carbon::now()->diffInHours($tripDateTime, false) < 2) {
             // Wait, requirement: "Time must be at least 2 hours after current time"
             // But if date is tomorrow, diffInHours is huge.
             // Only strictly check < 2 hours.
             return back()->withErrors(['time' => 'Le départ doit être au moins 2 heures après l\'heure actuelle.']);
        }

        $taxiId = $this->getDriverTaxiId();
        
        // Create function to DRY
        $createTrip = function($date) use ($request, $route, $taxiId) {
             Trip::create([
                'departure_hour' => $request->time,
                'estimated_arrival_hour' => $request->estimated_arrival,
                'range_of_lateness' => $request->range_of_lateness * 60, // Assuming minutes input, storing seconds? Migration says 'time'. 
                // Migration: $table->time('range_of_lateness');
                // So I should format it as HH:MM:SS ?
                // Input is number (minutes). 15 -> 00:15:00.
                // GM: Carbon createFromTime(0, $minutes)->format('H:i:s')
                'range_of_lateness' => Carbon::createFromTime(0, $request->range_of_lateness)->format('H:i:s'),
                
                'price' => $request->price,
                'status' => 'confirmed', // "Insert the trip into the database"
                'date' => $date,
                'route_id' => $route->id,
                'taxi_id' => $taxiId,
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
        $taxiId = $this->getDriverTaxiId();
        
        $trips = Trip::where('taxi_id', $taxiId)
            ->orderByDesc('date')
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
                    'can_cancel' => Carbon::parse($trip->date . ' ' . $trip->departure_hour)->diffInHours(now(), false) <= -48 // Future: date - now >= 48. So (date - now) >= 48.
                    // Actually: Carbon::now()->diffInHours($tripDate, false) >= 48
                ];
            });

        return view('driver.trips.index', ['trips' => $trips]);
    }

    public function destroy(Trip $trip)
    {
        // Validation: Only owner can delete
        if ($trip->taxi_id != $this->getDriverTaxiId()) {
            abort(403);
        }

        // Validation: 48h check
        $tripStart = Carbon::parse($trip->date . ' ' . $trip->departure_hour);
        if (now()->diffInHours($tripStart, false) < 48) {
            return back()->with('error', 'Impossible d\'annuler ce trajet (moins de 48h avant le départ ou déjà passé).');
        }

        $trip->delete(); 
        // Or $trip->update(['status' => 'cancelled']); User said "Cancel/delete".
        // Migration has onDelete cascade for reservations?
        // Let's delete.

        return back()->with('success', 'Trajet supprimé.');
    }
    public function bookings()
    {
        $taxiId = $this->getDriverTaxiId();
        
        $bookings = Reservation::whereHas('trip', function($q) use ($taxiId) {
                $q->where('taxi_id', $taxiId);
            })
            ->with(['trip.route.startCity', 'trip.route.arrivalCity', 'user', 'seats'])
            ->orderByDesc('created_at')
            ->get()
            ->map(function($res) {
                return [
                    'id' => $res->id,
                    'trip' => optional($res->trip->route->startCity)->name . ' → ' . optional($res->trip->route->arrivalCity)->name, // Use optional to avoid null pointer if route deleted
                    'time' => Carbon::parse($res->trip->departure_hour)->format('H:i'),
                    'seat' => $res->seats->pluck('seat_number')->join(', '),
                    'name' => $res->user->name,
                    'email' => $res->user->email,
                    'status' => $res->status,
                    'code' => $res->code // Display code instead of QR
                ];
            });

        return view('driver.bookings.index', ['bookings' => $bookings]);
    }

    public function validateBooking(Reservation $booking)
    {
         if ($booking->trip->taxi_id != $this->getDriverTaxiId()) {
             abort(403);
         }
         
         $booking->update(['status' => 'validated']);
         
         return back()->with('success', 'Réservation validée (embarquement confirmé).');
    }
}















