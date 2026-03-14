<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrescriptionItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'consultation_id',
        'medication_name',
        'dosage',
        'frequency_duration',
    ];

    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }
}
