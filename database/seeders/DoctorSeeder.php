<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\Speciality;
use App\Models\User;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            // Check if user already has a doctor record (although relationship is hasOne)
            if (!Doctor::where('user_id', $user->id)->exists()) {
                Doctor::create([
                    'user_id' => $user->id,
                    'speciality_id' => Speciality::inRandomOrder()->first()?->id,
                    'medical_license_number' => null,
                    'biography' => null,
                ]);
            }
        }
    }
}
