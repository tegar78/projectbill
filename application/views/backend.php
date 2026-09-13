<?php $isDarkTheme = (isset($_COOKIE['backend_theme']) && $_COOKIE['backend_theme'] === 'dark'); ?>
<!DOCTYPE html>
<html lang="en" class="<?= $isDarkTheme ? 'dark-mode' : '' ?>">

<head>
    <script>
        (function() {
            var theme = localStorage.getItem('backend_theme');
            if (theme === 'dark' || (theme !== 'light' && <?= $isDarkTheme ? 'true' : 'false' ?>)) {
                document.documentElement.classList.add('dark-mode');
                document.documentElement.style.backgroundColor = '#0f1423';
            }
        })();
    </script>
    <style>
        html.dark-mode, html.dark-mode body, html.dark-mode #wrapper, html.dark-mode #content-wrapper, html.dark-mode #content {
            background-color: #0f1423 !important;
            color: #f1f5f9 !important;
        }
    </style>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?= $title ?> | <?= $company['company_name'] ?></title>
    <link rel="shortcut icon" href="<?= base_url('assets/images/favicon.png') ?>">
    <!-- Custom fonts for this template-->
    <link href="<?= base_url('assets/backend/') ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url('assets/backend/') ?>css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">
    <!-- Custom styles for this page -->

    <link href="<?= base_url('assets/backend/') ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/backend/') ?>css/select2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/backend/') ?>vendor/datatables/responsive.bootstrap4.min.css">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="<?= base_url('assets/backend') ?>/bootstrap-datepicker/css/bootstrap-datepicker.min.css">
    <!-- Neumorphism Soft UI Theme -->
    <link href="<?= base_url('assets/backend/') ?>css/neumorphism.css?v=<?= time() ?>" rel="stylesheet">
    <!-- Leaflet Locate Control Library -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
    <!-- Leaflet Locate Control CSS Library -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@0.72.0/dist/L.Control.Locate.min.css" /> -->
    <script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/Leaflet.fullscreen.min.js'></script>
    <link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/leaflet.fullscreen.css' rel='stylesheet' />
    <!-- Leaflet Locate Control Library -->
    <script src="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@0.72.0/dist/L.Control.Locate.min.js" charset="utf-8"></script>

    <link rel="stylesheet" href="<?= base_url('assets/backend/') ?>leaflet-search/leaflet-search.css" />
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="<?= base_url('assets/backend/') ?>leaflet-search/leaflet-search.js"></script>
    <style>
        #map-canvas {
            width: 100%;
            height: 400px;
            border: solid #999 1px;
        }

        select {
            width: 240px;
        }

        #kab_box,
        #kec_box,
        #kel_box,

        #lat_box,
        #lng_box {
            display: none;
        }

        #mapid {
            height: 500px;
        }

        #map {
            /* width: 600px; */
            height: 500px;
        }
    </style>
    <style>
        .switch {
            display: inline-block;
            height: 34px;
            position: relative;
            width: 60px;

        }

        .switch input {
            display: none;
        }

        .slider {
            background-color: gray;
            bottom: 0;
            cursor: pointer;
            left: 0;
            position: absolute;
            right: 0;
            top: 0;
            transition: .4s;
        }

        .slider:before {
            background-color: #fff;
            bottom: 4px;
            content: "";
            height: 26px;
            left: 4px;
            position: absolute;
            transition: .4s;
            width: 26px;
        }

        input:checked+.slider {
            background-color: blue;
        }

        input:checked+.slider:before {
            transform: translateX(26px);
        }

        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>
    <script>
        (function() {
            var theme = localStorage.getItem('backend_theme');
            if (theme === 'dark') {
                document.documentElement.classList.add('dark-mode');
            }
        })();
    </script>
    <style>
        /* Theme Matching Landing Page */
        .bg-gradient-primary {
            background-color: #2a207a !important;
            background-image: linear-gradient(180deg, #2a207a 10%, #150d4a 100%) !important;
            background-size: cover !important;
        }

        .sidebar-dark .nav-item.active .nav-link {
            color: #f47b20 !important;
            font-weight: 700;
        }

        .sidebar-dark .nav-item.active .nav-link i {
            color: #f47b20 !important;
        }

        .sidebar-dark .nav-item .nav-link:hover {
            color: #f47b20 !important;
        }

        .sidebar-dark .nav-item .nav-link:hover i {
            color: #f47b20 !important;
        }

        .sidebar-dark .sidebar-brand {
            color: #1e293b !important;
            font-weight: 800;
        }

        .sidebar-dark .sidebar-brand .sidebar-brand-icon {
            color: #f47b20 !important;
        }

        html.dark-mode .sidebar-dark .sidebar-brand,
        body.dark-mode .sidebar-dark .sidebar-brand {
            color: #ffffff !important;
        }

        .sidebar-dark .nav-item .nav-link[data-toggle="collapse"]::after {
            color: #475569 !important;
            margin-left: auto !important;
        }

        html.dark-mode .sidebar-dark .nav-item .nav-link[data-toggle="collapse"]::after,
        body.dark-mode .sidebar-dark .nav-item .nav-link[data-toggle="collapse"]::after {
            color: #94a3b8 !important;
        }

        .sidebar-dark #sidebarToggle::after {
            color: #475569 !important;
        }

        html.dark-mode .sidebar-dark #sidebarToggle::after,
        body.dark-mode .sidebar-dark #sidebarToggle::after {
            color: #cbd5e1 !important;
        }

        .sidebar-dark .collapse-inner .collapse-item.active {
            color: #f47b20 !important;
            font-weight: 700;
        }

        .btn-primary {
            background-color: #f47b20 !important;
            border-color: #f47b20 !important;
            color: #ffffff !important;
        }

        .btn-primary:hover, .btn-primary:focus, .btn-primary:active {
            background-color: #d86612 !important;
            border-color: #d86612 !important;
            color: #ffffff !important;
        }

        .btn-primary i, .btn-primary span,
        a.btn-primary i, a.btn-primary span {
            color: #ffffff !important;
        }

        .stat-subtext {
            font-size: 0.82rem;
            color: #4a5568;
            font-weight: 500;
        }

        .stat-subtext-danger {
            font-size: 0.82rem;
            color: #dc3545;
            font-weight: 700;
        }

        /* Dark Mode Styling with High Contrast Typography */
        html.dark-mode body,
        body.dark-mode {
            background-color: #0f1423 !important;
            color: #f1f5f9 !important;
        }

        /* Fullscreen Layout Enforcement */
        html, body {
            width: 100% !important;
            max-width: 100% !important;
            overflow-x: hidden;
        }

        #wrapper {
            display: flex !important;
            width: 100% !important;
            max-width: 100% !important;
            min-height: 100vh;
        }

        #content-wrapper {
            display: flex !important;
            flex-direction: column !important;
            width: 100% !important;
            max-width: 100% !important;
            min-width: 0 !important;
            flex: 1 1 auto !important;
            overflow-x: hidden !important;
        }

        #content {
            flex: 1 0 auto !important;
            width: 100% !important;
            max-width: 100% !important;
            min-width: 0 !important;
        }

        .container-fluid {
            width: 100% !important;
            max-width: 100% !important;
            padding-left: 1.5rem !important;
            padding-right: 1.5rem !important;
            box-sizing: border-box !important;
        }

        .card,
        .card-body,
        .view_data,
        .table-responsive,
        table.dataTable,
        div.dataTables_wrapper {
            width: 100% !important;
            max-width: 100% !important;
            min-width: 100% !important;
            box-sizing: border-box !important;
        }

        body.dark-mode #wrapper,
        body.dark-mode #content-wrapper,
        body.dark-mode #content {
            background-color: #0f1423 !important;
        }

        body.dark-mode .topbar {
            background-color: #161c2e !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4) !important;
        }

        body.dark-mode .topbar h5,
        body.dark-mode .topbar #time,
        body.dark-mode .topbar .text-gray-600 {
            color: #f1f5f9 !important;
            font-weight: 600;
        }

        body.dark-mode .card {
            background-color: #161c2e !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3) !important;
            color: #f1f5f9 !important;
        }

        body.dark-mode .card-header {
            background-color: rgba(255, 255, 255, 0.04) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
            color: #ffffff !important;
        }

        body.dark-mode .card-body {
            color: #f1f5f9 !important;
        }

        body.dark-mode .sidebar {
            background: linear-gradient(180deg, #141829 0%, #0a0d18 100%) !important;
            border-right: 1px solid rgba(255, 255, 255, 0.05);
        }

        body.dark-mode .sidebar .collapse-inner {
            background-color: #111524 !important;
        }

        body.dark-mode .sidebar .collapse-inner .collapse-item {
            color: #cbd5e1 !important;
        }

        body.dark-mode .sidebar .collapse-inner .collapse-item:hover,
        body.dark-mode .sidebar .collapse-inner .collapse-item.active {
            background-color: rgba(244, 123, 32, 0.2) !important;
            color: #f47b20 !important;
        }

        /* Override Inline black & red colors for dark mode readability */
        body.dark-mode [style*="color:black"],
        body.dark-mode [style*="color: black"],
        body.dark-mode [style*="color:#000"],
        body.dark-mode [style*="color: #000"] {
            color: #cbd5e1 !important;
        }

        body.dark-mode [style*="color:red"],
        body.dark-mode [style*="color: red"] {
            color: #ff6b6b !important;
        }

        body.dark-mode .stat-subtext {
            color: #cbd5e1 !important;
        }

        body.dark-mode .stat-subtext-danger {
            color: #ff6b6b !important;
        }

        /* Dark Mode Text Colors for High Contrast */
        body.dark-mode .text-gray-800,
        body.dark-mode .text-gray-900,
        body.dark-mode .text-dark,
        body.dark-mode h1, body.dark-mode h2, body.dark-mode h3, body.dark-mode h4, body.dark-mode h5, body.dark-mode h6 {
            color: #ffffff !important;
        }

        body.dark-mode .text-muted,
        body.dark-mode .text-gray-500,
        body.dark-mode .text-gray-600 {
            color: #cbd5e1 !important;
        }

        body.dark-mode .text-primary {
            color: #60a5fa !important;
        }

        body.dark-mode .text-success {
            color: #4ade80 !important;
        }

        body.dark-mode .text-info {
            color: #38bdf8 !important;
        }

        body.dark-mode .text-warning {
            color: #facc15 !important;
        }

        body.dark-mode .text-danger {
            color: #f87171 !important;
        }

        body.dark-mode .text-secondary {
            color: #94a3b8 !important;
        }

        /* Tables & DataTables */
        .view_data,
        .table-responsive,
        table.dataTable,
        div.dataTables_wrapper {
            width: 100% !important;
        }

        body.dark-mode table,
        body.dark-mode .table {
            color: #f1f5f9 !important;
            border-color: rgba(255, 255, 255, 0.08) !important;
        }

        body.dark-mode table th,
        body.dark-mode table td {
            border-color: rgba(255, 255, 255, 0.08) !important;
            color: #e2e8f0 !important;
        }

        body.dark-mode table thead th {
            background-color: rgba(255, 255, 255, 0.06) !important;
            color: #ffffff !important;
            font-weight: 700;
        }

        body.dark-mode .table-bordered th,
        body.dark-mode .table-bordered td {
            border-color: rgba(255, 255, 255, 0.08) !important;
        }

        body.dark-mode .table-hover tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.05) !important;
            color: #ffffff !important;
        }

        body.dark-mode .page-item.disabled .page-link,
        body.dark-mode .page-link {
            background-color: #161c2e !important;
            border-color: rgba(255, 255, 255, 0.08) !important;
            color: #cbd5e1 !important;
        }

        body.dark-mode .page-item.active .page-link {
            background-color: #f47b20 !important;
            border-color: #f47b20 !important;
            color: #ffffff !important;
        }

        body.dark-mode .dataTables_info,
        body.dark-mode .dataTables_length,
        body.dark-mode .dataTables_filter {
            color: #cbd5e1 !important;
        }

        /* Forms, Inputs, Select2 */
        body.dark-mode .form-control,
        body.dark-mode select.form-control,
        body.dark-mode input.form-control {
            background-color: #0f1423 !important;
            border-color: rgba(255, 255, 255, 0.18) !important;
            color: #ffffff !important;
        }

        body.dark-mode .form-control::placeholder {
            color: #94a3b8 !important;
            opacity: 1;
        }

        body.dark-mode .form-control:focus {
            border-color: #f47b20 !important;
            box-shadow: 0 0 0 0.2rem rgba(244, 123, 32, 0.25) !important;
        }

        body.dark-mode .select2-container--default .select2-selection--single,
        body.dark-mode .select2-container--default .select2-selection--multiple {
            background-color: #0f1423 !important;
            border-color: rgba(255, 255, 255, 0.18) !important;
            color: #ffffff !important;
        }

        body.dark-mode .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #ffffff !important;
        }

        body.dark-mode .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: #94a3b8 !important;
        }

        html.dark-mode .select2-dropdown,
        body.dark-mode .select2-dropdown,
        .dark-mode .select2-dropdown {
            background-color: #161c2e !important;
            border-color: rgba(255, 255, 255, 0.18) !important;
            color: #ffffff !important;
        }

        html.dark-mode .select2-search__field,
        body.dark-mode .select2-search__field,
        .dark-mode .select2-search__field {
            background-color: #0f1423 !important;
            color: #ffffff !important;
            border-color: rgba(255, 255, 255, 0.15) !important;
        }

        html.dark-mode .select2-container--default .select2-results__option,
        body.dark-mode .select2-container--default .select2-results__option,
        .dark-mode .select2-container--default .select2-results__option {
            background-color: #161c2e !important;
            color: #e2e8f0 !important;
        }

        html.dark-mode .select2-container--default .select2-results__option[aria-selected="true"],
        body.dark-mode .select2-container--default .select2-results__option[aria-selected="true"],
        .dark-mode .select2-container--default .select2-results__option[aria-selected="true"],
        html.dark-mode .select2-container--default .select2-results__option[aria-selected=true],
        body.dark-mode .select2-container--default .select2-results__option[aria-selected=true],
        .dark-mode .select2-container--default .select2-results__option[aria-selected=true] {
            background-color: #262f48 !important;
            color: #60a5fa !important;
            font-weight: 600;
        }

        html.dark-mode .select2-container--default .select2-results__option--highlighted,
        body.dark-mode .select2-container--default .select2-results__option--highlighted,
        .dark-mode .select2-container--default .select2-results__option--highlighted,
        html.dark-mode .select2-container--default .select2-results__option--highlighted[aria-selected],
        body.dark-mode .select2-container--default .select2-results__option--highlighted[aria-selected],
        .dark-mode .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #f47b20 !important;
            color: #ffffff !important;
        }

        html.dark-mode select option,
        body.dark-mode select option,
        .dark-mode select option {
            background-color: #161c2e !important;
            color: #ffffff !important;
        }

        /* Modals & Dropdowns */
        body.dark-mode .modal-content,
        body.dark-mode .dropdown-menu {
            background-color: #161c2e !important;
            border: 1px solid rgba(255, 255, 255, 0.12) !important;
            color: #f1f5f9 !important;
        }

        body.dark-mode .dropdown-item {
            color: #e2e8f0 !important;
        }

        body.dark-mode .dropdown-item:hover {
            background-color: rgba(244, 123, 32, 0.2) !important;
            color: #f47b20 !important;
        }

        body.dark-mode .dropdown-header {
            color: #f47b20 !important;
            font-weight: 700;
        }

        body.dark-mode .footer,
        body.dark-mode footer.sticky-footer {
            background-color: #0f1423 !important;
            color: #94a3b8 !important;
        }

        /* Highcharts Dark Mode Styling */
        body.dark-mode .highcharts-container,
        body.dark-mode svg.highcharts-root {
            background-color: #161c2e !important;
            border-radius: 8px;
        }

        body.dark-mode rect.highcharts-background {
            fill: #161c2e !important;
        }

        body.dark-mode rect.highcharts-plot-background {
            fill: #0f1423 !important;
        }

        body.dark-mode .highcharts-title,
        body.dark-mode text.highcharts-title {
            fill: #ffffff !important;
            color: #ffffff !important;
        }

        body.dark-mode .highcharts-axis-labels text,
        body.dark-mode text.highcharts-axis-title {
            fill: #cbd5e1 !important;
            color: #cbd5e1 !important;
        }

        body.dark-mode .highcharts-grid-line,
        body.dark-mode path.highcharts-grid-line {
            stroke: rgba(255, 255, 255, 0.08) !important;
        }

        body.dark-mode rect.highcharts-legend-box {
            fill: #0f1423 !important;
            stroke: rgba(255, 255, 255, 0.1) !important;
        }

        body.dark-mode .highcharts-legend-item text {
            fill: #cbd5e1 !important;
            color: #cbd5e1 !important;
        }

        /* Mobile Bottom Navigation Bar */
        .mobile-bottom-nav {
            background: linear-gradient(135deg, #2a207a 0%, #150d4a 100%) !important;
            border-top: 1px solid rgba(255, 255, 255, 0.12) !important;
            box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.3) !important;
            padding: 4px 0 !important;
            z-index: 1040 !important;
        }

        body.dark-mode .mobile-bottom-nav {
            background: #161c2e !important;
            border-top: 1px solid rgba(255, 255, 255, 0.08) !important;
            box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.5) !important;
        }

        .mobile-bottom-nav .nav-link {
            color: rgba(255, 255, 255, 0.7) !important;
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            justify-content: center !important;
            padding: 6px 0 !important;
            font-size: 0.7rem !important;
            line-height: 1.1 !important;
            transition: all 0.2s ease !important;
        }

        .mobile-bottom-nav .nav-link i,
        .mobile-bottom-nav .nav-link svg {
            font-size: 1.25rem !important;
            margin-bottom: 2px !important;
            transition: transform 0.2s ease, color 0.2s ease !important;
        }

        .mobile-bottom-nav .nav-link.active,
        .mobile-bottom-nav .nav-link:hover {
            color: #f47b20 !important;
            font-weight: 700 !important;
        }

        .mobile-bottom-nav .nav-link.active i,
        .mobile-bottom-nav .nav-link.active svg {
            color: #f47b20 !important;
            fill: #f47b20 !important;
            transform: translateY(-2px) scale(1.1) !important;
        }

        /* Mobile Responsive Offcanvas Sidebar & Submenu Overlay Fix */
        @media (max-width: 767.98px) {
            html, body {
                width: 100% !important;
                max-width: 100% !important;
            }

            body {
                padding-bottom: 70px !important;
                overflow-x: hidden !important;
            }

            body.sidebar-open {
                overflow: hidden !important;
            }

            #wrapper {
                position: relative !important;
                width: 100% !important;
                max-width: 100% !important;
                overflow-x: visible !important;
                overflow-x: clip !important;
            }

            #content-wrapper {
                width: 100% !important;
                max-width: 100% !important;
                min-width: 100% !important;
                margin-left: 0 !important;
                padding-left: 0 !important;
                overflow-x: visible !important;
                overflow-x: clip !important;
                overflow-y: visible !important;
            }

            .container-fluid {
                padding-left: 0.75rem !important;
                padding-right: 0.75rem !important;
            }

            /* Offcanvas Mobile Drawer */
            .sidebar.nm-sidebar,
            #accordionSidebar {
                position: fixed !important;
                top: 0 !important;
                left: 0 !important;
                bottom: 0 !important;
                height: 100% !important;
                height: 100dvh !important;
                width: 280px !important;
                max-width: 85vw !important;
                min-height: 100vh !important;
                z-index: 10005 !important;
                overflow-y: auto !important;
                overflow-x: hidden !important;
                -webkit-overflow-scrolling: touch !important;
                scrollbar-width: thin !important;
                scrollbar-color: rgba(120, 130, 150, 0.4) transparent !important;
                margin: 0 !important;
                padding-bottom: 90px !important;
                box-shadow: 10px 0 35px rgba(0, 0, 0, 0.35) !important;
                transform: translateX(-100%) !important;
                visibility: hidden !important;
                pointer-events: none !important;
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), visibility 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
            }

            .sidebar.nm-sidebar::-webkit-scrollbar,
            #accordionSidebar::-webkit-scrollbar {
                width: 4px !important;
            }

            .sidebar.nm-sidebar::-webkit-scrollbar-track,
            #accordionSidebar::-webkit-scrollbar-track {
                background: transparent !important;
            }

            .sidebar.nm-sidebar::-webkit-scrollbar-thumb,
            #accordionSidebar::-webkit-scrollbar-thumb {
                background: rgba(120, 130, 150, 0.35) !important;
                border-radius: 4px !important;
            }

            .sidebar.nm-sidebar::-webkit-scrollbar-thumb:hover,
            #accordionSidebar::-webkit-scrollbar-thumb:hover {
                background: rgba(120, 130, 150, 0.6) !important;
            }

            /* When mobile drawer is opened */
            body.sidebar-open .sidebar.nm-sidebar,
            body.sidebar-open #accordionSidebar {
                transform: translateX(0) !important;
                visibility: visible !important;
                pointer-events: auto !important;
            }

            /* Ensure closed select2 or page controls never overlay the mobile drawer */
            body.sidebar-open .select2-container {
                z-index: 1 !important;
            }

            /* Mobile Backdrop Overlay */
            .sidebar-backdrop {
                position: fixed !important;
                top: 0 !important;
                left: 0 !important;
                right: 0 !important;
                bottom: 0 !important;
                width: 100vw !important;
                height: 100vh !important;
                background-color: rgba(15, 20, 35, 0.65) !important;
                backdrop-filter: blur(4px) !important;
                -webkit-backdrop-filter: blur(4px) !important;
                z-index: 10000 !important;
                opacity: 0 !important;
                visibility: hidden !important;
                pointer-events: none !important;
                transition: opacity 0.3s ease, visibility 0.3s ease !important;
            }

            body.sidebar-open .sidebar-backdrop {
                opacity: 1 !important;
                visibility: visible !important;
                pointer-events: auto !important;
            }

            /* Brand header on mobile with close button */
            .sidebar.nm-sidebar .sidebar-brand,
            #accordionSidebar .sidebar-brand {
                height: 4.5rem !important;
                padding: 0.75rem 1.25rem !important;
                display: flex !important;
                align-items: center !important;
                justify-content: space-between !important;
                width: 100% !important;
                border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
            }

            .sidebar.nm-sidebar .sidebar-brand .sidebar-brand-text,
            #accordionSidebar .sidebar-brand .sidebar-brand-text {
                display: inline-block !important;
                font-size: 1.05rem !important;
                font-weight: 800 !important;
                letter-spacing: 0.02em !important;
            }

            .nm-close-sidebar-btn {
                width: 36px !important;
                height: 36px !important;
                min-width: 36px !important;
                border-radius: 50% !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                background-color: var(--nm-bg) !important;
                box-shadow: var(--nm-inset-sm) !important;
                border: 1px solid rgba(255, 255, 255, 0.4) !important;
                color: #e53e3e !important;
                font-size: 1rem !important;
                cursor: pointer !important;
                outline: none !important;
                transition: transform 0.2s ease, box-shadow 0.2s ease !important;
            }

            .nm-close-sidebar-btn:active {
                transform: scale(0.92) !important;
            }

            html.dark-mode .nm-close-sidebar-btn,
            body.dark-mode .nm-close-sidebar-btn {
                background-color: #161c2e !important;
                border-color: rgba(255, 255, 255, 0.08) !important;
                color: #ff6b6b !important;
            }

            /* Nav items in mobile drawer: full width, horizontal row */
            .sidebar.nm-sidebar .nav-item,
            #accordionSidebar .nav-item {
                width: 100% !important;
                position: relative !important;
            }

            .sidebar.nm-sidebar .nav-item .nav-link,
            #accordionSidebar .nav-item .nav-link {
                width: 100% !important;
                display: flex !important;
                align-items: center !important;
                justify-content: flex-start !important;
                text-align: left !important;
                padding: 0.8rem 1.25rem !important;
                font-size: 0.92rem !important;
                box-sizing: border-box !important;
            }

            .sidebar.nm-sidebar .nav-item .nav-link span,
            #accordionSidebar .nav-item .nav-link span {
                display: inline-block !important;
                font-size: 0.92rem !important;
                margin-left: 0.75rem !important;
                font-weight: 600 !important;
            }

            .sidebar.nm-sidebar .nav-item .nav-link i,
            #accordionSidebar .nav-item .nav-link i {
                font-size: 1.05rem !important;
                width: 24px !important;
                text-align: center !important;
                margin-right: 0 !important;
                flex-shrink: 0 !important;
            }

            .sidebar.nm-sidebar .nav-item .nav-link[data-toggle="collapse"]::after,
            #accordionSidebar .nav-item .nav-link[data-toggle="collapse"]::after {
                display: inline-flex !important;
                margin-left: auto !important;
                float: none !important;
            }

            /* SUBMENUS: CRITICAL FIX TO PREVENT FLOATING OVERLAP */
            .sidebar .nav-item .collapse,
            .sidebar .nav-item .collapsing,
            .sidebar.nm-sidebar .nav-item .collapse,
            .sidebar.nm-sidebar .nav-item .collapsing,
            #accordionSidebar .nav-item .collapse,
            #accordionSidebar .nav-item .collapsing {
                position: static !important;
                left: auto !important;
                top: auto !important;
                width: 100% !important;
                max-width: 100% !important;
                margin: 0 !important;
                float: none !important;
                box-shadow: none !important;
                z-index: auto !important;
                animation: none !important;
            }

            .sidebar .collapse-inner,
            .nm-sidebar .collapse-inner,
            #accordionSidebar .collapse-inner {
                width: auto !important;
                min-width: 0 !important;
                margin: 4px 12px 10px 12px !important;
                padding: 8px 10px !important;
                border-radius: var(--nm-radius-md) !important;
                box-shadow: var(--nm-inset-sm) !important;
            }

            .sidebar .collapse-inner .collapse-item,
            .nm-sidebar .collapse-inner .collapse-item,
            #accordionSidebar .collapse-inner .collapse-item {
                padding: 0.55rem 0.9rem !important;
                font-size: 0.85rem !important;
                white-space: normal !important;
                word-break: break-word !important;
            }

            /* Topbar mobile refinements: Fixed/Sticky on Scroll */
            .topbar.nm-topbar {
                position: -webkit-sticky !important;
                position: sticky !important;
                top: 0 !important;
                margin: 0 0 14px 0 !important;
                padding: 8px 12px !important;
                min-height: 54px !important;
                border-radius: 0 0 18px 18px !important;
                border-top: none !important;
                border-left: none !important;
                border-right: none !important;
                border-bottom: 1px solid rgba(255, 255, 255, 0.45) !important;
                box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08) !important;
                z-index: 1030 !important;
            }

            html.dark-mode .topbar.nm-topbar,
            body.dark-mode .topbar.nm-topbar {
                background-color: #1a2236 !important;
                border-bottom: 1px solid rgba(255, 255, 255, 0.06) !important;
                box-shadow: 0 6px 20px rgba(0, 0, 0, 0.4) !important;
            }

            .topbar.nm-topbar.topbar-scrolled {
                box-shadow: 0 8px 25px rgba(0, 0, 0, 0.14) !important;
            }

            html.dark-mode .topbar.nm-topbar.topbar-scrolled,
            body.dark-mode .topbar.nm-topbar.topbar-scrolled {
                box-shadow: 0 8px 25px rgba(0, 0, 0, 0.55) !important;
            }

            #sidebarToggleTop {
                width: 38px !important;
                height: 38px !important;
                min-width: 38px !important;
                display: inline-flex !important;
                align-items: center !important;
                justify-content: center !important;
                border-radius: 50% !important;
                background-color: var(--nm-bg) !important;
                box-shadow: var(--nm-raised-sm) !important;
                border: 1px solid rgba(255, 255, 255, 0.4) !important;
                color: var(--nm-brand) !important;
                font-size: 1.05rem !important;
                text-decoration: none !important;
                margin-right: 0.5rem !important;
                transition: all 0.2s ease !important;
            }

            #sidebarToggleTop:active {
                box-shadow: var(--nm-inset-sm) !important;
                transform: scale(0.94) !important;
            }

            html.dark-mode #sidebarToggleTop,
            body.dark-mode #sidebarToggleTop {
                background-color: #161c2e !important;
                border-color: rgba(255, 255, 255, 0.08) !important;
                box-shadow: 3px 3px 8px rgba(0, 0, 0, 0.4), -2px -2px 6px rgba(255, 255, 255, 0.03) !important;
                color: #f47b20 !important;
            }
        }

        /* Desktop Sidebar Toggled / Minimized - Brand Symmetry Fix */
        @media (min-width: 768px) {
            .sidebar.toggled .sidebar-brand,
            .sidebar.nm-sidebar.toggled .sidebar-brand,
            #accordionSidebar.toggled .sidebar-brand,
            body.sidebar-toggled .sidebar .sidebar-brand,
            body.sidebar-toggled #accordionSidebar .sidebar-brand {
                width: 6.5rem !important;
                max-width: 6.5rem !important;
                height: 4.75rem !important;
                padding: 0 !important;
                margin: 0 auto !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                text-align: center !important;
                box-sizing: border-box !important;
                overflow: hidden !important;
                border-bottom: none !important;
            }

            .sidebar.toggled .sidebar-brand a,
            .sidebar.nm-sidebar.toggled .sidebar-brand a,
            #accordionSidebar.toggled .sidebar-brand a,
            body.sidebar-toggled .sidebar .sidebar-brand a,
            body.sidebar-toggled #accordionSidebar .sidebar-brand a {
                width: 100% !important;
                height: 100% !important;
                max-width: 100% !important;
                padding: 0 !important;
                margin: 0 auto !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                text-align: center !important;
                flex-grow: 0 !important;
                text-decoration: none !important;
            }

            .sidebar.toggled .sidebar-brand .sidebar-brand-icon,
            .sidebar.nm-sidebar.toggled .sidebar-brand .sidebar-brand-icon,
            #accordionSidebar.toggled .sidebar-brand .sidebar-brand-icon,
            body.sidebar-toggled .sidebar .sidebar-brand .sidebar-brand-icon,
            body.sidebar-toggled #accordionSidebar .sidebar-brand .sidebar-brand-icon {
                width: 44px !important;
                height: 44px !important;
                min-width: 44px !important;
                min-height: 44px !important;
                margin: 0 auto !important;
                padding: 0 !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                text-align: center !important;
                transform: none !important;
                border-radius: 50% !important;
                background-color: var(--nm-bg) !important;
                box-shadow: var(--nm-raised-xs) !important;
                color: var(--nm-brand) !important;
                transition: all 0.25s ease !important;
            }

            .sidebar.toggled .sidebar-brand .sidebar-brand-icon i,
            .sidebar.nm-sidebar.toggled .sidebar-brand .sidebar-brand-icon i,
            #accordionSidebar.toggled .sidebar-brand .sidebar-brand-icon i,
            body.sidebar-toggled .sidebar .sidebar-brand .sidebar-brand-icon i,
            body.sidebar-toggled #accordionSidebar .sidebar-brand .sidebar-brand-icon i {
                font-size: 1.45rem !important;
                margin: 0 !important;
                padding: 0 !important;
                display: inline-block !important;
                transform: none !important;
                line-height: 1 !important;
                text-align: center !important;
                color: #f47b20 !important;
                filter: drop-shadow(0 2px 4px rgba(244, 123, 32, 0.35));
            }

            .sidebar.toggled .sidebar-brand a:hover .sidebar-brand-icon,
            .sidebar.nm-sidebar.toggled .sidebar-brand a:hover .sidebar-brand-icon,
            #accordionSidebar.toggled .sidebar-brand a:hover .sidebar-brand-icon {
                box-shadow: var(--nm-raised-sm) !important;
                transform: scale(1.06) !important;
                color: var(--nm-brand-hover) !important;
            }

            html.dark-mode .sidebar.toggled .sidebar-brand .sidebar-brand-icon,
            body.dark-mode .sidebar.toggled .sidebar-brand .sidebar-brand-icon,
            html.dark-mode #accordionSidebar.toggled .sidebar-brand .sidebar-brand-icon {
                background-color: #161c2e !important;
                box-shadow: 3px 3px 8px rgba(0, 0, 0, 0.45), -2px -2px 6px rgba(255, 255, 255, 0.03) !important;
            }

            .sidebar.toggled .sidebar-brand .sidebar-brand-text,
            .sidebar.nm-sidebar.toggled .sidebar-brand .sidebar-brand-text,
            #accordionSidebar.toggled .sidebar-brand .sidebar-brand-text,
            body.sidebar-toggled .sidebar .sidebar-brand .sidebar-brand-text {
                display: none !important;
                width: 0 !important;
                height: 0 !important;
                margin: 0 !important;
                padding: 0 !important;
                overflow: hidden !important;
            }

            .sidebar.toggled .sidebar-brand #sidebarCloseBtn,
            .sidebar.nm-sidebar.toggled .sidebar-brand #sidebarCloseBtn,
            #accordionSidebar.toggled .sidebar-brand #sidebarCloseBtn {
                display: none !important;
            }
        }
    </style>
</head>

<body id="page-top" class="<?= $isDarkTheme ? 'dark-mode' : '' ?>">

    <?php if ($user['email'] == '') {
        redirect('auth/logout');
    } ?>


    <?php if ($user['role_id'] == 2) {

        redirect('member');
    } ?>
    <!-- Page Wrapper -->
    <div id="wrapper">
        <?php $role = $this->db->get_where('role_management', ['role_id' => $this->session->userdata('role_id')])->row_array() ?>
        <?php $menu = $this->db->get_where('role_menu', ['role_id' => $this->session->userdata('role_id')])->row_array() ?>
        <?php $wa = $this->db->get('whatsapp')->row_array() ?>
        <?php $pg = $this->db->get('payment_gateway')->row_array() ?>
        <!-- Sidebar Backdrop for Mobile -->
        <div id="sidebarBackdrop" class="sidebar-backdrop d-md-none"></div>

        <!-- Sidebar -->
        <ul class="navbar-nav sidebar sidebar-dark nm-sidebar accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <div class="sidebar-brand d-flex align-items-center justify-content-between justify-content-md-center">
                <a class="d-flex align-items-center justify-content-center flex-grow-1 flex-md-grow-0 text-decoration-none text-reset" href="<?= site_url('dashboard') ?>">
                    <div class="sidebar-brand-icon rotate-n-15 mr-2">
                        <i class="fas fa-wifi"></i>
                    </div>
                    <div class="sidebar-brand-text mx-1"><?= $company['apps_name']; ?></div>
                </a>
                <button type="button" class="btn d-md-none nm-close-sidebar-btn p-0" id="sidebarCloseBtn" aria-label="Tutup Menu">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">
            <!-- Nav Item - Dashboard -->
            <li class="nav-item <?= $title == 'Dashboard'  ? 'active' : '' ?>">
                <a class="nav-link" href="<?= site_url('dashboard') ?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Beranda</span></a>
            </li>
            <?php if ($this->session->userdata('role_id') == 1 or $menu['services_menu'] == 1) { ?>
                <li class="nav-item <?= $title == 'Item Package' | $title == 'Category Package'  ? 'active' : '' ?>">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fas fa-fw fa-sitemap"></i>
                        <span>Layanan</span>
                    </a>
                    <div id="collapseTwo" class="collapse <?= $title == 'Item Package' | $title == 'Category Package' ? 'show' : '' ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="py-2 collapse-inner rounded">
                            <?php if ($this->session->userdata('role_id') == 1 or $menu['services_item'] == 1) { ?>
                                <a class="collapse-item <?= $title == 'Item Package'  ? 'active' : '' ?>" href="<?= site_url('package/item') ?>">Paket</a>
                            <?php } ?>
                            <?php if ($this->session->userdata('role_id') == 1 or $menu['services_category'] == 1) { ?>
                                <a class="collapse-item <?= $title == 'Category Package'  ? 'active' : '' ?>" href="<?= site_url('package/category') ?>">Kategori</a>
                            <?php } ?>
                        </div>
                    </div>
                </li>
            <?php } ?>
            <!-- Nav Item - Pages Collapse Menu -->
            <?php if ($this->session->userdata('role_id') == 1 or $menu['customer_menu'] == 1) { ?>
                <li class="nav-item <?= $title == 'Customer' | $title == 'Isolir' | $title == 'Whatsapp Pelanggan' | $title == 'Add Customer' | $title == 'Free' | $title == 'Aktif' | $title == 'Non-Aktif' | $title == 'Waiting'   ? 'active' : '' ?>">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCustomer" aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fas fa-fw fa-users"></i>
                        <span>Pelanggan</span>
                    </a>
                    <div id="collapseCustomer" class="collapse <?= $title == 'Aktif' | $title == 'Isolir' | $title == 'Add Customer' | $title == 'Free' | $title == 'Whatsapp Pelanggan' | $title == 'Non-Aktif' | $title == 'Maps' | $title == 'Customer' | $title == 'Waiting' ? 'show' : '' ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="py-2 collapse-inner rounded">

                            <?php if ($this->session->userdata('role_id') == 1 or $menu['customer_add'] == 1) { ?>
                                <a class="collapse-item <?= $title == 'Add Customer'  ? 'active' : '' ?>" href="<?= site_url('customer/add') ?>">Tambah</a>
                            <?php } ?>
                            <?php if ($this->session->userdata('role_id') == 1 or $menu['customer_active'] == 1) { ?>
                                <a class="collapse-item <?= $title == 'Aktif'  ? 'active' : '' ?>" href="<?= site_url('customer/active') ?>">Aktif</a>
                            <?php } ?>
                            <?php if ($this->session->userdata('role_id') == 1 or $menu['customer_non_active'] == 1) { ?>
                                <a class="collapse-item <?= $title == 'Non-Aktif'  ? 'active' : '' ?>" href="<?= site_url('customer/nonactive') ?>">Non-Aktif</a>
                            <?php } ?>
                            <?php if ($this->session->userdata('role_id') == 1 or $menu['customer_waiting'] == 1) { ?>
                                <a class="collapse-item <?= $title == 'Waiting'  ? 'active' : '' ?>" href="<?= site_url('customer/wait') ?>">Menunggu</a>
                            <?php } ?>
                            <?php if ($this->session->userdata('role_id') == 1 or $menu['customer_free'] == 1) { ?>
                                <a class="collapse-item <?= $title == 'Free'  ? 'active' : '' ?>" href="<?= site_url('customer/free') ?>">Free</a>
                            <?php } ?>
                            <?php if ($this->session->userdata('role_id') == 1 or $menu['customer_isolir'] == 1) { ?>
                                <a class="collapse-item <?= $title == 'Isolir'  ? 'active' : '' ?>" href="<?= site_url('customer/isolir') ?>">Isolir</a>
                            <?php } ?>
                            <?php if ($this->session->userdata('role_id') == 1 or $menu['customer'] == 1) { ?>
                                <a class="collapse-item <?= $title == 'Customer'  ? 'active' : '' ?>" href="<?= site_url('customer') ?>">Semua</a>
                            <?php } ?>
                            <?php if ($this->session->userdata('role_id') == 1 or $menu['customer_whatsapp'] == 1) { ?>
                                <a class="collapse-item <?= ($title == 'Kirim Whatsapp' || $title == 'Whatsapp Pelanggan')  ? 'active' : '' ?>" href="<?= site_url('customer/whatsapp') ?>">Kirim Whatsapp</a>
                            <?php } ?>
                            <?php if ($this->session->userdata('role_id') == 1 or $menu['customer_maps'] == 1) { ?>

                                <a class="collapse-item <?= $title == 'Maps'  ? 'active' : '' ?>" href="<?= site_url('maps') ?>">Maps</a>

                            <?php } ?>
                        </div>
                    </div>
                </li>
            <?php } ?>
            <?php if ($this->session->userdata('role_id') == 1 or $menu['coverage_menu'] == 1) { ?>
                <li class="nav-item <?= $title == 'Coverage Area' | $title == 'Coverage Maps' | $title == 'Add Coverage'  ? 'active' : '' ?>">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsecoverage" aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fas fa-fw fa-sitemap"></i>
                        <span>Coverage</span>
                    </a>
                    <div id="collapsecoverage" class="collapse <?= $title == 'Coverage Area' | $title == 'Coverage Maps' | $title == 'Add Coverage' ? 'show' : '' ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="py-2 collapse-inner rounded">
                            <?php if ($this->session->userdata('role_id') == 1 or $menu['coverage_add'] == 1) { ?>
                                <a class="collapse-item <?= $title == 'Add Coverage'  ? 'active' : '' ?>" href="<?= site_url('coverage/add') ?>">Tambah</a>
                            <?php } ?>
                            <?php if ($this->session->userdata('role_id') == 1 or $menu['coverage'] == 1) { ?>
                                <a class="collapse-item <?= $title == 'Coverage Area'  ? 'active' : '' ?>" href="<?= site_url('coverage') ?>">Daftar Coverage</a>
                            <?php } ?>
                            <?php if ($this->session->userdata('role_id') == 1 or $menu['coverage_maps'] == 1) { ?>
                                <!-- <a class="collapse-item <?= $title == 'Coverage Maps'  ? 'active' : '' ?>" href="<?= site_url('coverage/maps') ?>">Maps Area</a> -->
                            <?php } ?>
                        </div>
                    </div>
                </li>
            <?php } ?>

            <?php if ($this->session->userdata('role_id') == 1 or $menu['bill_menu'] == 1) { ?>
                <li class="nav-item <?= $title == 'Belum Bayar' | $title == 'Sudah Bayar' | $title == 'Sharing Profit' |  $title == 'Jatuh Tempo' | $title == 'Bill'  ? 'active' : '' ?>">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#tagihan" aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fas fa-fw fa-tasks"></i>
                        <span>Tagihan</span>
                    </a>
                    <div id="tagihan" class="collapse <?= $title == 'Belum Bayar' |  $title == 'Sudah Bayar' | $title == 'Sharing Profit' |  $title == 'Jatuh Tempo' | $title == 'Konfirmasi Pembayaran' |  $title == 'Tunggakan' |  $title == 'Hapus Tagihan' | $title == 'Bill Draf' | $title == 'Bill' ? 'show' : '' ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="py-2 collapse-inner rounded">
                            <?php if ($this->session->userdata('role_id') == 1 or $menu['bill_unpaid'] == 1) { ?>
                                <a class="collapse-item <?= $title == 'Belum Bayar'  ? 'active' : '' ?>" href="<?= site_url('bill/unpaid') ?>">Belum Bayar</a>
                            <?php } ?>
                            <?php if ($this->session->userdata('role_id') == 1 or $menu['bill_paid'] == 1) { ?>
                                <a class="collapse-item <?= $title == 'Sudah Bayar'  ? 'active' : '' ?>" href="<?= site_url('bill/paid') ?>">Sudah Bayar</a>
                            <?php } ?>
                            <?php if ($this->session->userdata('role_id') == 1 or $menu['bill_due_date'] == 1) { ?>
                                <a class="collapse-item <?= $title == 'Jatuh Tempo'  ? 'active' : '' ?>" href="<?= site_url('bill/duedate') ?>">Jatuh Tempo</a>
                            <?php } ?>
                            <?php if ($this->session->userdata('role_id') == 1 or $menu['bill'] == 1) { ?>
                                <a class="collapse-item <?= $title == 'Bill'  ? 'active' : '' ?>" href="<?= site_url('bill') ?>">Semua</a>
                            <?php } ?>
                            <?php if ($this->session->userdata('role_id') == 1 or $menu['bill_draf'] == 1) { ?>
                                <a class="collapse-item <?= $title == 'Bill Draf'  ? 'active' : '' ?>" href="<?= site_url('bill/draf') ?>">Tagihan Bulan Ini <sup style="color: red;">Draf</sup></a>
                            <?php } ?>
                            <?php if ($this->session->userdata('role_id') == 1 or $menu['bill_debt'] == 1) { ?>
                                <a class="collapse-item <?= $title == 'Tunggakan'  ? 'active' : '' ?>" href="<?= site_url('bill/debt') ?>">Tunggakan</a>
                            <?php } ?>
                            <?php if ($this->session->userdata('role_id') == 1 or $menu['bill_confirm'] == 1) { ?>
                                <a class="collapse-item <?= $title == 'Konfirmasi Pembayaran'  ? 'active' : '' ?>" href="<?= site_url('confirm') ?>">Konfirmasi Pembayaran</a>
                            <?php } ?>

                            <?php if ($this->session->userdata('role_id') == 1 or $menu['bill_history'] == 1) { ?>
                                <a class="collapse-item <?= $title == 'Bill History'  ? 'active' : '' ?>" href="<?= site_url('bill/history') ?>">Riwayat Tagihan</a>
                            <?php } ?>


                            <?php if ($pg['vendor'] == 'Tripay') { ?>
                                <?php if ($pg['is_active'] == 1) { ?>
                                    <?php if ($this->session->userdata('role_id') == 1 or $menu['bill_code_coupon'] == 1) { ?>
                                        <a class="collapse-item <?= $title == 'Kode Kupon'  ? 'active' : '' ?>" href="<?= site_url('coupon') ?>">Kode Kupon</a>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                            <?php if ($this->session->userdata('role_id') == 1 or $menu['bill_delete'] == 1) { ?>
                                <a class="collapse-item <?= $title == 'Hapus Tagihan'  ? 'active' : '' ?>" href="" data-toggle="modal" data-target="#confirmdelbill"><span style="color: red;">Hapus Tagihan</span></a>
                            <?php } ?>
                            <!-- <?php if ($this->session->userdata('role_id') == 1 or $menu['bill_sharing_profit'] == 1) { ?>
                                <a class="collapse-item <?= $title == 'Sharing Profit'  ? 'active' : '' ?>" href="<?= site_url('bill/recapmitra') ?>">Sharing Profit</a>
                            <?php } ?> -->
                        </div>
                    </div>
                </li>
            <?php } ?>

            <?php if ($this->session->userdata('role_id') == 1 or $menu['finance_menu'] == 1) { ?>
                <li class="nav-item <?= $title == 'Income' | $title == 'Expenditure' | $title == 'Report'  ? 'active' : '' ?>">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReport" aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fas fa-fw fa-dollar-sign"></i>
                        <span>Keuangan</span>
                    </a>
                    <div id="collapseReport" class="collapse <?= $title == 'Income' | $title == 'Expenditure' | $title == 'Report' ? 'show' : '' ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="py-2 collapse-inner rounded">
                            <?php if ($this->session->userdata('role_id') == 1 or $menu['finance_income'] == 1) { ?>
                                <a class="collapse-item <?= $title == 'Income'  ? 'active' : '' ?>" href="<?= site_url('income') ?>">Pemasukan</a>
                            <?php } ?>
                            <?php if ($this->session->userdata('role_id') == 1 or $menu['finance_expend'] == 1) { ?>
                                <a class="collapse-item <?= $title == 'Expenditure'  ? 'active' : '' ?>" href="<?= site_url('expenditure') ?>">Pengeluaran</a>
                            <?php } ?>
                            <?php if ($this->session->userdata('role_id') == 1 or $menu['finance_report'] == 1) { ?>
                                <a class="collapse-item <?= $title == 'Report'  ? 'active' : '' ?>" href="<?= site_url('income/kas') ?>">Laporan Keuangan</a>
                            <?php } ?>
                        </div>
                    </div>
                </li>
            <?php } ?>
            <?php if ($this->session->userdata('role_id') == 1 or $menu['help_menu'] == 1) { ?>
                <li class="nav-item position-relative <?= $title == 'Data Help'  | $title == 'Help Setting' ? 'active' : '' ?>" id="navItemHelp">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsehelp" aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fas fa-fw fa-info-circle"></i>
                        <span>Bantuan</span>
                    </a>
                    <div id="collapsehelp" class="collapse <?= $title == 'Data Help'  | $title == 'Help Setting' ? 'show' : '' ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="py-2 collapse-inner rounded">
                            <?php if ($this->session->userdata('role_id') == 1 or $menu['help'] == 1) { ?>
                                <a class="collapse-item <?= $title == 'Data Help'  ? 'active' : '' ?>" href="<?= site_url('help/data') ?>">Tiket</a>
                            <?php } ?>
                            <?php if ($this->session->userdata('role_id') == 1 or $menu['help_category'] == 1) { ?>
                                <a class="collapse-item <?= $title == 'Help Setting'  ? 'active' : '' ?>" href="<?= site_url('help/setting') ?>">Kategori & Solusi</a>
                            <?php } ?>
                        </div>
                    </div>
                    <!-- Sidebar Toggler Docked on Right Side of Bantuan (Desktop) -->
                    <button class="rounded-circle border-0 d-none d-md-flex" id="sidebarToggle" title="Perkecil / Perbesar Sidebar"></button>
                </li>
            <?php } else { ?>
                <!-- Fallback Sidebar Toggler if Bantuan menu hidden -->
                <li class="nav-item position-relative d-none d-md-block" style="height:0;margin:0;padding:0;" id="navItemHelpFallback">
                    <button class="rounded-circle border-0 d-none d-md-flex" id="sidebarToggle" title="Perkecil / Perbesar Sidebar"></button>
                </li>
            <?php } ?>
            <?php if ($this->session->userdata('role_id') == 1 or $menu['master_menu'] == 1) { ?>

                <li class="nav-item <?= $title == 'Odc' | $title == 'Odp'    ? 'active' : '' ?>">

                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsmaster" aria-expanded="true" aria-controls="collapseTwo">

                        <i class="fas fa-fw fa-cube"></i>

                        <span>Master</span>

                    </a>

                    <div id="collapsmaster" class="collapse <?= $title == 'Odc' | $title == 'Odp'    ? 'show' : '' ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">

                        <div class="py-2 collapse-inner rounded">
                            <?php if ($this->session->userdata('role_id') == 1 or $menu['master_odc'] == 1) { ?>
                                <a class="collapse-item <?= $title == 'Odc'  ? 'active' : '' ?>" href="<?= site_url('odc') ?>">ODC</a>
                            <?php } ?>
                            <?php if ($this->session->userdata('role_id') == 1 or $menu['master_odp'] == 1) { ?>
                                <a class="collapse-item <?= $title == 'Odp'  ? 'active' : '' ?>" href="<?= site_url('odp') ?>" data-prefetch="true">ODP</a>
                            <?php } ?>


                        </div>

                    </div>

                </li>

            <?php } ?>


            <?php if ($this->session->userdata('role_id') == 1 or $menu['router_menu'] == 1) { ?>

                <li class="nav-item <?= $title == 'Routers' | $title == 'Customer Mikrotik' | $title == 'Schedule' | $title == 'Usage'  ? 'active' : '' ?>">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseRouter" aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fas fa-fw fa-wifi"></i>
                        <span>Router</span>
                    </a>
                    <div id="collapseRouter" class="collapse <?= $title == 'Routers' | $title == 'Customer Mikrotik' | $title == 'Schedule' | $title == 'Usage' ? 'show' : '' ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="py-2 collapse-inner rounded">
                            <?php if ($this->session->userdata('role_id') == 1 or $menu['router'] == 1) { ?>
                                <a class="collapse-item <?= $title == 'Routers'  ? 'active' : '' ?>" href="<?= site_url('router') ?>">Routers</a>
                            <?php } ?>
                            <?php $rt = $this->db->get_where('router', ['id' => 1])->row_array() ?>
                            <?php if ($rt['is_active'] == 0) { ?>
                                <?php if ($this->session->userdata('role_id') == 1 or $menu['router_schedule'] == 1) { ?>
                                    <a class="collapse-item <?= $title == 'Schedule'  ? 'active' : '' ?>" href="<?= site_url('setting/schedule') ?>">Shedule</a>
                                <?php } ?>
                            <?php } ?>
                            <?php if ($rt['is_active'] == 1) { ?>
                                <?php if ($this->session->userdata('role_id') == 1 or $menu['router_customer'] == 1) { ?>
                                    <a class="collapse-item <?= $title == 'Customer Mikrotik'  ? 'active' : '' ?>" href="<?= site_url('mikrotik/customer') ?>">Customer</a>
                                <?php } ?>
                                <?php if ($this->session->userdata('role_id') == 1 or $menu['router_customer'] == 1) { ?>
                                    <a class="collapse-item <?= $title == 'Usage'  ? 'active' : '' ?>" href="<?= site_url('mikrotik/usage') ?>">Pemakaian Internet</a>
                                <?php } ?>
                                <?php if ($this->session->userdata('role_id') == 1 or $menu['router_schedule'] == 1) { ?>
                                    <a class="collapse-item <?= $title == 'Schedule'  ? 'active' : '' ?>" href="<?= site_url('mikrotik/setting') ?>">Shedule</a>
                                <?php } ?>
                                <?php $other = $this->db->get('other')->row_array() ?>
                                <a class="collapse-item <?= $title == 'Schedule'  ? 'active' : '' ?>" href="<?= site_url('front/monitoring/' . $other['key_apps']) ?>" target="blank">Monitoring</a>

                            <?php } ?>

                        </div>
                    </div>
                </li>

            <?php } ?>

            <!-- Divider -->


            <!-- Divider -->
            <?php if ($this->session->userdata('role_id') == 1 or $menu['user_menu'] == 1) { ?>


                <li class="nav-item <?= $title == 'User' | $title == 'Admin' | $title == 'Mitra' | $title == 'Pelanggan' | $title == 'Operator' | $title == 'Teknisi' ? 'active' : '' ?>">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsuser" aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fas fa-fw fa-users"></i>
                        <span>Pengguna</span>
                    </a>
                    <div id="collapsuser" class="collapse <?= $title == 'User' | $title == 'Admin' | $title == 'Mitra' | $title == 'Pelanggan' | $title == 'Operator' | $title == 'Teknisi' ? 'show' : '' ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="py-2 collapse-inner rounded">
                            <?php if ($this->session->userdata('role_id') == 1 or $menu['user_add'] == 1) { ?>
                                <a class="collapse-item <?= $title == 'Add User'  ? 'active' : '' ?>" href="<?= site_url('user/register') ?>">Tambah</a>
                            <?php } ?>
                            <?php if ($this->session->userdata('role_id') == 1 or $menu['user_admin'] == 1) { ?>
                                <a class="collapse-item <?= $title == 'Admin'  ? 'active' : '' ?>" href="<?= site_url('user/admin') ?>">Administrator</a>
                            <?php } ?>
                            <?php if ($this->session->userdata('role_id') == 1 or $menu['user_customer'] == 1) { ?>
                                <a class="collapse-item <?= $title == 'Pelanggan'  ? 'active' : '' ?>" href="<?= site_url('user/customer') ?>">Pelanggan</a>
                            <?php } ?>

                            <?php if ($this->session->userdata('role_id') == 1 or $menu['user_operator'] == 1) { ?>
                                <a class="collapse-item <?= $title == 'Operator'  ? 'active' : '' ?>" href="<?= site_url('user/operator') ?>">Operator</a>
                            <?php } ?>
                            <?php if ($this->session->userdata('role_id') == 1 or $menu['user_teknisi'] == 1) { ?>
                                <a class="collapse-item <?= $title == 'Teknisi'  ? 'active' : '' ?>" href="<?= site_url('user/teknisi') ?>">Teknisi</a>
                            <?php } ?>
                            <?php if ($this->session->userdata('role_id') == 1 or $menu['user'] == 1) { ?>
                                <a class="collapse-item <?= $title == 'User'  ? 'active' : '' ?>" href="<?= site_url('user') ?>">Semua</a>
                            <?php } ?>
                        </div>
                    </div>
                </li>
            <?php } ?>

            <?php if ($this->session->userdata('role_id') == 1 or $menu['integration_menu'] == 1) { ?>
                <li class="nav-item <?= $title == 'Whatsapp'  | $title == 'OLT' | $title == 'BRI API'  | $title == 'Payment Gateway' | $title == 'Bot Telegram' | $title == 'OLT' | $title == 'SMS Gateway'  | $title == 'Email' | $title == 'Olt' | $title == 'Radius' ? 'active' : '' ?>">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapintegration" aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fas fa-fw fa-cog"></i>
                        <span>Integrasi</span>
                    </a>
                    <div id="collapintegration" class="collapse <?= $title == 'Whatsapp'  | $title == 'OLT' | $title == 'BRI API'  | $title == 'Payment Gateway' | $title == 'Bot Telegram' | $title == 'OLT' | $title == 'SMS Gateway'  | $title == 'Email' | $title == 'Olt' | $title == 'Radius'  ? 'show' : '' ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="py-2 collapse-inner rounded">
                            <?php if ($this->session->userdata('role_id') == 1 or $menu['integration_email'] == 1) { ?>
                                <a class="collapse-item <?= $title == 'Email'  ? 'active' : '' ?>" href="<?= site_url('setting/email') ?>">Email</a>
                            <?php } ?>

                            <?php if ($this->session->userdata('role_id') == 1 or $menu['integration_payment_gateway'] == 1) { ?>
                                <a class="collapse-item <?= $title == 'Payment Gateway'  ? 'active' : '' ?>" href="<?= site_url('payment') ?>">Payment Gateway</a>
                            <?php } ?>

                            <?php if ($this->session->userdata('role_id') == 1 or $menu['integration_whatsapp'] == 1) { ?>
                                <a class="collapse-item <?= $title == 'Whatsapp'  ? 'active' : '' ?>" href="<?= site_url('whatsapp') ?>">Whatsapp Gateway</a>
                            <?php } ?>

                            <?php if ($this->session->userdata('role_id') == 1 or $menu['integration_telegram'] == 1) { ?>
                                <a class="collapse-item <?= $title == 'Bot Telegram'  ? 'active' : '' ?>" href="<?= site_url('setting/bottelegram') ?>">Telegram</a>
                            <?php } ?>
                            <?php if ($this->session->userdata('role_id') == 1 or $menu['integration_maps'] == 1) { ?>
                                <a class="collapse-item <?= $title == 'Maps'  ? 'active' : '' ?>" href="<?= site_url('maps/setting') ?>">Maps</a>
                            <?php } ?>

                        </div>
                    </div>
                </li>
            <?php } ?>
            <?php if ($this->session->userdata('role_id') == 1 or $menu['setting_menu'] == 1) { ?>
                <li class="nav-item <?= $title == 'Setting'  | $title == 'Syarat dan Ketentuan' |  $title == 'Logs'  | $title == 'About' | $title == 'Backup' ? 'active' : '' ?>">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSetting" aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fas fa-fw fa-cog"></i>
                        <span>Pengaturan</span>
                    </a>
                    <div id="collapseSetting" class="collapse <?= $title == 'Setting'  | $title == 'Syarat dan Ketentuan' |  $title == 'Logs'  | $title == 'About' | $title == 'Backup'  ? 'show' : '' ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="py-2 collapse-inner rounded">
                            <?php if ($this->session->userdata('role_id') == 1 or $menu['setting_company'] == 1) { ?>
                                <a class="collapse-item <?= $title == 'Setting'  ? 'active' : '' ?>" href="<?= site_url('setting') ?>">Perusahaan</a>
                            <?php } ?>
                            <?php if ($this->session->userdata('role_id') == 1 or $menu['setting_about_company'] == 1) { ?>
                                <a class="collapse-item <?= $title == 'About'  ? 'active' : '' ?>" href="<?= site_url('setting/about') ?>">Tentang Perusahaan</a>
                            <?php } ?>
                            <?php if ($this->session->userdata('role_id') == 1 or $menu['setting_bank_account'] == 1) { ?>
                                <a class="collapse-item <?= $title == 'Bank'  ? 'active' : '' ?>" href="<?= site_url('setting/bank') ?>">Rekening Bank</a>
                            <?php } ?>

                            <?php if ($this->session->userdata('role_id') == 1 or $menu['setting_terms_condition'] == 1) { ?>
                                <a class="collapse-item <?= $title == 'Syarat dan Ketentuan'  ? 'active' : '' ?>" href="<?= site_url('setting/terms') ?>">Syarat dan Ketentuan</a>
                            <?php } ?>
                            <?php if ($this->session->userdata('role_id') == 1 or $menu['setting_privacy_policy'] == 1) { ?>
                                <a class="collapse-item <?= $title == 'Kebijakan Privasi'  ? 'active' : '' ?>" href="<?= site_url('setting/policy') ?>">Kebijakan Privasi</a>
                            <?php } ?>
                            <?php if ($this->session->userdata('role_id') == 1 or $menu['setting_logs'] == 1) { ?>
                                <a class="collapse-item <?= $title == 'Logs'  ? 'active' : '' ?>" href="<?= site_url('logs') ?>">Logs</a>
                            <?php } ?>
                            <?php if ($this->session->userdata('role_id') == 1 or $menu['setting_backup'] == 1) { ?>
                                <a class="collapse-item <?= $title == 'Backup'  ? 'active' : '' ?>" href="<?= site_url('backup') ?>">Backup</a>
                            <?php } ?>
                            <?php if ($this->session->userdata('role_id') == 1 or $menu['setting_other'] == 1) { ?>
                                <a class="collapse-item <?= $title == 'Lainnya'  ? 'active' : '' ?>" href="<?= site_url('setting/other') ?>">Lainnya</a>
                            <?php } ?>

                        </div>
                    </div>
                </li>
            <?php } ?>

            <?php if ($this->session->userdata('role_id') == 1 or $menu['role_menu'] == 1) { ?>


                <li class="nav-item <?= $title == 'Role' | $title == 'Role Menu' ? 'active' : '' ?>">
                    <a class=" nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsrole" aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fas fa-fw fa-cog"></i>
                        <span>Role Management</span>
                    </a>
                    <div id="collapsrole" class="collapse  <?= $title == 'Role' | $title == 'Role Menu' ? 'show' : '' ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="py-2 collapse-inner rounded">
                            <?php if ($this->session->userdata('role_id') == 1 or $menu['role_access'] == 1) { ?>
                                <a class="collapse-item <?= $title == 'Role'  ? 'active' : '' ?>" href="<?= site_url('role') ?>">Access</a>
                            <?php } ?>
                            <?php if ($this->session->userdata('role_id') == 1 or $menu['role_sub_menu'] == 1) { ?>
                                <a class="collapse-item <?= $title == 'Role Menu'  ? 'active' : '' ?>" href="<?= site_url('role/menu') ?>">Menu</a>
                            <?php } ?>
                        </div>
                    </div>
                </li>
            <?php } ?>
            <?php if ($this->session->userdata('role_id') == 1 or $menu['website_menu'] == 1) { ?>
                <li class="nav-item <?= $title == 'Slide' | $title == 'Product' ? 'active' : '' ?>">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseweb" aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fas fa-fw fa-info-circle"></i>
                        <span>Webiste</span>
                    </a>
                    <div id="collapseweb" class="collapse <?= $title == 'Slide' | $title == 'Product' ? 'show' : '' ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="py-2 collapse-inner rounded">
                            <?php if ($this->session->userdata('role_id') == 1 or $menu['website_slide'] == 1) { ?>
                                <a class="collapse-item <?= $title == 'Slide'  ? 'active' : '' ?>" href="<?= site_url('slider') ?>">Slide Show</a>
                            <?php } ?>
                            <?php if ($this->session->userdata('role_id') == 1 or $menu['website_product'] == 1) { ?>
                                <a class="collapse-item <?= $title == 'Product'  ? 'active' : '' ?>" href="<?= site_url('product/data') ?>">Produk / Jasa</a>
                            <?php } ?>
                        </div>
                    </div>
                </li>
            <?php } ?>
            <?php if ($this->session->userdata('role_id') == 1) { ?>
                <li class="nav-item <?= $title == 'Changelog'  ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= site_url('about/changelog') ?>">
                        <i class="fas fa-fw fa-info-circle"></i>
                        <span>Changelog</span></a>
                </li>
            <?php } ?>
            <!-- Sidebar Toggler moved beside Bantuan -->

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar Neumorphism -->
                <nav class="navbar navbar-expand topbar mb-4 sticky-top nm-topbar">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form class=" form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search d-none d-sm-block d-md-block">
                        <h5>
                            <?= htmlspecialchars(trim(str_ireplace('(BILL GAYUH BARU)', '', $company['company_name']))) ?>
                        </h5>

                    </form>

                    <div class="d-none d-sm-block d-md-block">
                        <p id="time"></p>
                    </div>
                    <!-- Topbar Navbar -->

                    <ul class="navbar-nav ml-auto">
                        <!-- Dark Mode Toggle Button -->
                        <li class="nav-item mx-2 d-flex align-items-center">
                            <button id="btnToggleDark" type="button" class="nm-btn nm-btn-circle-sm" title="Mode Gelap / Terang" onclick="toggleDarkMode()">
                                <i class="fas fa-moon" id="iconDark"></i>
                            </button>
                        </li>
                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter"><?= $this->db->get_where('confirm_payment', ['status' => 'Pending'])->num_rows() ?></span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Menunggu Konfirmasi Pembayaran
                                </h6>
                                <?php $query = "SELECT *
                                    FROM `confirm_payment`
                                    WHERE `status` =  'Pending'";
                                $pendingConfirm = $this->db->query($query)->result(); ?>
                                <?php foreach ($pendingConfirm as $data) : ?>
                                    <a class="dropdown-item d-flex align-items-center" href="<?= site_url('bill/confirmdetail/' . $data->invoice_id) ?>">
                                        <div>
                                            <?php $Customer = $this->db->get_where('customer', ['no_services' => $data->no_services])->row_array(); ?>
                                            <?php $bill = $this->db->get_where('invoice', ['no_services' => $data->no_services, 'invoice' => $data->invoice_id])->row_array(); ?>
                                            <span class="font-weight-bold"><?= $Customer['name'] ?> - <?= $data->no_services ?></span>
                                            <div class="small text-gray-500">#<?= $data->invoice_id ?> Periode <?= indo_month($bill['month']) ?> <?= $bill['year'] ?></div>
                                        </div>
                                    </a>
                                <?php endforeach ?>
                                <a class="dropdown-item text-center small text-gray-500" href="<?= site_url('confirm') ?>">Tampilkan Semua</a>
                            </div>
                        </li>

                        <!-- Nav Item - Messages -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-users fa-fw"></i>
                                <!-- Counter - Messages -->
                                <!-- Mitra -->
                                <?php if ($this->session->userdata('role_id') == 4) { ?>
                                    <?php $Capel = $this->db->get_where('customer', ['c_status' => 'Menunggu', 'mitra' => $this->session->userdata('id')]); ?>
                                <?php } ?>
                                <!-- Admin -->
                                <?php if ($this->session->userdata('role_id') == 1) { ?>
                                    <?php $Capel = $this->db->get_where('customer', ['c_status' => 'Menunggu']); ?>
                                <?php } ?>
                                <?php if ($this->session->userdata('role_id') == 5) { ?>
                                    <?php $Capel = $this->db->get_where('customer', ['c_status' => 'Menunggu']); ?>
                                <?php } ?>
                                <!-- Operator -->
                                <?php if ($this->session->userdata('role_id') == 3) { ?>

                                    <?php $Capel = $this->db->get_where('customer', ['c_status' => 'Menunggu']); ?>

                                <?php } ?>
                                <span class="badge badge-danger badge-counter"><?= $Capel->num_rows(); ?></span>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                                <h6 class="dropdown-header">
                                    Calon Pelanggan Baru
                                </h6>
                                <?php foreach ($Capel->result() as $capel) { ?>
                                    <a class="dropdown-item d-flex align-items-center" href="<?= site_url('customer/edit/' . $capel->customer_id) ?>">

                                        <div class="font-weight-bold">
                                            <div class="text-truncate"><?= $capel->name; ?></div>
                                            <div class="small text-gray-500"><?= date('d F Y', $capel->created); ?></div>
                                        </div>
                                    </a>
                                <?php } ?>


                                <a class="dropdown-item text-center small text-gray-500" href="<?= site_url('customer/wait') ?>">Tampilkan Semua</a>
                            </div>
                        </li>
                        <div class="topbar-divider d-none d-sm-block"></div>
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle nm-user-pill" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline small font-weight-bold" style="color: var(--nm-text-main);"><?= $user['name']; ?></span>
                                <img class="img-profile rounded-circle" src="<?= base_url(''); ?>assets/images/profile/<?= $user['image']; ?>" alt="" style="width: 28px; height: 28px; object-fit: cover;">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="<?= site_url('user/profile') ?>">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Akun
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Keluar
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->
                <!-- Bootstrap core JavaScript-->
                <script src="<?= base_url('assets/backend/') ?>vendor/jquery/jquery.min.js"></script>
                <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.10.4/dist/sweetalert2.all.min.js"></script> -->
                <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <!-- Begin Page Content -->

                <div class="container-fluid">


                    <?= $contents ?>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
            <div class="modal fade" id="confirmdelbill" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form action="<?= site_url('bill/confirmdelbill') ?>" method="POST">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Password</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="password">Masukan Ulang Password Login Anda</label>
                                    <input type="password" name="password" id="password" class="form-control" autocapitalize="off" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Go</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Footer -->
            <footer class="sticky-footer">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; <?= $company['company_name'] ?> <?= date('Y') ?></span>
                        <div class="text-center text-gray-500 mt-2" style="font-size: 0.875rem;">
                            Page rendered in <strong>{elapsed_time}</strong> seconds.
                        </div>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->
    <!-- Modal -->

    <!-- Scroll to Top Button-->
    <style>
        .scroll-to-top {
            position: fixed;
            left: 50%;
            right: 50%;
            bottom: 4rem;
            display: none;
            width: 2.75rem;
            height: 2.75rem;
            text-align: center;
            color: #fff;
            background: rgba(90, 92, 105, 0.5);
            line-height: 46px;
        }

        .scroll-to-top:focus,
        .scroll-to-top:hover {
            color: white;
        }

        .scroll-to-top:hover {
            background: #5a5c69;
        }

        .scroll-to-top i {
            font-weight: 800;
        }
    </style>
    <a class="scroll-to-top rounded" href="#page-top" title="Back To Top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h5 class="modal-title" id="exampleModalLabel">Apakah anda yakin ?</h5>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="<?= site_url('auth/logout') ?>">Keluar</a>
                </div>
            </div>
        </div>
    </div>
    <nav class="navbar mobile-bottom-nav navbar-expand d-md-none fixed-bottom">
        <ul class="navbar-nav nav-justified w-100 flex-row">
            <li class="nav-item">
                <a href="<?= site_url('dashboard') ?>" class="nav-link <?= $title == 'Dashboard' ? 'active' : '' ?>" title="Beranda">
                    <i class="fas fa-home"></i>
                    <span>Beranda</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= site_url('customer/active') ?>" class="nav-link <?= in_array($title, ['Aktif', 'Customer', 'Non-Aktif', 'Add Customer', 'Free', 'Isolir', 'Waiting', 'Maps']) ? 'active' : '' ?>" title="Pelanggan">
                    <i class="fas fa-users"></i>
                    <span>Pelanggan</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= site_url('bill') ?>" class="nav-link <?= in_array($title, ['Bill', 'Belum Bayar', 'Sudah Bayar', 'Jatuh Tempo', 'Tunggakan']) ? 'active' : '' ?>" title="Tagihan">
                    <i class="fas fa-file-invoice-dollar"></i>
                    <span>Tagihan</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= site_url('user/profile') ?>" class="nav-link <?= $title == 'Profile' ? 'active' : '' ?>" title="Profil">
                    <i class="fas fa-user-circle"></i>
                    <span>Profil</span>
                </a>
            </li>
            <?php if ($this->session->userdata('role_id') == 1) { ?>
                <li class="nav-item">
                    <a href="<?= site_url('setting') ?>" class="nav-link <?= $title == 'Setting' ? 'active' : '' ?>" title="Pengaturan">
                        <i class="fas fa-cog"></i>
                        <span>Pengaturan</span>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </nav>
    <div class="modal fade" id="popup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="spinner-grow text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <div class="spinner-grow text-secondary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <div class="spinner-grow text-success" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <div class="spinner-grow text-danger" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <div class="spinner-grow text-warning" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <div class="spinner-grow text-info" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <div class="spinner-grow text-light" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <div class="spinner-grow text-dark" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>
    <script src="<?= base_url('assets/backend/') ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>




    <!-- Custom scripts for all pages-->
    <script src="<?= base_url('assets/backend/') ?>js/sb-admin-2.js"></script>
    <!-- Page level plugins -->
    <script src="<?= base_url('assets/backend/') ?>vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url('assets/backend/') ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <!-- Page level custom scripts -->
    <script src="<?= base_url('assets/backend/') ?>js/demo/datatables-demo.js"></script>
    <script src="<?= base_url('assets/backend/') ?>js/select2.full.min.js"></script>
    <script src="<?= base_url('assets/backend/') ?>moment.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.2.2/js/dataTables.fixedHeader.min.js"></script>
    <script src="<?= base_url('assets/backend/') ?>vendor/datatables/dataTables.responsive.min.js"></script>
    <script src="<?= base_url('assets/backend/') ?>vendor/datatables/responsive.bootstrap4.min.js"></script>
    <!-- bootstrap datepicker -->
    <script src="<?= base_url('assets/backend') ?>/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/Leaflet.fullscreen.min.js'></script>
    <link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/leaflet.fullscreen.css' rel='stylesheet' />


    <script>
        $(document).ready(function() {
            $('#tablebt').DataTable({
                "lengthMenu": [
                    [10, 25, 50, 100, 250, 500, 1000],
                    [10, 25, 50, 100, 250, 500, 1000]
                ],
                dom: 'lBfrtip',
                buttons: [{
                        extend: ['copy'],
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: ['csv'],
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: ['excel'],
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: ['pdf'],
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: ['print'],
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    'colvis'
                ],

            });

        });
    </script>
    <script>
        $(document).ready(function() {
            oTable = jQuery('#dataTableDraf').dataTable({
                "bPaginate": false,
                "bLengthChange": false,
                "searching": true,
                "aoColumns": [{
                        "bSortable": true
                    },
                    {
                        "bSortable": true
                    },
                    {
                        "bSortable": true
                    },
                    {
                        "bSortable": true
                    },
                    {
                        "bSortable": true
                    },
                    {
                        "bSortable": true
                    },

                    {
                        "bSortable": false
                    },
                    {
                        "bSortable": false
                    },

                ]
            });
        })
    </script>


    <script type="text/javascript">
        $(document).ready(function() {
            $("#popup").modal({
                show: false,
                backdrop: 'static'
            });
        });
        $("#click-me").click(function() {
            $("#popup").modal("show");
            $("#billGenerate").modal("hide");
            $("#DeleteModal").modal("hide");
            $("#ModalBayar").modal("hide");
            $("#exampleModal").modal("hide");
            $("#add").modal("hide");

        });
        $(document).ready(function() {
            if ($(window).width() < 768) {
                // Pastikan drawer mobile tertutup saat halaman dimuat
                $("body").removeClass("sidebar-open sidebar-toggled");
                $(".sidebar").removeClass("toggled");
            }
        });
        // document.addEventListener('contextmenu', event => event.preventDefault());
        // document.onkeydown = function(e) {
        //     if (e.ctrlKey &&
        //         (e.keyCode === 67 ||
        //             e.keyCode === 86 ||
        //             e.keyCode === 85 ||
        //             e.keyCode === 117)) {
        //         return false;
        //     } else {
        //         return true;
        //     }
        // };
        // $(document).keypress("u", function(e) {
        //     if (e.ctrlKey) {
        //         return false;
        //     } else {
        //         return true;
        //     }
        // });
        // $(document).keydown(function(event) {
        //     if (event.keyCode == 123) { // Prevent F12
        //         return false;
        //     } else if (event.ctrlKey && event.shiftKey && event.keyCode == 73) { // Prevent Ctrl+Shift+I        
        //         return false;
        //     }
        // });
    </script>

    <script>
        //Date picker
        $('#datepicker').datepicker({
            maxDate: '0',
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
        })
        $('#datepickerdisablefuture').datepicker({
            maxDate: '0',
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            endDate: new Date()
        });
    </script>
    <script>
        window.updateHighchartsTheme = function(isDark) {
            if (typeof Highcharts === 'undefined') return;
            isDark = typeof isDark !== 'undefined' ? isDark : $('body').hasClass('dark-mode');
            var themeOptions = {
                chart: {
                    backgroundColor: isDark ? '#161c2e' : '#ffffff',
                    plotBackgroundColor: isDark ? '#0f1423' : '#ffffff',
                    plotBorderColor: isDark ? 'rgba(255, 255, 255, 0.1)' : '#cccccc'
                },
                title: {
                    style: {
                        color: isDark ? '#ffffff' : '#333333',
                        fontSize: '16px',
                        fontWeight: 'bold'
                    }
                },
                subtitle: {
                    style: {
                        color: isDark ? '#cbd5e1' : '#666666'
                    }
                },
                xAxis: {
                    gridLineColor: isDark ? 'rgba(255, 255, 255, 0.08)' : '#e6e6e6',
                    lineColor: isDark ? 'rgba(255, 255, 255, 0.15)' : '#ccd6eb',
                    tickColor: isDark ? 'rgba(255, 255, 255, 0.15)' : '#ccd6eb',
                    labels: {
                        style: {
                            color: isDark ? '#cbd5e1' : '#666666'
                        }
                    },
                    title: {
                        style: {
                            color: isDark ? '#cbd5e1' : '#666666'
                        }
                    }
                },
                yAxis: {
                    gridLineColor: isDark ? 'rgba(255, 255, 255, 0.08)' : '#e6e6e6',
                    lineColor: isDark ? 'rgba(255, 255, 255, 0.15)' : '#ccd6eb',
                    tickColor: isDark ? 'rgba(255, 255, 255, 0.15)' : '#ccd6eb',
                    labels: {
                        style: {
                            color: isDark ? '#cbd5e1' : '#666666'
                        }
                    },
                    title: {
                        style: {
                            color: isDark ? '#cbd5e1' : '#666666'
                        }
                    }
                },
                legend: {
                    backgroundColor: isDark ? '#0f1423' : '#ffffff',
                    itemStyle: {
                        color: isDark ? '#cbd5e1' : '#333333'
                    },
                    itemHoverStyle: {
                        color: isDark ? '#f47b20' : '#000000'
                    },
                    itemHiddenStyle: {
                        color: isDark ? '#64748b' : '#cccccc'
                    }
                },
                tooltip: {
                    backgroundColor: isDark ? '#1a2138' : 'rgba(247, 247, 247, 0.85)',
                    style: {
                        color: isDark ? '#ffffff' : '#333333'
                    },
                    borderColor: isDark ? 'rgba(255, 255, 255, 0.2)' : '#606060'
                },
                colors: isDark ? ['#60a5fa', '#f47b20', '#4ade80', '#facc15', '#a78bfa'] : ['#7cb5ec', '#434348', '#90ed7d', '#f7a35c', '#8085e9']
            };
            Highcharts.setOptions(themeOptions);
        };

        function applyDarkMode(isDark) {
            if (isDark) {
                document.documentElement.classList.add('dark-mode');
                document.body.classList.add('dark-mode');
                document.documentElement.style.backgroundColor = '#0f1423';
                document.body.style.backgroundColor = '#0f1423';
                $('#iconDark').removeClass('fa-moon text-secondary').addClass('fa-sun text-warning');
                $('#btnToggleDark').removeClass('btn-outline-secondary').addClass('btn-warning text-dark');
                localStorage.setItem('backend_theme', 'dark');
                document.cookie = "backend_theme=dark; path=/; max-age=31536000";
            } else {
                document.documentElement.classList.remove('dark-mode');
                document.body.classList.remove('dark-mode');
                document.documentElement.style.backgroundColor = '';
                document.body.style.backgroundColor = '';
                $('#iconDark').removeClass('fa-sun text-warning').addClass('fa-moon text-secondary');
                $('#btnToggleDark').removeClass('btn-warning text-dark').addClass('btn-outline-secondary');
                localStorage.setItem('backend_theme', 'light');
                document.cookie = "backend_theme=light; path=/; max-age=31536000";
            }

            if (window.updateHighchartsTheme) {
                window.updateHighchartsTheme(isDark);
            }

            if (typeof myLineChart !== 'undefined') {
                var textColor = isDark ? '#cbd5e1' : '#858796';
                var gridColor = isDark ? 'rgba(255, 255, 255, 0.08)' : 'rgb(234, 236, 244)';
                var zeroGridColor = isDark ? 'rgba(255, 255, 255, 0.12)' : 'rgb(234, 236, 244)';
                
                if (myLineChart.options && myLineChart.options.scales) {
                    myLineChart.options.scales.xAxes[0].ticks.fontColor = textColor;
                    myLineChart.options.scales.yAxes[0].ticks.fontColor = textColor;
                    myLineChart.options.scales.yAxes[0].gridLines.color = gridColor;
                    myLineChart.options.scales.yAxes[0].gridLines.zeroLineColor = zeroGridColor;
                    myLineChart.options.tooltips.backgroundColor = isDark ? '#161c2e' : 'rgb(255,255,255)';
                    myLineChart.options.tooltips.bodyFontColor = isDark ? '#f1f5f9' : '#858796';
                    myLineChart.options.tooltips.titleFontColor = isDark ? '#ffffff' : '#6e707e';
                    myLineChart.options.tooltips.borderColor = isDark ? 'rgba(255, 255, 255, 0.15)' : '#dddfeb';
                    myLineChart.update();
                }
            }
        }

        function toggleDarkMode() {
            var isDark = !$('body').hasClass('dark-mode');
            applyDarkMode(isDark);
        }

        $(document).ready(function() {
            var theme = localStorage.getItem('backend_theme');
            if (theme === 'dark') {
                applyDarkMode(true);
            }
        });

        console.log('Ini adalah fitur browser yang ditujukan untuk developer. kami tidak bertanggung jawab jika anda mengubah script yg mengakibatkan error, dan mohon untuk tidak menjual kembali source code billing ini, jika terdeteksi maka tidak akan mendapatkan lagi support untuk update !');
        console.log('Ini adalah fitur browser yang ditujukan untuk pengguna. Jika seseorang meminta Anda untuk menyalin-menempel sesuatu di sini untuk mengaktifkan fitur Billing atau "meretas" akun seseorang, ini adalah penipuan dan akan memberikannya akses ke akun Anda.');
    </script>
</body>

</html>
<script>
    var timeDisplay = document.getElementById("time");
    var timezone = '<?= $company['timezone'] ?>'

    function refreshTime() {
        var dateString = new Date().toLocaleString("en-US", {
            timeZone: timezone,
            // weekday: 'short', // long, short, narrow
            // day: 'numeric', // numeric, 2-digit
            // year: 'numeric', // numeric, 2-digit
            // month: 'long', // numeric, 2-digit, long, short, narrow
            // hour: 'numeric', // numeric, 2-digit
            // minute: 'numeric', // numeric, 2-digit
            // second: 'numeric', // numeric, 2-digit
        });

        // console.log(dateString);
        var formattedString = moment(dateString).format('DD-MM-YYYY - H:m:s');
        timeDisplay.innerHTML = formattedString;
    }

    setInterval(refreshTime, 1000);
</script>

<!-- CEK ULANG ISOLIR -->

<?php $cekcs = (isset($this->customer_m) && method_exists($this->customer_m, 'getisolirpasca')) ? $this->customer_m->getisolirpasca()->num_rows() : 0; ?>

<?php if ($cekcs > 0) { ?>
    <?php $rt = $this->db->get_where('router', ['id' => 1])->row_array() ?>
    <?php if ($rt['is_active'] == 1) { ?>
        <?php $other = $this->db->get('other')->row_array() ?>


    <?php } ?>
<?php } ?>
<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2({
            width: '100%'
        });
    });
</script>
<script>
    var current_detail_service = '';

    function getdetailcustomer(force) {
        var no_services = $('select#no_services').val() || $("#no_services").val();

        if (!no_services || no_services === '') {
            current_detail_service = '';
            $('.loading').html('');
            $('.getdatacustomer').html('');
            $('#contents').show();
            return false;
        }

        if (no_services === current_detail_service && !force) {
            return false;
        }

        current_detail_service = no_services;

        $.ajax({
            type: 'POST',
            data: "&no_services=" + encodeURIComponent(no_services),
            cache: false,
            url: '<?= site_url('customer/get_data') ?>',
            beforeSend: function() {
                $('.loading').html(` <div class="container py-4">
                    <div class="text-center">
                        <div class="spinner-border text-primary" style="width: 4rem; height: 4rem;" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <p class="mt-2 text-muted font-weight-bold">Memuat detail pelanggan...</p>
                    </div>
                </div>`);
                $('.getdatacustomer').html('');
            },
            success: function(data) {
                $('.loading').html('');
                $('.getdatacustomer').html(data);
                $('#contents').hide();
            },
            error: function(xhr, status, error) {
                $('.loading').html('<div class="alert alert-danger mx-3 my-2">Gagal memuat data pelanggan. Silakan coba lagi.</div>');
            }
        });

        return false;
    }

    function closedetailcustomer() {
        current_detail_service = '';
        if ($('select#no_services').length) {
            $('select#no_services').val('').trigger('change.select2');
        }
        $('.loading').html('');
        $('.getdatacustomer').html('');
        $('#contents').show();
    }

    $(document).ready(function() {
        $(document).on('select2:select change', 'select#no_services', function() {
            getdetailcustomer();
        });

        // Instant hover prefetch for ultra-fast navigation
        $(document).on('mouseenter touchstart', 'a[data-prefetch="true"]', function() {
            var url = $(this).attr('href');
            if (url && !$(this).data('prefetched')) {
                $(this).data('prefetched', true);
                var link = document.createElement('link');
                link.rel = 'prefetch';
                link.href = url;
                document.head.appendChild(link);
            }
        });
    });
</script>