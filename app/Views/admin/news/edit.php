<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../layouts/navbar.php'; ?>
<?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>



<div class="content-wrapper">
    <section class="content-header">
        <h1>Edit News</h1>
    </section>

    <section class="content">

        <?php if (!empty($_SESSION['errors'])): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($_SESSION['errors'] as $fieldErrors): ?>
                        <?php foreach ($fieldErrors as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php unset($_SESSION['errors']); ?>
        <?php endif; ?>

        <form action="/news/update/<?= $news['id'] ?>" method="POST">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

            <div class="form-group">
                <label>Title</label>
                <input type="text" name="title" class="form-control"
                       value="<?= htmlspecialchars($_SESSION['old']['title'] ?? $news['title']) ?>" required>
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea name="description" rows="3" class="form-control"><?= htmlspecialchars($_SESSION['old']['description'] ?? $news['description']) ?></textarea>
            </div>

            <div class="form-group">
                <label>Content</label>
                <textarea name="content" rows="6" class="form-control" required><?= htmlspecialchars($_SESSION['old']['content'] ?? $news['content']) ?></textarea>
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="0" <?= (($_SESSION['old']['status'] ?? $news['status']) == 0) ? 'selected' : '' ?>>Pending</option>
                    <option value="1" <?= (($_SESSION['old']['status'] ?? $news['status']) == 1) ? 'selected' : '' ?>>Published</option>
                    <option value="2" <?= (($_SESSION['old']['status'] ?? $news['status']) == 2) ? 'selected' : '' ?>>Archived</option>
                </select>
            </div>
            <div class="form-group">
                <label>Current Media</label><br>
                <?php if(!empty($news['media_path'])): ?>
                    <img src="/<?= htmlspecialchars($news['media_path']) ?>" width="120" style="border-radius:6px">
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label>Change Media</label>
                <select name="media_id" class="form-control">
                    <option value="">-- Select Media --</option>
                    <?php foreach ($media as $m): ?>
                        <?php if($m['type'] === 'image' && $m['is_deleted'] == 0): ?>
                            <option value="<?= $m['id'] ?>" <?= ($news['media_id'] == $m['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($m['name']) ?>
                            </option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>


            <div class="form-group">
                <label>Deleted</label>
                <select name="is_deleted" class="form-control">
                    <option value="0" <?= (($_SESSION['old']['is_deleted'] ?? $news['is_deleted']) == 0) ? 'selected' : '' ?>>No</option>
                    <option value="1" <?= (($_SESSION['old']['is_deleted'] ?? $news['is_deleted']) == 1) ? 'selected' : '' ?>>Yes</option>
                </select>
            </div>

            <button class="btn btn-primary">Update</button>
            <a href="/news/index" class="btn btn-secondary">Cancel</a>
        </form>

        <?php unset($_SESSION['old']); ?>
    </section>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
<?php require __DIR__ . '/../layouts/scripts.php'; ?>
