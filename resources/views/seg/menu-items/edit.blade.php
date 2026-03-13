@extends('layouts.app')

@section('title', 'Editar opción de menú')

@section('content')
    <div class="card">
        <h1>Editar opción de menú</h1>

        <form method="POST" action="{{ route('seg.menu-items.update', $menuItem) }}">
            @csrf
            @method('PUT')

            @include('seg.menu-items.partials.form', ['menuItem' => $menuItem])

            <div style="margin-top:20px; display:flex; gap:8px;">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('seg.menu-items.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection