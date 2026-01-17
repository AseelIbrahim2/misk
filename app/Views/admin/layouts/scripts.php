<script src="/assets/adminlte/plugins/jquery/jquery.min.js"></script>
<script src="/assets/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/assets/adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="/assets/adminlte/dist/js/adminlte.min.js"></script>

<script src="/assets/adminlte/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/assets/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>

<!-- Ekko Lightbox -->
<script src="/assets/adminlte/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>

<!-- Dropzone -->
<script src="/assets/adminlte/plugins/dropzone/min/dropzone.min.js"></script>

<script>
Dropzone.autoDiscover = false;

document.addEventListener('DOMContentLoaded', function () {

    const myDropzone = new Dropzone("#mediaDropzone", {
        url: "/media/upload",
        paramName: "file",
        maxFilesize: 2,
        acceptedFiles: "image/jpeg,image/png,image/webp",

        autoProcessQueue: false, 
        addRemoveLinks: true,
        parallelUploads: 5,

        init: function () {
            let dz = this;

            document.getElementById("uploadBtn")
                .addEventListener("click", function () {
                    if (dz.getQueuedFiles().length === 0) {
                        alert("Please select at least one file");
                        return;
                    }
                    dz.processQueue(); 
                });
        },

        success: function () {
            window.location.href = "/media";
        },

        error: function (file, message) {
            alert(message);
        }
    });

});
</script>

<script>
$(function () {
    $('#newsTable').DataTable({
        paging: true,
        searching: true,
        ordering: true,
        info: true,
        lengthChange: true,
        pageLength: 10,
        responsive: true
    });
});
</script>


<script>
$(document).on('click', '[data-toggle="lightbox"]', function(event) {
    event.preventDefault();

    let caption = $(this).data('title') + '<br><small class="text-muted">' + $(this).find('img').attr('src') + '</small>';

    $(this).ekkoLightbox({
        alwaysShowClose: true,
        showArrows: true,
        loadingMessage: 'Loading...',
        title: caption, 
        onShown: function() {
            $('.ekko-lightbox .modal-dialog').css({
                'max-width': '95%',
                'width': 'auto'
            });
            $('.ekko-lightbox img').css({
                'max-width': '100%',
                'max-height': '90vh',   // زيادة لارتفاع النافذة
                'object-fit': 'contain',
                'display': 'block',
                'margin': '0 auto'
            });

            $('.ekko-lightbox .modal-title').css({
                'font-size': '15px',
                'text-align': 'center',
                'margin-bottom': '10px',
                'word-break': 'break-word'
            });
        }
    });
});

</script>






</div>
</body>
</html>



