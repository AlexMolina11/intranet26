<?php

namespace App\Modules\Org\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAreaRequest extends FormRequest
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
        return [
            'id_departamento' => ['required', 'integer', Rule::exists('org_departamentos', 'id_departamento')->whereNull('deleted_at')],
            'id_proyecto' => ['required', 'integer', Rule::exists('org_proyectos', 'id_proyecto')->whereNull('deleted_at')],
            'nombre' => ['required', 'string', 'max:150'],
            'descripcion' => ['nullable', 'string', 'max:255'],
            'activo' => ['nullable', 'boolean'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $id = $this->route('area')->id_area ?? null;

            $existe = \App\Modules\Org\Models\Area::query()
                ->where('id_departamento', $this->id_departamento)
                ->where('id_proyecto', $this->id_proyecto)
                ->whereRaw('LOWER(nombre) = ?', [mb_strtolower($this->nombre)])
                ->where('id_area', '!=', $id)
                ->exists();

            if ($existe) {
                $validator->errors()->add(
                    'nombre',
                    'Ya existe un área con ese nombre para el departamento y proyecto seleccionados.'
                );
            }
        });
    }
}