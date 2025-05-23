<?php

namespace App\Http\Requests\Cliente;

use Illuminate\Foundation\Http\FormRequest;

class Store extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if( auth()->user()->id ){

            return true;

        }else{

            return false;

        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            
            'numero' => 'required|string',
            'nombre' => 'required|string',
            'telefono' => 'required|string',
            'email' => 'string|nullable',
            'estado' => 'string|nullable',
            'ciudad' => 'string|nullable',
            'colonia' => 'string|nullable',
            'calle' => 'string|nullable',
            'exterior' => 'string|nullable',
            'cp' => 'string|nullable',
            'empresa' => 'string|nullable',
            'razon' => 'string|nullable',
            'rfc' => 'string|nullable',
            
        ];
    }
}
