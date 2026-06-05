<header class="app-topbar">
    <div class="topbar-left">
        <button type="button" class="sidebar-toggle" id="sidebarToggle">
            ☰
        </button>

        <button type="button" class="sidebar-mobile-toggle" id="sidebarMobileToggle">
            ☰
        </button>

        <div>
            <h1 class="topbar-title">@yield('page-title', 'Intranet 2026')</h1>
            <p class="topbar-subtitle">@yield('page-subtitle', 'Sistema institucional')</p>
        </div>
    </div>

    <div class="topbar-right">
        @auth
            @php
                $usuario = auth()->user();
            @endphp

            <button type="button" class="notification-toggle-btn" id="notificationToggle" title="Notificaciones">
                🔔

                @if(($notificacionesGlobalesPendientes ?? 0) > 0)
                    <span class="notification-badge">
                        {{ $notificacionesGlobalesPendientes > 99 ? '99+' : $notificacionesGlobalesPendientes }}
                    </span>
                @endif
            </button>

            <div class="topbar-user">
                <div class="topbar-user-info">
                    <strong>{{ $usuario->nombre_completo ?? $usuario->nombres ?? 'Usuario' }}</strong>
                    <small>{{ $usuario->correo }}</small>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-danger">
                        Salir
                    </button>
                </form>
            </div>
        @endauth
    </div>
</header>