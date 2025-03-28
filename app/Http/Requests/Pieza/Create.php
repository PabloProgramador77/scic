<?php

namespace App\Http\Requests\Pieza;

use Illuminate\Foundation\Http\FormRequest;

class Create extends FormRequest
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
            
            'nombre' => 'required|string',
            'alto' => 'required|numeric',
            'largo' => 'required|numeric',
            'descripcion' => 'string|nullable',
            'idModelo' => 'required|integer',
            'cantidad' => 'required|integer',
            'suaje' => 'required|string',
            
        ];
    }
}
