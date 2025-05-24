<aside class="main-sidebar elevation-4 sidebar-light-success">
    <!-- Brand Logo -->
    <a href="{{ url('/') }}" class="brand-link bg-success">
        @if ($setting->logo != null)
            <img src="{{ Storage::url($setting->logo) }}" alt="Logo"
                class="brand-image img-circle elevation-3 bg-light" style="opacity: .8">
        @else
            <img src="{{ asset('images/logo-madrasah1.png') }}" alt="Logo"
                class="brand-image img-circle elevation-3 bg-light" style="opacity: .8">
        @endif
        <span class="brand-text font-weight-light">{{ $setting->singkatan }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- User Panel -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                @if (!empty(auth()->user()->foto) && Storage::disk('public')->exists(auth()->user()->foto))
                    <img src="{{ Storage::url(auth()->user()->foto) }}" alt="User Image" class="img-circle elevation-2"
                        style="width: 35px; height: 35px;">
                @else
                    <img src="{{ asset('AdminLTE/dist/img/user1-128x128.jpg') }}" alt="User Image"
                        class="img-circle elevation-2" style="width: 35px; height: 35px;">
                @endif
            </div>
            <div class="info">
                <a href="{{ route('profile.show') }}" class="d-block" data-toggle="tooltip" data-placement="top"
                    title="Edit Profil">
                    {{ auth()->user()->name }}
                    <i class="fas fa-pencil-alt ml-2 text-sm text-primary"></i>
                </a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                {{-- Dashboard --}}
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                {{-- Manage Menu --}}
                {{--  <li class="nav-item">
                    <a href="{{ route('manage-menu.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-list-alt"></i>
                        <p>Manage Menu</p>
                    </a>
                </li>  --}}

                {{-- Website Section --}}
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-globe"></i>
                        <p>
                            Website
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('manage-menu.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Menu</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('halaman.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Halaman Statis</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('kategori.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Kategori</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('berita.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Berita / Artikel</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Galeri</p>
                            </a>
                        </li>
                        {{--  <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Guru & Tenaga Pendidik</p>
                            </a>
                        </li>  --}}
                        {{--  <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Siswa & Alumni</p>
                            </a>
                        </li>  --}}
                        {{--  <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Agenda & Pengumuman</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>PPDB</p>
                            </a>
                        </li>  --}}
                    </ul>
                </li>

                {{-- Users & Permissions --}}
                {{--  <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-users-cog"></i>
                        <p>
                            Pengguna & Hak Akses
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Admin</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Role & Permission</p>
                            </a>
                        </li>
                    </ul>
                </li>  --}}

                {{-- Pengaturan Website --}}
                <li class="nav-item">
                    <a href="{{ route('setting.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>Pengaturan Website</p>
                    </a>
                </li>

                {{-- Backup & Restore --}}
                {{--  <li class="nav-item">
                    <a href="#" class="nav-link {{ request()->routeIs('backup.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-database"></i>
                        <p>Backup & Restore</p>
                    </a>
                </li>  --}}
            </ul>
        </nav>
    </div>
</aside>
