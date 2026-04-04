@extends('layouts.app')

@section('title', 'Editar Tipo de acceso')

@section('content')
    <div class="card">
        <form method="POST" action="{{ route('bib.config.tipos-acceso.update', $tipoAcceso) }}">
            @csrf
            @method('PUT')
            @include('bib.config.tipos-acceso._form', ['tipoAcceso' => $tipoAcceso])

            <div class="page-header-actions" style="margin-top:16px;">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('bib.config.tipos-acceso.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection