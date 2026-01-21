<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

<div class="content-wrapper">
    <section class="content pt-3">
        <div class="container-fluid">

            <div class="card card-outline card-success">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-plus"></i> Create Partner</h3>
                </div>

                <form action="/partners/store" method="POST">
                    <input type="hidden" name="csrf_token" value="<?= \App\Middleware\CsrfMiddleware::generateToken() ?>">
                    <input type="hidden" name="media_id" id="media_id" value="<?= $_SESSION['old']['media_id'] ?? '' ?>">

                    <div class="card-body">

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control"
                                   value="<?= htmlspecialchars($_SESSION['old']['name'] ?? '') ?>" required>
                        </div>

                        <div class="form-group">
                            <label>Media</label><br>
                            <button type="button" class="btn btn-outline-primary mb-2" data-toggle="modal" data-target="#mediaModal">
                                <i class="fas fa-image"></i> Choose Media
                            </button>
                            <div class="mt-2">
                                <img id="mediaPreview" src="<?= !empty($_SESSION['old']['media_path']) ? '/'.$_SESSION['old']['media_path'] : '' ?>"
                                     class="img-thumbnail <?= !empty($_SESSION['old']['media_path']) ? '' : 'd-none' ?>"
                                     style="max-width:180px; border-radius:10px;">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Link</label>
                            <input type="text" name="link" class="form-control"
                                   value="<?= htmlspecialchars($_SESSION['old']['link'] ?? '') ?>">
                        </div>

                        <div class="form-group">
                            <label>Order</label>
                            <input type="number" name="order" class="form-control"
                                   value="<?= (int)($_SESSION['old']['order'] ?? 0) ?>">
                        </div>

                    </div>

                    <div class="card-footer text-right">
                        <button class="btn btn-success">Create Partner</button>
                        <a href="/partners" class="btn btn-secondary">Back</a>
                    </div>
                </form>
            </div>

        </div>
    </section>
</div>

<!-- Media Modal -->
<div class="modal fade" id="mediaModal">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-photo-video"></i> Select Media</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <?php foreach ($media as $m): ?>
                        <div class="col-md-3 mb-3">
                            <div class="media-item" data-id="<?= $m['id'] ?>" data-path="/<?= htmlspecialchars($m['path']) ?>">
                                <img src="/<?= htmlspecialchars($m['path']) ?>" class="img-thumbnail" style="cursor:pointer; border-radius:10px;">
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>
    </div>
</div>


<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
<?php require_once __DIR__ . '/../layouts/scripts.php'; ?>
