<div class="menu">
    <div class="menu-item">
        <a href="{{ route('dashboard') }}" class="menu-item-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <div class="menu-item-icon">
                <i class="fa fa-desktop"></i>
            </div>
            <span class="menu-item-text">Dashboard</span>
        </a>
    </div>

    @php
        $masterData = request()->routeIs('dashboard.master-data.*');
    @endphp

    <div class="menu-item {{ $masterData ? 'active' : '' }}">
        <button class="menu-item-link menu-item-toggle {{ $masterData ? 'active' : '' }}">
            <div class="menu-item-icon">
                <i class="fa fa-database"></i>
            </div>
            <span class="menu-item-text">Master Data</span>
            <div class="menu-item-addon">
                <i class="menu-item-caret caret"></i>
            </div>
        </button>
        <div class="menu-submenu" style="{{ $masterData ? 'display: block;' : '' }}">
            <div class="menu-item">
                <a href="{{ route('dashboard.master-data.genre.index') }}"
                    class="menu-item-link {{ request()->routeIs('dashboard.master-data.genre.*') ? 'active' : '' }}">
                    <i class="menu-item-bullet"></i>
                    <span class="menu-item-text">Genre</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="{{ route('dashboard.master-data.author.index') }}"
                    class="menu-item-link {{ request()->routeIs('dashboard.master-data.author.*') ? 'active' : '' }}">
                    <i class="menu-item-bullet"></i>
                    <span class="menu-item-text">Author</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="{{ route('dashboard.master-data.artist.index') }}"
                    class="menu-item-link {{ request()->routeIs('dashboard.master-data.artist.*') ? 'active' : '' }}">
                    <i class="menu-item-bullet"></i>
                    <span class="menu-item-text">Artist</span>
                </a>
            </div>
        </div>
    </div>

    <div class="menu-item">
        <a href="{{ route('dashboard.manage-comics.comic-titles.index') }}" class="menu-item-link {{ request()->routeIs('dashboard.manage-comics.comic-titles.index') ? 'active' : '' }}">
            <div class="menu-item-icon">
                <i class="fa fa-images"></i>
            </div>
            <span class="menu-item-text">Manage Comics</span>
        </a>
    </div>

    <div class="menu-item">
        <a href="" class="menu-item-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <div class="menu-item-icon">
                <i class="fa fa-book-open"></i>
            </div>
            <span class="menu-item-text">Manage Light Novel</span>
        </a>
    </div>
</div>
