
<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/navbar.php'; ?>
<?php require __DIR__ . '/../layouts/sidebar.php'; ?>

<div class="content-wrapper">
<section class="content pt-3">
<div class="container-fluid">

    <div class="card card-outline card-primary">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h3 class="card-title flex-grow-1">
                <i class="fas fa-chart-bar mr-1"></i> Statistics List
            </h3>
            <a href="/statistic/create" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add New
            </a>
        </div>

        <div class="card-body">

            <?php if (!empty($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?= $_SESSION['success']; unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <table id="statisticsTable" class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th width="50">ID</th>
                        <th>Label</th>
                        <th width="100">Value</th>
                        <th width="80">Suffix</th>
                        <th width="80">Order</th>
                        <th width="100">Active</th>
                        <th width="160">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($statistics as $stat): ?>
                    <tr>
                        <td><?= $stat['id'] ?></td>
                        <td class="text-truncate" style="max-width:200px">
                            <?= htmlspecialchars($stat['label']) ?>
                        </td>
                        <td><?= $stat['value'] ?></td>
                        <td><?= $stat['suffix'] ?></td>
                        <td><?= $stat['order'] ?></td>
                        <td>
                            <span class="badge <?= $stat['is_active'] ? 'badge-success' : 'badge-secondary' ?>">
                                <?= $stat['is_active'] ? 'Active' : 'Inactive' ?>
                            </span>
                        </td>
                        <td class="text-nowrap">
                            <a href="/statistic/edit/<?= $stat['id'] ?>" class="btn btn-sm btn-warning mr-1">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="/statistic/delete/<?= $stat['id'] ?>" method="POST" class="d-inline">
                                <input type="hidden" name="csrf_token" value="<?= \App\Middleware\CsrfMiddleware::generateToken() ?>">
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this statistic?')">
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


<?php require __DIR__ . '/../layouts/footer.php'; ?>
<?php require __DIR__ . '/../layouts/scripts.php'; ?>
