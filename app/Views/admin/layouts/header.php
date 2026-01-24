

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title><?= $title ?? 'Admin Panel' ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Font Awesome -->
<link rel="stylesheet" href="/assets/adminlte/plugins/fontawesome-free/css/all.min.css">
<!-- overlayScrollbars -->
<link rel="stylesheet" href="/assets/adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="/assets/adminlte/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/assets/adminlte/dist/css/adminlte.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="/assets/adminlte/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="/assets/adminlte/plugins/summernote/summernote-bs4.min.css">
  <link rel="stylesheet" href="/assets/adminlte/plugins/ekko-lightbox/ekko-lightbox.css">
  

    <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="/assets/adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">




  <style>


/* prevent click on soft deleted items */
.disabled-link {
    pointer-events: none;
}


.dataTables_wrapper .dataTables_filter label {
  float: right !important;
    display: flex !important;
    align-items: center;
    gap: 5px; 
}

.dataTables_wrapper .dataTables_length {
    float: left !important;
    text-align: left !important;
}


.dataTables_wrapper .dataTables_paginate {
    float: right !important;
    margin-top: 10px;
}


.dataTables_wrapper .dataTables_info {
    float: left !important;
    margin-top: 10px;
}



/* Center preview container 22 ميديا  */

.dz-success-mark,
.dz-error-mark {
    display: none !important;
}


/* Center preview container */
.dropzone {
    display: flex;
    flex-direction: column;
    align-items: center;
}

/* Center each preview */
.dropzone .dz-preview {
    margin: 15px auto;
    text-align: center;
}

/* Make image bigger */
.dropzone .dz-preview img {
    width: 220px;       /* حجم الصورة */
    height: auto;
    max-width: 100%;
    border-radius: 10px;
}

/* Remove default small thumbnail sizing */
.dropzone .dz-image {
    width: auto;
    height: auto;
}

/* Hide success/error icons */
.dz-success-mark,
.dz-error-mark {
    display: none !important;
}


----------------------------------------
/* Soft deleted items */
.deleted {
    opacity: 0.5;
}

/* Disable clicking for soft deleted */
.disabled-link {
    pointer-events: none;
}

/* Media card styling */
.media-card {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    transition: transform 0.2s ease;
}

.media-card:hover {
    transform: scale(1.05);
}

.media-card img {
    width: 100%;
    height: 160px;
    object-fit: cover;
    border-radius: 8px;
}

/* Media actions buttons */
.media-actions a {
    margin: 2px 4px;
}
  </style>
</head>

<body class="layout-fixed sidebar-expand-lg sidebar-open bg-body-tertiary hold-transition ">
<div class="app-wrapper">

