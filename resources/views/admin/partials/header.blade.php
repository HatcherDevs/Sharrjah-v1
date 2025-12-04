<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SAT Admin</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('public/admin/vendors/iconfonts/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/admin/') }}/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="{{ asset('public/admin/') }}/vendors/css/vendor.bundle.addons.css">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('public/admin/') }}/css/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset('public/admin/') }}/images/favicon.png" />

    <!-- include summernote css/js -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    
    <link href="{{ url('public/froala_editor/css/froala_editor.pkgd.min.css') }}" rel='stylesheet' type='text/css' />

    <!--- Start fonts.google --->
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!--- End fonts.google --->
    <style>
        .form-control { border: 1px solid #a7a7a7; }
        .note-popover.popover { display: none; }
        .ui-widget.ui-widget-content { z-index: 1000 !important;}
        .content-wrapper {
            background: #696969;
        }
        .navbar.default-layout {
            background: #2a2a2a;
        }
        .type-box {
            display: none;
        }
        .type-box.active {
            display: block;
        }
        .file-upload {
            position: relative;
        }
        .remove-box {
            position: absolute;
            top: 0;
            right: 0;
        }

        .no-fontsize .note-fontsize {
            display: none !important;
        }

        .sidebar .nav .nav-item .nav-link {
            padding: 9px 35px;
            height: 32px;
        }
        .sidebar .nav.sub-menu .nav-item .nav-link {
            padding: 8px 1rem;
        }

        .sidebar .nav .nav-item .collapse.show, .sidebar .nav .nav-item .collapsing, .sidebar .nav .nav-item .nav-link[aria-expanded="true"] {
            background: #efefef;
        }

        .checkbox-wrapper {
    display: flex;
    align-items: center;
}

.checkbox-label {
    margin-left: 40px;
    margin-top: 8px;}

/* Style the checkbox */
.checkbox-style {
    width: 25px;
    height: 25px;
    margin: 0;
}

/* Style the checkbox when checked */
.checkbox-style:checked {
    background-color: #007bff; /* Change this to your desired color */
}
    </style>

    @yield('css')
</head>

<body>
<div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-left" style="border-bottom:1px solid #ccc">
            <a href="#" style="color: #8e8e8e; font-size: 26px; margin-top:10px; text-align:left;padding-left: 40px;">SAT Admin</a>
        </div>
        <div class="navbar-menu-wrapper align-items-center">
            <a href="{{ url('logout') }}" style="float:right; color: #fff; margin-top:20px">Logout</a>
        </div>
    </nav>
