@extends('layouts.app')

@section('title', 'Editar Estado de solicitud')

@section('content')
    <div class="card">
        <form method="POST" action="{{ route('bib.config.estados-solicitud.update', $estadoSolicitud) }}">
            @csrf
            @method('PUT')
            @include('bib.config.estados-solicitud._form', ['estadoSolicitud' => $estadoSolicitud])

            <div class="page-header-actions" style="margin-top:16px;">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('bib.config.estados-solicitud.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection