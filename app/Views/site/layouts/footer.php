<footer class="bg-primary text-white text-lg-start mt-5">
  <div class="container-fluid px-0">
    <div class="row g-0 align-items-stretch">

      <!-- LEFT COLUMN -->
      <div class="col-lg-7 col-md-7 col-12 p-5 py-5">
        <div class="d-flex flex-column justify-content-center">

          <div class="row justify-content-evenly">

            <?php
        
            $footerMenus = array_filter($menus, fn($menu) => $menu['location'] === 'footer');

            foreach ($footerMenus as $menu):
              $links = $menu['links'];
              $chunks = array_chunk($links, 5); 
            ?>

              <?php foreach ($chunks as $index => $chunk): ?>
                <div class="col-md-5 col-6 mb-4">
                  <ul class="list-unstyled mb-4 text-start">
                    <?php foreach ($chunk as $link): ?>
                      <li class="mb-3">
                        <a href="<?= htmlspecialchars($link['url']) ?>" target="<?= htmlspecialchars($link['target']) ?>" class="text-white text-decoration-none fw-bold">
                          <?= htmlspecialchars($link['title']) ?>
                        </a>
                      </li>
                    <?php endforeach; ?>
                  </ul>

                    <?php if ($index === 0): ?>
                      <div class="d-flex my-4 justify-content-start">
                        <img src="/assets/images/footer2.svg" style="max-height:50px;">
                        <img src="/assets/images/footer1.svg" style="max-height:55px;">
                      </div>
                    <?php endif; ?>

                </div> 
              <?php endforeach; ?>

            <?php endforeach; ?>

          </div>

        </div>
      </div>

      <!-- RIGHT IMAGE -->
      <div class="col-lg-5 col-md-5 d-none d-md-block p-0 position-relative">
        <img src="/assets/images/footer3.jpg" class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover" alt="Footer Image">
      </div>

    </div>
  </div>

  <!-- bottom bar -->
  <div class="bg-primary-hover text-dark py-3">
    <div class="container-fluid">
      <div class="d-flex flex-column flex-md-row justify-content-around align-items-center py-2">

        <!-- social -->
        <div class="d-flex align-items-center gap-3 mb-3 mb-md-0">
          <img src="/assets/images/social-links (1).svg" class="social-icon">
          <img src="/assets/images/social-links (2).svg" class="social-icon">
          <img src="/assets/images/social-links (3).svg" class="social-icon">
          <img src="/assets/images/social-links.svg" class="social-icon">
        </div>

        <!-- privacy & terms -->
        <div class="d-flex flex-wrap align-items-center gap-3 justify-content-center mt-2 mt-md-0">
          <span class="small">Privacy Policy</span>
          <span class="small">Terms & Conditions</span>
          <span class="small">© Copyright MISK 2023-2024. All Rights Reserved</span>
        </div>

      </div>
    </div>
  </div>
</footer>



    <!-- Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/countup.js/2.6.2/countUp.umd.js"></script>


 
    <!-- Custom JS -->
    <script src="/assets/js/main.js"></script>







</body>
</html>



