<?php

namespace App\Modules\Bib\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

abstract class BaseNombreCatalogoRequest extends FormRequest
{
    abstract protected function table(): string;
    abstract protected function primaryKey(): string;
    abstract protected function routeParam(): string;

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'nombre' => $this->nombre ? trim($this->nombre) : null,
            'descripcion' => $this->descripcion ? trim($this->descripcion) : null,
            'sigla' => $this->sigla ? strtoupper(trim($this->sigla)) : null,
            'sitio_web' => $this->sitio_web ? trim($this->sitio_web) : null,
            'activo' => $this->boolean('activo'),
        ]);
    }

    public function rules(): array
    {
        $model = $this->route($this->routeParam());
        $id = $model?->{$this->primaryKey()};

        return [
            'nombre' => [
                'required',
                'string',
                'max:150',
                Rule::unique($this->table(), 'nombre')->ignore($id, $this->primaryKey()),
            ],
            'descripcion' => ['nullable', 'string'],
            'activo' => ['nullable', 'boolean'],
        ];
    }
}