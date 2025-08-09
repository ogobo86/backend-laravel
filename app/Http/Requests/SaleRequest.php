<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaleRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Validacion
            'sale_date' => 'required|date',
            'email' => 'required|email',
            'concepts' => 'required|array|min:1',
            'concepts.*.quantity'=> 'required|numeric',
            'concepts.*.product_id'=> 'required|exists:product,id'
        ];
    }

    public function messages(){
        return [
            
            'sale_date.required' => 'La fecha es obligatoria',
            'sale_date.date' => 'La fecha debe ser una fecha valida',
            'email.required' => 'El email es obligatorio',
            'email.email'=> 'El emial debe ser un email valido',
            'concepts.required'=> 'Los conceptos son obligatorios',
            'concepts.array' => 'Los conceptos deben ser un arreglo',
            'concepts.min' => 'Debe haber al menos un concepto',
            'concepts.*.quantity.required'=> 'La cantidad es obligatoria',
            'concepts.*.quantity.numeric'=> 'La cantidad debe ser un numero',
            'concepts.*.product_id.required'=> 'El id del producto es obligatorio',
            'concepts.*.product_id.exists'=> 'El id del producto no existe',
        ];
    }
}
