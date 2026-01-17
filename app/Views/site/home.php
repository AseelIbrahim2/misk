<?php
// Layout wrapper
ob_start();
?>

<!-- 🎞️ SLIDER PLACEHOLDER -->
<section id="hero">
    <?php
    /**
     * لاحقًا:
     * foreach ($sliders as $slider)
     */
    ?>
    <div class="slider-placeholder">
        <h2>Slider Section</h2>
    </div>
</section>

<!-- 🤝 PARTNERS PLACEHOLDER -->
<section id="partners">
    <h3>Our Partners</h3>

    <?php
    /**
     * لاحقًا:
     * foreach ($partners as $partner)
     */
    ?>
    <div class="partners-placeholder">
        Partner logos here
    </div>
</section>

<?php
$content = ob_get_clean();
require __DIR__ . '/layouts/master.php';
