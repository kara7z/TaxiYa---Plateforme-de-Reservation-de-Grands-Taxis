<?php

namespace Database\Seeders;

use App\Models\Seat;
use App\Models\Taxi;
use Illuminate\Database\Seeder;

class TaxiSeeder extends Seeder
{
    public function run(): void
    {
        $taxis = [
            ['model' => 'Dacia Logan', 'color' => 'Blanc', 'licence_plate' => '1234-A-99'],
            ['model' => 'Renault Symbol', 'color' => 'Blanc', 'licence_plate' => '5678-B-99'],
            ['model' => 'Hyundai Accent', 'color' => 'Gris', 'licence_plate' => '9012-C-99'],
            ['model' => 'Dacia Duster', 'color' => 'Bleu', 'licence_plate' => '3456-D-99'],
            ['model' => 'Renault Clio', 'color' => 'Rouge', 'licence_plate' => '7890-E-99'],
            ['model' => 'Toyota Corolla', 'color' => 'Noir', 'licence_plate' => '1357-F-99'],
        ];

        foreach ($taxis as $data) {
            $taxi = Taxi::updateOrCreate(
                ['licence_plate' => $data['licence_plate']],
                ['model' => $data['model'], 'color' => $data['color']]
            );

            for ($i = 1; $i <= 6; $i++) {
                Seat::updateOrCreate(
                    ['taxi_id' => $taxi->id, 'seat_number' => $i],
                    ['type' => $i === 1 ? 'front' : 'back']
                );
            }
        }
    }
}

