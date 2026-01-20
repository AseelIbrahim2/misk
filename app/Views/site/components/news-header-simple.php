<!-- Simple News Header -->


<header>

  <?php include __DIR__ . '/news-navbar.php'; ?>

  <?php include __DIR__ . '/sidebar.php'; ?>


    <!-- Hero Section -->
    <div class="position-relative w-100 hero-section2 bg-tertiary-hover">
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

    <!-- Data Bar & Social Links -->
    <div class="w-100 position-relative floating-section3">
        <div class="data-bar bg-primary-hover">
            <div class="d-flex justify-content-between align-items-center w-100 pe-3">
                <div class="small fw-bold text-uppercase text-dark" style="letter-spacing: 0.05em;">
                    <?= !empty($publishDate) ? htmlspecialchars($publishDate) : '' ?>
                </div>

                <div class="d-flex align-items-center gap-2 ms-auto">
                    <img src="/assets/images/social-links.svg">
                    <img src="/assets/images/social-links (1).svg">
                    <img src="/assets/images/social-links (2).svg">
                    <img src="/assets/images/social-links (3).svg">
                </div>
            </div>
        </div>
    </div>

</header>


<!-- Content Section -->
<section class="container py-5 my-5 h-100">
    <div class="custom-width-md p-3 my-3">
        <?php if (!empty($description)): ?>
            <h3 class="h3 fw-bold mb-3">
                <?= htmlspecialchars($description) ?>
            </h3>
        <?php endif; ?>

        <?php if (!empty($content)): ?>
            <?= $content ?>
        <?php endif; ?>
    </div>

</section>