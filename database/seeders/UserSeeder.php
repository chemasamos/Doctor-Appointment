<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;  // ← AGREGAR ESTA LÍNEA

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Crear un usuario de prueba cada que ejecuto migrations
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'id_number' => '0000000000',
            'phone' => '0000000000',
            'address' => 'Admin Address',
        ])->assignRole('Administrador');
    }
}