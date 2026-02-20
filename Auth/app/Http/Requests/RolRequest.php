<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RolRequest extends FormRequest
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
        $isMehodPut = $this->isMethod('put' || $this->isMethod('patch'));

        return [
            'nombre_rol' => $isMehodPut ? 'sometimes|string|unique:roles,nombre_rol,': 'required|string|unique:roles,nombre_rol',
            'descripcion' => $isMehodPut ? 'sometimes|string|': 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre_rol.required' => 'El nombre del rol es obligatorio.',
            'nombre_rol.string' => 'El nombre del rol debe ser una cadena de texto.',
            'nombre_rol.unique' => 'El nombre del rol ya existe.',
            'descripcion.required' => 'La descripción es obligatoria.',
            'descripcion.string' => 'La descripción debe ser una cadena de texto.',
        ];
    }
}
