<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = ['Casablanca', 'Agadir', 'Rabat', 'Marrakech', 'Fès', 'Tanger', 'Oujda', 'Meknès','Tétouan' ,'Safi'];
        
        foreach ($cities as $cityName) {
            City::create(['name' => $cityName]);
        }
    }
}
