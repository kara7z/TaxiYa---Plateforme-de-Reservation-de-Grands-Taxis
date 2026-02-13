<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Route;
use App\Models\City;
use App\Models\Reservation;


class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'drivers_pending' => User::where('role', 'driver')
                ->where('isValidated', false) ->count(),
            'trips_today' => Trip::whereDate('date', today())->count(),
            'bookings_today' => Reservation::whereDate('created_at', today())->count(),
        ];
        return view('admin.dashboard', ['stats'=>$stats]);
    }

    public function drivers()
    {
        $drivers = User::where('role', 'driver')
            ->where('isValidated', false)
            ->with('taxi')
            ->get();
        
        return view('admin.drivers', ['drivers' => $drivers]);
    }

    public function validateDriver(User $driver)
    {
        $driver->update(['isValidated' => true]);
        return redirect()->route('admin.drivers.pending')
            ->with('success', 'Chauffeur validé avec succès !');
    }
    public function rejectDriver(User $driver)
    {
        $driver->delete(); // ou $driver->update(['isValidated' => false]);
        return redirect()->route('admin.drivers.pending')
            ->with('success', 'Chauffeur rejeté !');
    }

    // public function routes()
    // {
    //     $cities = City::all();
    //     $routes = Route::with('startCity', 'arrivalCity')->get();
    //     return view('admin.routes', [
    //         'cities' => $cities,
    //         'routes' => $routes,
    //     ]);
    // }

    // public function storeRoute(Request $request)
    // {
    //     Route::create([
    //         'start_city_id' => $request->start_city_id,
    //         'arrival_city_id' => $request->arrival_city_id,
    //         'base_price' => $request->base_price,
    //     ]);
        
    //     return redirect()->back()->with('success', 'Route créée avec succès !');
    // }
}


