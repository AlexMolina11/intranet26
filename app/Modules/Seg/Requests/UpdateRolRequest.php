<?php

namespace App\Modules\Seg\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Modules\Seg\Models\Rol;

class UpdateRolRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'nombre' => $this->nombre ? trim($this->nombre) : null,
            'descripcion' => $this->descripcion ? trim($this->descripcion) : null,
            'activo' => $this->boolean('activo'),
        ]);
    }

    public function rules(): array
    {
        $sistema = $this->route('sistema');
        /** @var Rol $rol */
        $rol = $this->route('rol');

        return [
            'nombre' => [
                'required',
                'string',
                'max:120',
                Rule::unique('seg_roles', 'nombre')
                    ->ignore($rol->id_rol, 'id_rol')
                    ->where(function ($query) use ($sistema) {
                        return $query->where('id_sistema', $sistema->id_sistema)
                            ->whereNull('deleted_at');
                    }),
            ],
            'descripcion' => ['nullable', 'string', 'max:255'],
            'activo' => ['required', 'boolean'],
        ];
    }
}