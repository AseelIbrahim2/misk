<?php require __DIR__ . '/../../layouts/header.php'; ?>
<?php require __DIR__ . '/../../layouts/navbar.php'; ?>
<?php require __DIR__ . '/../../layouts/sidebar.php'; ?>

<div class="content-wrapper">
<section class="content pt-3">
<div class="container-fluid">

<form method="POST" action="/slider/store">
<input type="hidden" name="csrf_token"
value="<?= \App\Middleware\CsrfMiddleware::generateToken() ?>">

<div class="mb-3">
  <label>Title</label>
  <input type="text" name="title" class="form-control" required>
</div>

<div class="mb-3">
  <label>Slider Image</label>
  <select name="media_id" class="form-control" required>
    <option value="">-- Select Image --</option>

    <?php foreach ($media as $item): ?>
      <?php if ($item['type'] === 'image' && $item['is_deleted'] == 0): ?>
        <option value="<?= $item['id'] ?>">
          <?= $item['name'] ?>
        </option>
      <?php endif; ?>
    <?php endforeach; ?>
  </select>
</div>


<div class="mb-3">
  <label>Description</label>
  <textarea name="description" class="form-control"></textarea>
</div>

<div class="mb-3">
  <label>Order</label>
  <input type="number" name="order" class="form-control" value="0">
</div>

<button class="btn btn-success">Save</button>
</form>




</div>
</section>
</div>

<?php require __DIR__ . '/../../layouts/footer.php'; ?>
<?php require __DIR__ . '/../../layouts/scripts.php'; ?>
