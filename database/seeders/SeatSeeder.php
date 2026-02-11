<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Seat;
use App\Models\Taxi;

class SeatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $taxis = Taxi::all();
        foreach ($taxis as $taxi) {
            Seat::create([
                'seat_number' => 1,
                'type' => 'front',
                'taxi_id' => $taxi->id,
            ]);

            Seat::create([
                'seat_number' => 2,
                'type' => 'middle',
                'taxi_id' => $taxi->id,
            ]);

            Seat::create([
                'seat_number' => 3,
                'type' => 'middle',
                'taxi_id' => $taxi->id,
            ]);

            Seat::create([
                'seat_number' => 4,
                'type' => 'middle',
                'taxi_id' => $taxi->id,
            ]);

            Seat::create([
                'seat_number' => 5,
                'type' => 'back',
                'taxi_id' => $taxi->id,
            ]);

            Seat::create([
                'seat_number' => 6,
                'type' => 'back',
                'taxi_id' => $taxi->id,
            ]);
        }
    }
}
