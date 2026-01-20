<aside class="sidebar bg-primary d-flex flex-column" id="mainSidebar">

  <!-- Sidebar Header -->
  <div class="d-flex justify-content-between align-items-center px-5 py-4">
    <div class="logo-img1">
      <img src="/assets/images/logo-colored.svg" class="img-fluid" alt="Logo">
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
  <div class="mt-auto px-5 py-4">
    <hr class="custom-hr">
    <div class="input-group bg-white rounded-0 p-2">
      <span class="input-group-text bg-transparent border-0 text-muted">Search</span>
      <input type="text" class="form-control border-0 shadow-none">
      <span class="input-group-text bg-transparent border-0">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <circle cx="11" cy="11" r="8"></circle>
          <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
        </svg>
      </span>
    </div>
  </div>
</aside>

<div class="sidebar-overlay" id="sidebarOverlay"></div>
