<!-- ======= Sidebar ======= -->

<aside id="sidebar" class="sidebar">
@if($config['menus'])
    <ul class="sidebar-nav" id="sidebar-nav">
        @foreach($config['menus'] as $menu)
        <li class="nav-item">
            <a
                class="nav-link {{ request()->is( \Illuminate\Support\Str::replace('.index', '', $menu['path']) . '*' ) ? 'active' : '' }} @if($menu['children']){{'collapsed'}}@endif"
                @if($menu['children'])data-bs-target="#{{ \Illuminate\Support\Str::replace('.', '', $menu['path']) }}-nav" data-bs-toggle="collapse" href="#" @else href="{{ route($menu['path']) }}" @endif>
                @if($menu['icon'])
                <i class="{{ $menu['icon'] }}"></i>
                @endif
                <span>{{ $menu['title'] }}</span>
                @if($menu['children'])
                    <i class="bi bi-chevron-down ms-auto"></i>
                @endif
            </a>
            @if($menu['children'])
                @include('widgets._includes._menu_children', ['menus' => $menu['children'], 'id' => \Illuminate\Support\Str::replace('.', '', $menu['path'])])
            @endif
        </li><!-- End Dashboard Nav -->
        @endforeach

    </ul>
@endif
</aside><!-- End Sidebar-->
