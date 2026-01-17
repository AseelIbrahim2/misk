<?php require __DIR__ . '/../../layouts/header.php'; ?>
<?php require __DIR__ . '/../../layouts/navbar.php'; ?>
<?php require __DIR__ . '/../../layouts/sidebar.php'; ?>

<div class="content-wrapper">
<section class="content pt-3">
<div class="container-fluid">

<a href="/slider/create" class="btn btn-primary mb-3">Add Slider</a>

<table class="table table-bordered">
<thead>
<tr>
  <th>ID</th>
 <th>Image</th>
<th>Title</th>
<th>Order</th>
  <th>Actions</th>
</tr>
</thead>

<tbody>
<?php foreach ($sliders as $slider): ?>
<tr>
<td><?= $slider['id'] ?></td>
<td>
  <?php if (!empty($slider['media_id'])): ?>
    <img src="/<?= htmlspecialchars($slider['media_path'] ?? '') ?>"
         width="80"
         style="border-radius:6px">
  <?php endif; ?>
</td>

<td><?= htmlspecialchars($slider['title']) ?></td>
<td><?= (int)$slider['order'] ?></td>
<td>
<a href="/slider/edit/<?= $slider['id'] ?>" class="btn btn-sm btn-warning">Edit</a>

<form method="POST" action="/slider/delete/<?= $slider['id'] ?>" style="display:inline">
<input type="hidden" name="csrf_token"
value="<?= \App\Middleware\CsrfMiddleware::generateToken() ?>">
<button class="btn btn-sm btn-danger">Delete</button>
</form>
</td>
</tr>
<?php endforeach; ?>
</tbody>

</table>

</div>
</section>
</div>

<?php require __DIR__ . '/../../layouts/footer.php'; ?>
<?php require __DIR__ . '/../../layouts/scripts.php'; ?>
