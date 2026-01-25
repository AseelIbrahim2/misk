<?php
$logoPath   = !empty($siteSettings['logo_path']) ? htmlspecialchars($siteSettings['logo_path']) : '/assets/images/logo-colored.svg';
$siteName   = htmlspecialchars($siteSettings['site_name'] ?? 'Misk Schools');
$currentUser = $_SESSION['user']['username'] ?? 'Guest';
$isLoggedIn = isset($_SESSION['user']); 
$avatarLetter = $isLoggedIn ? strtoupper($currentUser[0]) : '?';

function renderMenuLinks(array $links)
{
    foreach ($links as $link) {
        $hasChildren = !empty($link['children']);
        ?>
        <li>
            <a href="<?= htmlspecialchars($link['url']) ?>"
               class="submenu-link d-flex align-items-center <?= $hasChildren ? 'collapsed' : '' ?>"
               <?php if ($hasChildren): ?>
                   data-bs-toggle="collapse"
                   data-bs-target="#link-<?= $link['id'] ?>"
               <?php endif; ?>>

                <?= htmlspecialchars($link['title']) ?>
                <?php if ($hasChildren): ?>
                    <span class="arrow-icon ms-2">▼</span>
                <?php endif; ?>
            </a>

            <?php if ($hasChildren): ?>
                <div class="collapse" id="link-<?= $link['id'] ?>">
                    <ul class="list-unstyled nested-submenu-list ps-3">
                        <?php renderMenuLinks($link['children']); ?>
                    </ul>
                </div>
            <?php endif; ?>
        </li>
        <?php
    }
}
?>

<aside class="sidebar bg-primary d-flex flex-column" id="mainSidebar">

  <!-- Sidebar Header -->
  <div class="d-flex justify-content-between align-items-center px-5 py-4">
    <div class="logo-img1">
      <img src="<?= $logoPath ?>" alt="<?= $siteName ?>" class="img-fluid">
    </div>
    <button class="btn-close-custom" id="sidebarClose" aria-label="Close menu">
      <svg width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <line x1="18" y1="6" x2="6" y2="18"></line>
        <line x1="6" y1="6" x2="18" y2="18"></line>
      </svg>
    </button>
  </div>

  <!-- Sidebar Menu -->
  <div class="sidebar-content px-5">
    <ul class="list-unstyled menu-list">

      <?php foreach ($menus as $menu): ?>
        <?php if ($menu['location'] === 'sidebar'): ?>
          <li class="menu-item">
            <a class="menu-link d-flex align-items-center collapsed"
               data-bs-toggle="collapse"
               data-bs-target="#menu-<?= $menu['id'] ?>">
              <?= htmlspecialchars($menu['title']) ?>
              <span class="arrow-icon ms-2">▼</span>
            </a>

            <?php if (!empty($menu['links'])): ?>
              <div class="collapse" id="menu-<?= $menu['id'] ?>">
                <ul class="list-unstyled submenu-list ps-3">
                  <?php renderMenuLinks($menu['links']); ?>
                </ul>
              </div>
            <?php endif; ?>
          </li>
        <?php endif; ?>
      <?php endforeach; ?>

    </ul>
  </div>

  <!-- Footer -->
  <div class="mt-auto px-4 py-3 border-top border-secondary">

    <!-- Search -->
    <div class="mb-3">
      <div class="input-group bg-white p-2">
        <span class="input-group-text bg-transparent border-0">🔍</span>
        <input type="text" class="form-control border-0 shadow-none" placeholder="Search...">
      </div>
    </div>

    <!-- User -->
    <div class="d-flex justify-content-between align-items-center">
      <div class="d-flex align-items-center">
        <div class="avatar bg-light text-primary rounded-circle d-flex justify-content-center align-items-center me-2"
            style="width:35px;height:35px;font-weight:bold;">
          <?= $avatarLetter ?>
        </div>

        <span class="text-white"><?= htmlspecialchars($currentUser) ?></span>
      </div>

      <?php if ($isLoggedIn): ?>
        <a href="/auth/logout" class="btn btn-sm btn-outline-light">
          Logout
        </a>
      <?php else: ?>
        <a href="/auth/login" class="btn btn-sm btn-outline-light">
          Login
        </a>
      <?php endif; ?>
    </div>

  </div>
</aside>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

