<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../layouts/navbar.php'; ?>
<?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

<div class="content-wrapper">

    <!-- Upload form -->
    <form action="/media/upload" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token"
               value="<?= \App\Middleware\CsrfMiddleware::generateToken() ?>">
        <input type="file" name="file" required>
        <button type="submit">Upload</button>
    </form>

 </div>
<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
<?php require_once __DIR__ . '/../layouts/scripts.php'; ?>
