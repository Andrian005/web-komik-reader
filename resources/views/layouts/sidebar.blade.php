<div class="menu">
    <div class="menu-item">
        <a href="{{ route('dashboard') }}" class="menu-item-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <div class="menu-item-icon">
                <i class="fa fa-desktop"></i>
            </div>
            <span class="menu-item-text">Dashboard</span>
        </a>
    </div>
    <!-- BEGIN Menu Section -->
    <div class="menu-section">
        <div class="menu-section-icon">
            <i class="fa fa-ellipsis-h"></i>
        </div>
        <h2 class="menu-section-text">Manajemen Data</h2>
    </div>
    <!-- END Menu Section -->

    @php
        $manajemenKomikActive = request()->routeIs('dashboard.manajemen-komik.*');
    @endphp

    <div class="menu-item {{ $manajemenKomikActive ? 'active' : '' }}">
        <button class="menu-item-link menu-item-toggle {{ $manajemenKomikActive ? 'active' : '' }}">
            <div class="menu-item-icon">
                <i class="fa fa-book"></i>
            </div>
            <span class="menu-item-text">Manajemen Komik</span>
            <div class="menu-item-addon">
                <i class="menu-item-caret caret"></i>
            </div>
        </button>
        <!-- BEGIN Menu Submenu -->
        <div class="menu-submenu" style="{{ $manajemenKomikActive ? 'display: block;' : '' }}">
            <div class="menu-item">
                <a href="{{ route('dashboard.manajemen-komik.genre.index') }}"
                    class="menu-item-link {{ request()->routeIs('dashboard.manajemen-komik.genre.*') ? 'active' : '' }}">
                    <i class="menu-item-bullet"></i>
                    <span class="menu-item-text">Genre</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="{{ route('dashboard.manajemen-komik.author.index') }}"
                    class="menu-item-link {{ request()->routeIs('dashboard.manajemen-komik.author.*') ? 'active' : '' }}">
                    <i class="menu-item-bullet"></i>
                    <span class="menu-item-text">Author</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="{{ route('dashboard.manajemen-komik.artist.index') }}"
                    class="menu-item-link {{ request()->routeIs('dashboard.manajemen-komik.artist.*') ? 'active' : '' }}">
                    <i class="menu-item-bullet"></i>
                    <span class="menu-item-text">Artist</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="{{ route('dashboard.manajemen-komik.judul.index') }}"
                    class="menu-item-link {{ request()->routeIs('dashboard.manajemen-komik.judul.*') || request()->routeIs('dashboard.manajemen-komik.chapter.*') ? 'active' : '' }}">
                    <i class="menu-item-bullet"></i>
                    <span class="menu-item-text">Judul</span>
                </a>
            </div>
        </div>
        <!-- END Menu Submenu -->
    </div>
</div>
