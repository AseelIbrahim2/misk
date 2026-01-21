<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/navbar.php'; ?>
<?php require __DIR__ . '/../layouts/sidebar.php'; ?>

<div class="content-wrapper">
<section class="content pt-3">
<div class="container-fluid">

<div class="card card-outline card-primary">
  <div class="card-header">
    <div class="d-flex justify-content-between align-items-center">
      <h3 class="card-title">
        <i class="fas fa-images mr-1"></i> Sliders
      </h3>
      <a href="/slider/create" class="btn btn-primary btn-sm">
        <i class="fas fa-plus"></i> Add Slider
      </a>
    </div>
  </div>

  <div class="card-body">
    <table id="sliderTable" class="table table-hover table-striped">
      <thead>
        <tr>
          <th width="60">#</th>
          <th width="140">Image</th>
          <th>Title</th>
          <th width="100">Order</th>
          <th width="140">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($sliders as $slider): ?>
        <tr>
          <td><?= $slider['id'] ?></td>
          <td>
            <?php if (!empty($slider['media_id'])): ?>
              <img src="/<?= htmlspecialchars($slider['media_path']) ?>"
                   class="img-thumbnail"
                   style="max-width:120px;border-radius:10px">
            <?php else: ?>
              <span class="text-muted">No Image</span>
            <?php endif; ?>
          </td>
          <td><?= htmlspecialchars($slider['title']) ?></td>
          <td>
            <span class="badge badge-info"><?= (int)$slider['order'] ?></span>
          </td>
          <td>
            <a href="/slider/edit/<?= $slider['id'] ?>" class="btn btn-sm btn-warning">
              <i class="fas fa-edit"></i>
            </a>

            <form method="POST" action="/slider/delete/<?= $slider['id'] ?>" style="display:inline-block">
              <input type="hidden" name="csrf_token"
                     value="<?= \App\Middleware\CsrfMiddleware::generateToken() ?>">
              <button class="btn btn-sm btn-danger"
                      onclick="return confirm('Delete this slider?')">
                <i class="fas fa-trash"></i>
              </button>
            </form>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

</div>
</section>
</div>



<?php require __DIR__ . '/../layouts/footer.php'; ?>
<?php require __DIR__ . '/../layouts/scripts.php'; ?>
