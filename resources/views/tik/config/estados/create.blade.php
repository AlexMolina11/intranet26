@extends('layouts.app')

@section('title', 'Crear Estado')

@section('content')
    <div class="page-header">
        <div class="page-header-text">
            <h1 style="margin:0;">Crear Estado</h1>
            <p class="page-subtitle">Registro de nuevo estado del flujo</p>
        </div>
    </div>

    <div class="card">
        <form method="POST" action="{{ route('tik.config.estados.store') }}">
            @csrf
            @include('tik.config.estados._form')

            <div class="page-header-actions" style="margin-top:16px;">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('tik.config.estados.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection