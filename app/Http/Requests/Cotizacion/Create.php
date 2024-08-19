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
            
            'cliente' => 'required|integer',
            'modelo' => 'required|integer',
            'total' => 'required|numeric',
            'piezas' => 'required|array',
            'piezas.*' => 'integer',
            'materiales' => 'required|array',
            'materiales.*' => 'integer',
            'costos' => 'array|nullable',
            'costos.*' => 'integer|nullable',
            'consumibles' => 'array|nullable',
            'consumibles.*' => 'integer|nullable',
            'suelas' => 'array|nullable',
            'suelas.*' => 'integer|nullable',
            'costes' => 'array|nullable',
            'costes.*' => 'integer|nullable',
            'colores' => 'array|nullable',
            'colores.*' => 'string|nullable',
            'observaciones' => 'string|nullable',
            
        ];
    }
}
