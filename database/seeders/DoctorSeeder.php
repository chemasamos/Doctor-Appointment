<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\Speciality;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Doctor 1
        $user1 = User::firstOrCreate(
            ['email' => 'doctor1@example.com'],
            [
                'name'       => 'Dr. Juan García',
                'password'   => Hash::make('password'),
                'phone'      => '5551234567',
                'address'    => 'Av. Reforma 100, CDMX',
                'id_number'  => 'DOC0000001',
            ]
        );
        $user1->assignRole('Doctor');

        $speciality1 = Speciality::where('name', 'Cardiología')->first();

        Doctor::firstOrCreate(
            ['user_id' => $user1->id],
            [
                'speciality_id'          => $speciality1->id,
                'medical_license_number' => '1234567',
                'biography'              => 'Cardiólogo con más de 15 años de experiencia en el diagnóstico y tratamiento de enfermedades cardiovasculares.',
            ]
        );

        // Doctor 2
        $user2 = User::firstOrCreate(
            ['email' => 'doctor2@example.com'],
            [
                'name'       => 'Dra. María López',
                'password'   => Hash::make('password'),
                'phone'      => '5557654321',
                'address'    => 'Calle Juárez 200, CDMX',
                'id_number'  => 'DOC0000002',
            ]
        );
        $user2->assignRole('Doctor');

        $speciality2 = Speciality::where('name', 'Pediatría')->first();

        Doctor::firstOrCreate(
            ['user_id' => $user2->id],
            [
                'speciality_id'          => $speciality2->id,
                'medical_license_number' => '7654321',
                'biography'              => 'Pediatra especializada en el cuidado integral de niños y adolescentes, con enfoque en medicina preventiva.',
            ]
        );
    }
}
