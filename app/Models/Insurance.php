<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Insurance extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nombre_empresa',
        'telefono_contacto',
        'notas_adicionales',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Retorna la fecha de registro formateada en español (México).
     * Ejemplo: "15 de enero de 2025"
     *
     * Nota: Se usa Carbon::setLocale() sólo para esta instancia y se
     * demuestra con isoFormat para máxima compatibilidad con ICU locales.
     * La alternativa sería setlocale() global de PHP, pero afecta todo el proceso.
     */
    public function getFechaRegistroAttribute(): string
    {
        return Carbon::parse($this->created_at)
            ->locale('es_MX')
            ->isoFormat('D [de] MMMM [de] YYYY');
    }
}
