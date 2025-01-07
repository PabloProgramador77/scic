<?php

namespace App\Http\Requests\Actividades;

use Illuminate\Foundation\Http\FormRequest;

class Create extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            
            'nombre' => 'required|string',
            'descripcion' => 'string|nullable',
            'orden' => 'required|integer',
            'duracion' => 'required|integer',
            'idProceso' => 'required|integer',
            'idUsuario' => 'required|integer',
            'tipo' => 'required|string',
            
        ];
    }
}
