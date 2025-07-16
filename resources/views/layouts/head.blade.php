<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/simple-datatables/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/choices.js/choices.min.css') }}" />
    <link rel="shortcut icon" href="{{ asset('auth/assets/logo-posyandu.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.0.0/dist/css/tom-select.css" rel="stylesheet">
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        .wrapper {
            min-height: 100%;
            display: flex;
            flex-direction: column;
        }


        #sidebar {
            background-color: #176265 !important;
        }

        .sidebar-wrapper {
            background-color: #176265 !important;
        }

        .custom-sidebar {
            background-color: #176265 !important;
            /* atau #6ac8d8 */
            color: #ffffff !important;
        }

        .custom-sidebar .sidebar-link,
        .custom-sidebar .sidebar-link span {
            color: #ffffff !important;
        }

        /* Hover dan active state di sidebar link */
        .sidebar-item.active>.sidebar-link,
        .sidebar-link:hover {
            background-color: #48b8af !important;
            color: #ffffff !important;
        }

        /* Untuk ikon dalam link */
        .sidebar-item.active>.sidebar-link i,
        .sidebar-link:hover i {
            color: #ffffff !important;
        }



        .custom-sidebar .sidebar-title {
            color: #d1faff !important;
        }

        .custom-sidebar [data-feather],
        .custom-sidebar i {
            color: #ffffff !important;
        }

        .main-content {
            flex: 1;
            /* Isi ruang tersisa */
        }

        footer {
            background-color: #f8f9fa;
            /* Warna opsional */
            padding: 1rem;
        }
    </style>
    @stack('styles')
</head>

<body>
