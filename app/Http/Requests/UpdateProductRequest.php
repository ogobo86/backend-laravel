<?php

namespace App\Http\Requests;



class UpdateProductRequest extends ApiFormRequest
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
            // REGLAS
            'name' => 'required|string|max:255',
            'description' => 'required|max:2000',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:category,id'
        ];
    }

    public function messages (){
        return [
                "name.required" => 'El nombre del producto es obligatorio.',
                "name.string" => 'El nombre debe ser una cadea de texto.',
                'name.max' => 'El nombre no puede superar los 255 caracteres.',
                'description.requiered' => 'La descripcion es obligatoria',
                'descroption.max' => 'La descripcion no puede superar los 2000 caracteres.',
                'price.required' => 'El precio es obligatorio.',
                'price.numeric' => 'El precio debe ser un numero.',
                'category_id.required' => 'La categoria es obligatoria.',
                'category_id.exists' => 'La categoria seleccionada no es valida'
        ];
    }


}
