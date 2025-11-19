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
            'name' => 'Chema Samos',
            'email' => 'chemasassss@gmail.com',
            'password' => bcrypt('13demayo'),
            'id_number' => '1234567890',
            'phone' => '5555555555',
            'address' => '123 Main St, Anytown, USA',
        ])->assignRole('Doctor');
    }
}