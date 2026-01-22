<div class="hero-slider-container">
  <div class="hero-slider">

    <?php if (!empty($sliders)): ?>
      <?php $loopIndex = 0; ?>
      <?php foreach ($sliders as $slider): ?>

        <div class="hero-slide"
             style="background-image:url('<?= htmlspecialchars($slider['media_path']) ?>');">

          <div class="slide-overlay"></div>

          <div class="hero-content-wrapper">

            <?php if (!empty($slider['title'])): ?>
              <h<?= $loopIndex === 0 ? '1' : '2' ?> class="h1 text-white">
                <?= htmlspecialchars($slider['title']) ?>
              </h<?= $loopIndex === 0 ? '1' : '2' ?>>
            <?php endif; ?>

            <?php if ($loopIndex === 0 && !empty($siteSettings['slogan'])): ?>
              <p class="text-white mt-2 hero-slogan">
                <?= htmlspecialchars($siteSettings['slogan']) ?>
              </p>
            <?php endif; ?>

          </div>

        </div>

        <?php $loopIndex++; ?>
      <?php endforeach; ?>
    <?php endif; ?>

  </div>
</div>

