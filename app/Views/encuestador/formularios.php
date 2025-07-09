<?php
$session = session();
$isLoggedIn = $session->get('isLoggedIn');
$userData = $session->get('usuario');

$nombreCompleto = "Invitado";
$nombreUsuario = "invitado";
$rutaFotoPerfil = base_url(RECURSOS_ENCUESTADOR_IMAGES . '/user.png');

if ($isLoggedIn && is_array($userData)) {
    $nombreCompleto = esc($userData['nombre']) . ' ' .
                      esc($userData['apellido_paterno']) . ' ' .
                      esc($userData['apellido_materno']);
    $nombreUsuario = esc($userData['usuario']);
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
    <title>Vota y Opina | Formularios de Encuestas</title>

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
    <style>
:root {
    --primary-red: #F44336;
    --primary-red-dark: #C62828;
    --primary-red-light: #FFCDD2;
    --primary-accent: #FF3D00; /* Se usa para header y botón */
    --text-dark: #212121;
    --text-medium: #616161;
    --bg-page: #FAFAFA;
    --bg-card: #FFFFFF;
    --border-subtle: #E0E0E0;
    --shadow-subtle: rgba(0, 0, 0, 0.08);
    --shadow-hover: rgba(0, 0, 0, 0.18);
}

body {
    background-color: var(--bg-page);
    font-family: 'Roboto', sans-serif;
}

.survey-card {
    margin-bottom: 25px;
    border: none;
    border-radius: 10px;
    overflow: hidden;
    background-color: var(--bg-card);
    box-shadow: 0 6px 12px var(--shadow-subtle);
    transition: all 0.3s ease-in-out;
}

.survey-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 20px var(--shadow-hover);
}

.survey-card .header {
    background-color: var(--primary-accent);
    color: white;
    padding: 20px 25px;
}

.survey-card .header h2 {
    font-weight: bold;
    font-size: 1.4em;
    margin: 0 0 8px;
    color: white;
}

.survey-card .header .survey-date {
    font-size: 0.9em;
    color: rgba(255, 255, 255, 0.85);
}

.survey-card .body {
    padding: 25px;
    background-color: var(--bg-card);
    color: var(--text-dark);
}

.survey-card .survey-description {
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 1px solid var(--border-subtle);
    font-size: 1em;
    line-height: 1.5;
}

/* Modificación para el botón (ahora un enlace con estilo de botón) */
.survey-card .body .btn {
    background-color: var(--primary-accent) !important;
    color: #fff;
    border: none;
    padding: 14px 28px;
    border-radius: 6px;
    font-weight: bold;
    letter-spacing: 1px;
    text-transform: uppercase;
    transition: 0.3s ease-in-out;
    box-shadow: 0 4px 10px rgba(255, 61, 0, 0.4);
    cursor: pointer; /* Cambiado de not-allowed a pointer */
    text-decoration: none; /* Asegura que no tenga subrayado de enlace */
    display: inline-block; /* Para que padding y width funcionen como en un botón */
    text-align: center; /* Centrar texto si es necesario */
}

.survey-card .body .btn:hover {
    background-color: var(--primary-red-dark) !important;
    transform: translateY(-2px);
}

.no-surveys-message {
    padding: 60px 30px;
    text-align: center;
    background-color: var(--bg-card);
    border: 1px solid var(--border-subtle);
    border-radius: 8px;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.08);
    color: var(--text-medium);
}

.no-surveys-message .material-icons {
    font-size: 80px;
    color: var(--primary-accent);
    opacity: 0.9;
    margin-bottom: 20px;
}

.no-surveys-message h2 {
    color: var(--text-dark);
    font-weight: 700;
    margin-bottom: 15px;
}

.no-surveys-message p {
    font-size: 1.1em;
    color: var(--text-medium);
}

/* RESPONSIVE DESIGN */
@media screen and (max-width: 768px) {
    .survey-card {
        border-radius: 6px;
        margin-bottom: 20px;
    }

    .survey-card .header {
        padding: 15px 20px;
    }

    .survey-card .header h2 {
        font-size: 1.2em;
    }

    .survey-card .body {
        padding: 20px;
    }

    .survey-card .survey-description {
        font-size: 0.95em;
        padding-bottom: 12px;
    }

    .survey-card .body .btn {
        width: 100%;
        padding: 12px 0;
        font-size: 0.95em;
        box-shadow: none;
    }

    .no-surveys-message {
        padding: 40px 20px;
    }

    .no-surveys-message .material-icons {
        font-size: 60px;
    }

    .no-surveys-message h2 {
        font-size: 1.5em;
    }
}

@media screen and (max-width: 480px) {
    .survey-card .header h2 {
        font-size: 1.1em;
    }

    .survey-card .body .btn {
        font-size: 0.9em;
    }

    .no-surveys-message h2 {
        font-size: 1.3em;
    }

    .no-surveys-message p {
        font-size: 1em;
    }
}
</style>

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

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>ENCUESTAS DISPONIBLES</h2>
            </div>

            <div class="row clearfix">
                <div class="col-lg-12">
                    <?php if (empty($encuestas)): ?>
                        <div class="card no-surveys-message">
                            <i class="material-icons">info_outline</i>
                            <h2>No hay encuestas activas disponibles en este momento.</h2>
                            <p>Por favor, revisa más tarde o contacta al administrador.</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($encuestas as $encuesta): ?>
                            <div class="card survey-card">
                                <div class="header">
                                    <h2><?= esc($encuesta['titulo']) ?></h2>
                                    <?php if (isset($encuesta['fecha_creacion'])): ?>
                                        <span class="survey-date">Creada el: <?= date('d/m/Y', strtotime(esc($encuesta['fecha_creacion']))) ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="body">
                                    <p class="survey-description"><?= esc($encuesta['descripcion']) ?></p>
                                    <!-- Botón habilitado y como enlace, usando id_encuesta -->
                                    <a href="<?= base_url('encuestador/verEncuesta/' . esc($encuesta['id_encuesta'])) ?>" class="btn waves-effect m-t-15">Ver Encuesta</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <script src="<?= base_url(RECURSOS_ENCUESTADOR_PLUGINS . '/jquery/jquery.min.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_ENCUESTADOR_PLUGINS . '/bootstrap/js/bootstrap.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_ENCUESTADOR_PLUGINS . '/node-waves/waves.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_ENCUESTADOR_JS . '/admin.js') ?>"></script>
</body>
</html>
