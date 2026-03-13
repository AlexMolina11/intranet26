@extends('layouts.app')

@section('title', 'Crear sistema')

@section('content')
    <div class="card">
        <h1>Nuevo sistema</h1>

        <form method="POST" action="{{ route('seg.sistemas.store') }}">
            @csrf

            @include('seg.sistemas.partials.form')

            <div style="margin-top:20px; display:flex; gap:8px;">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('seg.sistemas.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection