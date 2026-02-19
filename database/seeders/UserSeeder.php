<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@taxiapp.com'],
            [
                'name' => 'Administrateur',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'isValidated' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'driver@taxiapp.com'],
            [
                'name' => 'Chauffeur Jean',
                'password' => Hash::make('driver123'),
                'role' => 'driver',
                'isValidated' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'passenger@taxiapp.com'],
            [
                'name' => 'Passager Marie',
                'password' => Hash::make('passenger123'),
                'role' => 'passenger',
                'isValidated' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'rihabsabri21@gmail.com'],
            [
                'name' => 'Rihab',
                'password' => Hash::make('rihabsabri21@gmail.com'),
                'role' => 'passenger',
                'isValidated' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'rihab@gmail.com'],
            [
                'name' => 'Rihab',
                'password' => Hash::make('rihab@gmail.com'),
                'role' => 'passenger',
                'isValidated' => true,
            ]
        );
    }
}
