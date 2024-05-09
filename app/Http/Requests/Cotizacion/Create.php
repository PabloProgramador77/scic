<?php

namespace App\Http\Requests\Cotizacion;

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
            
            'nombre' => 'string|nullable',
            'telefono' => 'string|nullable',
            'domicilio' => 'string|nullable',
            'email' => 'string|email|nullable',
            'modelo' => 'required|integer',
            'total' => 'required|numeric',
            'piezas' => 'required|array',
            'piezas.*' => 'integer',
            'materiales' => 'required|array',
            'materiales.*' => 'integer',
            'costos' => 'required|array',
            'costos.*' => 'integer',
            'consumibles' => 'required|array',
            'consumibles.*' => 'integer',
            'suelas' => 'required|array',
            'suelas.*' => 'integer',
            
        ];
    }
}
