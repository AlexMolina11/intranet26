<?php

namespace App\Modules\Seg\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class StoreUsuarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombres' => ['required', 'string', 'max:150'],
            'apellidos' => ['required', 'string', 'max:150'],
            'correo' => ['required', 'email', 'max:150', 'unique:seg_usuarios,correo'],
            'clave' => ['required', 'string', 'min:8', 'confirmed'],
            'activo' => ['nullable', 'boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'correo' => $this->correo ? mb_strtolower(trim($this->correo)) : null,
            'activo' => $this->boolean('activo'),
        ]);
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if (!$this->correo) {
                return;
            }

            $prefijo = strtolower(strtok($this->correo, '@'));

            $existe = DB::table('seg_usuarios')
                ->where('nombre_usuario', $prefijo)
                ->exists();

            if ($existe) {
                $validator->errors()->add(
                    'correo',
                    'El prefijo del correo ya está siendo usado como nombre de usuario por otro registro.'
                );
            }
        });
    }

    public function messages(): array
    {
        return [
            'nombres.required' => 'Los nombres son obligatorios.',
            'apellidos.required' => 'Los apellidos son obligatorios.',
            'correo.required' => 'El correo es obligatorio.',
            'correo.email' => 'Debe ingresar un correo válido.',
            'correo.unique' => 'Ya existe un usuario con ese correo.',
            'clave.required' => 'La contraseña es obligatoria.',
            'clave.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'clave.confirmed' => 'La confirmación de la contraseña no coincide.',
        ];
    }
}