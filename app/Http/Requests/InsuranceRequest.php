<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InsuranceRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado a realizar esta solicitud.
     * La autorización real la gestiona el middleware 'auth:sanctum' en las rutas.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación.
     *
     * Rule::unique con 'ignore' es la solución más robusta para el escenario de edición:
     * descarta la alternativa de unique:insurances,nombre_empresa,{id} en string
     * porque es frágil — si el campo ID cambia de nombre, la regla falla silenciosamente.
     */
    public function rules(): array
    {
        // En edición se pasa el modelo vía route model binding; en creación es null.
        $insurance = $this->route('insurance');

        return [
            'nombre_empresa' => [
                'required',
                'string',
                'max:150',
                Rule::unique('insurances', 'nombre_empresa')
                    ->ignore($insurance?->id)
                    ->whereNull('deleted_at'), // Ignora registros con soft delete
            ],
            'telefono_contacto' => [
                'required',
                'string',
                'max:20',
                'regex:/^[0-9()\-\s\+]+$/',
            ],
            'notas_adicionales' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ];
    }

    /**
     * Mensajes de error personalizados en español (México).
     */
    public function messages(): array
    {
        return [
            'nombre_empresa.required'      => 'El nombre de la empresa es obligatorio.',
            'nombre_empresa.max'           => 'El nombre no puede exceder los 150 caracteres.',
            'nombre_empresa.unique'        => 'Ya existe una aseguradora registrada con ese nombre.',
            'telefono_contacto.required'   => 'El teléfono de contacto es obligatorio.',
            'telefono_contacto.max'        => 'El teléfono no puede exceder los 20 caracteres.',
            'telefono_contacto.regex'      => 'El teléfono solo puede contener números, paréntesis, guiones, espacios y el símbolo +.',
            'notas_adicionales.max'        => 'Las notas no pueden exceder los 1,000 caracteres.',
        ];
    }

    /**
     * Nombres legibles de los campos para los mensajes de validación automáticos.
     */
    public function attributes(): array
    {
        return [
            'nombre_empresa'    => 'nombre de la empresa',
            'telefono_contacto' => 'teléfono de contacto',
            'notas_adicionales' => 'notas adicionales',
        ];
    }
}
