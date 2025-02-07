<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MiembroRequest extends FormRequest
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
            'nombre' => 'required|string|min:3|max:35',
            'apellidos' => 'required|string|min:3|max:35',
            'fecha_nac' => 'required|date|before:today|after:1945-01-01',
            'grupo_extra' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.string' => 'El nombre debe ser una cadena de texto.',
            'nombre.min' => 'El nombre debe tener al menos 3 caracteres.',
            'nombre.max' => 'El nombre no puede tener más de 35 caracteres.',
            'apellidos.required' => 'Los apellidos son obligatorios.',
            'apellidos.string' => 'Los apellidos deben ser una cadena de texto.',
            'apellidos.min' => 'Los apellidos deben tener al menos 3 caracteres.',
            'apellidos.max' => 'Los apellidos no pueden tener más de 35 caracteres.',
            'fecha_nac.required' => 'La fecha de nacimiento es obligatoria.',
            'fecha_nac.date' => 'La fecha de nacimiento debe ser una fecha válida.',
            'fecha_nac.before' => 'La fecha de nacimiento debe ser anterior a hoy.',
            'fecha_nac.after' => 'La fecha de nacimiento debe ser posterior al 1 de enero de 1945.',
            'grupo_extra.string' => 'El grupo extra debe ser una cadena de texto.',
        ];
    }
}
