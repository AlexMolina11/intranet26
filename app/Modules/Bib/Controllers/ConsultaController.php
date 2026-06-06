<?php

namespace App\Modules\Bib\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Bib\Models\Recurso;
use App\Modules\Bib\Models\TipoRecurso;
use Illuminate\Http\Request;

class ConsultaController extends Controller
{
    public function index(Request $request)
    {
        $query = Recurso::query()
            ->with([
                'editorial',
                'tipoRecurso',
                'idioma',
                'autores',
                'ejemplares.estado',
                'ejemplares.disponibilidad',
            ])
            ->withCount([
                'ejemplares as ejemplares_total' => function ($query) {
                    $query->where('activo', true);
                },
                'ejemplares as ejemplares_disponibles' => function ($query) {
                    $query->where('activo', true)
                        ->whereHas('disponibilidad', function ($subquery) {
                            $subquery->where('codigo', 'DISPONIBLE');
                        });
                },
            ])
            ->where('activo', true);

        if ($request->filled('q')) {
            $search = trim($request->q);

            $query->where(function ($subquery) use ($search) {
                $subquery->where('codigo', 'like', "%{$search}%")
                    ->orWhere('titulo', 'like', "%{$search}%")
                    ->orWhere('subtitulo', 'like', "%{$search}%")
                    ->orWhere('isbn', 'like', "%{$search}%")
                    ->orWhere('issn', 'like', "%{$search}%")
                    ->orWhereHas('editorial', function ($editorialQuery) use ($search) {
                        $editorialQuery->where('nombre', 'like', "%{$search}%");
                    })
                    ->orWhereHas('autores', function ($autorQuery) use ($search) {
                        $autorQuery->where('nombre', 'like', "%{$search}%")
                            ->orWhere('apellido', 'like', "%{$search}%")
                            ->orWhere('nombre_completo', 'like', "%{$search}%")
                            ->orWhere('seudonimo', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('id_tipo_recurso')) {
            $query->where('id_tipo_recurso', (int) $request->id_tipo_recurso);
        }

        if ($request->filled('solo_disponibles') && $request->solo_disponibles === '1') {
            $query->whereHas('ejemplares', function ($ejemplarQuery) {
                $ejemplarQuery->where('activo', true)
                    ->whereHas('disponibilidad', function ($disponibilidadQuery) {
                        $disponibilidadQuery->where('codigo', 'DISPONIBLE');
                    });
            });
        }

        $recursos = $query
            ->orderBy('titulo')
            ->paginate(12)
            ->withQueryString();

        $tiposRecurso = TipoRecurso::query()
            ->where('activo', true)
            ->orderBy('nombre')
            ->get();

        return view('bib.consulta.index', compact('recursos', 'tiposRecurso'));
    }
}