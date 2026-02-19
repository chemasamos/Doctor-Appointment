<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpecialitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $specialities = [
            'Cardiología',
            'Pediatría',
            'Neurología',
            'Dermatología',
            'Oftalmología',
            'Traumatología',
            'Ginecología',
            'Psiquiatría',
        ];

        foreach ($specialities as $speciality) {
            DB::table('specialities')->insertOrIgnore([
                'name' => $speciality,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
