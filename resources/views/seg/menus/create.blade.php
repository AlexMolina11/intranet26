@extends('layouts.app')

@section('title', 'Crear menú')

@section('content')
    <div class="card">
        <h1>Nuevo menú</h1>

        <form method="POST" action="{{ route('seg.menus.store') }}">
            @csrf

            @include('seg.menus.partials.form')

            <div class="stack-mobile" style="margin-top:20px;">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('seg.menus.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection