<!-- SECTION 4 -->
<section class="container partners-section d-flex flex-column align-items-center">

  <h2 class="h2 my-5 text-center">
    Our Partners
  </h2>


<div class="row gx-5 gy-4 justify-content-center mb-3">
  <?php foreach ($partners as $partner): ?>
    <div class="col-6 col-sm-6 col-md-3 d-flex justify-content-center">
      <div class="partner-card d-flex align-items-center justify-content-center p-2 overflow-hidden">
        <img 
          class="img-fluid partner-img" 
          src="<?= htmlspecialchars($partner['media_path'] ?? '/assets/images/default.png') ?>" 
          
          alt="<?= htmlspecialchars($partner['name'] ?? 'Partner') ?>"
        >
      </div>
    </div>
  <?php endforeach; ?>
</div>


  <!-- BUTTON -->
  <button class="btn btn-primary btn-lg my-5">
    Load More
  </button>

</section>



