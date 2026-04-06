@extends('layouts.app')

@section('title', 'Detalle del recurso')

@section('content')
    <div class="page-header">
        <div class="page-header-text">
            <h1 style="margin:0;">{{ $recurso->titulo_completo }}</h1>
            <p class="page-subtitle">Detalle del recurso bibliográfico</p>
        </div>

        <div class="page-header-actions">
            <a href="{{ route('bib.recursos.index') }}" class="btn btn-secondary">Volver</a>

            @if(auth()->user()->tienePermiso('BIB_RECURSOS_EDITAR'))
                <a href="{{ route('bib.recursos.edit', $recurso) }}" class="btn btn-primary">Editar</a>
            @endif
        </div>
    </div>

    <div class="card" style="margin-bottom:16px;">
        <div class="form-grid form-grid-3">
            <div>
                <strong>Código:</strong><br>
                {{ $recurso->codigo }}
            </div>
            <div>
                <strong>Tipo de recurso:</strong><br>
                {{ $recurso->tipoRecurso?->nombre ?: '-' }}
            </div>
            <div>
                <strong>Estado:</strong><br>
                {{ $recurso->activo ? 'Activo' : 'Inactivo' }}
            </div>
        </div>
    </div>

    <div class="card" style="margin-bottom:16px;">
        <div class="form-grid form-grid-2">
            <div>
                <strong>Título:</strong><br>
                {{ $recurso->titulo }}
            </div>
            <div>
                <strong>Subtítulo:</strong><br>
                {{ $recurso->subtitulo ?: '-' }}
            </div>
            <div>
                <strong>ISBN:</strong><br>
                {{ $recurso->isbn ?: '-' }}
            </div>
            <div>
                <strong>ISSN:</strong><br>
                {{ $recurso->issn ?: '-' }}
            </div>
            <div>
                <strong>Año de publicación:</strong><br>
                {{ $recurso->anio_publicacion ?: '-' }}
            </div>
            <div>
                <strong>Edición:</strong><br>
                {{ $recurso->edicion ?: '-' }}
            </div>
            <div>
                <strong>Número de páginas:</strong><br>
                {{ $recurso->numero_paginas ?: '-' }}
            </div>
            <div>
                <strong>Orden:</strong><br>
                {{ $recurso->orden }}
            </div>
        </div>
    </div>

    <div class="card" style="margin-bottom:16px;">
        <div class="form-grid form-grid-3">
            <div>
                <strong>Editorial:</strong><br>
                {{ $recurso->editorial?->nombre ?: '-' }}
            </div>
            <div>
                <strong>País:</strong><br>
                {{ $recurso->pais?->nombre ?: '-' }}
            </div>
            <div>
                <strong>Idioma:</strong><br>
                {{ $recurso->idioma?->nombre ?: '-' }}
            </div>
            <div>
                <strong>Nivel bibliográfico:</strong><br>
                {{ $recurso->nivelBibliografico?->nombre ?: '-' }}
            </div>
            <div>
                <strong>Tipo de adquisición:</strong><br>
                {{ $recurso->tipoAdquisicion?->nombre ?: '-' }}
            </div>
            <div>
                <strong>Tipo de acceso:</strong><br>
                {{ $recurso->tipoAcceso?->nombre ?: '-' }}
            </div>
        </div>
    </div>

    <div class="card" style="margin-bottom:16px;">
        <div class="form-grid form-grid-2">
            <div>
                <strong>Autores:</strong><br>
                {{ $recurso->autores->isNotEmpty() ? $recurso->autores->pluck('nombre')->join(', ') : '-' }}
            </div>
            <div>
                <strong>Géneros:</strong><br>
                {{ $recurso->generos->isNotEmpty() ? $recurso->generos->pluck('nombre')->join(', ') : '-' }}
            </div>
            <div>
                <strong>Clasificaciones:</strong><br>
                {{ $recurso->clasificaciones->isNotEmpty() ? $recurso->clasificaciones->pluck('nombre')->join(', ') : '-' }}
            </div>
            <div>
                <strong>Etiquetas:</strong><br>
                {{ $recurso->etiquetas->isNotEmpty() ? $recurso->etiquetas->pluck('nombre')->join(', ') : '-' }}
            </div>
        </div>
    </div>

    <div class="card" style="margin-bottom:16px;">
        <div class="form-group">
            <strong>Resumen:</strong>
            <p style="margin-top:8px;">{{ $recurso->resumen ?: 'Sin resumen.' }}</p>
        </div>

        <div class="form-group">
            <strong>Tabla de contenido:</strong>
            <p style="margin-top:8px; white-space: pre-line;">{{ $recurso->tabla_contenido ?: 'Sin tabla de contenido.' }}</p>
        </div>

        <div class="form-group">
            <strong>Notas:</strong>
            <p style="margin-top:8px; white-space: pre-line;">{{ $recurso->notas ?: 'Sin notas.' }}</p>
        </div>
    </div>
@endsection