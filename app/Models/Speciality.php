<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Speciality extends Model
{
    use HasFactory;

<<<<<<< HEAD
    protected $fillable = [
        'name',
    ];
=======
    protected $fillable = ['name'];
>>>>>>> 33f65c76ac7969c0e806c7c2a92ab322b5558aa7

    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }
}
