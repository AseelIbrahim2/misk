<?php require __DIR__ . '/../../layouts/header.php'; ?>
<?php require __DIR__ . '/../../layouts/navbar.php'; ?>
<?php require __DIR__ . '/../../layouts/sidebar.php'; ?>

<div class="content-wrapper">
    <section class="content-header"><h1>Create Menu</h1></section>
    <section class="content">

        <?php if (!empty($_SESSION['errors'])): ?>
            <div class="alert alert-danger">
                <?php foreach ($_SESSION['errors'] as $fieldErrors): ?>
                    <?php foreach ($fieldErrors as $error): ?>
                        <p><?= $error ?></p>
                    <?php endforeach; ?>
                <?php endforeach; ?>
                <?php unset($_SESSION['errors']); ?>
            </div>
        <?php endif; ?>

        <form action="/menus/store" method="POST">
            <input type="hidden" name="csrf_token" value="<?= \App\Middleware\CsrfMiddleware::generateToken(); ?>">

            <div class="form-group">
                <label for="name">Menu Name</label>
                <input type="text" name="name" class="form-control"
                       value="<?= $_SESSION['old']['name'] ?? '' ?>" required>
            </div>

            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" class="form-control"
                       value="<?= $_SESSION['old']['title'] ?? '' ?>" required>
            </div>

            <button type="submit" class="btn btn-success mt-2">Create Menu</button>
            <a href="/menus" class="btn btn-secondary mt-2">Cancel</a>
        </form>
    </section>
</div>

<?php unset($_SESSION['old']); ?>
<?php require __DIR__ . '/../../layouts/footer.php'; ?>
<?php require __DIR__ . '/../../layouts/scripts.php'; ?>
