<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/navbar.php'; ?>
<?php require __DIR__ . '/../layouts/sidebar.php'; ?>

<div class="content-wrapper">
  <section class="content pt-3">
    <div class="container-fluid">

      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Users List</h3>

          <div class="card-tools">
           <a href="/admin/createUser" class="btn btn-sm btn-primary">
            Add New User
            </a>
          </div>
        </div>

        <div class="card-body table-responsive p-0">
          <table class="table table-hover text-nowrap">
            <thead>
              <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Roles</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($users as $user): ?>
                <tr>
                  <td><?= htmlspecialchars($user['id']) ?></td>
                  <td><?= htmlspecialchars($user['username']) ?></td>
                  <td><?= htmlspecialchars($user['email']) ?></td>
                  <td>
                    <?= isset($user['roles']) && is_array($user['roles'])
                        ? implode(', ', $user['roles'])
                        : '—' ?>
                  </td>
                  <td>
                   <a href="/admin/editUser/<?= $user['id'] ?>" class="btn btn-sm btn-warning">
                    Edit
                    </a>
                   <form method="POST" action="/admin/deleteUser/<?= $user['id'] ?>" style="display:inline;">
                        <input type="hidden" name="csrf_token"
                            value="<?= \App\Middleware\CsrfMiddleware::generateToken() ?>">
                        <button class="btn btn-sm btn-danger"
                                onclick="return confirm('Are you sure?')">
                            Delete
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
