<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Reservation;

class ReservationSeatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reservation1 = Reservation::find(1);
        $reservation1->seats()->attach([1, 2]);

        $reservation2 = Reservation::find(2);
        $reservation2->seats()->attach([3]);

        $reservation3 = Reservation::find(3);
        $reservation3->seats()->attach([1, 4, 5]);

        $reservation4 = Reservation::find(4);
        $reservation4->seats()->attach([2, 6]);
    }
}
