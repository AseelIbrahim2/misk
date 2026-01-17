<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Website' ?></title>

    <!-- CSS -->
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>

<?php require __DIR__ . '/header.php'; ?>

<main>
    <?= $content ?>
</main>

<?php require __DIR__ . '/footer.php'; ?>

<!-- JS -->
<script src="/assets/js/app.js"></script>
</body>
</html>
