<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Trip;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $reservations = [
            [
                'price' => 88.00,
                'status' => 'confirmed',
                'code' => 'ABC123',
                'user_id' => 1,
                'trip_id' => 1,
            ],
            [
                'price' => 132.00,
                'status' => 'confirmed',
                'code' => 'DEF456',
                'user_id' => 2,
                'trip_id' => 2,
            ],
            [
                'price' => 154.00,
                'status' => 'confirmed',
                'code' => 'GHI789',
                'user_id' => 3,
                'trip_id' => 3,
            ],
            [
                'price' => 308.00,
                'status' => 'confirmed',
                'code' => 'JKL012',
                'user_id' => 1,
                'trip_id' => 4,
            ],
        ];

        foreach ($reservations as $reservation) {
            Reservation::create($reservation);
        }
    }
}
