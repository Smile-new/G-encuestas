<?php
// Obtener la instancia de la sesión al inicio del archivo
$session = session();

// Preparar los datos del usuario para mostrar en la plantilla
$isLoggedIn = $session->get('isLoggedIn');
$userData = $session->get('usuario'); // Obtener todo el array 'usuario' de la sesión

// Definir valores por defecto si el usuario no está logueado o los datos no existen
$nombreCompleto = "Invitado";
$nombreUsuario = "invitado"; // Se usará el campo 'usuario' (username)
$rutaFotoPerfil = base_url(RECURSOS_ENCUESTADOR_IMAGES . '/user.png'); // Imagen por defecto de la plantilla AdminBSB

if ($isLoggedIn && is_array($userData)) {
    $nombreCompleto = esc($userData['nombre']) . ' ' .
                      esc($userData['apellido_paterno']) . ' ' .
                      esc($userData['apellido_materno']);
    $nombreUsuario = esc($userData['usuario']); // Usamos el campo 'usuario' del array de sesión
    
    // Si hay una foto de usuario cargada en la sesión, usarla; de lo contrario, usar la por defecto
    if (!empty($userData['foto'])) {
        $rutaFotoPerfil = base_url('public/img_user/' . esc($userData['foto']));
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Vota y Opina | Changelogs</title> <!-- Título actualizado -->

    <!-- Favicon-->
    <link rel="icon" href="<?= base_url(RECURSOS_ENCUESTADOR_IMAGES . '/favicon.ico') ?>" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="<?= base_url(RECURSOS_ENCUESTADOR_PLUGINS . '/bootstrap/css/bootstrap.css') ?>" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="<?= base_url(RECURSOS_ENCUESTADOR_PLUGINS . '/node-waves/waves.css') ?>" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="<?= base_url(RECURSOS_ENCUESTADOR_PLUGINS . '/animate-css/animate.css') ?>" rel="stylesheet" />

    <!-- Morris Chart Css-->
    <link href="<?= base_url(RECURSOS_ENCUESTADOR_PLUGINS . '/morrisjs/morris.css') ?>" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="<?= base_url(RECURSOS_ENCUESTADOR_CSS . '/style.css') ?>" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="<?= base_url(RECURSOS_ENCUESTADOR_CSS . '/themes/all-themes.css') ?>" rel="stylesheet" />
</head>

<body class="theme-red">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Please wait...</p>
        </div>
    </div>
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Search Bar -->
    <div class="search-bar">
        <div class="search-icon">
            <i class="material-icons">search</i>
        </div>
        <input type="text" placeholder="START TYPING...">
        <div class="close-search">
            <i class="material-icons">close</i>
        </div>
    </div>
    <!-- #END# Search Bar -->
    <!-- Top Bar -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="<?= base_url('home') ?>">VOTA Y OPINA</a> <!-- Título de la marca ajustado -->
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li class="pull-right"><a href="javascript:void(0);" class="js-right-sidebar" data-close="true"><i class="material-icons">more_vert</i></a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info">
                <div class="image">
                    <img src="<?= $rutaFotoPerfil ?>" width="48" height="48" alt="User" />
                </div>
                <div class="info-container">
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $nombreCompleto ?></div>
                    <div class="email"><?= $nombreUsuario ?></div> <!-- Nombre de usuario dinámico -->
                    <div class="btn-group user-helper-dropdown">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="javascript:void(0);"><i class="material-icons">person</i>Profile</a></li>
                            <li role="seperator" class="divider"></li>
                            <!-- Enlace de cerrar sesión dinámico -->
                            <li><a href="<?= base_url('logout') ?>"><i class="material-icons">input</i>Sign Out</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="header">MAIN NAVIGATION</li>
                    <li class="active">
                        <a href="<?= base_url('home') ?>">
                            <i class="material-icons">home</i>
                            <span>Home</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('formularios') ?>">
                            <i class="material-icons">assignment</i>
                            <span>Formularios</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('cam') ?>">
                            <i class="material-icons">camera_alt</i> <!-- Icono sugerido para 'cam' -->
                            <span>Cam</span>
                        </a>
                    </li>
                    <!-- Puedes añadir más elementos de navegación aquí si es necesario -->
                </ul>
            </div>
            <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">
                <div class="copyright">
                    &copy; <?= date('Y') ?> <a href="javascript:void(0);">Vota y Opina</a>. <!-- Año actualizado y nombre de la empresa -->
                </div>
                <div class="version">
                    <b>Version: </b> 1.0.0 <!-- Versión ajustada si es necesario -->
                </div>
            </div>
            <!-- #Footer -->
        </aside>
        <!-- #END# Left Sidebar -->
        <!-- Right Sidebar -->
       
        <!-- #END# Right Sidebar -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>CHANGELOGS</h2>
            </div>
            <!-- Contenido de tus changelogs aquí -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>VERSION 1.0.0 <small>2025-07-01</small></h2>
                        </div>
                        <div class="body">
                            <ul>
                                <li>Implementación inicial del sistema de encuestas.</li>
                                <li>Funcionalidad de login y registro de usuarios.</li>
                                <li>Panel de control para administradores y encuestadores.</li>
                                <li>Gestión básica de encuestas, preguntas y opciones.</li>
                                <li>Módulo de estadísticas con gráficas y tablas.</li>
                            </ul>
                        </div>
                    </div>
                    <div class="card">
                        <div class="header">
                            <h2>VERSION 0.9.0 <small>2025-06-15</small></h2>
                        </div>
                        <div class="body">
                            <ul>
                                <li>Diseño de base de datos para encuestas.</li>
                                <li>Prototipo de interfaz de usuario.</li>
                                <li>Configuración inicial de CodeIgniter.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Contenido de tus changelogs -->
        </div>
    </section>


    <!-- Jquery Core Js -->
    <script src="<?= base_url(RECURSOS_ENCUESTADOR_PLUGINS . '/jquery/jquery.min.js') ?>"></script>

    <!-- Bootstrap Core Js -->
    <script src="<?= base_url(RECURSOS_ENCUESTADOR_PLUGINS . '/bootstrap/js/bootstrap.js') ?>"></script>

    <!-- Select Plugin Js -->
    <script src="<?= base_url(RECURSOS_ENCUESTADOR_PLUGINS . '/bootstrap-select/js/bootstrap-select.js') ?>"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="<?= base_url(RECURSOS_ENCUESTADOR_PLUGINS . '/jquery-slimscroll/jquery.slimscroll.js') ?>"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="<?= base_url(RECURSOS_ENCUESTADOR_PLUGINS . '/node-waves/waves.js') ?>"></script>

    <!-- Jquery CountTo Plugin Js -->
    <script src="<?= base_url(RECURSOS_ENCUESTADOR_PLUGINS . '/jquery-countto/jquery.countTo.js') ?>"></script>

    <!-- Morris Plugin Js -->
    <script src="<?= base_url(RECURSOS_ENCUESTADOR_PLUGINS . '/raphael/raphael.min.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_ENCUESTADOR_PLUGINS . '/morrisjs/morris.js') ?>"></script>

    <!-- ChartJs -->
    <script src="<?= base_url(RECURSOS_ENCUESTADOR_PLUGINS . '/chartjs/Chart.bundle.js') ?>"></script>

    <!-- Flot Charts Plugin Js -->
    <script src="<?= base_url(RECURSOS_ENCUESTADOR_PLUGINS . '/flot-charts/jquery.flot.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_ENCUESTADOR_PLUGINS . '/flot-charts/jquery.flot.resize.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_ENCUESTADOR_PLUGINS . '/flot-charts/jquery.flot.pie.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_ENCUESTADOR_PLUGINS . '/flot-charts/jquery.flot.categories.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_ENCUESTADOR_PLUGINS . '/flot-charts/jquery.flot.time.js') ?>"></script>

    <!-- Sparkline Chart Plugin Js -->
    <script src="<?= base_url(RECURSOS_ENCUESTADOR_PLUGINS . '/jquery-sparkline/jquery.sparkline.js') ?>"></script>

    <!-- Custom Js -->
    <script src="<?= base_url(RECURSOS_ENCUESTADOR_JS . '/admin.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_ENCUESTADOR_JS . '/pages/index.js') ?>"></script>

    <!-- Demo Js -->
    <script src="<?= base_url(RECURSOS_ENCUESTADOR_JS . '/demo.js') ?>"></script>
</body>

</html>
