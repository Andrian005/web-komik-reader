<div class="menu">
    <div class="menu-item">
        <a href="{{ route('dashboard') }}" class="menu-item-link">
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
    <div class="menu-item">
        <button class="menu-item-link menu-item-toggle">
            <div class="menu-item-icon">
                <i class="fa fa-book"></i>
            </div>
            <span class="menu-item-text">Manajemen Komik</span>
            <div class="menu-item-addon">
                <i class="menu-item-caret caret"></i>
            </div>
        </button>
        <!-- BEGIN Menu Submenu -->
        <div class="menu-submenu">
            <div class="menu-item">
                <a href="{{ route('dashboard.manajemen-komik.judul.index') }}"
                    class="menu-item-link d-flex align-items-center ps-3">
                    <i class="fa fa-book d-inline-block text-center pl-4" style="width: 24px;"></i>
                    <span class="menu-item-text pl-3">Judul</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="{{ route('dashboard.manajemen-komik.genre.index') }}"
                    class="menu-item-link d-flex align-items-center ps-3">
                    <i class="fa fa-tags d-inline-block text-center pl-4" style="width: 24px;"></i>
                    <span class="menu-item-text pl-3">Genre</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="{{ route('dashboard.manajemen-komik.author.index') }}"
                    class="menu-item-link d-flex align-items-center ps-3">
                    <i class="fa fa-user d-inline-block text-center pl-4" style="width: 24px;"></i>
                    <span class="menu-item-text pl-3">Author</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="{{ route('dashboard.manajemen-komik.artist.index') }}"
                    class="menu-item-link d-flex align-items-center ps-3">
                    <i class="fa fa-paint-brush d-inline-block text-center pl-4" style="width: 24px;"></i>
                    <span class="menu-item-text pl-3">Artist</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="" class="menu-item-link d-flex align-items-center ps-3">
                    <i class="fa fa-file-alt d-inline-block text-center pl-4" style="width: 24px;"></i>
                    <span class="menu-item-text pl-3">Chapter & Halaman</span>
                </a>
            </div>
        </div>
        <!-- END Menu Submenu -->
    </div>
</div>
