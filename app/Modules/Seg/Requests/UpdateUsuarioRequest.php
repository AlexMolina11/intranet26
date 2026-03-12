<?php

namespace App\Modules\Seg\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UpdateUsuarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $idUsuario = $this->route('usuario')->id_usuario ?? null;

        return [
            'nombres' => ['required', 'string', 'max:150'],
            'apellidos' => ['required', 'string', 'max:150'],
            'correo' => [
                'required',
                'email',
                'max:150',
                Rule::unique('seg_usuarios', 'correo')->ignore($idUsuario, 'id_usuario'),
            ],
            'clave' => ['nullable', 'string', 'min:8', 'confirmed'],
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
            $idUsuario = $this->route('usuario')->id_usuario ?? null;

            $existe = DB::table('seg_usuarios')
                ->where('nombre_usuario', $prefijo)
                ->where('id_usuario', '!=', $idUsuario)
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
            'clave.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'clave.confirmed' => 'La confirmación de la contraseña no coincide.',
        ];
    }
}