@extends('layouts.app')

@section('title', 'Editar Flujo')

@section('content')
    <div class="page-header">
        <div class="page-header-text">
            <h1 style="margin:0;">Editar Flujo</h1>
            <p class="page-subtitle">Actualización de flujo de ticket</p>
        </div>
    </div>

    <div class="card">
        <form method="POST" action="{{ route('tik.config.flujos.update', $flujo->id_flujo_ticket) }}">
            @csrf
            @method('PUT')
            @include('tik.config.flujos._form')

            <div class="page-header-actions" style="margin-top:16px;">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('tik.config.flujos.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection