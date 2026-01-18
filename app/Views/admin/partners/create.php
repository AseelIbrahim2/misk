<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Create Partner</h1>
    </section>

    <section class="content mt-3">
        <form action="/partners/store" method="POST">
            <input type="hidden" name="csrf_token"
                   value="<?= \App\Middleware\CsrfMiddleware::generateToken() ?>">

            <div class="form-group">
                <label>Name</label>
                <input type="text"
                       name="name"
                       class="form-control"
                       value="<?= htmlspecialchars($_SESSION['old']['name'] ?? '') ?>">
            </div>

           <div class="form-group">
                <label>Media</label>

                <div class="media-gallery d-flex flex-wrap gap-3">
                    <?php if (!empty($media)): ?>
                        <?php foreach ($media as $m): ?>
                            <label style="text-align:center; cursor:pointer;">
                                <img src="/<?= htmlspecialchars($m['path']) ?>"
                                    style="width:90px; height:60px; object-fit:cover;
                                            border:1px solid #ccc; padding:3px;">
                                <br>
                                <input type="radio"
                                    name="media_id"
                                    value="<?= $m['id'] ?>"
                                    <?= (($_SESSION['old']['media_id'] ?? '') == $m['id']) ? 'checked' : '' ?>>
                            </label>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-muted">No media available.</p>
                    <?php endif; ?>
                </div>
            </div>


            <div class="form-group">
                <label>Link</label>
                <input type="text"
                       name="link"
                       class="form-control"
                       value="<?= htmlspecialchars($_SESSION['old']['link'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label>Order</label>
                <input type="number"
                       name="order"
                       class="form-control"
                       value="<?= (int)($_SESSION['old']['order'] ?? 0) ?>">
            </div>

            <button class="btn btn-success">Create Partner</button>
            <a href="/partners" class="btn btn-secondary">Back</a>
        </form>
    </section>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
<?php require_once __DIR__ . '/../layouts/scripts.php'; ?>
