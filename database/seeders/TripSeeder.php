<?php

namespace Database\Seeders;

use App\Models\Route;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class TripSeeder extends Seeder
{
    public function run(): void
    {
        $routes = Route::all();

        $driverIds = User::query()
            ->when(Schema::hasColumn('users', 'role'), fn ($q) => $q->where('role', 'driver'))
            ->pluck('id');

        if ($driverIds->isEmpty()) {
            $driverIds = User::pluck('id');
        }

        foreach ($routes as $route) {
            $driverId = $driverIds->isNotEmpty() ? $driverIds->random() : null;

            Trip::create([
                'departure_hour' => '08:30:00',
                'estimated_arrival_hour' => '11:00:00',
                'range_of_lateness' => '00:20:00',
                'price' => $route->base_price * 1.1,
                'status' => 'confirmed',
                'date' => now()->addDays(1)->toDateString(),
                'route_id' => $route->id,
                'driver_id' => $driverId,
            ]);

            Trip::create([
                'departure_hour' => '14:00:00',
                'estimated_arrival_hour' => '16:30:00',
                'range_of_lateness' => '00:15:00',
                'price' => $route->base_price * 1.05,
                'status' => 'confirmed',
                'date' => now()->addDays(2)->toDateString(),
                'route_id' => $route->id,
                'driver_id' => $driverId,
            ]);
        }
    }
}
