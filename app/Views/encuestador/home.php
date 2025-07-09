<?php
// Tus constantes se asumen definidas en app/Config/Constants.php
// No es necesario definirlas aquí de nuevo, pero las dejo comentadas como recordatorio:
// if (!defined('RECURSOS_ENCUESTADOR_IMAGES')) define('RECURSOS_ENCUESTADOR_IMAGES', 'recursos_encuestador/images');
// if (!defined('RECURSOS_ENCUESTADOR_PLUGINS')) define('RECURSOS_ENCUESTADOR_PLUGINS', 'recursos_encuestador/plugins');
// if (!defined('RECURSOS_ENCUESTADOR_CSS')) define('RECURSOS_ENCUESTADOR_CSS', 'recursos_encuestador/css');
// ... y otras constantes de recursos

// Obtener la instancia de la sesión al inicio del archivo
$session = session();

// Preparar los datos del usuario para mostrar en la plantilla
$isLoggedIn = $session->get('isLoggedIn');
$userData = $session->get('usuario'); // Obtener todo el array 'usuario' de la sesión

// Definir valores por defecto si el usuario no está logueado o los datos no existen
$nombreCompleto = "Invitado";
$nombreUsuario = "usuario@ejemplo.com"; // CAMBIADO: Ahora se usará el campo 'usuario' de la BD
$rolTexto = "Rol Desconocido";
$rutaFotoPerfil = base_url(RECURSOS_ENCUESTADOR_IMAGES . '/user.png'); // Imagen por defecto de la plantilla AdminBSB

if ($isLoggedIn && is_array($userData)) {
    $nombreCompleto = esc($userData['nombre']) . ' ' .
                      esc($userData['apellido_paterno']) . ' ' .
                      esc($userData['apellido_materno']);
    $nombreUsuario = esc($userData['usuario']); // CAMBIADO: Usamos el campo 'usuario' de la sesión
    
    $id_rol = $userData['id_rol'] ?? null; // Usar id_rol para el rol
    switch ($id_rol) {
        case 1: $rolTexto = 'Administrador'; break;
        case 2: $rolTexto = 'Operador'; break;
        case 3: $rolTexto = 'Encuestador'; break; // Asumiendo que este es el rol 3
        default: $rolTexto = 'Miembro'; break;
    }

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
    <title>Vota y Opina | Panel Encuestador</title>
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
    <!-- #END# Search Bar -->
    <!-- Top Bar -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="<?= base_url('home') ?>">VOTA Y OPINA</a> <!-- Título dinámico -->
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <!-- Puedes añadir elementos de navegación aquí si es necesario -->
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
                    <!-- Foto de perfil dinámica -->
                    <img src="<?= $rutaFotoPerfil ?>" width="48" height="48" alt="User" />
                </div>
                <div class="info-container">
                    <!-- Nombre completo dinámico -->
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $nombreCompleto ?></div>
                    <!-- Nombre de usuario dinámico -->
                    <div class="email"><?= $nombreUsuario ?></div> <!-- CAMBIADO: Muestra el nombre de usuario -->
                    <div class="btn-group user-helper-dropdown">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="javascript:void(0);"><i class="material-icons">person</i>Perfil</a></li>
                            <li role="seperator" class="divider"></li>
                            <!-- Enlace de cerrar sesión dinámico -->
                            <li><a href="<?= base_url('logout') ?>"><i class="material-icons">input</i>Cerrar Sesión</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="header">NAVEGACIÓN PRINCIPAL</li>
                    <li class="active">
                        <a href="<?= base_url('home') ?>">
                            <i class="material-icons">home</i>
                            <span>Inicio</span>
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
                            <span>Cámara</span>
                        </a>
                    </li>
                    <!-- Puedes añadir más elementos de navegación aquí si es necesario -->
                </ul>
            </div>
            <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">
                <div class="copyright">
                    &copy; <?= date('Y') ?> <a href="javascript:void(0);">Vota y Opina</a>.
                </div>
                <div class="version">
                    <b>Version: </b> 1.0.0
                </div>
            </div>
            <!-- #Footer -->
        </aside>
        
    </section>

    <!-- Aquí iría el contenido principal de tu página, que se cargaría dinámicamente -->
    <!-- Por ejemplo, si usas un layout, este sería el lugar donde se renderiza el contenido de las vistas hijas -->
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>DASHBOARD</h2>
            </div>
            <!-- Contenido de tu dashboard aquí -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>Bienvenido, <?= esc($userData['nombre'] ?? 'Usuario') ?>!</h2>
                        </div>
                        <div class="body">
                            <p>Este es tu panel de control como Encuestador. Aquí podrás acceder a los formularios y otras herramientas.</p>
                            <p>Tu rol actual es: <strong><?= $rolTexto ?></strong></p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Contenido de tu dashboard -->
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
