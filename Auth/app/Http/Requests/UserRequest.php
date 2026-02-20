<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isUpdate = $this->isMethod('put') || $this->isMethod('patch');

        return [
            'nombre_usuario' => $isUpdate
                ? 'sometimes|bail|string|max:255|unique:usuarios,nombre_usuario'
                : 'required|bail|string|max:255|unique:usuarios,nombre_usuario',

            'nombre_completo' => $isUpdate
                ? 'sometimes|bail|string|max:255'
                : 'required|bail|string|max:255',

            'email' => $isUpdate
                ? 'sometimes|bail|string|email:rfc,dns|max:255|unique:usuarios,email'
                : 'required|bail|string|email:rfc,dns|max:255|unique:usuarios,email',

            'password' => $isUpdate
                ? 'sometimes|bail|string|min:8|max:64'
                : 'required|bail|string|min:8|max:64',

            'cod_rol' => $isUpdate
                ? 'sometimes|bail|exists:roles,cod_rol'
                : 'required|bail|exists:roles,cod_rol',
        ];
    }

    public function messages(): array
    {
        return [
            // nombre_usuario
            'nombre_usuario.required' => 'El nombre de usuario es obligatorio.',
            'nombre_usuario.string' => 'El nombre de usuario debe ser una cadena de texto.',
            'nombre_usuario.max' => 'El nombre de usuario no puede superar los 255 caracteres.',
            'nombre_usuario.unique' => 'El nombre de usuario ya existe.',

            // nombre_completo
            'nombre_completo.required' => 'El nombre completo es obligatorio.',
            'nombre_completo.string' => 'El nombre completo debe ser una cadena de texto.',
            'nombre_completo.max' => 'El nombre completo no puede superar los 255 caracteres.',

            // email
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.string' => 'El correo electrónico debe ser una cadena de texto.',
            'email.email' => 'El correo electrónico debe ser una dirección válida (formato RFC y dominio existente).',
            'email.max' => 'El correo electrónico no puede superar los 255 caracteres.',
            'email.unique' => 'El correo electrónico ya existe.',

            // password
            'password.required' => 'La contraseña es obligatoria.',
            'password.string' => 'La contraseña debe ser una cadena de texto.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.max' => 'La contraseña no puede superar los 64 caracteres.',

            // cod_rol
            'cod_rol.required' => 'El código del rol es obligatorio.',
            'cod_rol.exists' => 'El código del rol no existe en la base de datos.',
        ];
    }
}