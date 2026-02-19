<?php

namespace Database\Seeders;

use App\Models\Taxi;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaxiSeeder extends Seeder
{
    public function run(): void
    {
        $driverIds = User::pluck('id');

        if ($driverIds->isEmpty()) {
            return;
        }

        $taxis = [
            ['model' => 'Dacia Logan', 'color' => 'Blanc', 'licence_plate' => '1234-A-99'],
            ['model' => 'Renault Symbol', 'color' => 'Blanc', 'licence_plate' => '5678-B-99'],
            ['model' => 'Hyundai Accent', 'color' => 'Gris', 'licence_plate' => '9012-C-99'],
            ['model' => 'Dacia Duster', 'color' => 'Bleu', 'licence_plate' => '3456-D-99'],
            ['model' => 'Renault Clio', 'color' => 'Rouge', 'licence_plate' => '7890-E-99'],
            ['model' => 'Toyota Corolla', 'color' => 'Noir', 'licence_plate' => '1357-F-99'],
            ['model' => 'Dacia Logan', 'color' => 'Argenté', 'licence_plate' => '2468-G-99'],
            ['model' => 'Renault Kangoo', 'color' => 'Blanc', 'licence_plate' => '8024-H-99'],
        ];

        foreach ($taxis as $taxi) {
            Taxi::updateOrCreate(
                ['licence_plate' => $taxi['licence_plate']],
                [
                    'model' => $taxi['model'],
                    'color' => $taxi['color'],
                    'licence_plate' => $taxi['licence_plate'],
                    'driver_id' => $driverIds->random(),
                ]
            );
        }
    }
}
