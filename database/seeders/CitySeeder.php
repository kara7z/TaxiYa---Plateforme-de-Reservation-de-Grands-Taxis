<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = ['Casablanca', 'Agadir', 'Rabat', 'Marrakech', 'Fès', 'Agadir', 'Tanger', 'Oujda', 'Meknès'];
        
        foreach ($cities as $cityName) {
            City::create(['name' => $cityName]);
        }
    }
}
