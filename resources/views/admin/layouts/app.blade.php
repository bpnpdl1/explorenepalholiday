<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title.' | ' : '' }}{{ config('app.name', 'Explore Nepal Holidays') }} Admin</title>
    <link rel="shortcut icon" href="{{ asset('admin/velzon/images/favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('admin/velzon/libs/simplebar/simplebar.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/velzon/libs/node-waves/waves.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/velzon/libs/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/velzon/libs/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/velzon/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/velzon/css/icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/velzon/css/app.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/velzon/css/custom.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/velzon/libs/toastify-js/toastify.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/velzon/libs/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/form-validation.css') }}">
    @vite(['resources/css/admin.css', 'resources/js/admin.js'])
    @stack('styles')
    <script src="{{ asset('admin/velzon/js/layout.js') }}"></script>
</head>
<body>
    <div id="layout-wrapper">
        @include('admin.partials.topbar')
        @include('admin.partials.sidebar')
        <div class="vertical-overlay"></div>

        <div class="main-content">
            <main class="page-content">
                <div class="container-fluid">
                    {{ $slot }}
                </div>
            </main>
            @include('admin.partials.footer')
        </div>
    </div>

    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top" aria-label="Back to top">
        <i class="ri-arrow-up-line"></i>
    </button>

    <script src="{{ asset('admin/velzon/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/velzon/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/velzon/libs/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin/velzon/libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('admin/velzon/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('admin/velzon/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('admin/velzon/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('admin/velzon/libs/toastify-js/toastify.js') }}"></script>
    <script src="{{ asset('admin/velzon/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('admin/velzon/js/app.js') }}"></script>
    <script src="{{ asset('js/form-validation.js') }}"></script>
    @include('admin.partials.toast-listener')
    @stack('scripts')
</body>
</html>
