<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Trip;
use App\Models\Reservation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    /**
     * Display a listing of the user's reservations.
     */
    public function index()
    {
        $bookings = Reservation::with(['trip.route.startCity', 'trip.route.arrivalCity', 'trip.taxi', 'trip.driver', 'seats'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('pages.booking.index', compact('bookings'));
    }

    /**
     * Store a newly created reservation in storage.
     */
    public function store(Request $request, Trip $trip)
    {
        $request->validate([
            'seats' => 'required|array|min:1',
            'seats.*' => 'exists:seats,id',
            'email' => 'required|email'
        ]);
        
        if (auth()->user()->role === 'driver') {
            return back()->withErrors(['seats' => 'En tant que chauffeur, vous ne pouvez pas effectuer de réservations.']);
        }

        $isAlreadyTaken = DB::table('reservation_seat')
            ->join('reservations', 'reservation_seat.reservation_id', '=', 'reservations.id')
            ->where('reservations.trip_id', $trip->id)
            ->whereIn('seat_id', $request->seats)
            ->exists();

        if ($isAlreadyTaken) {
            return back()->withErrors(['seats' => 'Désolé, un des sièges vient d\'être réservé par quelqu\'un d\'autre.']);
        }

        DB::transaction(function () use ($request, $trip) {
            $reservation = Reservation::create([
                'user_id' => auth()->id(),
                'trip_id' => $trip->id,
                'status'  => 'pending', 
                'price'   => count($request->seats) * $trip->price,
                'code'    => 'TX-' . strtoupper(Str::random(6)), 
            ]);

            $reservation->seats()->attach($request->seats);
        });

        return redirect()->route('booking.success')->with('success', 'Votre réservation a été enregistrée !');
    }
}