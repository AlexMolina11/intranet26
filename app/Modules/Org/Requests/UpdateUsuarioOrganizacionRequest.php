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

    protected function prepareForValidation(): void
    {
        $secundarias = $this->input('secundarias', []);

        if (!is_array($secundarias)) {
            $secundarias = [];
        }

        $secundariasLimpias = [];

        foreach ($secundarias as $fila) {
            if (!is_array($fila)) {
                continue;
            }

            $secundariasLimpias[] = [
                'id_departamento' => $fila['id_departamento'] ?? null,
                'id_proyecto' => $fila['id_proyecto'] ?? null,
                'id_area' => $fila['id_area'] ?? null,
            ];
        }

        $this->merge([
            'principal_id_departamento' => $this->input('principal_id_departamento') ?: null,
            'principal_id_proyecto' => $this->input('principal_id_proyecto') ?: null,
            'principal_id_area' => $this->input('principal_id_area') ?: null,
            'secundarias' => $secundariasLimpias,
        ]);
    }

    public function rules(): array
    {
        return [
            'principal_id_departamento' => [
                'nullable',
                'integer',
                Rule::exists('org_departamentos', 'id_departamento')->whereNull('deleted_at'),
            ],
            'principal_id_proyecto' => [
                'nullable',
                'integer',
                Rule::exists('org_proyectos', 'id_proyecto')->whereNull('deleted_at'),
            ],
            'principal_id_area' => [
                'nullable',
                'integer',
                Rule::exists('org_areas', 'id_area')->whereNull('deleted_at'),
            ],

            'secundarias' => ['nullable', 'array'],
            'secundarias.*.id_departamento' => [
                'nullable',
                'integer',
                Rule::exists('org_departamentos', 'id_departamento')->whereNull('deleted_at'),
            ],
            'secundarias.*.id_proyecto' => [
                'nullable',
                'integer',
                Rule::exists('org_proyectos', 'id_proyecto')->whereNull('deleted_at'),
            ],
            'secundarias.*.id_area' => [
                'nullable',
                'integer',
                Rule::exists('org_areas', 'id_area')->whereNull('deleted_at'),
            ],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $principalDep = $this->input('principal_id_departamento');
            $principalProy = $this->input('principal_id_proyecto');
            $principalArea = $this->input('principal_id_area');

            if (($principalDep || $principalProy || $principalArea) &&
                (!$principalDep || !$principalProy || !$principalArea)) {
                $validator->errors()->add(
                    'principal_id_area',
                    'El área principal debe quedar completamente definida.'
                );
            }

            $secundarias = $this->input('secundarias', []);
            $idsSecundarias = [];

            foreach ($secundarias as $index => $fila) {
                $tieneAlgo = !empty($fila['id_departamento']) || !empty($fila['id_proyecto']) || !empty($fila['id_area']);

                if (!$tieneAlgo) {
                    continue;
                }

                if (empty($fila['id_departamento']) || empty($fila['id_proyecto']) || empty($fila['id_area'])) {
                    $validator->errors()->add(
                        "secundarias.$index.id_area",
                        'Cada área secundaria debe quedar completamente definida.'
                    );
                    continue;
                }

                $idsSecundarias[] = (string) $fila['id_area'];
            }

            if ($principalArea && in_array((string) $principalArea, $idsSecundarias, true)) {
                $validator->errors()->add(
                    'principal_id_area',
                    'El área principal no puede repetirse como secundaria.'
                );
            }

            if (count($idsSecundarias) !== count(array_unique($idsSecundarias))) {
                $validator->errors()->add(
                    'secundarias',
                    'No puede repetir áreas secundarias.'
                );
            }
        });
    }

    public function messages(): array
    {
        return [
            'principal_id_departamento.exists' => 'El departamento principal seleccionado no es válido.',
            'principal_id_proyecto.exists' => 'El proyecto principal seleccionado no es válido.',
            'principal_id_area.exists' => 'El área principal resuelta no es válida.',
            'secundarias.array' => 'Las áreas secundarias deben enviarse como lista.',
        ];
    }
}