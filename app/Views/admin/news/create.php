<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/navbar.php'; ?>
<?php require __DIR__ . '/../layouts/sidebar.php'; ?>

<div class="content-wrapper">
<section class="content pt-3">
<div class="container-fluid">

<div class="card card-outline card-success">
  <div class="card-header">
    <h3 class="card-title">
      <i class="fas fa-plus"></i> Create News
    </h3>
  </div>

  <form action="/news/store" method="POST">
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
    <input type="hidden" name="media_id" id="media_id">

    <div class="card-body">

      <div class="form-group">
        <label>Title</label>
        <input type="text" name="title" class="form-control"
               value="<?= htmlspecialchars($_SESSION['old']['title'] ?? '') ?>" required>
      </div>

      <div class="form-group">
        <label>Description</label>
        <textarea name="description" rows="3" class="form-control"><?= htmlspecialchars($_SESSION['old']['description'] ?? '') ?></textarea>
      </div>

      <div class="form-group">
        <label>Content</label>
        <textarea name="content" rows="6" class="form-control" required><?= htmlspecialchars($_SESSION['old']['content'] ?? '') ?></textarea>
      </div>

      <div class="form-group">
        <label>Status</label>
        <select name="status" class="form-control">
          <option value="0">Pending</option>
          <option value="1">Published</option>
          <option value="2">Archived</option>
        </select>
      </div>

      <!-- Media Picker -->
      <div class="form-group">
        <label>Media</label><br>

        <button type="button" class="btn btn-outline-primary"
                data-toggle="modal" data-target="#mediaModal">
          <i class="fas fa-image"></i> Choose Media
        </button>

        <div class="mt-2">
          <img id="mediaPreview" src="" class="img-thumbnail d-none"
               style="max-width:180px;border-radius:10px">
        </div>
      </div>

      <div class="form-group">
        <label>Deleted</label>
        <select name="is_deleted" class="form-control">
          <option value="0">No</option>
          <option value="1">Yes</option>
        </select>
      </div>

    </div>

    <div class="card-footer text-right">
      <button class="btn btn-success">Save</button>
      <a href="/news/index" class="btn btn-secondary">Cancel</a>
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
        <h5 class="modal-title">
          <i class="fas fa-photo-video"></i> Select Media
        </h5>
        <button class="close" data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body">
        <div class="row">
          <?php foreach ($media as $m): ?>
            <?php if ($m['type']==='image' && $m['is_deleted']==0): ?>
              <div class="col-md-3 mb-3">
                <div class="media-item"
                     data-id="<?= $m['id'] ?>"
                     data-path="/<?= htmlspecialchars($m['path'] ?? $m['media_path']) ?>">
                  <img src="/<?= htmlspecialchars($m['path'] ?? $m['media_path']) ?>"
                       class="img-thumbnail"
                       style="cursor:pointer;border-radius:10px">
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
