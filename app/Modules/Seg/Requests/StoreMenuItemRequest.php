<?php

namespace App\Modules\Seg\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMenuItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'nombre' => $this->nombre ? trim($this->nombre) : null,
            'ruta' => $this->ruta ? trim($this->ruta) : null,
            'icono' => $this->icono ? trim($this->icono) : null,
            'permiso_requerido' => $this->permiso_requerido ? trim($this->permiso_requerido) : null,
            'visible' => $this->boolean('visible'),
            'es_externo' => $this->boolean('es_externo'),
            'abre_nueva_pestana' => $this->boolean('abre_nueva_pestana'),
            'id_menu_item_padre' => $this->id_menu_item_padre ?: null,
            'permiso_requerido' => $this->permiso_requerido ?: null,
        ]);
    }

    public function rules(): array
    {
        return [
            'id_sistema' => ['required', 'exists:seg_sistemas,id_sistema'],
            'id_menu' => ['required', 'exists:seg_menus,id_menu'],
            'id_menu_item_padre' => ['nullable', 'exists:seg_menu_items,id_menu_item'],
            'nombre' => ['required', 'string', 'max:150'],
            'ruta' => ['required', 'string', 'max:255'],
            'icono' => ['nullable', 'string', 'max:100'],
            'orden' => ['required', 'integer', 'min:1'],
            'visible' => ['nullable', 'boolean'],
            'es_externo' => ['nullable', 'boolean'],
            'abre_nueva_pestana' => ['nullable', 'boolean'],
            'permiso_requerido' => [
                'nullable',
                'string',
                'max:150',
                Rule::exists('seg_permisos', 'codigo'),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'id_sistema.required' => 'El sistema es obligatorio.',
            'id_menu.required' => 'El menú es obligatorio.',
            'nombre.required' => 'El nombre de la opción es obligatorio.',
            'ruta.required' => 'La ruta es obligatoria.',
            'orden.required' => 'El orden es obligatorio.',
            'permiso_requerido.exists' => 'El permiso requerido seleccionado no es válido.',
        ];
    }
}