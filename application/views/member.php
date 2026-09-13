<?php $isDarkTheme = (isset($_COOKIE['backend_theme']) && $_COOKIE['backend_theme'] === 'dark'); ?>
<!doctype html>
<html class="no-js <?= $isDarkTheme ? 'dark-mode' : '' ?>" lang="en">

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
        html.dark-mode, html.dark-mode body, html.dark-mode .wrapper, html.dark-mode .main-content {
            background-color: #0f1423 !important;
            color: #f1f5f9 !important;
        }
    </style>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>
        <?= $title ?> | Pelanggan</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="<?= base_url('assets/images/favicon.png') ?>">
    <link rel="icon" href="" type="image/x-icon" />

    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,600,700,800" rel="stylesheet">
    <script src="<?= base_url('assets/backend/') ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="<?= base_url('assets/member/') ?>plugins/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/member/') ?>plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/member/') ?>plugins/ionicons/dist/css/ionicons.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/member/') ?>plugins/icon-kit/dist/css/iconkit.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/member/') ?>plugins/perfect-scrollbar/css/perfect-scrollbar.css">
    <link rel="stylesheet" href="<?= base_url('assets/member/') ?>plugins/weather-icons/css/weather-icons.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/member/') ?>dist/css/theme.min.css">

    <link rel="stylesheet" href="<?= base_url('assets/member/') ?>plugins/owl.carousel/dist/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/member/') ?>plugins/owl.carousel/dist/assets/owl.theme.default.min.css">
    <script src="<?= base_url('assets/member/') ?>src/js/vendor/modernizr-2.8.3.min.js"></script>
    <!-- bootstrap datepicker -->
    <link href="<?= base_url('assets/backend/') ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
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
        .app-sidebar.colored,
        .sidebar-header {
            background-color: #2a207a !important;
            background-image: linear-gradient(180deg, #2a207a 10%, #150d4a 100%) !important;
        }

        .navigation-main .nav-item.active a,
        .navigation-main .nav-item a:hover {
            color: #f47b20 !important;
        }

        .navigation-main .nav-item.active a i,
        .navigation-main .nav-item a:hover i {
            color: #f47b20 !important;
        }

        .header-brand .logo-img i {
            color: #f47b20 !important;
        }

        /* Dark Mode Styling */
        html.dark-mode body,
        body.dark-mode {
            background-color: #12172b !important;
            color: #e2e8f0 !important;
        }

        body.dark-mode .header-top {
            background-color: #181e33 !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
        }

        body.dark-mode .main-content,
        body.dark-mode .page-wrap {
            background-color: #12172b !important;
        }

        body.dark-mode .card {
            background-color: #181e33 !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            color: #e2e8f0 !important;
        }

        body.dark-mode .card-header {
            background-color: rgba(255, 255, 255, 0.04) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
            color: #f8fafc !important;
        }

        body.dark-mode table,
        body.dark-mode .table {
            color: #e2e8f0 !important;
            border-color: rgba(255, 255, 255, 0.08) !important;
        }

        body.dark-mode table th,
        body.dark-mode table td {
            border-color: rgba(255, 255, 255, 0.08) !important;
            color: #e2e8f0 !important;
        }

        body.dark-mode .form-control {
            background-color: #12172b !important;
            border-color: rgba(255, 255, 255, 0.15) !important;
            color: #f8fafc !important;
        }

        body.dark-mode .dropdown-menu,
        body.dark-mode .modal-content {
            background-color: #181e33 !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
            color: #e2e8f0 !important;
        }

        body.dark-mode .dropdown-item {
            color: #cbd5e1 !important;
        }

        body.dark-mode .dropdown-item:hover {
            background-color: rgba(244, 123, 32, 0.15) !important;
            color: #f47b20 !important;
        }

        body.dark-mode .footer {
            background-color: #12172b !important;
            color: #64748b !important;
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

        .mobile-bottom-nav .nav-link i {
            font-size: 1.25rem !important;
            margin-bottom: 2px !important;
            transition: transform 0.2s ease, color 0.2s ease !important;
        }

        .mobile-bottom-nav .nav-link.active,
        .mobile-bottom-nav .nav-link:hover {
            color: #f47b20 !important;
            font-weight: 700 !important;
        }

        .mobile-bottom-nav .nav-link.active i {
            color: #f47b20 !important;
            transform: translateY(-2px) scale(1.1) !important;
        }

        @media (max-width: 767.98px) {
            body {
                padding-bottom: 60px !important;
            }
        }
    </style>
<body class="<?= $isDarkTheme ? 'dark-mode' : '' ?>">
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <?php if ($user['role_id'] != 2) {
        redirect('auth/logout');
    } ?>
    <?php $role = $this->db->get_where('role_management', ['role_id' => 2])->row_array() ?>
    <?= $this->session->flashdata('message') ?>
    <?php $rolepelanggan = $this->db->get_where('role_management', ['role_id' => 2])->row_array() ?>
    <div class="wrapper">
        <header class="header-top" header-theme="light">
            <div class="container-fluid">
                <div class="d-flex justify-content-between">
                    <div class="top-menu d-flex align-items-center">
                        <button type="button" class="btn-icon mobile-nav-toggle d-lg-none"><span></span></button>
                        <!-- <div class="header-search">
                            <div class="input-group">
                                <span class="input-group-addon search-close"><i class="ik ik-x"></i></span>
                                <input type="text" class="form-control">
                                <span class="input-group-addon search-btn"><i class="ik ik-search"></i></span>
                            </div>
                        </div> -->
                        <!-- <button type="button" id="navbar-fullscreen" class="nav-link"><i class="ik ik-maximize"></i></button> -->
                    </div>
                    <div class="top-menu d-flex align-items-center">
                        <div class="dropdown">
                            <!-- <a class="nav-link dropdown-toggle" href="#" id="notiDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ik ik-bell"></i><span class="badge bg-danger">3</span></a> -->
                            <!-- <div class="dropdown-menu dropdown-menu-right notification-dropdown" aria-labelledby="notiDropdown">
                                <h4 class="header">Notifications</h4>
                                <div class="notifications-wrap">
                                    <a href="#" class="media">
                                        <span class="d-flex">
                                            <i class="ik ik-check"></i>
                                        </span>
                                        <span class="media-body">
                                            <span class="heading-font-family media-heading">Invitation accepted</span>
                                            <span class="media-content">Your have been Invited ...</span>
                                        </span>
                                    </a>
                                    <a href="#" class="media">
                                        <span class="d-flex">
                                            <img src="<?= base_url('assets/member/') ?>/img/users/1.jpg" class="rounded-circle" alt="">
                                        </span>
                                        <span class="media-body">
                                            <span class="heading-font-family media-heading">Steve Smith</span>
                                            <span class="media-content">I slowly updated projects</span>
                                        </span>
                                    </a>
                                    <a href="#" class="media">
                                        <span class="d-flex">
                                            <i class="ik ik-calendar"></i>
                                        </span>
                                        <span class="media-body">
                                            <span class="heading-font-family media-heading">To Do</span>
                                            <span class="media-content">Meeting with Nathan on Friday 8 AM ...</span>
                                        </span>
                                    </a>
                                </div>
                                <div class="footer"><a href="javascript:void(0);">See all activity</a></div>
                            </div> -->
                        </div>
                        <!-- <button type="button" class="nav-link ml-10 right-sidebar-toggle"><i class="ik ik-message-square"></i><span class="badge bg-success">3</span></button> -->
                        <!-- <div class="dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="menuDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ik ik-plus"></i></a>
                            <div class="dropdown-menu dropdown-menu-right menu-grid" aria-labelledby="menuDropdown">
                                <a class="dropdown-item" href="#" data-toggle="tooltip" data-placement="top" title="Dashboard"><i class="ik ik-bar-chart-2"></i></a>
                                <a class="dropdown-item" href="#" data-toggle="tooltip" data-placement="top" title="Message"><i class="ik ik-mail"></i></a>
                                <a class="dropdown-item" href="#" data-toggle="tooltip" data-placement="top" title="Accounts"><i class="ik ik-users"></i></a>
                                <a class="dropdown-item" href="#" data-toggle="tooltip" data-placement="top" title="Sales"><i class="ik ik-shopping-cart"></i></a>
                                <a class="dropdown-item" href="#" data-toggle="tooltip" data-placement="top" title="Purchase"><i class="ik ik-briefcase"></i></a>
                                <a class="dropdown-item" href="#" data-toggle="tooltip" data-placement="top" title="Pages"><i class="ik ik-clipboard"></i></a>
                                <a class="dropdown-item" href="#" data-toggle="tooltip" data-placement="top" title="Chats"><i class="ik ik-message-square"></i></a>
                                <a class="dropdown-item" href="#" data-toggle="tooltip" data-placement="top" title="Contacts"><i class="ik ik-map-pin"></i></a>
                                <a class="dropdown-item" href="#" data-toggle="tooltip" data-placement="top" title="Blocks"><i class="ik ik-inbox"></i></a>
                                <a class="dropdown-item" href="#" data-toggle="tooltip" data-placement="top" title="Events"><i class="ik ik-calendar"></i></a>
                                <a class="dropdown-item" href="#" data-toggle="tooltip" data-placement="top" title="Notifications"><i class="ik ik-bell"></i></a>
                                <a class="dropdown-item" href="#" data-toggle="tooltip" data-placement="top" title="More"><i class="ik ik-more-horizontal"></i></a>
                            </div>
                        </div> -->
                        <!-- <button type="button" class="nav-link ml-10" id="apps_modal_btn" data-toggle="modal" data-target="#appsModal"><i class="ik ik-grid"></i></button> -->
                        <div class="dropdown">
                            <a class="dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false""><?= $user['name'] ?></span>
                            <div class=" dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="<?= site_url('member/profile') ?>"><i class="ik ik-user dropdown-icon"></i> Profile</a>
                                <a class="dropdown-item" href="<?= site_url('auth/logout') ?>"><i class="ik ik-power dropdown-icon"></i> Logout</a>
                        </div>
                    </div>
                        <div class="mr-2 d-flex align-items-center">
                            <button id="btnToggleDarkMember" type="button" class="btn btn-sm btn-circle btn-outline-secondary shadow-sm" title="Mode Gelap / Terang" onclick="toggleDarkMode()">
                                <i class="fas fa-moon" id="iconDarkMember"></i>
                            </button>
                        </div>
                        <div class="dropdown">
                            <a class="dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img class="avatar" src="<?= base_url(''); ?>assets/images/profile/<?= $user['image']; ?>" alt=""></a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="<?= site_url('member/profile') ?>"><i class="ik ik-user dropdown-icon"></i> Profile</a>
                                <a class="dropdown-item" href="<?= site_url('auth/logout') ?>"><i class="ik ik-power dropdown-icon"></i> Logout</a>
                            </div>
                        </div>

                </div>
            </div>
    </div>
    </header>

    <div class="page-wrap">
        <div class="app-sidebar colored">
            <div class="sidebar-header">
                <a class="header-brand" href="<?= base_url('member') ?>">
                    <div class="logo-img">
                        <i class="fa fa-wifi"> </i>
                    </div>
                    <span class="text"><?= $company['apps_name']; ?></span>
                </a>
                <button type="button" class="nav-toggle"><i data-toggle="expanded" class="ik ik-toggle-right toggle-icon"></i></button>
                <button id="sidebarClose" class="nav-close"><i class="ik ik-x"></i></button>
            </div>

            <div class="sidebar-content">
                <div class="nav-container">
                    <nav id="main-menu-navigation" class="navigation-main">

                        <div class="nav-item <?= $title == 'Dashboard'  ? 'active' : '' ?>">
                            <a href="<?= base_url('member') ?>"><i class="ik ik-bar-chart-2"></i><span>Beranda</span></a>
                        </div>
                        <div class="nav-item <?= $title == 'Status'  ? 'active' : '' ?>">
                            <a href="<?= base_url('member/status') ?>"><i class="ik ik-menu"></i><span>Informasi Layanan</span> </a>
                        </div>
                        <?php if ($role['show_history'] == 1) { ?>
                            <div class="nav-item <?= $title == 'History'  ? 'active' : '' ?>">
                                <a href="<?= base_url('member/history') ?>"><i class="ik ik-dollar-sign"></i><span>Riwayat Tagihan</span> </a>
                            </div>
                        <?php } ?>
                        <?php if ($role['show_help'] == 1) { ?>
                            <div class="nav-item <?= $title == 'Lapor Gangguan'  ? 'active' : '' ?>">
                                <a href="<?= base_url('help') ?>"><i class="fas fa-wrench"></i><span>Open Tiket</span> </a>
                            </div>
                            <div class="nav-item <?= $title == 'Help'  ? 'active' : '' ?>">
                                <a href="<?= base_url('member/help') ?>"><i class="fa fa-question"></i><span>Bantuan</span> </a>
                            </div>
                        <?php } ?>
                        <?php if ($role['show_log'] == 1) { ?>
                            <div class="nav-item <?= $title == 'Logs'  ? 'active' : '' ?>">
                                <a href="<?= base_url('member/logs') ?>"><i class="ik ik-clock"></i><span>Logs</span> </a>
                            </div>
                        <?php } ?>
                        <?php $customer = $this->db->get_where('customer', ['email' => $this->session->userdata('email')])->row_array(); ?>
                        <?php $modem = $this->member_m->getmodem($customer['customer_id'])->num_rows() ?>
                        <?php if ($modem > 0) { ?>
                            <div class="nav-item <?= $title == 'Modem'  ? 'active' : '' ?>">
                                <a href="<?= base_url('member/modem') ?>"><i class="ik ik-rss"></i><span>Modem</span> </a>
                            </div>
                        <?php } ?>
                        <?php if ($modem == 0) { ?>
                            <div class="nav-item <?= $title == 'Modem'  ? 'active' : '' ?>">
                                <!-- <a href="<?= base_url('member/modem') ?>"><i class="ik ik-rss"></i><span>Ganti Password Modem</span> </a> -->
                            </div>
                        <?php } ?>

                        <?php if ($role['show_speedtest'] == 1) { ?>
                            <div class="nav-item <?= $title == 'Speedtest'  ? 'active' : '' ?>">
                                <a href="<?= base_url('member/speedtest') ?>"><i class="ik ik-rss"></i><span>Speedtest</span> </a>
                            </div>
                        <?php } ?>

                        <div class="nav-lavel">Pengaturan</div>
                        <div class="nav-item <?= $title == 'Profile' | $title == 'Account'  ? 'active' : '' ?>">
                            <a href="<?= site_url('member/profile') ?>"><i class="ik ik-user"></i><span>Profile</span></a>
                        </div>
                        <div class="nav-item <?= $title == 'Ganti Password'  ? 'active' : '' ?>">
                            <a href="<?= site_url('member/changepassword') ?>"><i class="fa fa-key"></i><span>Ganti Password</span></a>
                        </div>

                        <div class="nav-item <?= $title == 'Tentang'  ? 'active' : '' ?>">
                            <a href="<?= site_url('member/about') ?>"><i class="fa fa-info"></i><span>Tentang</span></a>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.10.4/dist/sweetalert2.all.min.js"></script>
        <div class="main-content">
            <div class="container-fluid">
                <?= $contents ?>
            </div>
        </div>
        <aside class="right-sidebar">
            <div class="sidebar-chat" data-plugin="chat-sidebar">
                <div class="sidebar-chat-info">
                    <h6>Chat List</h6>
                    <form class="mr-t-10">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Search for friends ...">
                            <i class="ik ik-search"></i>
                        </div>
                    </form>
                </div>

            </div>
        </aside>

        <div class="chat-panel" hidden>
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <a href="javascript:void(0);"><i class="ik ik-message-square text-success"></i></a>
                    <span class="user-name">John Doe</span>
                    <button type="button" class="close" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="card-body">
                    <div class="widget-chat-activity flex-1">
                        <div class="messages">
                            <div class="message media reply">

                                <div class="message-body media-body">
                                    <p>Epic Cheeseburgers come in all kind of styles.</p>
                                </div>
                            </div>
                            <div class="message media">

                                <div class="message-body media-body">
                                    <p>Cheeseburgers make your knees weak.</p>
                                </div>
                            </div>
                            <div class="message media reply">

                                <div class="message-body media-body">
                                    <p>Cheeseburgers will never let you down.</p>
                                    <p>They'll also never run around or desert you.</p>
                                </div>
                            </div>
                            <div class="message media">

                                <div class="message-body media-body">
                                    <p>A great cheeseburger is a gastronomical event.</p>
                                </div>
                            </div>
                            <div class="message media reply">

                                <div class="message-body media-body">
                                    <p>There's a cheesy incarnation waiting for you no matter what you palete preferences are.</p>
                                </div>
                            </div>
                            <div class="message media">

                                <div class="message-body media-body">
                                    <p>If you are a vegan, we are sorry for you loss.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form action="javascript:void(0)" class="card-footer" method="post">
                    <div class="d-flex justify-content-end">
                        <textarea class="border-0 flex-1" rows="1" placeholder="Type your message here"></textarea>
                        <button class="btn btn-icon" type="submit"><i class="ik ik-arrow-right text-success"></i></button>
                    </div>
                </form>
            </div>
        </div>

        <footer class="footer">
            <div class="w-100 clearfix">
                <span class="text-center text-sm-left d-md-inline-block">Copyright © <?= date('Y') ?> <?= $company['company_name'] ?> All Rights Reserved.</span>

            </div>
        </footer>
    </div>
    </div>
    <div class="modal fade apps-modal" id="appsModal" tabindex="-1" role="dialog" aria-labelledby="appsModalLabel" aria-hidden="true" data-backdrop="false">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="ik ik-x-circle"></i></button>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="quick-search">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4 ml-auto mr-auto">
                                <div class="input-wrap">
                                    <input type="text" id="quick-search" class="form-control" placeholder="Search." />
                                    <i class="ik ik-search"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-body d-flex align-items-center">
                    <div class="container">
                        <div class="apps-wrap">
                            <div class="app-item">
                                <a href="#"><i class="ik ik-bar-chart-2"></i><span>Dashboard</span></a>
                            </div>
                            <div class="app-item">
                                <a href="#"><i class="ik ik-mail"></i><span>Message</span></a>
                            </div>
                            <div class="app-item">
                                <a href="#"><i class="ik ik-users"></i><span>Accounts</span></a>
                            </div>
                            <div class="app-item">
                                <a href="#"><i class="ik ik-shopping-cart"></i><span>Sales</span></a>
                            </div>
                            <div class="app-item">
                                <a href="#"><i class="ik ik-briefcase"></i><span>Purchase</span></a>
                            </div>
                            <div class="app-item">
                                <a href="#"><i class="ik ik-server"></i><span>Menus</span></a>
                            </div>
                            <div class="app-item">
                                <a href="#"><i class="ik ik-clipboard"></i><span>Pages</span></a>
                            </div>
                            <div class="app-item">
                                <a href="#"><i class="ik ik-message-square"></i><span>Chats</span></a>
                            </div>
                            <div class="app-item">
                                <a href="#"><i class="ik ik-map-pin"></i><span>Contacts</span></a>
                            </div>
                            <div class="app-item">
                                <a href="#"><i class="ik ik-box"></i><span>Blocks</span></a>
                            </div>
                            <div class="app-item">
                                <a href="#"><i class="ik ik-calendar"></i><span>Events</span></a>
                            </div>
                            <div class="app-item">
                                <a href="#"><i class="ik ik-bell"></i><span>Notifications</span></a>
                            </div>
                            <div class="app-item">
                                <a href="#"><i class="ik ik-pie-chart"></i><span>Reports</span></a>
                            </div>
                            <div class="app-item">
                                <a href="#"><i class="ik ik-layers"></i><span>Tasks</span></a>
                            </div>
                            <div class="app-item">
                                <a href="#"><i class="ik ik-edit"></i><span>Blogs</span></a>
                            </div>
                            <div class="app-item">
                                <a href="#"><i class="ik ik-settings"></i><span>Settings</span></a>
                            </div>
                            <div class="app-item">
                                <a href="#"><i class="ik ik-more-horizontal"></i><span>More</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <nav class="navbar mobile-bottom-nav navbar-expand d-md-none fixed-bottom">
        <ul class="navbar-nav nav-justified w-100 flex-row">
            <li class="nav-item">
                <a href="<?= site_url('member') ?>" class="nav-link <?= $title == 'Dashboard' ? 'active' : '' ?>" title="Beranda">
                    <i class="fas fa-home"></i>
                    <span>Beranda</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= site_url('member/status') ?>" class="nav-link <?= $title == 'Status' ? 'active' : '' ?>" title="Layanan">
                    <i class="fas fa-info-circle"></i>
                    <span>Layanan</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= site_url('member/history') ?>" class="nav-link <?= $title == 'History' ? 'active' : '' ?>" title="Tagihan">
                    <i class="fas fa-credit-card"></i>
                    <span>Tagihan</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= site_url('member/profile') ?>" class="nav-link <?= $title == 'Profile' ? 'active' : '' ?>" title="Profil">
                    <i class="fas fa-user-circle"></i>
                    <span>Profil</span>
                </a>
            </li>
        </ul>
    </nav>

    <script>
        window.jQuery || document.write('<script src="<?= base_url('assets/member/') ?>/src/js/vendor/jquery-3.3.1.min.js"><\/script>')
    </script>
    <!-- Page level plugins -->
    <script src="<?= base_url('assets/backend/') ?>vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url('assets/backend/') ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <!-- Page level custom scripts -->
    <script src="<?= base_url('assets/backend/') ?>js/demo/datatables-demo.js"></script>
    <script src="<?= base_url('assets/member/') ?>plugins/popper.js/dist/umd/popper.min.js"></script>
    <script src="<?= base_url('assets/member/') ?>plugins/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?= base_url('assets/member/') ?>plugins/perfect-scrollbar/dist/perfect-scrollbar.min.js"></script>

    <script src="<?= base_url('assets/member/') ?>dist/js/theme.min.js"></script>
    <script src="<?= base_url('assets/member/') ?>plugins/owl.carousel/dist/owl.carousel.min.js"></script>
    <script src="<?= base_url('assets/member/') ?>js/carousel.js"></script>
    <!-- Google Analytics: change UA-XXXXX-X to be y
    <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
    <script>
        (function(b, o, i, l, e, r) {
            b.GoogleAnalyticsObject = l;
            b[l] || (b[l] =
                function() {
                    (b[l].q = b[l].q || []).push(arguments)
                });
            b[l].l = +new Date;
            e = o.createElement(i);
            r = o.getElementsByTagName(i)[0];
            e.src = 'https://www.google-analytics.com/analytics.js';
            r.parentNode.insertBefore(e, r)
        }(window, document, 'script', 'ga'));
        ga('create', 'UA-XXXXX-X', 'auto');
        ga('send', 'pageview');
    </script>
    <!-- bootstrap datepicker -->
    <script src="<?= base_url('assets/backend') ?>/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script src="<?= base_url('assets/backend/') ?>js/demo/datatables-demo.js"></script>
    <script>
        //Date picker
        $('#tanggal').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
        })
        $('#tanggal2').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
        })
        $('#datepicker').datepicker({
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
                $('#iconDarkMember').removeClass('fa-moon text-secondary').addClass('fa-sun text-warning');
                $('#btnToggleDarkMember').removeClass('btn-outline-secondary').addClass('btn-warning text-dark');
                localStorage.setItem('backend_theme', 'dark');
                document.cookie = "backend_theme=dark; path=/; max-age=31536000";
            } else {
                document.documentElement.classList.remove('dark-mode');
                document.body.classList.remove('dark-mode');
                document.documentElement.style.backgroundColor = '';
                document.body.style.backgroundColor = '';
                $('#iconDarkMember').removeClass('fa-sun text-warning').addClass('fa-moon text-secondary');
                $('#btnToggleDarkMember').removeClass('btn-warning text-dark').addClass('btn-outline-secondary');
                localStorage.setItem('backend_theme', 'light');
                document.cookie = "backend_theme=light; path=/; max-age=31536000";
            }

            if (window.updateHighchartsTheme) {
                window.updateHighchartsTheme(isDark);
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
    </script>
</body>

</html>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
    var Tawk_API = Tawk_API || {},
        Tawk_LoadStart = new Date();
    (function() {
        var s1 = document.createElement("script"),
            s0 = document.getElementsByTagName("script")[0];
        s1.async = true;
        s1.src = '<?= $company['tawk']; ?>';
        s1.charset = 'UTF-8';
        s1.setAttribute('crossorigin', '*');
        s0.parentNode.insertBefore(s1, s0);
    })();
</script>
<!--End of Tawk.to Script-->
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