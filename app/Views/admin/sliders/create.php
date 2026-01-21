<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/navbar.php'; ?>
<?php require __DIR__ . '/../layouts/sidebar.php'; ?>

<div class="content-wrapper">
<section class="content pt-3">
<div class="container-fluid">

<form method="POST" action="/slider/store">
<input type="hidden" name="csrf_token"
value="<?= \App\Middleware\CsrfMiddleware::generateToken() ?>">

<input type="hidden" name="media_id" id="media_id">

<div class="card card-outline card-success">
  <div class="card-header">
    <h3 class="card-title">
      <i class="fas fa-plus-circle mr-1"></i> Create Slider
    </h3>
  </div>

  <div class="card-body">

    <div class="form-group">
      <label>Title</label>
      <input type="text" name="title" class="form-control" required>
    </div>

    <div class="form-group">
      <label>Slider Image</label><br>
      <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#mediaModal">
        <i class="fas fa-image"></i> Choose Image
      </button>

      <div class="mt-3">
        <img id="mediaPreview" class="img-thumbnail d-none"
             style="max-width:180px;border-radius:10px">
      </div>
    </div>

    <div class="form-group">
      <label>Description</label>
      <textarea name="description" class="form-control"></textarea>
    </div>

    <div class="form-group">
      <label>Order</label>
      <input type="number" name="order" class="form-control" value="0">
    </div>

  </div>

  <div class="card-footer text-right">
    <a href="/slider" class="btn btn-secondary">
      <i class="fas fa-times"></i> Cancel
    </a>
    <button class="btn btn-success">
      <i class="fas fa-save"></i> Save
    </button>
  </div>
</div>

</form>
</div>
</section>
</div>



<div class="modal fade" id="mediaModal">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">
          <i class="fas fa-photo-video"></i> Select Image
        </h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body">
        <div class="row">
          <?php foreach ($media as $item): ?>
            <?php if ($item['type'] === 'image' && $item['is_deleted'] == 0): ?>
            <div class="col-md-3 mb-3">
              <div class="card media-item"
                   style="cursor:pointer"
                   onclick="selectMedia(
                     <?= $item['id'] ?>,
                     '/<?= htmlspecialchars($item['path']) ?>'
                   )">
                <img src="/<?= htmlspecialchars($item['path']) ?>"
                     class="card-img-top"
                     style="height:140px;object-fit:cover">
              </div>
            </div>
            <?php endif; ?>
          <?php endforeach; ?>
        </div>
      </div>

    </div>
  </div>
</div>


<?php require __DIR__ . '/../layouts/footer.php'; ?>
<?php require __DIR__ . '/../layouts/scripts.php'; ?>
