<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Edit Partner</h1>
    </section>

    <section class="content mt-3">
        <form action="/partners/update/<?= $partner['id'] ?>" method="POST">
            <input type="hidden" name="csrf_token"
                   value="<?= \App\Middleware\CsrfMiddleware::generateToken() ?>">

            <div class="form-group">
                <label>Name</label>
                <input type="text"
                       name="name"
                       class="form-control"
                       value="<?= htmlspecialchars($partner['name']) ?>">
            </div>
            <div class="form-group">
                <label>Media</label>

                <div class="media-gallery d-flex flex-wrap gap-3">
                    <?php foreach ($media as $m): ?>
                        <label style="text-align:center; cursor:pointer;">
                            <img src="/<?= htmlspecialchars($m['path']) ?>"
                                style="width:90px; height:60px; object-fit:cover;
                                        border:<?= ($partner['media_id'] == $m['id'])
                                            ? '2px solid #28a745'
                                            : '1px solid #ccc' ?>;
                                        padding:3px;">
                            <br>
                            <input type="radio"
                                name="media_id"
                                value="<?= $m['id'] ?>"
                                <?= ($partner['media_id'] == $m['id']) ? 'checked' : '' ?>>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="form-group">
                <label>Link</label>
                <input type="text"
                       name="link"
                       class="form-control"
                       value="<?= htmlspecialchars($partner['link']) ?>">
            </div>

            <div class="form-group">
                <label>Order</label>
                <input type="number"
                       name="order"
                       class="form-control"
                       value="<?= (int)$partner['order'] ?>">
            </div>

            <button class="btn btn-success">Update Partner</button>
            <a href="/partners" class="btn btn-secondary">Back</a>
        </form>
    </section>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
<?php require_once __DIR__ . '/../layouts/scripts.php'; ?>
