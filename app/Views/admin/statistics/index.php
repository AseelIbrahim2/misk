<?php
// Admin Dashboard - Statistics List
use App\Middleware\CsrfMiddleware;
?>
<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/navbar.php'; ?>
<?php require __DIR__ . '/../layouts/sidebar.php'; ?>

<div class="content-wrapper">
<section class="content pt-3">
<div class="container-fluid">


    <h1>Statistics</h1>
    <a href="/statistic/create" class="btn btn-primary">Add New Statistic</a>

    <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <?php if (!empty($_SESSION['errors'])): ?>
        <div class="alert alert-danger">
            <?php foreach ($_SESSION['errors'] as $error): ?>
                <div><?= $error; ?></div>
            <?php endforeach; unset($_SESSION['errors']); ?>
        </div>
    <?php endif; ?>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Key</th>
                <th>Label</th>
                <th>Value</th>
                <th>Suffix</th>
                <th>Order</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($statistics as $stat): ?>
            <tr>
                <td><?= $stat['id'] ?></td>
                <td><?= $stat['key'] ?></td>
                <td><?= $stat['label'] ?></td>
                <td><?= $stat['value'] ?></td>
                <td><?= $stat['suffix'] ?></td>
                <td><?= $stat['order'] ?></td>
                <td><?= $stat['is_active'] ? 'Yes' : 'No' ?></td>
                <td>
                    <a href="/statistic/edit/<?= $stat['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                    <form action="/statistic/delete/<?= $stat['id'] ?>" method="POST" style="display:inline;">
                        <input type="hidden" name="csrf_token" value="<?= CsrfMiddleware::generateToken(); ?>">
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this statistic?')">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</section>
</div>


<?php require __DIR__ . '/../layouts/footer.php'; ?>
<?php require __DIR__ . '/../layouts/scripts.php'; ?>