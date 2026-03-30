@extends('layouts.app')

@section('title', 'Crear Tipo de Servicio')

@section('content')
    <div class="page-header">
        <div class="page-header-text">
            <h1 style="margin:0;">Crear Tipo de Servicio</h1>
            <p class="page-subtitle">Registro de nuevo tipo de servicio</p>
        </div>
    </div>

    <div class="card">
        <form method="POST" action="{{ route('tik.config.tipos-servicio.store') }}">
            @csrf
            @include('tik.config.tipos-servicio._form')

            <div class="page-header-actions" style="margin-top:16px;">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('tik.config.tipos-servicio.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection