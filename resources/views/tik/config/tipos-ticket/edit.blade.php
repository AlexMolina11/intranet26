@extends('layouts.app')

@section('title', 'Editar Tipo de Ticket')

@section('content')
    <div class="page-header">
        <div class="page-header-text">
            <h1 style="margin:0;">Editar Tipo de Ticket</h1>
            <p class="page-subtitle">Actualización del catálogo</p>
        </div>
    </div>

    <div class="card">
        <form method="POST" action="{{ route('tik.config.tipos-ticket.update', $tipoTicket->id_tipo_ticket) }}">
            @csrf
            @method('PUT')
            @include('tik.config.tipos-ticket._form')

            <div class="page-header-actions" style="margin-top:16px;">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('tik.config.tipos-ticket.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection