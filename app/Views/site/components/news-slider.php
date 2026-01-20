<!-- section 2 -->
<section class="container-fluid">
  <h2 class="h2 text-center mt-5 mb-3">Featured News</h2>

  <div class="news-slider">
    <?php if (empty($news)): ?>
      <p class="text-center mt-4">No news available.</p>
   <?php else: ?>
    <?php foreach ($news as $item): ?>
      <div class="news-card mt-3">
        <div class="img-box position-relative">
          <img 
            src="<?= htmlspecialchars($item['media_path'] ?? '/assets/images/default-news.png') ?>" 
            alt="<?= htmlspecialchars($item['title'] ?? 'News') ?>"
            class="img-fluid"
          >
          <span class="overlay-text rounded-4 date text-white bg-primary position-absolute px-2 py-1">
            <?= date('M d, Y', strtotime($item['created'] ?? 'now')) ?>
          </span>
        </div>
        <div class="news-content">
          <h3 class="h3 mt-2"><?= htmlspecialchars($item['title'] ?? '') ?></h3>
        <a href="/NewsPage/show/<?= (int)$item['id'] ?>" class="inline-link2 text-primary">Read More</a>


        </div>
      </div>
    <?php endforeach; ?>
  </div>
 <?php endif; ?>
  <div class="d-flex justify-content-center align-items-center gap-3 mt-4">
    <button class="arrow-btn d-flex justify-content-center align-items-center prev-btn" aria-label="Previous"></button>
    <button class="arrow-btn d-flex justify-content-center align-items-center next-btn" aria-label="Next"></button>
  </div>

  <div class="d-flex justify-content-center mt-4 mb-5">
    <button class="btn btn-primary">See All News</button>
  </div>
</section>
                                         