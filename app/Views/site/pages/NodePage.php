<?php include __DIR__ . '/../layouts/head.php'; ?>

<?php
$pageTitle   = $newsById['title'] ?? 'News';
$publishDate = !empty($newsById['created']) ? date('d M Y', strtotime($newsById['created'])) : null;
$heroImage   = $newsById['media_path'] ?? null; 
$description = $newsById['description'] ?? null;
$content     = $newsById['content'] ?? null;
?>


<?php if (!empty($heroImage)): ?>
   
    <?php include __DIR__ . '/../components/news-header.php'; ?>
     <?php include __DIR__ . '/../components/news-content.php'; ?>
<?php else: ?>
     <?php include __DIR__ . '/../components/news-header-simple.php'; ?>
<?php endif; ?>


<?php include __DIR__ . '/../components/news-slider.php'; ?>
<?php include __DIR__ . '/../layouts/footer.php'; ?>
