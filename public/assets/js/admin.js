

Dropzone.autoDiscover = false;

document.addEventListener('DOMContentLoaded', function () {

    const myDropzone = new Dropzone("#mediaDropzone", {
        url: "/media/upload",
        paramName: "file",
        maxFilesize: 15,
        acceptedFiles: "image/jpeg,image/png,image/webp,image/svg+xml",


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

$(function () {
  $('#newsTable').DataTable({
    paging: true,
    searching: true,
    ordering: true,
    info: true,
    lengthChange: true,
    pageLength: 10,
    responsive: true,
    order: [[4, 'desc']]
  });
});

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
                'max-height': '90vh',   
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


$(function () {
    $('#applicationsTable').DataTable({
        paging: true,
        searching: true,
        ordering: true,
        info: true,
        lengthChange: true,
        pageLength: 10,
        responsive: true,
        order: [[4, 'desc']] 
    });
});

$(function () {
  $('#sliderTable').DataTable({
    autoWidth: false,
    responsive: true,
    order: [[0, 'desc']], 
    dom:
      "<'row mb-3'<'col-md-6'l><'col-md-6 text-right'f>>" +
      "<'row'<'col-md-12'tr>>" +
      "<'row mt-3'<'col-md-5'i><'col-md-7'p>>"
  });
});

function selectMedia(id, path) {
  document.getElementById('media_id').value = id;
  const img = document.getElementById('mediaPreview');
  img.src = path;
  img.classList.remove('d-none');
  $('#mediaModal').modal('hide');
}


$(document).ready(function() {
  $('.media-item').on('click', function() {
    const id  = $(this).data('id');
    const src = $(this).data('path');
    $('#media_id').val(id);
    $('#mediaPreview').attr('src', src).removeClass('d-none');

    $('#mediaPickerModal').modal('hide');
  });
});





$(function () {
    $('#statisticsTable').DataTable({
        paging: true,
        searching: true,
        ordering: true,
        info: true,
        lengthChange: true,
        pageLength: 10,
        responsive: true,
        order: [[0, 'desc']]
    });
});


$(function() {
    $('#partnersTable').DataTable({
        paging: true,
        searching: true,
        ordering: true,
        info: true,
        responsive: true,
        order: [[0, 'desc']]
    });
});
