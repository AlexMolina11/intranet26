<?php

namespace App\Modules\Org\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUsuarioOrganizacionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_area_principal' => [
                'nullable',
                'integer',
                Rule::exists('org_areas', 'id_area')->whereNull('deleted_at'),
            ],
            'areas_secundarias' => ['nullable', 'array'],
            'areas_secundarias.*' => [
                'integer',
                'distinct',
                Rule::exists('org_areas', 'id_area')->whereNull('deleted_at'),
            ],
        ];
    }

    protected function prepareForValidation(): void
    {
        $secundarias = $this->input('areas_secundarias', []);

        if (!is_array($secundarias)) {
            $secundarias = [];
        }

        $secundarias = array_values(array_filter($secundarias, function ($valor) {
            return $valor !== null && $valor !== '';
        }));

        $this->merge([
            'areas_secundarias' => $secundarias,
        ]);
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $principal = $this->input('id_area_principal');
            $secundarias = $this->input('areas_secundarias', []);

            if ($principal && in_array((string) $principal, array_map('strval', $secundarias), true)) {
                $validator->errors()->add(
                    'areas_secundarias',
                    'El área principal no puede repetirse como área secundaria.'
                );
            }
        });
    }

    public function messages(): array
    {
        return [
            'id_area_principal.exists' => 'El área principal seleccionada no es válida.',
            'areas_secundarias.array' => 'Las áreas secundarias deben enviarse como arreglo.',
            'areas_secundarias.*.exists' => 'Una de las áreas secundarias seleccionadas no es válida.',
            'areas_secundarias.*.distinct' => 'No puede repetir áreas secundarias.',
        ];
    }
}