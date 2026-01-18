<!-- Section 1 -->
<section class="px-3 px-md-0 section-spacing">
  <div class="container p-2 bg-primary rounded-4 text-center">

    <h2 class="text-white my-2 p-3 p-md-5">At a Glance</h2>

    <div class="row g-3 py-4 mb-3">

      <?php if (!empty($statistics)): ?>
        <?php foreach ($statistics as $stat): ?>
          <?php if ($stat['is_active']): ?>
            <div class="col-12 col-md-4 text-center">
              <p id="counter-<?= htmlspecialchars($stat['key']) ?>" 
                 class="display-1 text-primary-hover mb-3 fw-bold">0</p>
              <p class="text-white mb-0"><?= htmlspecialchars($stat['label']) ?></p>
            </div>
          <?php endif; ?>
        <?php endforeach; ?>
      <?php endif; ?>

    </div>
  </div>
</section>
