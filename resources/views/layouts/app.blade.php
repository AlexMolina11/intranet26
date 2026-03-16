<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Intranet 2026')</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f8fafc;
            color: #0f172a;
        }

        .topbar {
            height: 64px;
            background: #0f172a;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            border-bottom: 1px solid #1e293b;
        }

        .topbar-brand a {
            color: white;
            text-decoration: none;
            font-size: 20px;
            font-weight: bold;
        }

        .topbar-user {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .app-shell {
            display: grid;
            grid-template-columns: 290px 1fr;
            min-height: calc(100vh - 64px);
        }

        .sidebar {
            background: #111827;
            color: #e5e7eb;
            padding: 18px 14px;
            border-right: 1px solid #1f2937;
            overflow-y: auto;
        }

        .sidebar-section {
            margin-bottom: 20px;
        }

        .sidebar-system {
            font-size: 12px;
            text-transform: uppercase;
            color: #93c5fd;
            font-weight: bold;
            margin: 18px 8px 8px;
        }

        .sidebar-menu-title {
            display: block;
            font-size: 13px;
            color: #9ca3af;
            font-weight: bold;
            margin: 12px 8px 6px;
        }

        .nav-link {
            display: block;
            color: #e5e7eb;
            text-decoration: none;
            padding: 10px 12px;
            border-radius: 8px;
            margin-bottom: 4px;
            font-size: 14px;
        }

        .nav-link:hover {
            background: #1f2937;
        }

        .nav-link.active {
            background: #2563eb;
            color: white;
            font-weight: bold;
        }

        .nav-submenu {
            margin-left: 14px;
            padding-left: 10px;
            border-left: 1px solid #374151;
            margin-bottom: 8px;
        }

        .nav-submenu .nav-link {
            font-size: 13px;
            padding: 8px 10px;
        }

        .content {
            padding: 24px;
        }

        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
            padding: 24px;
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            padding: 10px 14px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }

        .btn-danger {
            background: #dc2626;
            color: white;
        }

        .btn-primary {
            background: #2563eb;
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

        .alert {
            padding: 12px 14px;
            border-radius: 8px;
            margin-bottom: 16px;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
        }

        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: bold;
        }

        .badge-success {
            background: #dcfce7;
            color: #166534;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th,
        .table td {
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
            vertical-align: middle;
        }

        .table th {
            background: #f8fafc;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
        }

        .form-control {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            box-sizing: border-box;
        }

        .text-danger {
            color: #b91c1c;
            font-size: 13px;
            margin-top: 4px;
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

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 16px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
        }

        .stat-title {
            color: #64748b;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .stat-value {
            font-size: 30px;
            font-weight: bold;
        }

        .system-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 16px;
        }

        .system-card {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 16px;
        }

        @media (max-width: 900px) {
            .app-shell {
                grid-template-columns: 1fr;
            }

            .sidebar {
                border-right: none;
                border-bottom: 1px solid #1f2937;
            }
        }
    </style>
</head>
<body>
    <header class="topbar">
        <div class="topbar-brand">
            <a href="{{ route('dashboard') }}">Intranet 2026</a>
        </div>

        <div class="topbar-user">
            @auth
                <span>{{ auth()->user()->nombre_completo }}</span>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Cerrar sesión</button>
                </form>
            @endauth
        </div>
    </header>

    <div class="app-shell">
        <aside class="sidebar">
            <div class="sidebar-section">
                <a href="{{ route('dashboard') }}"
                   class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    Dashboard
                </a>
            </div>

            @forelse ($navigation as $system)
                <div class="sidebar-system">{{ $system['nombre'] }}</div>

                @foreach ($system['menus'] as $menu)
                    <div class="sidebar-menu-title">{{ $menu['nombre'] }}</div>

                    @foreach ($menu['items'] as $item)
                        @php
                            $isActive = !$item['externo'] && request()->routeIs($item['route_name']);
                            $hasChildrenActive = collect($item['hijos'])->contains(function ($child) {
                                return !$child['externo'] && request()->routeIs($child['route_name']);
                            });
                        @endphp

                        <a href="{{ $item['url'] }}"
                           class="nav-link {{ $isActive || $hasChildrenActive ? 'active' : '' }}"
                           @if($item['externo'] && $item['nueva_pestana']) target="_blank" @endif>
                            {{ $item['nombre'] }}
                        </a>

                        @if (!empty($item['hijos']))
                            <div class="nav-submenu">
                                @foreach ($item['hijos'] as $child)
                                    <a href="{{ $child['url'] }}"
                                       class="nav-link {{ !$child['externo'] && request()->routeIs($child['route_name']) ? 'active' : '' }}"
                                       @if($child['externo'] && $child['nueva_pestana']) target="_blank" @endif>
                                        {{ $child['nombre'] }}
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    @endforeach
                @endforeach
            @empty
                <div style="color:#9ca3af; font-size:14px;">
                    No hay navegación disponible.
                </div>
            @endforelse
        </aside>

        <main class="content">
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
        </main>
    </div>
</body>
</html>