@extends('layouts.app')

@section('title', 'Editar área')

@section('content')
    <div class="card">
        <h1 style="margin-top:0;">Editar área</h1>

        <form method="POST" action="{{ route('org.areas.update', $area) }}">
            @csrf
            @method('PUT')

            @include('org.areas._form', ['area' => $area])

            <div style="margin-top:20px; display:flex; gap:8px;">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('org.areas.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection