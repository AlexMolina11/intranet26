<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Intranet 2026')</title>
    <style>
        :root {
            --bg: #f8fafc;
            --surface: #ffffff;
            --text: #0f172a;
            --muted: #64748b;
            --border: #e2e8f0;
            --dark: #0f172a;
            --dark-soft: #1e293b;
            --primary: #2563eb;
            --primary-soft: #dbeafe;
            --danger: #dc2626;
            --success-bg: #dcfce7;
            --success-text: #166534;
            --error-bg: #fee2e2;
            --error-text: #991b1b;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: var(--bg);
            margin: 0;
            padding: 0;
            color: var(--text);
        }

        .topbar {
            background: var(--dark);
            color: white;
            border-bottom: 1px solid #1e293b;
        }

        .topbar-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 10px 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .brand {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .brand a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            font-weight: 700;
            line-height: 1.1;
        }

        .brand span {
            font-size: 12px;
            color: #94a3b8;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .user-pill {
            background: rgba(255,255,255,0.08);
            color: #e2e8f0;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 600;
        }

        .subnav {
            background: white;
            border-bottom: 1px solid var(--border);
        }

        .subnav-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 10px 16px;
            display: flex;
            align-items: center;
            gap: 14px;
            flex-wrap: wrap;
        }

        .nav-section {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .nav-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .04em;
            color: var(--muted);
            margin-right: 2px;
        }

        .nav-divider {
            width: 1px;
            height: 22px;
            background: var(--border);
        }

        .nav-link {
            text-decoration: none;
            color: #334155;
            font-size: 13px;
            font-weight: 600;
            padding: 7px 10px;
            border-radius: 999px;
            transition: 0.2s ease;
        }

        .nav-link:hover {
            background: #f1f5f9;
            color: var(--text);
        }

        .nav-link-active {
            background: var(--primary-soft);
            color: var(--primary);
        }

        .container {
            max-width: 1200px;
            margin: 24px auto;
            padding: 0 16px;
        }

        .card {
            background: var(--surface);
            border-radius: 12px;
            box-shadow: 0 4px 14px rgba(15, 23, 42, 0.06);
            padding: 22px;
        }

        .btn {
            display: inline-block;
            padding: 8px 12px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-secondary {
            background: #475569;
            color: white;
        }

        .btn-warning {
            background: #d97706;
            color: white;
        }

        .btn-danger {
            background: var(--danger);
            color: white;
        }

        .btn-success {
            background: #16a34a;
            color: white;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 18px;
        }

        .table th,
        .table td {
            padding: 12px;
            border-bottom: 1px solid var(--border);
            text-align: left;
            vertical-align: middle;
        }

        .table th {
            background: #f8fafc;
            font-size: 13px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-label {
            display: block;
            margin-bottom: 6px;
            font-weight: 700;
            font-size: 14px;
        }

        .form-control {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            box-sizing: border-box;
            background: white;
        }

        .alert {
            padding: 12px 14px;
            border-radius: 10px;
            margin-bottom: 16px;
            font-size: 14px;
        }

        .alert-success {
            background: var(--success-bg);
            color: var(--success-text);
        }

        .alert-danger {
            background: var(--error-bg);
            color: var(--error-text);
        }

        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
        }

        .badge-success {
            background: #dcfce7;
            color: #166534;
        }

        .badge-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .actions {
            display: flex;
            gap: 8px;
            align-items: center;
            flex-wrap: wrap;
        }

        .inline-form {
            display: inline;
        }

        .text-danger {
            color: #b91c1c;
            font-size: 13px;
            margin-top: 4px;
        }

        small {
            display: block;
            margin-top: 6px;
            color: var(--muted);
        }

        @media (max-width: 768px) {
            .topbar-inner,
            .subnav-inner {
                align-items: flex-start;
                flex-direction: column;
            }

            .nav-divider {
                display: none;
            }

            .nav-section {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="topbar">
            <div class="topbar-inner">
                <div class="brand">
                    <a href="{{ route('dashboard') }}">Intranet 2026</a>
                    <span>Sistema interno institucional</span>
                </div>

                <div class="topbar-right">
                    @auth
                        <span class="user-pill">{{ auth()->user()->nombre_completo }}</span>

                        <form method="POST" action="{{ route('logout') }}" class="inline-form">
                            @csrf
                            <button type="submit" class="btn btn-danger">Cerrar sesión</button>
                        </form>
                    @endauth
                </div>
            </div>
        </div>

        <div class="subnav">
            <div class="subnav-inner">
                <div class="nav-section">
                    <span class="nav-label">Inicio</span>
                    <a href="{{ route('dashboard') }}"
                       class="nav-link {{ request()->routeIs('dashboard') ? 'nav-link-active' : '' }}">
                        Dashboard
                    </a>
                </div>

                <div class="nav-divider"></div>

                <div class="nav-section">
                    <span class="nav-label">Seguridad</span>

                    <a href="{{ route('seg.usuarios.index') }}"
                       class="nav-link {{ request()->routeIs('seg.usuarios.*') ? 'nav-link-active' : '' }}">
                        Usuarios
                    </a>

                    <a href="{{ route('seg.sistemas.index') }}"
                       class="nav-link {{ request()->routeIs('seg.sistemas.*') ? 'nav-link-active' : '' }}">
                        Sistemas
                    </a>

                    <a href="{{ route('seg.permisos.index') }}"
                       class="nav-link {{ request()->routeIs('seg.permisos.*') ? 'nav-link-active' : '' }}">
                        Permisos
                    </a>

                    <a href="{{ route('seg.menus.index') }}"
                       class="nav-link {{ request()->routeIs('seg.menus.*') ? 'nav-link-active' : '' }}">
                        Menús
                    </a>

                    <a href="{{ route('seg.menu-items.index') }}"
                       class="nav-link {{ request()->routeIs('seg.menu-items.*') ? 'nav-link-active' : '' }}">
                        Submenús
                    </a>
                </div>

                <div class="nav-divider"></div>

                <div class="nav-section">
                    <span class="nav-label">Organización</span>

                    <a href="{{ route('org.departamentos.index') }}"
                       class="nav-link {{ request()->routeIs('org.departamentos.*') ? 'nav-link-active' : '' }}">
                        Departamentos
                    </a>

                    <a href="{{ route('org.proyectos.index') }}"
                       class="nav-link {{ request()->routeIs('org.proyectos.*') ? 'nav-link-active' : '' }}">
                        Proyectos
                    </a>

                    <a href="{{ route('org.areas.index') }}"
                       class="nav-link {{ request()->routeIs('org.areas.*') ? 'nav-link-active' : '' }}">
                        Áreas
                    </a>
                </div>
            </div>
        </div>
    </header>

    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        @yield('content')
    </div>
</body>
</html>