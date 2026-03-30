@extends('layouts.app')

@section('title', 'Editar Estado')

@section('content')
    <div class="page-header">
        <div class="page-header-text">
            <h1 style="margin:0;">Editar Estado</h1>
            <p class="page-subtitle">Actualización del catálogo de estados</p>
        </div>
    </div>

    <div class="card">
        <form method="POST" action="{{ route('tik.config.estados.update', $estado->id_estado_ticket) }}">
            @csrf
            @method('PUT')
            @include('tik.config.estados._form')

            <div class="page-header-actions" style="margin-top:16px;">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('tik.config.estados.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection