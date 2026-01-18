<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../layouts/navbar.php'; ?>
<?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

<div class="content-wrapper">

    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>News Management</h1>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                        <h3 class="card-title flex-grow-1">News List</h3>

                        <a href="/news/create" class="btn btn-primary btn-sm ms-auto">
                            <i class="fas fa-plus"></i> Add News
                        </a>
                    </div>
                        <div class="card-body">
                            <table id="newsTable" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Description</th>
                                    <th>Media</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>

                                <tbody>
                                <?php foreach ($news as $item): ?>
                                    <tr>
                                        <td><?= $item['id'] ?></td>

                                        <td><?= htmlspecialchars($item['title']) ?></td>

                                        <td><?= $item['user_id'] ?></td>

                                        <td>
                                            <?php
                                            switch ($item['status']) {
                                                case 0:
                                                    echo '<span class="badge bg-secondary">Pending</span>';
                                                    break;
                                                case 1:
                                                    echo '<span class="badge bg-success">Published</span>';
                                                    break;
                                                case 2:
                                                    echo '<span class="badge bg-warning">Archived</span>';
                                                    break;
                                            }

                                            if ($item['is_deleted']) {
                                                echo ' <span class="badge bg-danger">Deleted</span>';
                                            }
                                            ?>
                                        </td>

                                        <td><?= $item['created'] ?></td>

                                        <td>
                                            <?= htmlspecialchars(mb_strimwidth($item['description'], 0, 50, '...')) ?>
                                        </td>
                                        <td>
                                            <?php if (!empty($item['media_path'])): ?>
                                                <img src="/<?= htmlspecialchars($item['media_path']) ?>" width="50" style="border-radius:6px">
                                            <?php else: ?>
                                                N/A
                                            <?php endif; ?>
                                        </td>


                                        <td>
                                            <?php if (!$item['is_deleted']): ?>
                                                <a href="/news/edit/<?= $item['id'] ?>"
                                                   class="btn btn-sm btn-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            <?php endif; ?>

                                            <form action="/news/delete/<?= $item['id'] ?>"
                                                  method="POST"
                                                  class="d-inline">
                                                <input type="hidden" name="csrf_token"
                                                       value="<?= $_SESSION['csrf_token'] ?>">

                                                <button class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Delete this news?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>

                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                </div>
            </div>

        </div>
    </section>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
<?php require_once __DIR__ . '/../layouts/scripts.php'; ?>
