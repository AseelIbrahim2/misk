<?php


$old = $_SESSION['old'] ?? $stat;
$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['old'], $_SESSION['errors']);
?>
<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/navbar.php'; ?>
<?php require __DIR__ . '/../layouts/sidebar.php'; ?>

<div class="content-wrapper">
<section class="content pt-3">
<div class="container-fluid">

<div class="card card-warning">
    <div class="card-header">
        <h3 class="card-title">Edit Statistic</h3>
    </div>

    <form action="/statistic/update/<?= $stat['id'] ?>" method="POST">
        <div class="card-body">

            <input type="hidden" name="csrf_token" value="<?= \App\Middleware\CsrfMiddleware::generateToken() ?>">

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Key</label>
                        <input type="text" name="key" class="form-control"
                               value="<?= htmlspecialchars($old['key'] ?? '') ?>">
                        <?php if (!empty($errors['key'])): ?>
                            <small class="text-danger"><?= implode(', ', $errors['key']); ?></small>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Label</label>
                        <input type="text" name="label" class="form-control"
                               value="<?= htmlspecialchars($old['label'] ?? '') ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Value</label>
                        <input type="number" name="value" class="form-control"
                               value="<?= htmlspecialchars($old['value'] ?? 0) ?>">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Suffix</label>
                        <input type="text" name="suffix" class="form-control"
                               value="<?= htmlspecialchars($old['suffix'] ?? '') ?>">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Order</label>
                        <input type="number" name="order" class="form-control"
                               value="<?= htmlspecialchars($old['order'] ?? 0) ?>">
                    </div>
                </div>
            </div>

            <div class="form-check mt-2">
                <input type="checkbox" name="is_active" value="1"
                       class="form-check-input"
                       <?= !empty($old['is_active']) ? 'checked' : '' ?>>
                <label class="form-check-label">Active</label>
            </div>

        </div>

        <div class="card-footer text-right">
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Update
            </button>
            <a href="/statistic" class="btn btn-secondary">
                Cancel
            </a>
        </div>
    </form>
</div>

</div>
</section>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
<?php require __DIR__ . '/../layouts/scripts.php'; ?>
