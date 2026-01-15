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
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/assets/adminlte/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="/assets/adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="/assets/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="/assets/adminlte/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/assets/adminlte/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="/assets/adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="/assets/adminlte/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="/assets/adminlte/plugins/summernote/summernote-bs4.min.css">
  <link rel="stylesheet" href="/assets/adminlte/plugins/ekko-lightbox/ekko-lightbox.css">


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

  </style>
</head>

<body class="layout-fixed sidebar-expand-lg sidebar-open bg-body-tertiary hold-transition ">
<div class="app-wrapper">

