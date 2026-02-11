<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Administrateur',
            'email' => 'admin@taxiapp.com',
            'password' => 'admin123', 
            'role' => 'admin',
            'isValidated' => true,
        ]);

        $driver = User::create([
            'name' => 'Chauffeur Jean',
            'email' => 'driver@taxiapp.com',
            'password' => 'driver123',
            'role' => 'driver',
            'isValidated' => true,
        ]);

        $passenger = User::create([
            'name' => 'Passager Marie',
            'email' => 'passenger@taxiapp.com',
            'password' => 'passenger123',
            'role' => 'passenger',
            'isValidated' => true,
        ]);
    }
}
