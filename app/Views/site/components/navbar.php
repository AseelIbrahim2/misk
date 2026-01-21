<!-- components/navbar.php -->
<?php
$logoPath = !empty($siteSettings['logo_path']) ? htmlspecialchars($siteSettings['logo_path']) : '/assets/images/logo-colored.svg';
$siteName = htmlspecialchars($siteSettings['site_name'] ?? 'Misk Schools');
?>

<nav class="navbar navbar-overlay px-4 py-0" id="mainNavbar">
  <div class="container-fluid d-flex justify-content-end align-items-center flex-nowrap">

    <!-- Logo -->
    <div class="d-flex align-items-center me-5">
      <div class="logo-img1">
        <a href="/" class="d-flex align-items-center text-decoration-none">
          <img src="<?= $logoPath ?>" class="img-fluid" alt="<?= $siteName ?>">
        </a>
      </div>
    </div>

    <!-- Burger -->
    <div class="burger-container d-flex align-items-center justify-content-center">
      <img src="/assets/images/Subtract.svg" class="img-fluid" alt="">
      <button class="btn btn-menu text-primary p-0" id="sidebarToggle">
        <svg width="48" height="32" viewBox="0 0 24 24"
             fill="none"
             stroke="currentColor"
             stroke-width="2.2"
             stroke-linecap="butt">
          <line x1="0.5" y1="6"  x2="23.5" y2="6"></line>
          <line x1="0.5" y1="12" x2="23.5" y2="12"></line>
          <line x1="0.5" y1="18" x2="23.5" y2="18"></line>
        </svg>
      </button>
    </div>

  </div>
</nav>
