<?php
$logoPath = !empty($siteSettings['logo_path']) ? htmlspecialchars($siteSettings['logo_path']) : '/assets/images/logo-colored.svg';
$siteName = htmlspecialchars($siteSettings['site_name'] ?? 'Misk Schools');
$currentUser = $_SESSION['user']['username'] ?? 'Guest'; // تأكد أن اسم المستخدم موجود في الجلسة
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
            <a href="#menu-<?= $menu['id'] ?>" class="menu-link d-flex align-items-center collapsed" data-bs-toggle="collapse" data-bs-target="#menu-<?= $menu['id'] ?>">
              <?= htmlspecialchars($menu['title']) ?>
              <span class="arrow-icon ms-2">▼</span>
            </a>

            <?php if (!empty($menu['links'])): ?>
              <div class="collapse" id="menu-<?= $menu['id'] ?>">
                <ul class="list-unstyled submenu-list ps-3">
                  <?php foreach ($menu['links'] as $link): ?>
                    <li>
                      <a href="<?= htmlspecialchars($link['url']) ?>" class="submenu-link d-flex align-items-center collapsed" <?php if(!empty($link['children'])): ?>data-bs-toggle="collapse" data-bs-target="#link-<?= $link['id'] ?>"<?php endif; ?>>
                        <?= htmlspecialchars($link['title']) ?>
                        <?php if(!empty($link['children'])): ?><span class="arrow-icon ms-2">▼</span><?php endif; ?>
                      </a>

                      <?php if (!empty($link['children'])): ?>
                        <div class="collapse" id="link-<?= $link['id'] ?>">
                          <ul class="list-unstyled nested-submenu-list ps-3">
                            <?php foreach ($link['children'] as $child): ?>
                              <li><a href="<?= htmlspecialchars($child['url']) ?>" class="nested-link"><?= htmlspecialchars($child['title']) ?></a></li>
                            <?php endforeach; ?>
                          </ul>
                        </div>
                      <?php endif; ?>

                    </li>
                  <?php endforeach; ?>
                </ul>
              </div>
            <?php endif; ?>
          </li>
        <?php endif; ?>
      <?php endforeach; ?>

    </ul>
  </div>

  <!-- Sidebar Footer -->
  <div class="mt-auto px-4 py-3 border-top border-secondary">

    <!-- Search Box -->
    <div class="mb-3">
      <div class="input-group bg-white rounded-0 p-1">
        <span class="input-group-text bg-transparent border-0 text-muted">🔍</span>
        <input type="text" class="form-control border-0 shadow-none" placeholder="Search...">
      </div>
    </div>

    <!-- User Info + Logout -->
    <div class="d-flex align-items-center justify-content-between mt-2">
      <div class="d-flex align-items-center">
        <div class="avatar bg-light text-primary rounded-circle d-flex justify-content-center align-items-center me-2" style="width: 35px; height: 35px; font-weight: bold;">
          <?= strtoupper(substr($currentUser, 0, 1)) ?>
        </div>
        <span class="text-white fw-semibold"><?= htmlspecialchars($currentUser) ?></span>
      </div>
      <a href="/auth/logout" class="btn btn-sm btn-outline-light d-flex align-items-center">
        Logout
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right ms-1" viewBox="0 0 16 16">
          <path fill-rule="evenodd" d="M10 15a1 1 0 0 1-1-1v-2H4.5A1.5 1.5 0 0 1 3 10.5v-5A1.5 1.5 0 0 1 4.5 4H9V2a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v11a1 1 0 0 1-1 1h-5zM9 1v2H4.5A.5.5 0 0 0 4 3.5v5c0 .276.224.5.5.5H9v2a1 1 0 0 1-1 1H4.5A1.5 1.5 0 0 1 3 10.5v-5A1.5 1.5 0 0 1 4.5 4H8a1 1 0 0 1 1 1z"/>
          <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L14.293 8l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
        </svg>
      </a>
    </div>

  </div>

</aside>

<div class="sidebar-overlay" id="sidebarOverlay"></div>
