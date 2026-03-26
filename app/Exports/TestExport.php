<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;

class TestExport implements FromArray
{
    public function array(): array
    {
        return [
            ['nombre_completo', 'correo', 'telefono', 'fecha_nacimiento', 'tipo_sangre', 'alergias'],
            ['Benito Antonio Martinez Ocasio', 'benito.mtz@example.com', '9991234567', '1994-03-10', 'O+', 'Ninguna'],
            ['Dua Lipa', 'dua.lipa@example.com', '9997654321', '1995-08-22', 'A-', 'Penicilina'],
            ['Stefani Joanne Angelina Germanotta', 'stefani.g@example.com', '9991112233', '1986-03-28', 'B+', 'Ninguna'],
            ['Abel Makkonen Tesfaye', 'abel.tesfaye@example.com', '9994445566', '1990-02-16', 'O-', 'Lactosa'],
            ['Peter Gene Hernandez', 'peter.hernandez@example.com', '9998889900', '1985-10-08', 'AB+', 'Ibuprofeno'],
            ['Shakira Isabel Mebarak Ripoll', 'shakira.m@example.com', '9992223344', '1977-02-02', 'A+', 'Ninguna'],
            ['Harry Edward Styles', 'harry.styles@example.com', '9996667788', '1994-02-01', 'O+', 'Polvo'],
            ['John Peter Petrucci', 'john.petrucci@example.com', '9993334455', '1967-07-12', 'B-', 'Ninguna'],
            ['Aubrey Drake Graham', 'aubrey.graham@example.com', '9995556677', '1986-10-24', 'O+', 'Ninguna'],
        ];
    }
}
