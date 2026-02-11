<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;
use App\Models\Route;

class RouteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $routes = [
            ['Casablanca', 'Rabat', 80.00],
            ['Casablanca', 'Marrakech', 120.00],
            ['Casablanca', 'Agadir', 280.00],
            ['Casablanca', 'Fès', 150.00],
            ['Rabat', 'Fès', 100.00],
            ['Rabat', 'Tanger', 110.00],
            ['Rabat', 'Meknès', 90.00],
            ['Tanger', 'Tétouan', 60.00],
            ['Tanger', 'Oujda', 180.00],
            ['Marrakech', 'Agadir', 150.00],
            ['Fès', 'Meknès', 40.00],
            ['Meknès', 'Safi', 120.00],
        ];

        foreach ($routes as [$from, $to, $price]) {
            $startCity = City::where('name', $from)->first();
            $arrivalCity = City::where('name', $to)->first();

            Route::create([
                'start_city_id' => $startCity->id,
                'arrival_city_id' => $arrivalCity->id,
                'base_price' => $price,
            ]);
        }
    }
}
