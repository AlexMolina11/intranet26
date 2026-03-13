<?php

namespace App\Modules\Seg\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSistemaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $slug = $this->slug;

        if (!$slug && $this->nombre) {
            $slug = \Illuminate\Support\Str::slug($this->nombre);
        }

        $this->merge([
            'codigo' => $this->codigo ? strtoupper(trim($this->codigo)) : null,
            'nombre' => $this->nombre ? trim($this->nombre) : null,
            'slug' => $slug ? \Illuminate\Support\Str::slug($slug) : null,
            'descripcion' => $this->descripcion ? trim($this->descripcion) : null,
            'icono' => $this->icono ? trim($this->icono) : null,
            'url_base' => $this->url_base ? trim($this->url_base) : null,
            'orden' => $this->orden !== null ? (int) $this->orden : 0,
            'activo' => $this->boolean('activo'),
        ]);
    }

    public function rules(): array
    {
        return [
            'codigo' => [
                'required',
                'string',
                'max:30',
                Rule::unique('seg_sistemas', 'codigo')->whereNull('deleted_at'),
            ],
            'nombre' => [
                'required',
                'string',
                'max:120',
                Rule::unique('seg_sistemas', 'nombre')->whereNull('deleted_at'),
            ],
            'slug' => [
                'required',
                'string',
                'max:120',
                Rule::unique('seg_sistemas', 'slug')->whereNull('deleted_at'),
            ],
            'descripcion' => ['nullable', 'string', 'max:255'],
            'icono' => ['nullable', 'string', 'max:100'],
            'url_base' => ['nullable', 'string', 'max:255'],
            'orden' => ['required', 'integer', 'min:0'],
            'activo' => ['required', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'codigo.required' => 'El código es obligatorio.',
            'codigo.unique' => 'Ya existe un sistema con ese código.',
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.unique' => 'Ya existe un sistema con ese nombre.',
            'slug.required' => 'El slug es obligatorio.',
            'slug.unique' => 'Ya existe un sistema con ese slug.',
            'orden.required' => 'El orden es obligatorio.',
        ];
    }
}