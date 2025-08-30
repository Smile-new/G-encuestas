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
    <title>Vota y Opina | Panel Encuestador</title>
    <link rel="icon" href="<?= base_url(RECURSOS_ENCUESTADOR_IMAGES . '/favicon.ico') ?>" type="image/x-icon">

    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <link href="<?= base_url(RECURSOS_ENCUESTADOR_PLUGINS . '/bootstrap/css/bootstrap.css') ?>" rel="stylesheet">

    <link href="<?= base_url(RECURSOS_ENCUESTADOR_PLUGINS . '/node-waves/waves.css') ?>" rel="stylesheet" />

    <link href="<?= base_url(RECURSOS_ENCUESTADOR_PLUGINS . '/animate-css/animate.css') ?>" rel="stylesheet" />

    <link href="<?= base_url(RECURSOS_ENCUESTADOR_PLUGINS . '/morrisjs/morris.css') ?>" rel="stylesheet" />

    <link href="<?= base_url(RECURSOS_ENCUESTADOR_CSS . '/style.css') ?>" rel="stylesheet">

    <link href="<?= base_url(RECURSOS_ENCUESTADOR_CSS . '/themes/all-themes.css') ?>" rel="stylesheet" />
</head>

<body class="theme-red">
    <?php
    // Esta lógica idealmente estaría en el controlador, que pasaría las variables a la vista.
    // Aquí se simula la obtención de datos desde la sesión de CodeIgniter 4.
    $session = session();
    $userData = $session->get('userData'); // Asumiendo que los datos del usuario (array) están en la sesión.

    // Valores por defecto para un invitado
    $nombreCompleto = "Invitado";
    $nombreUsuario = "invitado";
    $rutaFotoPerfil = base_url('recursos_encuestador/images/user.png');
    $rolTexto = 'Rol Desconocido';
    $nombreBienvenida = 'Usuario';

    // Si el usuario ha iniciado sesión, se sobreescriben los valores
    if ($session->get('isLoggedIn') && !empty($userData)) {
        $nombreCompleto = trim(($userData['nombre'] ?? '') . ' ' . ($userData['apellido_paterno'] ?? '') . ' ' . ($userData['apellido_materno'] ?? ''));
        $nombreUsuario = $userData['usuario'] ?? 'invitado';
        $nombreBienvenida = $userData['nombre'] ?? 'Usuario';
        
        if (!empty($userData['foto'])) {
            $rutaFotoPerfil = base_url('public/img_user/' . $userData['foto']);
        }

        // Asumiendo que el nombre del rol también está en los datos de la sesión
        $rolTexto = $userData['nombre_rol'] ?? 'Rol Desconocido';
    }
    ?>

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
    <div class="overlay"></div>
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="<?= site_url('home') ?>">VOTA Y OPINA</a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li class="pull-right"><a href="javascript:void(0);" class="js-right-sidebar" data-close="true"><i class="material-icons">more_vert</i></a></li>
                </ul>
            </div>
        </div>
    </nav>
    <section>
        <aside id="leftsidebar" class="sidebar">
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
            <div class="menu">
                <ul class="list">
                    <li class="header">NAVEGACIÓN PRINCIPAL</li>
                    <li class="active">
                        <a href="<?= site_url('home') ?>">
                            <i class="material-icons">home</i>
                            <span>Inicio</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= site_url('formularios') ?>">
                            <i class="material-icons">assignment</i>
                            <span>Formularios</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= site_url('cam') ?>">
                            <i class="material-icons">camera_alt</i>
                            <span>Cámara</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="legal">
                <div class="copyright">
                    &copy; <?= date('Y') ?> <a href="javascript:void(0);">Vota y Opina</a>.
                </div>
                <div class="version">
                    <b>Version: </b> 1.0.0
                </div>
            </div>
            </aside>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>DASHBOARD</h2>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>Bienvenido, <?= esc($nombreBienvenida) ?>!</h2>
                        </div>
                        <div class="body">
                            <p>Este es tu panel de control como Encuestador. Aquí podrás acceder a los formularios y otras herramientas.</p>
                            <p>Tu rol actual es: <strong><?= esc($rolTexto) ?></strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

     <script src="<?= base_url(RECURSOS_ENCUESTADOR_PLUGINS . '/jquery/jquery.min.js') ?>"></script>

    <script src="<?= base_url(RECURSOS_ENCUESTADOR_PLUGINS . '/bootstrap/js/bootstrap.js') ?>"></script>

    <script src="<?= base_url(RECURSOS_ENCUESTADOR_PLUGINS . '/bootstrap-select/js/bootstrap-select.js') ?>"></script>

    <script src="<?= base_url(RECURSOS_ENCUESTADOR_PLUGINS . '/jquery-slimscroll/jquery.slimscroll.js') ?>"></script>

    <script src="<?= base_url(RECURSOS_ENCUESTADOR_PLUGINS . '/node-waves/waves.js') ?>"></script>

    <script src="<?= base_url(RECURSOS_ENCUESTADOR_PLUGINS . '/jquery-countto/jquery.countTo.js') ?>"></script>

    <script src="<?= base_url(RECURSOS_ENCUESTADOR_PLUGINS . '/raphael/raphael.min.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_ENCUESTADOR_PLUGINS . '/morrisjs/morris.js') ?>"></script>

    <script src="<?= base_url(RECURSOS_ENCUESTADOR_PLUGINS . '/chartjs/Chart.bundle.js') ?>"></script>

    <script src="<?= base_url(RECURSOS_ENCUESTADOR_PLUGINS . '/flot-charts/jquery.flot.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_ENCUESTADOR_PLUGINS . '/flot-charts/jquery.flot.resize.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_ENCUESTADOR_PLUGINS . '/flot-charts/jquery.flot.pie.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_ENCUESTADOR_PLUGINS . '/flot-charts/jquery.flot.categories.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_ENCUESTADOR_PLUGINS . '/flot-charts/jquery.flot.time.js') ?>"></script>

    <script src="<?= base_url(RECURSOS_ENCUESTADOR_PLUGINS . '/jquery-sparkline/jquery.sparkline.js') ?>"></script>

    <script src="<?= base_url(RECURSOS_ENCUESTADOR_JS . '/admin.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_ENCUESTADOR_JS . '/pages/index.js') ?>"></script>

    <script src="<?= base_url(RECURSOS_ENCUESTADOR_JS . '/demo.js') ?>"></script>
</body>

</html>