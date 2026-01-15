<script src="/assets/adminlte/plugins/jquery/jquery.min.js"></script>
<script src="/assets/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/assets/adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="/assets/adminlte/dist/js/adminlte.min.js"></script>

<script src="/assets/adminlte/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/assets/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>

<!-- Ekko Lightbox -->
<link rel="stylesheet" href="/assets/adminlte/plugins/ekko-lightbox/ekko-lightbox.css">
<script src="/assets/adminlte/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>

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
$(document).on('click', '[data-toggle="lightbox"]', function (event) {
    event.preventDefault();
    $(this).ekkoLightbox({
        alwaysShowClose: true
    });
});
</script>



</div>
</body>
</html>



