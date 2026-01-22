<?php

$pageTitle   = $pageTitle   ?? '';
$heroImage   = $heroImage   ?? '/assets/images/default-hero.jpg';
$publishDate = $publishDate ?? null;
?>

<!-- Hero Section -->
<div class="position-relative w-100 hero-section bg-tertiary-hover">
  <div class="container pt-5 pt-md-6">
    <div class="row">
      <div class="col-12">
        <h1 class="h1 fw-bold ls-tight page-title">
          <?= htmlspecialchars($pageTitle) ?>
        </h1>
      </div>
    </div>
  </div>
</div>

<!-- Floating Image Section -->
<div class="w-100 position-relative floating-section">
  <div class="news-card-wrapper">

    <?php if (!empty($publishDate)): ?>
    <!-- Data Bar (News only) -->
    <div class="data-bar bg-primary-hover">
      <div class="d-flex justify-content-between align-items-center w-100 pe-3">
        <div class="small fw-bold text-uppercase text-dark" style="letter-spacing: 0.05em;">
          <?= htmlspecialchars($publishDate) ?>
        </div>

        <div class="d-flex align-items-center gap-2 ms-auto">
          <img src="/assets/images/social-links.svg">
          <img src="/assets/images/social-links (1).svg">
          <img src="/assets/images/social-links (2).svg">
          <img src="/assets/images/social-links (3).svg">
        </div>
      </div>
    </div>
    <?php endif; ?>

    <div class="image-container">
      <div class="image-overlay"></div>
      <img src="<?= htmlspecialchars($heroImage) ?>" alt="">
    </div>

  </div>
</div>
