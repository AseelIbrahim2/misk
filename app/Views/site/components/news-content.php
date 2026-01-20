<section class="container py-5 my-5 h-100">

    <!-- Description / Location -->
    <?php if (!empty($newsById['description'])): ?>
        <h3 class="h3 fw-bold">
            <?= htmlspecialchars($newsById['description']) ?>
        </h3>
    <?php endif; ?>

    <!-- Main Content -->
    <?php if (!empty($newsById['content'])): ?>
        <div class="custom-width-md p-3 my-3 content-area">
            <?= $newsById['content'] ?>
        </div>
    <?php endif; ?>

    <hr class="custom-width-md border border-primary opacity-75">

    <!-- Last Updated -->
    <?php if (!empty($newsById['updated'])): ?>
        <div class="date mt-3">
            Last Updated: <?= date('d/m/Y', strtotime($newsById['updated'])) ?>
        </div>
    <?php endif; ?>

</section>
