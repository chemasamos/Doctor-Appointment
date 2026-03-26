<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Patient;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Validators\Failure;
use Illuminate\Support\Facades\Hash;
use Throwable;

class PatientsImport implements ToModel, WithHeadingRow, SkipsOnError, SkipsOnFailure
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Soporte para los headers solicitados y también los de prueba (español)
        $email = $row['email'] ?? $row['correo'] ?? null;
        if (empty($email)) {
            return null; // Skip silently if no email is provided
        }

        // 1. Verificar si ya existe un User con ese email, si existe skip
        if (User::where('email', $email)->exists()) {
            return null;
        }

        // Mapeo flexible de datos
        $name = $row['name'] ?? $row['nombre_completo'] ?? null;
        $phone = $row['phone'] ?? $row['telefono'] ?? null;
        $address = $row['address'] ?? null;
        $id_number = $row['id_number'] ?? null;
        $allergies = $row['allergies'] ?? $row['alergias'] ?? null;

        // 2. Crear User
        $user = User::create([
            'name'      => $name,
            'email'     => $email,
            'password'  => Hash::make('Password123!'),
            'phone'     => $phone,
            'address'   => $address,
            'id_number' => $id_number,
        ]);

        // 3. Asignar rol: Paciente
        $user->assignRole('Paciente');

        // 4. Crear Patient
        return Patient::create([
            'user_id'   => $user->id,
            'allergies' => $allergies,
        ]);
    }

    public function onError(Throwable $e)
    {
        // simplemente return (skip silencioso)
    }

    public function onFailure(Failure ...$failures)
    {
        // simplemente return (skip silencioso)
    }
}
