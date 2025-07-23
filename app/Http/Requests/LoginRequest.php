<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends ApiFormRequest
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
            // Asignar  Reglas
            'email'=> 'required|string|email|max:255',
            'password'=> 'required|string|min:6'
        ];
    }

    public function messages()
    {
        return [
            'email.required'=>'El correo del usuario es obligatorio.',
            'email.string'=>'El correo debe ser una cadena de texto.',
            'email.email'=>'El correo debe ser un correo valido.',
            'email.max'=>'El correo no puede superar los 255 caracteres.',
            'email.unique'=>'El correo ya esta en uso.',
            'password.required'=>'La contrasenia es obligatoria.',
            'password.string'=>'La contrasenia debe ser una cadena de texto.',
            'password.min'=>'La contrasenia debe tener al menos 6 caracteres.',
        ];
    }
}
