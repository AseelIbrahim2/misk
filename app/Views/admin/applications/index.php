<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../layouts/navbar.php'; ?>
<?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <h1>Applications</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <?php if (!empty($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?= $_SESSION['success']; unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

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

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Applications List</h3>
                </div>

                <div class="card-body">
                    <table id="applicationsTable" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Age</th>
                            <th>Message</th>
                            <th>Status</th>
                            <th>Submitted</th>
                            <th>Actions</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php foreach ($applications as $app): ?>
                            <tr>
                                <td><?= $app['id'] ?></td>
                                <td><?= htmlspecialchars($app['full_name']) ?></td>
                                <td><?= htmlspecialchars($app['email']) ?></td>
                                <td><?= htmlspecialchars($app['age'] ?? '-') ?></td>
                                <td><?= htmlspecialchars(mb_strimwidth($app['message'] ?? '-', 0, 50, '...')) ?></td>

                                <!-- STATUS -->
                                <td>
                                    <form action="/application/update/<?= $app['id'] ?>" method="POST">
                                        <input type="hidden" name="csrf_token"
                                               value="<?= $_SESSION['csrf_token'] ?>">

                                        <select name="status" class="form-control form-control-sm"
                                                onchange="this.form.submit()">
                                            <option value="pending" <?= ($app['status'] === 'pending') ? 'selected' : '' ?>>Pending</option>
                                            <option value="approved" <?= ($app['status'] === 'approved') ? 'selected' : '' ?>>Approved</option>
                                            <option value="rejected" <?= ($app['status'] === 'rejected') ? 'selected' : '' ?>>Rejected</option>
                                        </select>
                                    </form>
                                </td>

                                <td><?= $app['submitted'] ?></td>

                                <!-- ACTIONS -->
                                <td>
                                    <form action="/application/delete/<?= $app['id'] ?>" method="POST" class="d-inline">
                                        <input type="hidden" name="csrf_token"
                                               value="<?= $_SESSION['csrf_token'] ?>">
                                        <button class="btn btn-sm btn-danger"
                                                onclick="return confirm('Delete this application?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                        </tbody>

                    </table>
                </div>
            </div>

        </div>
    </section>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
<?php require_once __DIR__ . '/../layouts/scripts.php'; ?>

