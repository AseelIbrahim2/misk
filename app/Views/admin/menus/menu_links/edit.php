<?php require __DIR__ . '/../../layouts/header.php'; ?>
<?php require __DIR__ . '/../../layouts/navbar.php'; ?>
<?php require __DIR__ . '/../../layouts/sidebar.php'; ?>

<div class="content-wrapper">
    <section class="content-header"><h1>Edit Menu Link</h1></section>
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

        <form action="/menu-links/update/<?= $link['id'] ?>" method="POST">
            <input type="hidden" name="csrf_token" value="<?= \App\Middleware\CsrfMiddleware::generateToken(); ?>">

            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" class="form-control" value="<?= $_SESSION['old']['title'] ?? $link['title'] ?>" required>
            </div>

            <div class="form-group">
                <label for="url">URL</label>
                <input type="text" name="url" class="form-control" value="<?= $_SESSION['old']['url'] ?? $link['url'] ?>" required>
            </div>

            <div class="form-group">
                <label for="parent_id">Parent Link</label>
                <select name="parent_id" class="form-control">
                    <option value="">-- None --</option>
                    <?php foreach ($links as $linkOption): ?>
                        <?php if ($linkOption['id'] == $link['id']) continue; // can't be parent of itself ?>
                        <option value="<?= $linkOption['id'] ?>" <?= (($linkOption['id']==$link['parent_id']) ? 'selected' : '') ?>><?= $linkOption['title'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="order">Order</label>
                <input type="number" name="order" class="form-control" value="<?= $_SESSION['old']['order'] ?? $link['order'] ?>">
            </div>

            <div class="form-group">
                <label for="is_active">Active</label>
                <select name="is_active" class="form-control">
                    <option value="1" <?= (($link['is_active']==1)?'selected':'') ?>>Yes</option>
                    <option value="0" <?= (($link['is_active']==0)?'selected':'') ?>>No</option>
                </select>
            </div>

            <div class="form-group">
                <label for="target">Target</label>
                <select name="target" class="form-control">
                    <option value="_self" <?= (($link['target']=='_self')?'selected':'') ?>>_self</option>
                    <option value="_blank" <?= (($link['target']=='_blank')?'selected':'') ?>>_blank</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary mt-2">Update Link</button>
            <a href="/menu-links/<?= $menuId ?>" class="btn btn-secondary mt-2">Cancel</a>
        </form>
    </section>
</div>

<?php unset($_SESSION['old']); ?>
<?php require __DIR__ . '/../../layouts/footer.php'; ?>
<?php require __DIR__ . '/../../layouts/scripts.php'; ?>
