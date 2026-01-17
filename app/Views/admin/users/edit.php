<?php require __DIR__ . '/../../layouts/header.php'; ?>
<?php require __DIR__ . '/../../layouts/navbar.php'; ?>
<?php require __DIR__ . '/../../layouts/sidebar.php'; ?>

<div class="content-wrapper">
  <section class="content pt-3">
    <div class="container-fluid">

      <div class="card">
        <div class="card-header">
          <h3 class="h3">Edit User</h3>
          <?php
            $errors = $_SESSION['errors'] ?? [];
            $old = $_SESSION['old'] ?? [];
            unset($_SESSION['errors'], $_SESSION['old']);
            ?>

            <form method="POST" action="/admin/updateUser/<?= $user['id'] ?>">
                <input type="hidden" name="csrf_token"
                    value="<?= \App\Middleware\CsrfMiddleware::generateToken() ?>">

                <?php if(!empty($errors)): ?>
                <div class="alert alert-danger" style="opacity: 0.5;">
                    <ul class="mb-0">
                        <?php foreach($errors as $field => $messages): ?>
                            <?php foreach($messages as $msg): ?>
                                <li><?= htmlspecialchars($msg) ?></li>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>

                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username"
                        value="<?= htmlspecialchars($old['username'] ?? $user['username']) ?>"
                        class="form-control">
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email"
                        value="<?= htmlspecialchars($old['email'] ?? $user['email']) ?>"
                        class="form-control">
                </div>
                <div class="form-group">
                    <label>Role</label>
                    <select name="role_id" class="form-control" required>
                        <?php foreach ($roles as $role): ?>
                            <option value="<?= $role['id'] ?>"
                                <?= (($old['role_id'] ?? $userRoleId) == $role['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($role['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>


                <div class="form-group">
                    <label>New Password (optional)</label>
                    <input type="password" name="password" class="form-control">
                </div>

                <button class="btn btn-primary">Update</button>
                 <a href="/admin/users" class="btn btn-secondary">Cancel</a>
                
            </form>

      </div>

    </div>
  </section>
</div>

<?php require __DIR__ . '/../../layouts/footer.php'; ?>
<?php require __DIR__ . '/../../layouts/scripts.php'; ?>
