<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/navbar.php'; ?>
<?php require __DIR__ . '/../layouts/sidebar.php'; ?>


<div class="content-wrapper">

    <!-- Page Header -->
    <section class="content-header">
        <div class="container-fluid">
            <h1>Upload Media</h1>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Upload Files</h3>
                </div>

                <div class="card-body">

                    <!-- Dropzone -->
                    <form
                        action="/media/upload"
                        method="POST"
                        enctype="multipart/form-data"
                        class="dropzone"
                        id="mediaDropzone">

                        <input type="hidden" name="csrf_token"
                               value="<?= \App\Middleware\CsrfMiddleware::generateToken() ?>">

                        <div class="dz-message text-center">
                            <i class="fas fa-cloud-upload-alt fa-3x mb-3 text-primary"></i>
                            <h4>Drag & drop files here</h4>
                            <p class="text-muted">or click to select files</p>
                        </div>

                    </form>
                     <div class=" d-flex align-items-center justify-content-between ">
                    <button type="button"
                            id="uploadBtn"
                            class="btn btn-primary mt-3">
                        <i class="fas fa-upload"></i> Upload
                    </button>
                     <a href="/media/index" class="btn btn-secondary">Cancel</a>
                    </div>
                    

                </div>

                <div class="card-footer text-muted ">
                    Allowed types: JPG, PNG, WEBP, SVG • Max size: 15MB
                </div>

            </div>
            

        </div>
    </section>
</div>


<?php require __DIR__ . '/../layouts/footer.php'; ?>
<?php require __DIR__ . '/../layouts/scripts.php'; ?>