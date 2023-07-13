<ul id="{{ $id }}-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
    @foreach($menus as $menu)
    <li>
        <a href="{{ route($menu['path']) }}">
            <i class="bi bi-circle"></i><span>{{ $menu['title'] }}</span>
        </a>
    </li>
    @endforeach
</ul>
