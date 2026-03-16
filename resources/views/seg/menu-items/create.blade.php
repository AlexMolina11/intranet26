@extends('layouts.app')

@section('title', 'Crear opción de menú')

@section('content')
    <div class="card">
        <h1>Nueva opción de menú</h1>

        <form method="POST" action="{{ route('seg.menu-items.store') }}">
            @csrf

            @include('seg.menu-items.partials.form')

            <div class="stack-mobile" style="margin-top:20px;">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('seg.menu-items.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection