<div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

    <a href="{{ url('/') }}" class="logo d-flex align-items-center">
        {{--  <img src="{{ asset('NiceSchool/assets/img/logo.webp') }}" alt="">  --}}
        {{--  <i class="bi bi-buildings"></i>  --}}
        <h1 class="sitename">NiceSchool</h1>
    </a>

    <nav id="navmenu" class="navmenu">
        <ul>
            @foreach ($menuParents as $parent)
                @php
                    $children = $menuChildren->where('menu_parent_id', $parent->id);
                @endphp

                @if ($children->count() > 0)
                    <li class="dropdown">
                        <a href="{{ $parent->menu_url }}">
                            <span>{{ $parent->menu_title }}</span>
                            <i class="bi bi-chevron-down toggle-dropdown"></i>
                        </a>
                        <ul>
                            @foreach ($children as $child)
                                <li>
                                    <a href="{{ $child->menu_url }}"
                                        target="{{ $child->menu_target }}">{{ $child->menu_title }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @else
                    <li>
                        <a href="{{ $parent->menu_url }}"
                            target="{{ $parent->menu_target }}">{{ $parent->menu_title }}</a>
                    </li>
                @endif
            @endforeach

            <li><a href="{{ route('login') }}">Login</a></li>
        </ul>
    </nav>


</div>
