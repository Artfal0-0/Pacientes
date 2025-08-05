<!DOCTYPE html>
<html lang="en">


<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Participantes</title>

    <!-- favicon -->
    <link rel="icon" type="image/png" href="" sizes="32x32">

    <!-- Fonts and icons -->
    <script src="<?= base_url('public/assets/js/plugin/webfont/webfont.min.js') ?>"></script>
    <script>
        WebFont.load({
            google: {
                families: ["Public Sans:300,400,500,600,700"]
            },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["<?= base_url('public/assets/css/fonts.min.css') ?>"],
            },
            active: function() {
                sessionStorage.fonts = true;
            },
        });
    </script>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.bootstrap5.min.css">

    <!-- DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/your-kit-id.js" crossorigin="anonymous"></script> <!-- Reemplaza con tu ID de Font Awesome -->



    <!-- CSS Files -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="<?= base_url('public/assets/css/bootstrap.min.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('public/assets/css/plugins.min.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('public/assets/css/kaiadmin.min.css') ?>" />
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-5eS8YMo6H3eX5eD8nK0uP8zZ0F4z4nX8g8eMEcE" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous">
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="<?= base_url('public/assets/css/demo.css') ?>" />

    <!-- boton de menu desplegable corregido -->
    <style>
        .btn-toggle-left {
            height: 40px;
            color: white;
            outline: none;
            border: none;
        }

        .btn-toggle-left:focus {
            outline: none;
            box-shadow: none;
        }

        .btn-toggle-left:active {
            outline: none;
            box-shadow: none;
        }

        .btn-toggle-left:hover {
            background: none !important;
            color: white !important;
        }
    </style>

</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar" data-background-color="dark">
            <div class="sidebar-logo">
                <!-- Logo Header -->
                <div class="logo-header" data-background-color="dark">

                    <!-- menu deplegable-->
                    <div class="nav-toggle">
                        <button class="btn btn-toggle-left toggle-sidebar">
                            <i class="gg-menu-right"></i>
                        </button>
                        <button class="btn btn-toggle sidenav-toggler">
                            <i class="gg-menu-left"></i>
                        </button>
                    </div>
                    <div class="d-inline-block">
                        <button class="topbar-toggler more">
                            <i class="gg-more-vertical-alt"></i>
                        </button>
                    </div>
                </div>
                <!-- End Logo Header -->
            </div>
            <div class="sidebar-wrapper scrollbar scrollbar-inner">
                <div class="sidebar-content">
                    <ul class="nav nav-secondary">
                        <li class="nav-item <?= (strpos(uri_string(), 'producto') !== false) ? 'active' : '' ?>">
                            <a href="<?= base_url('/patients') ?>">
                                <i class="fa fa-list"></i>
                                <p>Lista de Participantes</p>
                            </a>
                            <a href="<?= base_url('/statistics') ?>">
                                <i class="bi bi-bar-chart"></i>
                                <p>Estadisticas</p>
                            </a>
                            <a href="<?= base_url('/ia') ?>">
                                <i class="bi bi-chat-left-text"></i>
                                <p>Chat con IA</p>
                            </a>
                        </li>
                    </ul>


                </div>
            </div>
        </div>


        <div class="main-panel">
            <div class="main-header">

                <!-- menu deplegable para vista de celular -->
                <div class="main-header-logo">
                    <!-- Logo Header -->
                    <div class="logo-header" data-background-color="dark">


                    </div>
                    <!-- End Logo Header -->
                </div>
                <!-- Navbar Header -->
                <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
                    <div class="container-fluid">
                        <nav
                            class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex">
                        </nav>


                        <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                            <li class="nav-item topbar-user dropdown hidden-caret">
                                <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#"
                                    aria-expanded="false">
                                    <div class="avatar-sm">
                                        <img src="<?= base_url('public/assets/img/profile.webp') ?>" alt="..."
                                            class="avatar-img rounded-circle" />
                                    </div>
                                    <span class="profile-username">
                                        <span class="op-7">Hola,</span>
                                        <span class="fw-bold"><?= session()->get('user_name') ? session()->get('user_name') : 'Usuario' ?></span>
                                    </span>
                                </a>
                                <ul class="dropdown-menu dropdown-user animated fadeIn">
                                    <div class="dropdown-user-scroll scrollbar-outer">
                                        <li>
                                            <div class="user-box">
                                                <div class="avatar-lg">
                                                    <img src="<?= base_url('public/assets/img/profile.webp') ?>"
                                                        alt="image profile" class="avatar-img rounded" />
                                                </div>
                                                <div class="u-text">
                                                    <h4><?= session()->get('user_name') ? session()->get('user_name') : 'Usuario' ?></h4>
                                                    <p class="text-muted">Administrador</p>
                                                </div>
                                            </div>
                                        </li>

                                    </div>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
            <div class="container">
                <div class="page-inner">