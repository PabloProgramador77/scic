<?php

namespace App\Http\Requests\CotizacionHasNumeraciones;

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
            
            'numeraciones' => 'required|array',
            'pares' => 'required|array',
            'montos' => 'required|array',
            'dias' => 'required|integer',

        ];
    }
}
