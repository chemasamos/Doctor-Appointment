<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //LLamar al RoleSeeder creado
        $this->call([
            RoleSeeder::class
        ]);

        //Crear un usuario de prueba cada que ejecuto migrations
        User::factory()->create([
            'name' => 'DavidFigV',
            'email' => 'chemasassss@gmail.com',
            'password' => bcrypt('13demayo')
        ]);
    }
}
