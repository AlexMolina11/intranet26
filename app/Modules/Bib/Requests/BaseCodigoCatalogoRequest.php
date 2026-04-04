<?php

namespace App\Modules\Bib\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

abstract class BaseCodigoCatalogoRequest extends FormRequest
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
            'codigo' => $this->codigo ? strtoupper(trim($this->codigo)) : null,
            'nombre' => $this->nombre ? trim($this->nombre) : null,
            'descripcion' => $this->descripcion ? trim($this->descripcion) : null,
            'orden' => $this->orden ?? 1,
            'activo' => $this->boolean('activo'),
        ]);
    }

    public function rules(): array
    {
        $model = $this->route($this->routeParam());
        $id = $model?->{$this->primaryKey()};

        return [
            'codigo' => [
                'required',
                'string',
                'max:50',
                Rule::unique($this->table(), 'codigo')->ignore($id, $this->primaryKey()),
            ],
            'nombre' => ['required', 'string', 'max:150'],
            'descripcion' => ['nullable', 'string'],
            'orden' => ['required', 'integer', 'min:1'],
            'activo' => ['nullable', 'boolean'],
        ];
    }
}