<?php require __DIR__ . '/../../layouts/header.php'; ?>
<?php require __DIR__ . '/../../layouts/navbar.php'; ?>
<?php require __DIR__ . '/../../layouts/sidebar.php'; ?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"><h1>Menus</h1></div>
                <div class="col-sm-6 text-right">
                    <a href="/menus/create" class="btn btn-primary">Add Menu</a>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Title</th>
                            <th>Created</th>
                            <th>Updated</th>
                            <th>Actions</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($menus as $menu): ?>
                            <tr>
                                <td><?= $menu['id']; ?></td>
                                <td><?= $menu['name']; ?></td>
                                <td><?= $menu['title']; ?></td>
                                <td><?= $menu['created']; ?></td>
                                <td><?= $menu['updated']; ?></td>
                                <td>
                                    <a href="/menus/edit/<?= $menu['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="/menus/delete/<?= $menu['id']; ?>" method="POST" style="display:inline-block;">
                                        <input type="hidden" name="csrf_token" value="<?= \App\Middleware\CsrfMiddleware::generateToken(); ?>">
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                    <a href="/MenuLinks/index/<?= $menu['id']; ?>" class="btn btn-sm btn-info">View Links</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<?php require __DIR__ . '/../../layouts/footer.php'; ?>
<?php require __DIR__ . '/../../layouts/scripts.php'; ?>
