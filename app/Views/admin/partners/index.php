<?php
use App\Middleware\CsrfMiddleware;
?>
<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../layouts/navbar.php'; ?>
<?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

<div class="content-wrapper">
    <section class="content pt-3">
        <div class="container-fluid">

            <div class="card card-outline card-primary">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title"><i class=" fas fa-user-friends mr-1"></i> Partners List</h3>
                    <a href="/partners/create" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Add New
                    </a>
                </div>

                <div class="card-body">

                    <?php if (!empty($_SESSION['success'])): ?>
                        <div class="alert alert-success">
                            <?= $_SESSION['success']; unset($_SESSION['success']); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($partners)): ?>
                    <table id="partnersTable" class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th width="50">ID</th>
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
                                             style="max-width:80px; max-height:50px;">
                                    <?php else: ?>
                                        <span class="text-muted">—</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?= !empty($partner['link']) ? '<a href="'.htmlspecialchars($partner['link']).'" target="_blank">'.$partner['link'].'</a>' : '—' ?>
                                </td>
                                <td><?= (int)$partner['order'] ?></td>
                                <td class="text-nowrap">
                                    <a href="/partners/edit/<?= $partner['id'] ?>" class="btn btn-sm btn-warning mr-1">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="/partners/delete/<?= $partner['id'] ?>" method="POST" class="d-inline">
                                        <input type="hidden" name="csrf_token" value="<?= CsrfMiddleware::generateToken() ?>">
                                        <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i>
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

                </div>
            </div>

        </div>
    </section>
</div>


<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
<?php require_once __DIR__ . '/../layouts/scripts.php'; ?>
