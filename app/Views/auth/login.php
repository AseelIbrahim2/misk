<?php require __DIR__ . '/../layouts/auth-header.php'; ?>

<div class="login-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <b>Login</b>
    </div>

    <div class="card-body">

      <p class="login-box-msg">Sign in </p>

      <!-- 🔴 ERRORS -->

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger" style="opacity:0.85">
                <?php
                    $errors = json_decode($error, true);
                ?>

                <?php if (is_array($errors)): ?>
                    <ul class="mb-0">
                        <?php foreach ($errors as $field => $messages): ?>
                            <?php foreach ($messages as $msg): ?>
                                <li><?= htmlspecialchars($msg) ?></li>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <?= htmlspecialchars($error) ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>


      <form method="POST">
        <input type="hidden" name="csrf_token"
               value="<?= \App\Middleware\CsrfMiddleware::generateToken(); ?>">

        <div class="input-group mb-3">
          <input type="text"
                 name="usernameOrEmail"
                 class="form-control"
                 placeholder="Username or Email"
                 value="<?= htmlspecialchars($_POST['usernameOrEmail'] ?? '') ?>"
                 required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="password"
                 name="password"
                 class="form-control"
                 placeholder="Password"
                 required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-4 ml-auto">
            <button type="submit" class="btn btn-primary btn-block">
              Login
            </button>
          </div>
        </div>
      </form>

      <p class="mb-0 mt-3 text-center">
        <a href="/auth/register">Register new account</a>
      </p>

    </div>
  </div>
</div>


<?php require __DIR__ . '/../layouts/auth-footer.php'; ?>
<?php require __DIR__ . '/../layouts/scripts.php'; ?>
