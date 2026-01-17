<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/navbar.php'; ?>
<?php require __DIR__ . '/../layouts/sidebar.php'; ?>


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
                        <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
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
                <div class="card-header d-flex align-items-center">

                    <!-- Title -->
                    <h3 class="card-title mb-0">Uploaded Media</h3>

                    <!-- Upload Button -->
                    <div class="card-tools ml-auto">
                        <a href="/media/upload" class="btn btn-success">
                            <i class="fas fa-cloud-upload-alt"></i> Upload Media
                        </a>
                    </div>

                </div>

                <div class="card-body">
                    <div class="row">

                        <?php if (!empty($media)): ?>
                            <?php foreach ($media as $item): ?>

                                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6 mb-4">
                                    <div class="media-card <?= $item['is_deleted'] ? 'deleted' : '' ?>">

                                        <!-- Lightbox image -->
                                        <a href="/<?= $item['path'] ?>"
                                           data-toggle="lightbox"
                                           data-title="<?= htmlspecialchars($item['name']) ?>"
                                           data-gallery="media-gallery"
                                           <?= $item['is_deleted'] ? 'class="disabled-link"' : '' ?>>

                                            <img src="/<?= $item['path'] ?>"
                                                 alt="<?= htmlspecialchars($item['name']) ?>">
                                        </a>

                                        <!-- Actions -->
                                        <div class="media-actions mt-2 text-center">
                                            <small class="text-muted d-block mb-1">ID: <?= $item['id'] ?></small>

                                            <?php if (!$item['is_deleted']): ?>
                                                <a href="/media/delete/<?= $item['id'] ?>"
                                                   class="btn btn-sm btn-danger mb-1"
                                                   title="Soft Delete"
                                                   onclick="return confirm('Delete this file?')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            <?php else: ?>
                                                <a href="/media/restore/<?= $item['id'] ?>"
                                                   class="btn btn-sm btn-success mb-1"
                                                   title="Restore"
                                                   onclick="return confirm('Restore this file?')">
                                                    <i class="fas fa-undo"></i>
                                                </a>
                                            <?php endif; ?>

                                            <a href="/media/forceDelete/<?= $item['id'] ?>"
                                               class="btn btn-sm btn-dark mb-1"
                                               title="Hard Delete"
                                               onclick="return confirm('This will permanently delete this file!')">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        </div>

                                        <!-- File path -->
                                        <div class="text-center mt-2">
                                            <small class="text-muted text-break"><?= '/'.$item['path'] ?></small>
                                        </div>

                                    </div>
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

<?php require __DIR__ . '/../layouts/footer.php'; ?>
<?php require __DIR__ . '/../layouts/scripts.php'; ?>