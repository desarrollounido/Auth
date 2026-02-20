<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'email' => [
                'bail',
                'required',
                'string',
                'email:rfc,dns',
                'max:255',
            ],
            'password' => [
                'bail',
                'required',
                'string',
                'min:8',
                'max:64',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email'    => 'El correo electrónico no es válido.',
            'email.max'      => 'El correo electrónico es demasiado largo.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min'      => 'La contraseña es incorrecta.',
            'password.max'      => 'La contraseña es incorrecta.',
        ];
    }
}
