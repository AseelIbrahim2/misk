<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../layouts/navbar.php'; ?>
<?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

<div class="content-wrapper">

    <!-- Page Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Media Gallery</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">Media</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Uploaded Media</h3>
                </div>

                <div class="card-body">
                    <div class="row">

                        <?php if (!empty($media)): ?>
                            <?php foreach ($media as $item): ?>

                                <!-- If soft deleted, reduce opacity -->
                                <div class="col-sm-2 mb-3" style="<?= $item['is_deleted'] ? 'opacity:0.5;' : '' ?>">

                                    <!-- Lightbox link -->
                                    <a href="/<?= $item['path'] ?>"
                                       data-toggle="lightbox"
                                       data-title="<?= htmlspecialchars($item['name']) ?>"
                                       data-gallery="media-gallery"
                                       <?= $item['is_deleted'] ? 'class="disabled-link"' : '' ?>>

                                        <img src="/<?= $item['path'] ?>"
                                             class="img-fluid mb-2"
                                             alt="<?= htmlspecialchars($item['name']) ?>">
                                    </a>

                                    <!-- Actions -->
                                    <div class="d-flex justify-content-between align-items-center mt-1">

                                        <small class="text-muted">ID: <?= $item['id'] ?></small>

                                        <?php if (!$item['is_deleted']): ?>
                                            <!-- Soft Delete -->
                                            <a href="/media/delete/<?= $item['id'] ?>"
                                               class="btn btn-sm btn-danger"
                                               onclick="return confirm('Delete this file?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        <?php else: ?>
                                            <!-- Optionally, Restore button -->
                                            <a href="/media/restore/<?= $item['id'] ?>"
                                               class="btn btn-sm btn-success"
                                               onclick="return confirm('Restore this file?')">
                                                Restore
                                            </a>
                                        <?php endif; ?>

                                        <!-- Hard Delete always available -->
                                        <a href="/media/forceDelete/<?= $item['id'] ?>" 
                                           class="btn btn-sm btn-dark"
                                           onclick="return confirm('This will permanently delete this file!')">
                                           Hard Delete
                                        </a>
                                    </div>

                                    <!-- Path -->
                                    <input type="text"
                                           class="form-control form-control-sm mt-1"
                                           value="/<?= $item['path'] ?>"
                                           readonly>

                                </div>

                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-12">
                                <p class="text-muted">No media found.</p>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>

        </div>
    </section>
</div>


<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
<?php require_once __DIR__ . '/../layouts/scripts.php'; ?>
