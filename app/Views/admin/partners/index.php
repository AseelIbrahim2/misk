<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

<div class="content-wrapper">
    <section class="content-header d-flex justify-content-between align-items-center">
        <h1>Partners</h1>
        <a href="/partners/create" class="btn btn-primary">Add New Partner</a>
    </section>

    <section class="content mt-3">
        <?php if (!empty($partners)): ?>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="60">ID</th>
                        <th>Name</th>
                        <th width="120">Media</th>
                        <th>Link</th>
                        <th width="80">Order</th>
                        <th width="160">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($partners as $partner): ?>
                    <tr>
                        <td><?= (int)$partner['id'] ?></td>
                        <td><?= htmlspecialchars($partner['name']) ?></td>
                        <td class="text-center">
                            <?php if (!empty($partner['media_path'])): ?>
                                <img src="/<?= htmlspecialchars($partner['media_path']) ?>"
                                    alt="Partner Media"
                                    style="max-width:80px; max-height:50px;">
                            <?php else: ?>
                                <span class="text-muted">—</span>
                            <?php endif; ?>
                        </td>


                        <td>
                            <?php if (!empty($partner['link'])): ?>
                                <a href="<?= htmlspecialchars($partner['link']) ?>" target="_blank">
                                    <?= htmlspecialchars($partner['link']) ?>
                                </a>
                            <?php else: ?>
                                —
                            <?php endif; ?>
                        </td>

                        <td><?= (int)$partner['order'] ?></td>

                        <td>
                            <a href="/partners/edit/<?= $partner['id'] ?>" class="btn btn-sm btn-warning">Edit</a>

                            <form action="/partners/delete/<?= $partner['id'] ?>"
                                  method="POST"
                                  style="display:inline-block;">
                                <input type="hidden" name="csrf_token"
                                       value="<?= \App\Middleware\CsrfMiddleware::generateToken() ?>">
                                <button class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-info">No partners found.</div>
        <?php endif; ?>
    </section>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
<?php require_once __DIR__ . '/../layouts/scripts.php'; ?>
