<?php

namespace App\Modules\Bib\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAutorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $nombre = $this->nombre ? trim($this->nombre) : null;
        $apellido = $this->apellido ? trim($this->apellido) : null;

        $this->merge([
            'nombre' => $nombre,
            'apellido' => $apellido,
            'nombre_completo' => trim(collect([$nombre, $apellido])->filter()->implode(' ')),
            'seudonimo' => $this->seudonimo ? trim($this->seudonimo) : null,
            'biografia' => $this->biografia ? trim($this->biografia) : null,
            'activo' => $this->boolean('activo'),
        ]);
    }

    public function rules(): array
    {
        $id = $this->route('autor')?->id_autor;

        return [
            'nombre' => ['required', 'string', 'max:150'],
            'apellido' => ['nullable', 'string', 'max:150'],
            'nombre_completo' => [
                'required',
                'string',
                'max:255',
                Rule::unique('bib_autores', 'nombre_completo')->ignore($id, 'id_autor'),
            ],
            'seudonimo' => ['nullable', 'string', 'max:150'],
            'fecha_nacimiento' => ['nullable', 'date'],
            'fecha_fallecimiento' => ['nullable', 'date', 'after_or_equal:fecha_nacimiento'],
            'biografia' => ['nullable', 'string'],
            'activo' => ['nullable', 'boolean'],
        ];
    }
}