<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge"> 
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Vota y Opina | Mi Perfil</title>

    <!-- Favicon -->
    <link rel="icon" href="<?= base_url('recursos_encuestador/images/favicon.ico') ?>" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="<?= base_url('recursos_encuestador/plugins/bootstrap/css/bootstrap.css') ?>" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="<?= base_url('recursos_encuestador/plugins/node-waves/waves.css') ?>" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="<?= base_url('recursos_encuestador/plugins/animate-css/animate.css') ?>" rel="stylesheet" />

    <!-- Morris Chart Css-->
    <link href="<?= base_url('recursos_encuestador/plugins/morrisjs/morris.css') ?>" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="<?= base_url('recursos_encuestador/css/style.css') ?>" rel="stylesheet">

    <!-- AdminBSB Themes -->
    <link href="<?= base_url('recursos_encuestador/css/themes/all-themes.css') ?>" rel="stylesheet" />
  <style>
    .logout_sidebar {
    position: absolute;
    bottom: 80px; /* queda justo arriba del bloque .legal */
    width: 100%;
    text-align: center;
}

.logout_sidebar a {
    display: block;
    padding: 12px;
    color: #fff; /* texto blanco */
    background-color: #f44336; /* rojo estilo Material */
    text-decoration: none;
    font-weight: bold;
}

.logout_sidebar a:hover {
    background-color: #d32f2f;
}
  </style>
</head>

<body class="theme-red">

<?php
// Preparar los datos del usuario para mostrar en la plantilla
$session = session();
$userData = $session->get('usuario'); // Suponiendo que guardas toda la info del usuario en la sesión
$nombreCompleto = "Invitado";
$nombreUsuario = "invitado";
$rutaFotoPerfil = base_url('recursos_encuestador/images/user.png');

if ($userData) {
    $nombreCompleto = $userData['nombre'] . ' ' . $userData['apellido_paterno'] . ' ' . $userData['apellido_materno'];
    $nombreUsuario = $userData['usuario'];

    if (!empty($userData['foto'])) {
        $rutaFotoPerfil = base_url('public/img_user/' . $userData['foto']);
    }
}
?>

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

<!-- Top Bar -->
<nav class="navbar">
    <div class="container-fluid">
        <div class="navbar-header">
            <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
            <a href="javascript:void(0);" class="bars"></a>
            <a class="navbar-brand" href="<?= base_url('home') ?>">VOTA Y OPINA</a>
        </div>
    </div>
</nav>

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
                <div class="email"><?= $nombreUsuario ?></div>
                <div class="btn-group user-helper-dropdown">
                    <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                    <ul class="dropdown-menu pull-right">
                        <li><a href="<?= base_url('perfil') ?>"><i class="material-icons">person</i>Profile</a></li>
                        <li role="seperator" class="divider"></li>
                        <li><a href="<?= base_url('logout') ?>"><i class="material-icons">input</i>Sign Out</a></li>
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
            <a href="<?= site_url('perfil') ?>">
                <i class="material-icons">account_circle</i>
                <span>Perfil</span>
            </a>
        </li>
    </ul>
</div>

<!-- Botón fijo abajo -->
<div class="logout_sidebar">
    <a href="<?= site_url('logout') ?>">
        <i class="material-icons">input</i>
        <span>Cerrar Sesión</span>
    </a>
</div>

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
    <!-- #END# Left Sidebar -->
</section>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>MI PERFIL</h2>
        </div>

        <div class="row clearfix">
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2 class="text-center">Información de usuario</h2>
                    </div>
                    <div class="body">
                        <?php if(session()->getFlashdata('success')): ?>
                            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                        <?php endif; ?>

                        <form action="<?= base_url('perfil/actualizar') ?>" method="POST" enctype="multipart/form-data">
                            <?= csrf_field() ?>

                            <div class="form-group">
                                <label>Nombre de Usuario</label>
                                <input type="text" name="usuario" value="<?= esc($userData['usuario']) ?>" class="form-control" readonly>
                            </div>
                          
                          <div class="form-group">
                              <label>Nombre(s)</label>
                              <input type="text" name="nombre" 
                                     value="<?= esc($userData['nombre']) ?>" 
                                     class="form-control" readonly>
                          </div>

                          <div class="form-group">
                              <label>Apellido Paterno</label>
                              <input type="text" name="apellido_paterno" 
                                     value="<?= esc($userData['apellido_paterno']) ?>" 
                                     class="form-control" readonly>
                          </div>

                          <div class="form-group">
                              <label>Apellido Materno</label>
                              <input type="text" name="apellido_materno" 
                                     value="<?= esc($userData['apellido_materno']) ?>" 
                                     class="form-control" readonly>
                          </div>

                          <div class="form-group">
                              <label>Teléfono</label>
                              <input type="text" name="telefono" 
                                     value="<?= esc($userData['telefono']) ?>" 
                                     class="form-control" readonly>
                          </div>


                            <div class="form-group">
                                <label>Foto de Perfil</label><br>
                                <img src="<?= !empty($userData['foto']) ? base_url('public/img_user/'.$userData['foto']) : base_url('recursos_encuestador/images/user.png') ?>" 
                                     alt="Foto actual" width="100" class="mb-2">
                                <input type="file" name="foto" class="form-control">
                            </div>

                           <button type="submit" class="btn bg-orange waves-effect">Actualizar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- Scripts -->
<script src="<?= base_url('recursos_encuestador/plugins/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('recursos_encuestador/plugins/bootstrap/js/bootstrap.js') ?>"></script>
<script src="<?= base_url('recursos_encuestador/plugins/bootstrap-select/js/bootstrap-select.js') ?>"></script>
<script src="<?= base_url('recursos_encuestador/plugins/jquery-slimscroll/jquery.slimscroll.js') ?>"></script>
<script src="<?= base_url('recursos_encuestador/plugins/node-waves/waves.js') ?>"></script>
<script src="<?= base_url('recursos_encuestador/plugins/jquery-countto/jquery.countTo.js') ?>"></script>
<script src="<?= base_url('recursos_encuestador/plugins/raphael/raphael.min.js') ?>"></script>
<script src="<?= base_url('recursos_encuestador/plugins/morrisjs/morris.js') ?>"></script>
<script src="<?= base_url('recursos_encuestador/plugins/chartjs/Chart.bundle.js') ?>"></script>
<script src="<?= base_url('recursos_encuestador/plugins/flot-charts/jquery.flot.js') ?>"></script>
<script src="<?= base_url('recursos_encuestador/plugins/flot-charts/jquery.flot.resize.js') ?>"></script>
<script src="<?= base_url('recursos_encuestador/plugins/flot-charts/jquery.flot.pie.js') ?>"></script>
<script src="<?= base_url('recursos_encuestador/plugins/flot-charts/jquery.flot.categories.js') ?>"></script>
<script src="<?= base_url('recursos_encuestador/plugins/flot-charts/jquery.flot.time.js') ?>"></script>
<script src="<?= base_url('recursos_encuestador/plugins/jquery-sparkline/jquery.sparkline.js') ?>"></script>
<script src="<?= base_url('recursos_encuestador/js/admin.js') ?>"></script>
<script src="<?= base_url('recursos_encuestador/js/pages/index.js') ?>"></script>
<script src="<?= base_url('recursos_encuestador/js/demo.js') ?>"></script>

</body>
</html>
