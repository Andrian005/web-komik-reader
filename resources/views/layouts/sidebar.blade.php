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
                <i class="fa fa-database"></i>
            </div>
            <span class="menu-item-text">Manajemen Komik</span>
            <div class="menu-item-addon">
                <i class="menu-item-caret caret"></i>
            </div>
        </button>
        <!-- BEGIN Menu Submenu -->
        <div class="menu-submenu">
            <div class="menu-item">
                <a href="{{ route('dashboard.manajemen-komik.genre.index') }}" class="menu-item-link">
                    <i class="menu-item-bullet"></i>
                    <span class="menu-item-text">Genre</span>
                </a>
            </div>
        </div>
        <!-- END Menu Submenu -->
    </div>
</div>
