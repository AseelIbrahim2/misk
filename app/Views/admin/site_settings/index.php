<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../layouts/navbar.php'; ?>
<?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Site Settings</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <?php if (!empty($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?= $_SESSION['success']; unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($_SESSION['errors'])): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach ($_SESSION['errors'] as $fieldErrors): ?>
                            <?php foreach ($fieldErrors as $error): ?>
                                <li><?= htmlspecialchars($error) ?></li>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php unset($_SESSION['errors']); ?>
            <?php endif; ?>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Site Settings</h3>
                </div>

                <div class="card-body">
                    <form action="/sitesetting/update" method="POST">
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

                        <div class="form-group">
                            <label>Site Name</label>
                            <input type="text" name="site_name" class="form-control"
                                   value="<?= htmlspecialchars($setting['site_name'] ?? '') ?>" required>
                        </div>

                        <div class="form-group">
                            <label>Slogan</label>
                            <input type="text" name="slogan" class="form-control"
                                   value="<?= htmlspecialchars($setting['slogan'] ?? '') ?>">
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control"
                                   value="<?= htmlspecialchars($setting['email'] ?? '') ?>" required>
                        </div>

                        <div class="form-group">
                            <label>Logo</label>
                            <select name="logo_m_id" class="form-control">
                                <option value="">-- Select Logo --</option>
                                <?php foreach ($media as $m): ?>
                                    <option value="<?= $m['id'] ?>" <?= ($m['id'] == $setting['logo_m_id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($m['name'] ?? $m['path']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                            <div >

                            <?php if(!empty($setting['logo_path'])): ?>
                                <img src="/<?= $setting['logo_path'] ?>" alt="Logo" style="height:100px; margin-top:5px;" class="bg-dark d-flex ">
                            <?php endif; ?>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>

        </div>
    </section>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
<?php require_once __DIR__ . '/../layouts/scripts.php'; ?>
