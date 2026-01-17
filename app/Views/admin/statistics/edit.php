<?php
use App\Middleware\CsrfMiddleware;

$old = $_SESSION['old'] ?? $stat;
$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['old'], $_SESSION['errors']);
?>
<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/navbar.php'; ?>
<?php require __DIR__ . '/../layouts/sidebar.php'; ?>


<div class="container">
    <h1>Edit Statistic</h1>
    <form action="/statistic/update/<?= $stat['id'] ?>" method="POST">
        <input type="hidden" name="csrf_token" value="<?= CsrfMiddleware::generateToken(); ?>">

        <div class="form-group">
            <label>Key</label>
            <input type="text" name="key" class="form-control" value="<?= htmlspecialchars($old['key'] ?? '') ?>">
            <?php if (!empty($errors['key'])): ?>
                <small class="text-danger"><?= implode(', ', $errors['key']); ?></small>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label>Label</label>
            <input type="text" name="label" class="form-control" value="<?= htmlspecialchars($old['label'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label>Value</label>
            <input type="number" name="value" class="form-control" value="<?= htmlspecialchars($old['value'] ?? 0) ?>">
        </div>

        <div class="form-group">
            <label>Suffix</label>
            <input type="text" name="suffix" class="form-control" value="<?= htmlspecialchars($old['suffix'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label>Order</label>
            <input type="number" name="order" class="form-control" value="<?= htmlspecialchars($old['order'] ?? 0) ?>">
        </div>

        <div class="form-group form-check">
            <input type="checkbox" name="is_active" value="1" class="form-check-input" <?= !empty($old['is_active']) ? 'checked' : '' ?>>
            <label class="form-check-label">Active</label>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="/statistic" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
<?php require __DIR__ . '/../layouts/scripts.php'; ?>