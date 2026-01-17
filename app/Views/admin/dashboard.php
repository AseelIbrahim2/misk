

<?php require __DIR__ . '/layouts/header.php'; ?>
<?php require __DIR__ . '/layouts/navbar.php'; ?>
<?php require __DIR__ . '/layouts/sidebar.php'; ?>

<div class="content-wrapper">
  <section class="content pt-3">
    <div class="container-fluid">
      <h1><?= $title ?? 'Admin Dashboard' ?></h1>
      <p>Welcome <?= htmlspecialchars($username ?? 'Admin') ?></p>
    </div>
  </section>





<?php require __DIR__ . '/layouts/footer.php'; ?>
<?php require __DIR__ . '/layouts/scripts.php'; ?>
