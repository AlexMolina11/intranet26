<?php

namespace App\Modules\Seg\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Modules\Seg\Models\Permiso;

class UpdatePermisoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'codigo' => $this->codigo ? trim(strtolower($this->codigo)) : null,
            'nombre' => $this->nombre ? trim($this->nombre) : null,
            'descripcion' => $this->descripcion ? trim($this->descripcion) : null,
        ]);
    }

    public function rules(): array
    {
        /** @var Permiso $permiso */
        $permiso = $this->route('permiso');

        return [
            'id_sistema' => ['required', 'exists:seg_sistemas,id_sistema'],
            'codigo' => [
                'required',
                'string',
                'max:150',
                Rule::unique('seg_permisos', 'codigo')
                    ->ignore($permiso->id_permiso, 'id_permiso')
                    ->whereNull('deleted_at'),
            ],
            'nombre' => ['required', 'string', 'max:150'],
            'descripcion' => ['nullable', 'string', 'max:255'],
        ];
    }
}