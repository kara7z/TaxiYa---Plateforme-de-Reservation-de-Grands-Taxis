<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Trip;
use App\Models\Route;
use App\Models\Taxi;

class TripSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $routes = Route::all();
        $taxis = Taxi::all();

        foreach ($routes as $route) {
            Trip::create([
                'departure_hour' => '08:30:00',
                'estimated_arrival_hour' => '11:00:00',
                'range_of_lateness' => '00:20:00',
                'price' => $route->base_price * 1.1,
                'status' => 'confirmed',
                'date' => now()->addDays(1),
                'route_id' => $route->id,
                'taxi_id' => $taxis->random()->id,
            ]);

            Trip::create([
                'departure_hour' => '14:00:00',
                'estimated_arrival_hour' => '16:30:00',
                'range_of_lateness' => '00:15:00',
                'price' => $route->base_price * 1.05,
                'status' => 'confirmed',
                'date' => now()->addDays(2),
                'route_id' => $route->id,
                'taxi_id' => $taxis->random()->id,
            ]);
        }
    }
}
