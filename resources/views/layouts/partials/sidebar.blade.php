<aside class="app-sidebar">
    <div class="sidebar-brand">
        <div class="sidebar-logo">
            I26
        </div>

        <div class="sidebar-brand-text">
            <strong>Intranet 2026</strong>
            <small>Sistema institucional</small>
        </div>
    </div>

    <nav class="sidebar-nav">
        @forelse($navigation ?? [] as $sistema)
            <div class="sidebar-system">
                <div class="sidebar-system-title">
                    @if(!empty($sistema['icono']))
                        <i class="{{ $sistema['icono'] }}"></i>
                    @endif

                    <span>{{ $sistema['nombre'] }}</span>
                </div>

                @foreach($sistema['sidebar_menus'] ?? [] as $menu)
                    <div class="sidebar-menu-title">
                        @if(!empty($menu['icono']))
                            <i class="{{ $menu['icono'] }}"></i>
                        @endif

                        <span>{{ $menu['nombre'] }}</span>
                    </div>

                    @foreach($menu['items'] ?? [] as $item)
                        @php
                            $hasChildren = !empty($item['hijos']);
                        @endphp

                        @if($hasChildren)
                            <div class="sidebar-item-group">
                                <div class="sidebar-link sidebar-link-parent">
                                    @if(!empty($item['icono']))
                                        <i class="{{ $item['icono'] }}"></i>
                                    @endif

                                    <span>{{ $item['nombre'] }}</span>
                                </div>

                                <div class="sidebar-children">
                                    @foreach($item['hijos'] as $child)
                                        <a
                                            href="{{ $child['url'] }}"
                                            class="sidebar-link sidebar-link-child"
                                            @if($child['externo'] && $child['nueva_pestana']) target="_blank" rel="noopener" @endif
                                        >
                                            @if(!empty($child['icono']))
                                                <i class="{{ $child['icono'] }}"></i>
                                            @endif

                                            <span>{{ $child['nombre'] }}</span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <a
                                href="{{ $item['url'] }}"
                                class="sidebar-link"
                                @if($item['externo'] && $item['nueva_pestana']) target="_blank" rel="noopener" @endif
                            >
                                @if(!empty($item['icono']))
                                    <i class="{{ $item['icono'] }}"></i>
                                @endif

                                <span>{{ $item['nombre'] }}</span>
                            </a>
                        @endif
                    @endforeach
                @endforeach
            </div>
        @empty
            <div class="sidebar-empty">
                Sin navegación disponible.
            </div>
        @endforelse
    </nav>
</aside>