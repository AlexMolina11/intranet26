@extends('layouts.app')

@section('title', 'Editar menú')

@section('content')
    <div class="card">
        <h1>Editar menú</h1>

        <form method="POST" action="{{ route('seg.menus.update', $menu) }}">
            @csrf
            @method('PUT')

            @include('seg.menus.partials.form', ['menu' => $menu])

            <div style="margin-top:20px; display:flex; gap:8px;">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('seg.menus.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection