<?php

namespace App\Modules\Bib\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Bib\Models\Autor;
use App\Modules\Bib\Models\Clasificacion;
use App\Modules\Bib\Models\Editorial;
use App\Modules\Bib\Models\Etiqueta;
use App\Modules\Bib\Models\Genero;
use App\Modules\Bib\Models\Idioma;
use App\Modules\Bib\Models\NivelBibliografico;
use App\Modules\Bib\Models\Pais;
use App\Modules\Bib\Models\Recurso;
use App\Modules\Bib\Models\TipoAcceso;
use App\Modules\Bib\Models\TipoAdquisicion;
use App\Modules\Bib\Models\TipoRecurso;
use App\Modules\Bib\Requests\StoreRecursoRequest;
use App\Modules\Bib\Requests\UpdateRecursoRequest;
use Illuminate\Http\Request;

class RecursoController extends Controller
{
    public function index(Request $request)
    {
        $query = Recurso::query()
            ->with([
                'editorial',
                'tipoRecurso',
                'idioma',
                'autores',
            ]);

        if ($request->filled('q')) {
            $search = trim($request->q);

            $query->where(function ($subquery) use ($search) {
                $subquery->where('codigo', 'like', "%{$search}%")
                    ->orWhere('titulo', 'like', "%{$search}%")
                    ->orWhere('subtitulo', 'like', "%{$search}%")
                    ->orWhere('isbn', 'like', "%{$search}%")
                    ->orWhere('issn', 'like', "%{$search}%");
            });
        }

        if ($request->filled('id_tipo_recurso')) {
            $query->where('id_tipo_recurso', (int) $request->id_tipo_recurso);
        }

        if ($request->filled('activo') && $request->activo !== '') {
            $query->where('activo', (bool) $request->activo);
        }

        $recursos = $query
            ->orderBy('titulo')
            ->paginate(15)
            ->withQueryString();

        $tiposRecurso = TipoRecurso::query()
            ->where('activo', true)
            ->orderBy('nombre')
            ->get();

        return view('bib.recursos.index', compact('recursos', 'tiposRecurso'));
    }

    public function create()
    {
        return view('bib.recursos.create', $this->catalogos());
    }

    public function store(StoreRecursoRequest $request)
    {
        $data = $request->validated();

        $recurso = Recurso::create($this->extractMainData($data));

        $this->syncRelations($recurso, $data);

        return redirect()
            ->route('bib.recursos.index')
            ->with('success', 'Recurso bibliográfico creado correctamente.');
    }

    public function show(Recurso $recurso)
    {
        $recurso->load([
            'editorial',
            'pais',
            'idioma',
            'nivelBibliografico',
            'tipoRecurso',
            'tipoAdquisicion',
            'tipoAcceso',
            'autores',
            'generos',
            'clasificaciones',
            'etiquetas',
        ]);

        return view('bib.recursos.show', compact('recurso'));
    }

    public function edit(Recurso $recurso)
    {
        $recurso->load([
            'autores',
            'generos',
            'clasificaciones',
            'etiquetas',
        ]);

        return view('bib.recursos.edit', array_merge(
            $this->catalogos(),
            compact('recurso')
        ));
    }

    public function update(UpdateRecursoRequest $request, Recurso $recurso)
    {
        $data = $request->validated();

        $recurso->update($this->extractMainData($data));

        $this->syncRelations($recurso, $data);

        return redirect()
            ->route('bib.recursos.index')
            ->with('success', 'Recurso bibliográfico actualizado correctamente.');
    }

    protected function catalogos(): array
    {
        return [
            'autores' => Autor::query()->where('activo', true)->orderBy('nombre')->get(),
            'editoriales' => Editorial::query()->where('activo', true)->orderBy('nombre')->get(),
            'clasificaciones' => Clasificacion::query()->where('activo', true)->orderBy('nombre')->get(),
            'generos' => Genero::query()->where('activo', true)->orderBy('nombre')->get(),
            'idiomas' => Idioma::query()->where('activo', true)->orderBy('nombre')->get(),
            'paises' => Pais::query()->where('activo', true)->orderBy('nombre')->get(),
            'nivelesBibliograficos' => NivelBibliografico::query()->where('activo', true)->orderBy('nombre')->get(),
            'tiposRecurso' => TipoRecurso::query()->where('activo', true)->orderBy('nombre')->get(),
            'tiposAdquisicion' => TipoAdquisicion::query()->where('activo', true)->orderBy('nombre')->get(),
            'tiposAcceso' => TipoAcceso::query()->where('activo', true)->orderBy('nombre')->get(),
            'etiquetas' => Etiqueta::query()->where('activo', true)->orderBy('nombre')->get(),
        ];
    }

    protected function extractMainData(array $data): array
    {
        return collect($data)->except([
            'id_autores',
            'id_generos',
            'id_clasificaciones',
            'id_etiquetas',
        ])->toArray();
    }

    protected function syncRelations(Recurso $recurso, array $data): void
    {
        $autores = collect($data['id_autores'] ?? [])
            ->values()
            ->mapWithKeys(fn ($id, $index) => [$id => ['orden' => $index + 1]])
            ->toArray();

        $recurso->autores()->sync($autores);
        $recurso->generos()->sync($data['id_generos'] ?? []);
        $recurso->clasificaciones()->sync($data['id_clasificaciones'] ?? []);
        $recurso->etiquetas()->sync($data['id_etiquetas'] ?? []);
    }
}