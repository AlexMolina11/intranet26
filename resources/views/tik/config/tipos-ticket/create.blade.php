@extends('layouts.app')

@section('title', 'Crear Tipo de Ticket')

@section('content')
    <div class="page-header">
        <div class="page-header-text">
            <h1 style="margin:0;">Crear Tipo de Ticket</h1>
            <p class="page-subtitle">Registro de nuevo tipo de ticket</p>
        </div>
    </div>

    <div class="card">
        <form method="POST" action="{{ route('tik.config.tipos-ticket.store') }}">
            @csrf
            @include('tik.config.tipos-ticket._form')

            <div class="page-header-actions" style="margin-top:16px;">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('tik.config.tipos-ticket.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection