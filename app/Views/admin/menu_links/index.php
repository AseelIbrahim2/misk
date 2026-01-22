<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/navbar.php'; ?>
<?php require __DIR__ . '/../layouts/sidebar.php'; ?>

<div class="content-wrapper">
    <!-- Page Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Menu Links for: <?= htmlspecialchars($menu['title']); ?></h1>
                </div>
                <div class="col-sm-6 text-right">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#addLinkModal">
                        Add New Link
                    </button>
                    <a href="/menus" class="btn btn-secondary">Back to Menus</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="content">
        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?= $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($_SESSION['errors'])): ?>
            <div class="alert alert-danger">
                <?php foreach ($_SESSION['errors'] as $error): ?>
                    <?= is_array($error) ? implode(', ', $error) : $error; ?><br>
                <?php endforeach; unset($_SESSION['errors']); ?>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>URL</th>
                        <th>Parent</th>
                        <th>Order</th>
                        <th>Active</th>
                        <th>Target</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($links as $link): ?>
                        <tr>
                            <td><?= $link['id']; ?></td>
                            <td><?= htmlspecialchars($link['title']); ?></td>
                            <td><?= htmlspecialchars($link['url']); ?></td>
                            <td><?= $link['parent_id'] ?? '-'; ?></td>
                            <td><?= $link['order']; ?></td>
                            <td><?= $link['is_active'] ? 'Yes' : 'No'; ?></td>
                            <td><?= htmlspecialchars($link['target']); ?></td>
                            <td>
                                <button class="btn btn-sm btn-warning"
                                        data-toggle="modal"
                                        data-target="#editLinkModal<?= $link['id']; ?>">
                                    Edit
                                </button>

                                <form action="/Menulinks/delete/<?= $link['id']; ?>"
                                      method="POST"
                                      style="display:inline-block;">
                                    <input type="hidden" name="csrf_token"
                                           value="<?= \App\Middleware\CsrfMiddleware::generateToken(); ?>">
                                    <input type="hidden" name="menu_id" value="<?= $menu['id']; ?>">
                                    <button type="submit"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editLinkModal<?= $link['id']; ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="/Menulinks/update/<?= $link['id']; ?>" method="POST">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Link</h5>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>

                                        <div class="modal-body">
                                            <input type="hidden" name="csrf_token"
                                                   value="<?= \App\Middleware\CsrfMiddleware::generateToken(); ?>">
                                            <input type="hidden" name="menu_id" value="<?= $menu['id']; ?>">

                                            <div class="form-group">
                                                <label>Title</label>
                                                <input type="text" name="title" class="form-control"
                                                       value="<?= htmlspecialchars($link['title']); ?>" required>
                                            </div>

                                            <div class="form-group">
                                                <label>URL</label>
                                                <input type="text" name="url" class="form-control"
                                                       value="<?= htmlspecialchars($link['url']); ?>" required>
                                            </div>
                                                <div class="form-group">
                                                    <label>Parent Link</label>
                                                    <select name="parent_id" class="form-control">
                                                        <option value="">— No Parent (Root) —</option>

                                                        <?php foreach ($links as $parent): ?>
                                                            <?php if ($parent['id'] != $link['id']): ?>
                                                                <option value="<?= $parent['id']; ?>"
                                                                    <?= ($link['parent_id'] == $parent['id']) ? 'selected' : ''; ?>>
                                                                    <?= htmlspecialchars($parent['title']); ?>
                                                                </option>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>



                                            <div class="form-group">
                                                <label>Order</label>
                                                <input type="number" name="order" class="form-control"
                                                       value="<?= $link['order']; ?>">
                                            </div>

                                            <div class="form-check">
                                                <input type="checkbox" name="is_active" class="form-check-input"
                                                    <?= $link['is_active'] ? 'checked' : ''; ?>>
                                                <label class="form-check-label">Active</label>
                                            </div>

                                            <div class="form-group mt-2">
                                                <label>Target</label>
                                                <select name="target" class="form-control">
                                                    <option value="_self" <?= $link['target'] === '_self' ? 'selected' : ''; ?>>_self</option>
                                                    <option value="_blank" <?= $link['target'] === '_blank' ? 'selected' : ''; ?>>_blank</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                Cancel
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<!-- Add New Link Modal -->
<div class="modal fade" id="addLinkModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/Menulinks/store/<?= $menu['id']; ?>" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Link</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="csrf_token"
                           value="<?= \App\Middleware\CsrfMiddleware::generateToken(); ?>">

                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>URL</label>
                        <input type="text" name="url" class="form-control" required>
                    </div>

                 <div class="form-group">
                    <label>Parent Link</label>
                    <select name="parent_id" class="form-control">
                        <option value="">— No Parent (Root) —</option>
                        <?php foreach ($links as $parent): ?>
                            <option value="<?= $parent['id']; ?>">
                                <?= htmlspecialchars($parent['title']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                    <div class="form-group">
                        <label>Order</label>
                        <input type="number" name="order" class="form-control" value="0">
                    </div>

                    <div class="form-check">
                        <input type="checkbox" name="is_active" class="form-check-input" checked>
                        <label class="form-check-label">Active</label>
                    </div>

                    <div class="form-group mt-2">
                        <label>Target</label>
                        <select name="target" class="form-control">
                            <option value="_self">_self</option>
                            <option value="_blank">_blank</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Add Link</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
<?php require __DIR__ . '/../layouts/scripts.php'; ?>
