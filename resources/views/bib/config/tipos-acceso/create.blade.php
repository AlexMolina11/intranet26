@extends('layouts.app')

@section('title', 'Crear Tipo de acceso')

@section('content')
    <div class="card">
        <form method="POST" action="{{ route('bib.config.tipos-acceso.store') }}">
            @csrf
            @include('bib.config.tipos-acceso._form', ['tipoAcceso' => null])

            <div class="page-header-actions" style="margin-top:16px;">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('bib.config.tipos-acceso.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection