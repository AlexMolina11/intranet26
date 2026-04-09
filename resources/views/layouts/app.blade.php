<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Intranet 2026')</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        :root {
            --topbar-height: 64px;
            --sidebar-width: 280px;
            --sidebar-collapsed-width: 88px;

            --color-primary-dark: #385506;
            --color-primary: #779123;
            --color-accent: #a0c525;
            --color-neutral: #656264;
            --color-white: #ffffff;
            --color-black: #000000;

            --color-bg: #f6f8f2;
            --color-surface: #ffffff;
            --color-surface-soft: #f3f5ed;
            --color-border: #d7ddd0;
            --color-text: #1f2937;
            --color-text-soft: #656264;

            --color-sidebar: #385506;
            --color-sidebar-soft: #4a6b0e;
            --color-topbar: #385506;

            --color-success-bg: #edf7d7;
            --color-success-text: #385506;

            --color-danger-bg: #f5f1f2;
            --color-danger-text: #656264;

            --shadow-card: 0 8px 24px rgba(0, 0, 0, 0.08);
            --radius: 12px;
            --radius-sm: 8px;
        }

        * {
            box-sizing: border-box;
        }

        html, body {
            margin: 0;
            padding: 0;
            min-height: 100%;
        }

        body {
            font-family: Arial, sans-serif;
            background: var(--color-bg);
            color: var(--color-text);
        }

        a {
            color: inherit;
        }

        .topbar {
            position: sticky;
            top: 0;
            z-index: 1200;
            height: var(--topbar-height);
            background: var(--color-topbar);
            color: var(--color-white);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 0 16px;
            border-bottom: 1px solid rgba(255,255,255,0.12);
        }

        .topbar-left,
        .topbar-center,
        .topbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
        }

        .topbar-left {
            flex: 0 0 auto;
        }

        .topbar-center {
            flex: 1 1 auto;
            min-width: 0;
        }

        .topbar-right {
            flex: 0 0 auto;
        }

        .topbar-brand a {
            color: var(--color-white);
            text-decoration: none;
            font-size: 20px;
            font-weight: bold;
            white-space: nowrap;
        }

        .sidebar-toggle,
        .mobile-menu-toggle {
            border: 1px solid rgba(255, 255, 255, 0.14);
            background: transparent;
            color: var(--color-white);
            width: 40px;
            height: 40px;
            border-radius: 10px;
            cursor: pointer;
            font-size: 18px;
        }

        .mobile-menu-toggle {
            display: none;
        }

        .topbar-system-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border-radius: 999px;
            background: rgba(255,255,255,0.10);
            color: rgba(255,255,255,0.95);
            font-size: 13px;
            font-weight: 600;
            white-space: nowrap;
        }

        .topbar-nav {
            display: flex;
            align-items: center;
            gap: 8px;
            min-width: 0;
            overflow-x: auto;
            scrollbar-width: thin;
        }

        .topbar-nav-group {
            position: relative;
        }

        .topbar-nav-button {
            border: 1px solid rgba(255,255,255,0.14);
            background: transparent;
            color: var(--color-white);
            min-height: 40px;
            padding: 0 14px;
            border-radius: 10px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            font-weight: 600;
            white-space: nowrap;
        }

        .topbar-nav-button:hover,
        .topbar-nav-group.open .topbar-nav-button {
            background: rgba(255,255,255,0.12);
        }

        .topbar-dropdown {
            position: absolute;
            top: calc(100% + 10px);
            left: 0;
            min-width: 420px;
            max-width: min(720px, calc(100vw - 32px));
            background: var(--color-surface);
            color: var(--color-text);
            border-radius: 12px;
            box-shadow: var(--shadow-card);
            border: 1px solid var(--color-border);
            padding: 12px;
            display: none;
            z-index: 1300;
        }

        .topbar-nav-group.open .topbar-dropdown,
        .user-menu.open .topbar-dropdown {
            display: block;
        }

        .topbar-dropdown.right {
            left: auto;
            right: 0;
        }

        .topbar-dropdown-panel {
            display: grid;
            grid-template-columns: repeat(2, minmax(180px, 1fr));
            gap: 8px;
            align-items: start;
        }

        .topbar-dropdown-block {
            min-width: 0;
        }

        .topbar-dropdown-block.full-width {
            grid-column: 1 / -1;
        }

        .topbar-dropdown-link {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 8px;
            text-decoration: none;
            color: var(--color-text);
            font-size: 14px;
            min-width: 0;
        }

        .topbar-dropdown-link-text {
            min-width: 0;
        }

        .topbar-dropdown-link-text strong,
        .topbar-dropdown-link-text small {
            word-break: break-word;
            white-space: normal;
        }

        @media (max-width: 900px) {
            .topbar-dropdown {
                min-width: 300px;
                max-width: min(94vw, 420px);
            }

            .topbar-dropdown-panel {
                grid-template-columns: 1fr;
            }
        }

        .topbar-dropdown-section-title {
            font-size: 12px;
            text-transform: uppercase;
            color: var(--color-text-soft);
            font-weight: bold;
            margin: 4px 8px 8px;
        }

        .topbar-dropdown-link {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 8px;
            text-decoration: none;
            color: var(--color-text);
            font-size: 14px;
        }

        .topbar-dropdown-link:hover {
            background: var(--color-surface-soft);
        }

        .topbar-dropdown-link.active {
            background: rgba(119,145,35,0.16);
            color: var(--color-primary-dark);
            font-weight: bold;
        }

        .topbar-dropdown-link-icon {
            width: 18px;
            min-width: 18px;
            text-align: center;
            margin-top: 1px;
        }

        .topbar-dropdown-link-text {
            min-width: 0;
        }

        .topbar-dropdown-link-text strong {
            display: block;
            font-size: 14px;
        }

        .topbar-dropdown-link-text small {
            display: block;
            color: var(--color-text-soft);
            margin-top: 2px;
        }

        .user-menu {
            position: relative;
        }

        .user-trigger {
            border: 1px solid rgba(255,255,255,0.14);
            background: transparent;
            color: var(--color-white);
            min-height: 40px;
            padding: 0 12px;
            border-radius: 10px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            max-width: 320px;
        }

        .user-trigger:hover,
        .user-menu.open .user-trigger {
            background: rgba(255,255,255,0.12);
        }

        .user-avatar {
            width: 34px;
            height: 34px;
            border-radius: 999px;
            background: rgba(255,255,255,0.16);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .user-summary {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            min-width: 0;
        }

        .user-summary strong,
        .user-summary small {
            max-width: 220px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .user-summary small {
            color: rgba(255,255,255,0.82);
        }

        .app-shell {
            display: flex;
            min-height: calc(100vh - var(--topbar-height));
        }

        .sidebar-backdrop {
            display: none;
        }

        .sidebar {
            width: var(--sidebar-width);
            flex-shrink: 0;
            background: var(--color-sidebar);
            color: #eef4dd;
            padding: 16px 12px;
            border-right: 1px solid rgba(0, 0, 0, 0.08);
            overflow-y: auto;
            transition: width 0.2s ease, transform 0.2s ease;
        }

        body.sidebar-collapsed .sidebar {
            width: var(--sidebar-collapsed-width);
        }

        .sidebar-section {
            margin-bottom: 18px;
        }

        .sidebar-system {
            font-size: 12px;
            text-transform: uppercase;
            color: #d7e8a9;
            font-weight: bold;
            margin: 18px 8px 8px;
            line-height: 1.3;
        }

        .sidebar-menu-title {
            display: flex;
            align-items: center;
            font-size: 13px;
            color: #e5efd0;
            font-weight: bold;
            margin: 12px 8px 6px;
            line-height: 1.3;
        }

        .sidebar-menu-title-icon {
            width: 18px;
            min-width: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 8px;
            font-size: 14px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #f8fbef;
            text-decoration: none;
            padding: 10px 12px;
            border-radius: 8px;
            margin-bottom: 4px;
            font-size: 14px;
            min-height: 40px;
            transition: background 0.2s ease, color 0.2s ease;
        }

        .nav-link:hover {
            background: var(--color-sidebar-soft);
        }

        .nav-link.active {
            background: var(--color-accent);
            color: var(--color-black);
            font-weight: bold;
        }

        .nav-link-icon {
            width: 20px;
            min-width: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        .nav-link-label {
            display: inline-block;
            min-width: 0;
            word-break: break-word;
        }

        .nav-submenu {
            margin-left: 14px;
            padding-left: 10px;
            border-left: 1px solid rgba(255,255,255,0.2);
            margin-bottom: 8px;
        }

        .nav-submenu .nav-link {
            font-size: 13px;
            padding: 8px 10px;
            min-height: 36px;
        }

        body.sidebar-collapsed .sidebar-system,
        body.sidebar-collapsed .sidebar-menu-title,
        body.sidebar-collapsed .nav-submenu,
        body.sidebar-collapsed .nav-link-label {
            display: none;
        }

        body.sidebar-collapsed .nav-link {
            justify-content: center;
            padding: 10px;
        }

        body.sidebar-collapsed .nav-link-icon {
            margin: 0;
        }

        .content {
            flex: 1;
            min-width: 0;
            padding: 24px;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .page-header-text h1 {
            margin: 0;
            font-size: 28px;
            color: var(--color-primary-dark);
        }

        .page-subtitle {
            margin: 6px 0 0 0;
            color: var(--color-text-soft);
            font-size: 14px;
        }

        .page-header-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .card {
            background: var(--color-surface);
            border-radius: var(--radius);
            box-shadow: var(--shadow-card);
            padding: 24px;
            margin-bottom: 20px;
            overflow: hidden;
            border: 1px solid rgba(56, 85, 6, 0.08);
        }

        .card-section {
            border: 1px solid var(--color-border);
            border-radius: 10px;
            padding: 16px;
            margin-bottom: 16px;
            background: #fbfcf7;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 14px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            min-height: 40px;
            white-space: nowrap;
        }

        .btn-primary {
            background: var(--color-primary);
            color: var(--color-white);
        }

        .btn-primary:hover {
            background: var(--color-primary-dark);
        }

        .btn-secondary {
            background: var(--color-neutral);
            color: var(--color-white);
        }

        .btn-secondary:hover {
            filter: brightness(0.95);
        }

        .btn-warning {
            background: var(--color-accent);
            color: var(--color-black);
        }

        .btn-warning:hover {
            filter: brightness(0.95);
        }

        .btn-danger {
            background: #4b4a4b;
            color: var(--color-white);
        }

        .btn-danger:hover {
            background: #3b3a3b;
        }

        .btn-success {
            background: var(--color-primary-dark);
            color: var(--color-white);
        }

        .btn-success:hover {
            filter: brightness(1.05);
        }

        .alert {
            padding: 12px 14px;
            border-radius: 8px;
            margin-bottom: 16px;
            font-size: 14px;
        }

        .alert-success {
            background: var(--color-success-bg);
            color: var(--color-success-text);
            border: 1px solid rgba(56, 85, 6, 0.14);
        }

        .alert-danger {
            background: var(--color-danger-bg);
            color: var(--color-danger-text);
            border: 1px solid rgba(101, 98, 100, 0.14);
        }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: bold;
        }

        .badge-success {
            background: #edf7d7;
            color: #385506;
        }

        .badge-danger {
            background: #ece9ea;
            color: #4b4a4b;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            border: 1px solid var(--color-border);
            border-radius: 10px;
        }

        .table {
            width: 100%;
            min-width: 760px;
            border-collapse: collapse;
            background: var(--color-white);
        }

        .table th,
        .table td {
            padding: 12px;
            border-bottom: 1px solid #e6ebdf;
            text-align: left;
            vertical-align: top;
            font-size: 14px;
        }

        .table th {
            background: var(--color-surface-soft);
            white-space: nowrap;
            color: var(--color-primary-dark);
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }

        .form-grid-1 {
            grid-template-columns: 1fr;
        }

        .form-group {
            margin-bottom: 16px;
            min-width: 0;
        }

        .form-label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
            font-size: 14px;
            color: var(--color-primary-dark);
        }

        .form-control {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #cdd6c1;
            border-radius: 8px;
            background: var(--color-white);
            font-size: 14px;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px rgba(119, 145, 35, 0.15);
        }

        .text-danger {
            color: #5a5759;
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

        .stack-mobile {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 16px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: var(--color-white);
            border-radius: 12px;
            padding: 20px;
            box-shadow: var(--shadow-card);
            border: 1px solid rgba(56, 85, 6, 0.08);
        }

        .stat-title {
            color: var(--color-text-soft);
            font-size: 14px;
            margin-bottom: 8px;
        }

        .stat-value {
            font-size: 30px;
            font-weight: bold;
            color: var(--color-primary-dark);
        }

        .system-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 16px;
        }

        .system-card {
            border: 1px solid var(--color-border);
            border-radius: 12px;
            padding: 16px;
            background: var(--color-white);
        }

        .quick-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .badge-soft {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: bold;
        }

        @media (max-width: 1180px) {
            .topbar-center {
                display: none;
            }
        }

        @media (max-width: 1024px) {
            .content {
                padding: 20px;
            }

            .card {
                padding: 20px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 900px) {
            .mobile-menu-toggle {
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }

            .sidebar-toggle {
                display: none;
            }

            .sidebar-backdrop {
                position: fixed;
                inset: var(--topbar-height) 0 0 0;
                background: rgba(0, 0, 0, 0.45);
                z-index: 1000;
            }

            .sidebar {
                position: fixed;
                top: var(--topbar-height);
                left: 0;
                bottom: 0;
                width: min(86vw, 320px);
                z-index: 1100;
                transform: translateX(-100%);
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            }

            body.mobile-sidebar-open .sidebar {
                transform: translateX(0);
            }

            body.mobile-sidebar-open .sidebar-backdrop {
                display: block;
            }

            body.sidebar-collapsed .sidebar {
                width: min(86vw, 320px);
            }

            body.sidebar-collapsed .sidebar-system,
            body.sidebar-collapsed .sidebar-menu-title,
            body.sidebar-collapsed .nav-submenu,
            body.sidebar-collapsed .nav-link-label {
                display: initial;
            }

            body.sidebar-collapsed .nav-link {
                justify-content: flex-start;
                padding: 10px 12px;
            }

            .content {
                width: 100%;
                padding: 16px;
            }

            .user-summary {
                display: none;
            }

            .page-header-text h1 {
                font-size: 24px;
            }
        }

        @media (max-width: 640px) {
            .topbar {
                padding: 0 12px;
            }

            .topbar-brand a {
                font-size: 18px;
            }

            .content {
                padding: 12px;
            }

            .card {
                padding: 16px;
                border-radius: 10px;
            }

            .btn {
                width: 100%;
            }

            .page-header-actions,
            .actions,
            .stack-mobile {
                width: 100%;
            }

            .page-header-actions > *,
            .actions > *,
            .stack-mobile > * {
                width: 100%;
            }

            .table {
                min-width: 680px;
            }
        }
    </style>
</head>
<body>
    @php
        $activeSystem = !empty($activeSystemCode)
            ? collect($navigation)->firstWhere('codigo', $activeSystemCode)
            : null;

        $sidebarSystems = !empty($activeSystemCode)
            ? collect($navigation)
            : collect($navigation);

        $topbarMenus = $activeSystem['topbar_menus'] ?? [];
        $sidebarMenus = $activeSystem['sidebar_menus'] ?? [];
        $currentUser = auth()->user();

        $userInitials = $currentUser
            ? collect(explode(' ', trim($currentUser->nombre_completo ?? 'U')))
                ->filter()
                ->take(2)
                ->map(fn ($part) => mb_strtoupper(mb_substr($part, 0, 1)))
                ->implode('')
            : 'U';

        $canEditOwnUser = $currentUser
            && Route::has('seg.usuarios.edit')
            && method_exists($currentUser, 'tienePermiso')
            && $currentUser->tienePermiso('USUARIOS_EDITAR');
    @endphp

    <header class="topbar">
        <div class="topbar-left">
            <button type="button" class="mobile-menu-toggle" id="mobileMenuToggle" aria-label="Abrir menú">
                ☰
            </button>

            <button type="button" class="sidebar-toggle" id="sidebarToggle" aria-label="Comprimir sidebar">
                ☰
            </button>

            <div class="topbar-brand">
                <a href="{{ route('dashboard') }}">Intranet 2026</a>
            </div>

            @if ($activeSystem)
                <div class="topbar-system-badge">
                    @if(!empty($activeSystem['icono']))
                        <i class="{{ $activeSystem['icono'] }}"></i>
                    @endif
                    <span>{{ $activeSystem['nombre'] }}</span>
                </div>
            @endif
        </div>

        <div class="topbar-center">
            @if (!empty($topbarMenus))
                <nav class="topbar-nav">
                    @foreach ($topbarMenus as $menu)
                        <div class="topbar-nav-group" data-dropdown-group>
                            <button type="button" class="topbar-nav-button">
                                @if(!empty($menu['icono']))
                                    <i class="{{ $menu['icono'] }}"></i>
                                @endif
                                <span>{{ $menu['nombre'] }}</span>
                                <i class="fa-solid fa-chevron-down" style="font-size:12px;"></i>
                            </button>

                            <div class="topbar-dropdown">
                                <div class="topbar-dropdown-section-title">{{ $menu['nombre'] }}</div>

                                <div class="topbar-dropdown-panel">
                                    @foreach ($menu['items'] as $item)
                                        @php
                                            $isActive = !$item['externo'] && !empty($item['route_name']) && request()->routeIs($item['route_name']);
                                            $hasChildren = !empty($item['hijos']);
                                        @endphp

                                        @if (!$hasChildren)
                                            <div class="topbar-dropdown-block">
                                                <a
                                                    href="{{ $item['url'] }}"
                                                    class="topbar-dropdown-link {{ $isActive ? 'active' : '' }}"
                                                    @if($item['externo'] && $item['nueva_pestana']) target="_blank" @endif
                                                >
                                                    <span class="topbar-dropdown-link-icon">
                                                        @if(!empty($item['icono']))
                                                            <i class="{{ $item['icono'] }}"></i>
                                                        @else
                                                            <i class="fa-solid fa-circle"></i>
                                                        @endif
                                                    </span>
                                                    <span class="topbar-dropdown-link-text">
                                                        <strong>{{ $item['nombre'] }}</strong>
                                                    </span>
                                                </a>
                                            </div>
                                        @else
                                            <div class="topbar-dropdown-block full-width">
                                                <div class="topbar-dropdown-section-title" style="margin-top: 4px;">
                                                    {{ $item['nombre'] }}
                                                </div>

                                                <div class="topbar-dropdown-panel">
                                                    @foreach ($item['hijos'] as $child)
                                                        <div class="topbar-dropdown-block">
                                                            <a
                                                                href="{{ $child['url'] }}"
                                                                class="topbar-dropdown-link {{ !$child['externo'] && !empty($child['route_name']) && request()->routeIs($child['route_name']) ? 'active' : '' }}"
                                                                @if($child['externo'] && $child['nueva_pestana']) target="_blank" @endif
                                                            >
                                                                <span class="topbar-dropdown-link-icon">
                                                                    @if(!empty($child['icono']))
                                                                        <i class="{{ $child['icono'] }}"></i>
                                                                    @else
                                                                        <i class="fa-regular fa-circle"></i>
                                                                    @endif
                                                                </span>
                                                                <span class="topbar-dropdown-link-text">
                                                                    <strong>{{ $child['nombre'] }}</strong>
                                                                </span>
                                                            </a>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </nav>
            @endif
        </div>

        <div class="topbar-right">
            @auth
                <div class="user-menu" id="userMenu" data-dropdown-group>
                    <button type="button" class="user-trigger">
                        <span class="user-avatar">{{ $userInitials }}</span>
                        <span class="user-summary">
                            <strong>{{ auth()->user()->nombre_completo }}</strong>
                            <small>{{ auth()->user()->correo }}</small>
                        </span>
                        <i class="fa-solid fa-chevron-down" style="font-size:12px;"></i>
                    </button>

                    <div class="topbar-dropdown right">
                        <div class="topbar-dropdown-section-title">Usuario</div>

                        <div class="topbar-dropdown-link" style="cursor:default;">
                            <span class="topbar-dropdown-link-icon">
                                <i class="fa-solid fa-user"></i>
                            </span>
                            <span class="topbar-dropdown-link-text">
                                <strong>{{ auth()->user()->nombre_completo }}</strong>
                                <small>{{ auth()->user()->correo }}</small>
                            </span>
                        </div>

                        @if ($canEditOwnUser)
                            <a href="{{ route('seg.usuarios.edit', auth()->user()) }}" class="topbar-dropdown-link">
                                <span class="topbar-dropdown-link-icon">
                                    <i class="fa-solid fa-user-pen"></i>
                                </span>
                                <span class="topbar-dropdown-link-text">
                                    <strong>Editar mi usuario</strong>
                                    <small>Actualizar datos de la cuenta</small>
                                </span>
                            </a>
                        @endif

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button
                                type="submit"
                                class="topbar-dropdown-link"
                                style="width:100%; border:none; background:none; text-align:left; cursor:pointer;"
                            >
                                <span class="topbar-dropdown-link-icon">
                                    <i class="fa-solid fa-right-from-bracket"></i>
                                </span>
                                <span class="topbar-dropdown-link-text">
                                    <strong>Cerrar sesión</strong>
                                    <small>Salir de la intranet</small>
                                </span>
                            </button>
                        </form>
                    </div>
                </div>
            @endauth
        </div>
    </header>

    <div class="app-shell">
        <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

        <aside class="sidebar" id="appSidebar">
            <div class="sidebar-section">
                <a href="{{ route('dashboard') }}"
                   class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <span class="nav-link-icon">
                        <i class="fa-solid fa-house"></i>
                    </span>
                    <span class="nav-link-label">Dashboard general</span>
                </a>
            </div>

            @if (!empty($activeSystemCode))
                @if ($activeSystem)
                    <div class="sidebar-system">{{ $activeSystem['nombre'] }}</div>

                    @foreach ($sidebarMenus as $menu)
                        <div class="sidebar-menu-title">
                            @if(!empty($menu['icono']))
                                <span class="sidebar-menu-title-icon">
                                    <i class="{{ $menu['icono'] }}"></i>
                                </span>
                            @endif
                            {{ $menu['nombre'] }}
                        </div>

                        @foreach ($menu['items'] as $item)
                            @php
                                $isActive = !$item['externo'] && !empty($item['route_name']) && request()->routeIs($item['route_name']);
                                $hasChildrenActive = collect($item['hijos'])->contains(function ($child) {
                                    return !$child['externo'] && !empty($child['route_name']) && request()->routeIs($child['route_name']);
                                });
                            @endphp

                            <a href="{{ $item['url'] }}"
                               class="nav-link {{ $isActive || $hasChildrenActive ? 'active' : '' }}"
                               @if($item['externo'] && $item['nueva_pestana']) target="_blank" @endif>
                                <span class="nav-link-icon">
                                    @if(!empty($item['icono']))
                                        <i class="{{ $item['icono'] }}"></i>
                                    @else
                                        <i class="fa-solid fa-circle"></i>
                                    @endif
                                </span>
                                <span class="nav-link-label">{{ $item['nombre'] }}</span>
                            </a>

                            @if (!empty($item['hijos']))
                                <div class="nav-submenu">
                                    @foreach ($item['hijos'] as $child)
                                        <a href="{{ $child['url'] }}"
                                           class="nav-link {{ !$child['externo'] && !empty($child['route_name']) && request()->routeIs($child['route_name']) ? 'active' : '' }}"
                                           @if($child['externo'] && $child['nueva_pestana']) target="_blank" @endif>
                                            <span class="nav-link-icon">
                                                @if(!empty($child['icono']))
                                                    <i class="{{ $child['icono'] }}"></i>
                                                @else
                                                    <i class="fa-regular fa-circle"></i>
                                                @endif
                                            </span>
                                            <span class="nav-link-label">{{ $child['nombre'] }}</span>
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    @endforeach
                @else
                    <div style="color:#eef4dd; font-size:14px;">
                        No hay navegación disponible.
                    </div>
                @endif
            @else
                @if (!empty($navigation))
                    <div class="sidebar-system">Sistemas disponibles</div>

                    @foreach ($navigation as $system)
                        @php
                            $firstUrl = null;

                            foreach (($system['sidebar_menus'] ?? $system['menus']) as $menu) {
                                foreach ($menu['items'] as $item) {
                                    if (!empty($item['url'])) {
                                        $firstUrl = $item['url'];
                                        break 2;
                                    }
                                }
                            }
                        @endphp

                        @if ($firstUrl)
                            <a href="{{ $firstUrl }}" class="nav-link">
                                <span class="nav-link-icon">
                                    @if(!empty($system['icono']))
                                        <i class="{{ $system['icono'] }}"></i>
                                    @else
                                        <i class="fa-solid fa-layer-group"></i>
                                    @endif
                                </span>
                                <span class="nav-link-label">{{ $system['nombre'] }}</span>
                            </a>
                        @endif
                    @endforeach
                @else
                    <div style="color:#eef4dd; font-size:14px;">
                        No hay navegación disponible.
                    </div>
                @endif
            @endif
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

    <script>
        (function () {
            const body = document.body;
            const sidebarToggle = document.getElementById('sidebarToggle');
            const mobileMenuToggle = document.getElementById('mobileMenuToggle');
            const sidebarBackdrop = document.getElementById('sidebarBackdrop');

            const desktopStateKey = 'intranet.sidebar.collapsed';

            if (localStorage.getItem(desktopStateKey) === '1' && window.innerWidth > 900) {
                body.classList.add('sidebar-collapsed');
            }

            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function () {
                    body.classList.toggle('sidebar-collapsed');
                    localStorage.setItem(
                        desktopStateKey,
                        body.classList.contains('sidebar-collapsed') ? '1' : '0'
                    );
                });
            }

            if (mobileMenuToggle) {
                mobileMenuToggle.addEventListener('click', function () {
                    body.classList.toggle('mobile-sidebar-open');
                });
            }

            if (sidebarBackdrop) {
                sidebarBackdrop.addEventListener('click', function () {
                    body.classList.remove('mobile-sidebar-open');
                });
            }

            window.addEventListener('resize', function () {
                if (window.innerWidth > 900) {
                    body.classList.remove('mobile-sidebar-open');
                }
            });

            document.addEventListener('click', function (event) {
                const groups = document.querySelectorAll('[data-dropdown-group]');

                groups.forEach(function (group) {
                    if (!group.contains(event.target)) {
                        group.classList.remove('open');
                    }
                });
            });

            document.querySelectorAll('[data-dropdown-group] > button').forEach(function (button) {
                button.addEventListener('click', function (event) {
                    event.stopPropagation();

                    const group = button.parentElement;
                    const isOpen = group.classList.contains('open');

                    document.querySelectorAll('[data-dropdown-group]').forEach(function (otherGroup) {
                        otherGroup.classList.remove('open');
                    });

                    if (!isOpen) {
                        group.classList.add('open');
                    }
                });
            });
        })();
    </script>
</body>
</html>