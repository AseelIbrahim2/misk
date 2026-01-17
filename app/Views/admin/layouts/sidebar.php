

      <?php $currentUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); ?>
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/admin/dashboard" class="brand-link">
      <img src="/assets/adminlte/dist/img/AdminLTELogo.png" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">MISK Admin</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="/assets/adminlte/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">
            <?= htmlspecialchars($_SESSION['user']['username'] ?? 'Admin') ?>
          </a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

            <li class="nav-item">
              <a href="/admin/dashboard"
                class="nav-link <?= str_starts_with($currentUri, '/admin/dashboard') ? 'active' : '' ?>">
                <i class="nav-icon fas fa-home"></i>
                <p>Dashboard</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="/admin/users"
                class="nav-link <?= str_starts_with($currentUri, '/admin/users') ? 'active' : '' ?>">
                <i class="nav-icon fas fa-users"></i>
                <p>Users</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="/news"
                class="nav-link <?= str_starts_with($currentUri, '/news') ? 'active' : '' ?>">
                <i class="nav-icon fas fa-newspaper"></i>
                <p>News</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="/media"
                class="nav-link <?= str_starts_with($currentUri, '/media') ? 'active' : '' ?>">
                <i class="nav-icon far fa-image"></i>
                <p>Media</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/menus"
                class="nav-link <?= str_starts_with($currentUri, '/menus') ? 'active' : '' ?>">
                <i class="nav-icon fas fa-list"></i> 
                <p>Menus</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="/slider"
                class="nav-link <?= str_starts_with($currentUri, '/slider') ? 'active' : '' ?>">
                <i class="nav-icon fas fa-images"></i> 
                <p>Slider</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/statistic"
                class="nav-link <?= str_starts_with($currentUri, '/statistic') ? 'active' : '' ?>">
                <i class="nav-icon fas fa-chart-bar"></i> 
                <p>Statistics</p>
              </a>
            </li>

          </ul>
        </nav>

      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>


