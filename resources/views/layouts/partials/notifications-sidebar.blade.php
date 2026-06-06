@auth
    <div class="notification-panel-backdrop" id="notificationPanelBackdrop"></div>

    <aside class="notification-panel" id="notificationPanel">
        <div class="notification-panel-header">
            <div>
                <h5 class="mb-0">Notificaciones</h5>
                <small class="text-muted">
                    {{ $notificacionesGlobalesPendientes ?? 0 }} pendiente(s)
                </small>
            </div>

            <button type="button" class="btn btn-sm btn-secondary" id="notificationPanelClose">
                Cerrar
            </button>
        </div>

        <div class="notification-panel-body">
            @if(($notificacionesGlobales ?? collect())->isNotEmpty())
                @foreach($notificacionesGlobales as $notificacion)
                    <div class="notification-item">
                        <div class="notification-item-title">
                            {{ $notificacion->titulo }}
                        </div>

                        <div class="notification-item-message">
                            {{ $notificacion->mensaje }}
                        </div>

                        <div class="notification-item-meta mb-2">
                            {{ optional($notificacion->fecha_notificacion)->format('d/m/Y') }}
                            · {{ str_replace('_', ' ', $notificacion->tipo) }}
                        </div>

                        @if(Route::has('bib.notificaciones.marcar-leida'))
                            <form method="POST" action="{{ route('bib.notificaciones.marcar-leida', $notificacion) }}">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-primary">
                                    Marcar como leída
                                </button>
                            </form>
                        @endif
                    </div>
                @endforeach
            @else
                <div class="alert alert-light border mb-0">
                    No tienes notificaciones pendientes.
                </div>
            @endif
        </div>
    </aside>
@endauth