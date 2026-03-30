@extends('layouts.app')

@section('title', 'Crear Flujo')

@section('content')
    <div class="page-header">
        <div class="page-header-text">
            <h1 style="margin:0;">Crear Flujo</h1>
            <p class="page-subtitle">Registro de nuevo flujo de ticket</p>
        </div>
    </div>

    <div class="card">
        <form method="POST" action="{{ route('tik.config.flujos.store') }}">
            @csrf
            @include('tik.config.flujos._form')

            <div class="page-header-actions" style="margin-top:16px;">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('tik.config.flujos.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection