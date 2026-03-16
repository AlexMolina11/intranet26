@extends('layouts.app')

@section('title', 'Crear permiso')

@section('content')
    <div class="card">
        <h1>Nuevo permiso</h1>

        <form method="POST" action="{{ route('seg.permisos.store') }}">
            @csrf

            @include('seg.permisos.partials.form')

            <div class="stack-mobile" style="margin-top:20px;">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('seg.permisos.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection