<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/navbar.php'; ?>
<?php require __DIR__ . '/../layouts/sidebar.php'; ?>

<div class="content-wrapper">
<section class="content pt-3">
<div class="container-fluid">

<form method="POST" action="/slider/update/<?= $slider['id'] ?>">
<input type="hidden" name="csrf_token"
       value="<?= \App\Middleware\CsrfMiddleware::generateToken() ?>">

<!-- Media ID محفوظ مسبقًا -->
<input type="hidden" name="media_id" id="media_id" value="<?= $slider['media_id'] ?>">

<div class="card card-outline card-warning">
  <div class="card-header">
    <h3 class="card-title">
      <i class="fas fa-edit mr-1"></i> Edit Slider
    </h3>
  </div>

  <div class="card-body">

    <!-- Title -->
    <div class="form-group">
      <label>Title</label>
      <input type="text"
             name="title"
             class="form-control"
             value="<?= htmlspecialchars($slider['title']) ?>"
             required>
    </div>

    <!-- Current Image -->
    <div class="form-group">
      <label>Current Image</label><br>
      <img id="currentMedia"
           src="<?= !empty($slider['media_path']) ? '/'.htmlspecialchars($slider['media_path']) : '' ?>"
           class="img-thumbnail"
           style="max-width:180px;border-radius:10px"
           <?= empty($slider['media_path']) ? 'class="d-none"' : '' ?>>
    </div>

    <!-- Media Picker -->
    <div class="form-group">
      <label>Change Image</label><br>
      <button type="button"
              class="btn btn-outline-primary"
              data-toggle="modal"
              data-target="#mediaPickerModal">
        <i class="fas fa-image"></i> Choose Image
      </button>

      <div class="mt-3">
        <img id="mediaPreview"
             class="img-thumbnail <?= empty($slider['media_path']) ? 'd-none' : '' ?>"
             src="<?= !empty($slider['media_path']) ? '/'.htmlspecialchars($slider['media_path']) : '' ?>"
             style="max-width:180px;border-radius:10px">
      </div>

      <small class="text-muted d-block mt-1">
        Select an image from media library
      </small>
    </div>

    <!-- Description -->
    <div class="form-group">
      <label>Description</label>
      <textarea name="description"
                class="form-control"
                rows="3"><?= htmlspecialchars($slider['description']) ?></textarea>
    </div>

    <!-- Order -->
    <div class="form-group">
      <label>Order</label>
      <input type="number"
             name="order"
             class="form-control"
             value="<?= (int)$slider['order'] ?>">
    </div>

  </div>

  <!-- Footer -->
  <div class="card-footer text-right">
    <a href="/slider" class="btn btn-secondary">
      <i class="fas fa-times"></i> Cancel
    </a>

    <button class="btn btn-warning">
      <i class="fas fa-sync"></i> Update Slider
    </button>
  </div>
</div>

</form>
</div>
</section>
</div>

<!-- ================= MEDIA PICKER MODAL ================= -->
<div class="modal fade" id="mediaPickerModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">
          <i class="fas fa-photo-video mr-1"></i> Select Image
        </h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body">
        <div class="row">
          <?php foreach ($media as $item): ?>
            <?php if ($item['type'] === 'image' && $item['is_deleted'] == 0): ?>
            <div class="col-md-3 mb-3">
              <div class="card media-item shadow-sm"
                   style="cursor:pointer"
                   data-id="<?= $item['id'] ?>"
                   data-path="/<?= htmlspecialchars($item['path']) ?>">
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

