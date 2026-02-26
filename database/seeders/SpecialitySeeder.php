<?php

namespace Database\Seeders;

<<<<<<< HEAD
use App\Models\Speciality;
use Illuminate\Database\Seeder;
=======
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
>>>>>>> 33f65c76ac7969c0e806c7c2a92ab322b5558aa7

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
<<<<<<< HEAD
            'Ortopedia',
            'Ginecología',
            'Psiquiatría',
            'Medicina General',
        ];

        foreach ($specialities as $name) {
            Speciality::firstOrCreate(['name' => $name]);
=======
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
>>>>>>> 33f65c76ac7969c0e806c7c2a92ab322b5558aa7
        }
    }
}
