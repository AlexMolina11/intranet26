@extends('layouts.app')

@section('title', 'Editar Servicio')

@section('content')
    <div class="page-header">
        <div class="page-header-text">
            <h1 style="margin:0;">Editar Servicio</h1>
            <p class="page-subtitle">Actualización del catálogo</p>
        </div>
    </div>

    <div class="card">
        <form method="POST" action="{{ route('tik.config.servicios.update', $servicio->id_servicio) }}">
            @csrf
            @method('PUT')
            @include('tik.config.servicios._form')

            <div class="page-header-actions" style="margin-top:16px;">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('tik.config.servicios.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection