<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Route;
use App\Models\City;
use App\Models\Reservation;
use App\Models\Trip;
        use Illuminate\Support\Carbon;


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
            ->get();
        
        return view('admin.drivers.pending', ['drivers' => $drivers]);
    }

    public function validateDriver(User $driver)
    {
        $driver->update(['isValidated' => true]);
        return redirect()->route('admin.drivers.pending')
            ->with('success', 'Chauffeur validé avec succès !');
    }
    public function rejectDriver(User $driver)
    {
        $driver->delete();
        return redirect()->route('admin.drivers.pending')
            ->with('success', 'Chauffeur rejeté !');
    }
    public function showDriver(User $driver)
    {
        return view('admin.drivers.show', ['driver' => $driver]);
    }

    public function listDrivers()
    {
        $drivers = User::where('role', 'driver')->get();
        return view('admin.drivers.list', ['drivers' => $drivers]);
    }

    public function deleteDriver(User $driver)
    {
        $driver->delete();
        
        return redirect()->route('admin.drivers.list')
            ->with('success', 'Chauffeur supprimé avec succès !');
    }

    public function listRoutes()
    {
        $routes = Route::with('startCity', 'arrivalCity')->get();
        return view('admin.routes.list', ['routes' => $routes]);
    }

    public function deleteRoute(Route $route)
    {
        $route->delete();
        return redirect()->route('admin.routes.list')
            ->with('success', 'Route supprimée avec succès !');
    }

    public function createRoute()
    {
        $cities = City::all();
        return view('admin.routes.create', ['cities' => $cities]);
    }

    public function storeRoute(Request $request)
    {
        $request->validate([
            'start_city_id' => 'required|exists:cities,id',
            'arrival_city_id' => 'required|exists:cities,id|different:start_city_id',
            'base_price' => 'required|numeric',
        ]);
        
        $exists = Route::where('start_city_id', $request->start_city_id)
        ->where('arrival_city_id', $request->arrival_city_id)
        ->exists();

        if ($exists) {
            return back()->with('error', 'Cette route existe déjà !');
        }
        Route::create([
            'start_city_id' => $request->start_city_id,
            'arrival_city_id' => $request->arrival_city_id,
            'base_price' => $request->base_price,
        ]);
        return redirect()->route('admin.dashboard')->with('success', 'Route créée avec succès !');
    }
}


