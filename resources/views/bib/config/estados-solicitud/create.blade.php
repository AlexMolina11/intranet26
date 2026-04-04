@extends('layouts.app')

@section('title', 'Crear Estado de solicitud')

@section('content')
    <div class="card">
        <form method="POST" action="{{ route('bib.config.estados-solicitud.store') }}">
            @csrf
            @include('bib.config.estados-solicitud._form', ['estadoSolicitud' => null])

            <div class="page-header-actions" style="margin-top:16px;">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('bib.config.estados-solicitud.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection