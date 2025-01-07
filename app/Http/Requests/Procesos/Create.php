<?php

namespace App\Http\Requests\Procesos;

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
            
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['string', 'max:255', 'nullable'],
            'orden' => ['required', 'integer'],
            
        ];
    }
}
