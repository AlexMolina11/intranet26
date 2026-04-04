@extends('layouts.app')

@section('title', 'Crear Tipo de recurso')

@section('content')
    <div class="card">
        <form method="POST" action="{{ route('bib.config.tipos-recurso.store') }}">
            @csrf
            @include('bib.config.tipos-recurso._form', ['tipoRecurso' => null])

            <div class="page-header-actions" style="margin-top:16px;">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('bib.config.tipos-recurso.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection