<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../layouts/navbar.php'; ?>
<?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

<div class="content-wrapper">
<section class="content pt-3">
<div class="container-fluid">

<div class="card card-outline card-primary">
  <div class="card-header d-flex align-items-center">
    <h3 class="card-title flex-grow-1">
      <i class="fas fa-newspaper mr-1"></i> News List
    </h3>

    <a href="/news/create" class="btn btn-primary btn-sm">
      <i class="fas fa-plus"></i> Add News
    </a>
  </div>

  <div class="card-body">
    <table id="newsTable" class="table table-hover">
      <thead>
        <tr>
          <th width="50">#</th>
          <th width="260">Title</th>
          <th width="120">Author</th>
          <th width="140">Status</th>
          <th width="140">Created</th>
          <th width="200">Description</th>
          <th width="160">Media</th>
          <th width="140">Actions</th>
        </tr>
      </thead>

      <tbody>
      <?php foreach ($news as $item): ?>
        <tr>
          <td><?= $item['id'] ?></td>

          <td class="text-truncate" style="max-width:260px">
            <?= htmlspecialchars($item['title']) ?>
          </td>

          <td><?= htmlspecialchars($item['user_id']) ?></td>

          <td>
            <?php
              echo match ($item['status']) {
                0 => '<span class="badge badge-secondary">Pending</span>',
                1 => '<span class="badge badge-success">Published</span>',
                2 => '<span class="badge badge-warning">Archived</span>',
              };
              if ($item['is_deleted']) {
                echo ' <span class="badge badge-danger">Deleted</span>';
              }
            ?>
          </td>

          <td><?= htmlspecialchars($item['created']) ?></td>

          <td class="text-truncate" style="max-width:200px">
            <?= htmlspecialchars(mb_strimwidth($item['description'], 0, 80, '...')) ?>
          </td>

          <td>
            <?php if (!empty($item['media_path'])): ?>
              <img src="/<?= htmlspecialchars($item['media_path']) ?>"
                   class="img-thumbnail"
                   style="max-width:150px;border-radius:10px">
            <?php else: ?>
              <span class="text-muted">N/A</span>
            <?php endif; ?>
          </td>

          <td class="text-nowrap">
            <?php if (!$item['is_deleted']): ?>
              <a href="/news/edit/<?= $item['id'] ?>"
                 class="btn btn-sm btn-primary mr-1">
                <i class="fas fa-edit"></i>
              </a>
            <?php endif; ?>

            <form action="/news/delete/<?= $item['id'] ?>"
                  method="POST"
                  class="d-inline">
              <input type="hidden" name="csrf_token"
                     value="<?= $_SESSION['csrf_token'] ?>">
              <button class="btn btn-sm btn-danger"
                      onclick="return confirm('Delete this news?')">
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


<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
<?php require_once __DIR__ . '/../layouts/scripts.php'; ?>
