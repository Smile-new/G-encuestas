<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge"> 
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Vota y Opina | Mi Perfil</title>

    <link rel="manifest" href="<?= base_url('manifest.json') ?>">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="theme-color" content="#f44336"> 

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
  /* ====== Estilos personalizados para el perfil ====== */
  .perfil-container {
      background: linear-gradient(135deg, #ff5252 0%, #f44336 100%);
      color: #fff;
      padding: 30px;
      border-radius: 20px;
      box-shadow: 0 6px 15px rgba(0,0,0,0.2);
  }

  .perfil-container h2 {
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 1px;
      margin-bottom: 25px;
  }

  .perfil-card {
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      padding: 30px;
  }

  .perfil-card .form-group label {
      font-weight: 600;
      color: #f44336;
  }

  .perfil-card .form-control {
      border-radius: 10px;
      border: 1px solid #ddd;
      transition: all 0.3s ease;
  }

  .perfil-card .form-control:focus {
      border-color: #f44336;
      box-shadow: 0 0 5px rgba(244,67,54,0.4);
  }

  .perfil-card img {
      display: block;
      margin: 0 auto 15px auto;
      border-radius: 50%;
      box-shadow: 0 4px 10px rgba(0,0,0,0.15);
      width: 120px;
      height: 120px;
      object-fit: cover;
  }

  .perfil-card input[type="file"] {
      border: none;
      background: #f9f9f9;
      border-radius: 8px;
      padding: 8px;
  }

  .perfil-card button {
      background: linear-gradient(45deg, #ff7043, #f44336);
      border: none;
      border-radius: 10px;
      color: white;
      font-weight: bold;
      letter-spacing: 0.5px;
      transition: all 0.3s ease;
      width: 100%;
      padding: 12px;
      margin-top: 15px;
  }

  .perfil-card button:hover {
      background: linear-gradient(45deg, #f44336, #d32f2f);
      transform: scale(1.02);
      box-shadow: 0 4px 12px rgba(244,67,54,0.3);
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

        <div class="row clearfix">
            <div class="perfil-container">
  <h2 class="text-center">Mi Perfil</h2>

  <div class="perfil-card">
    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success text-center">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('perfil/actualizar') ?>" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="text-center">
            <img src="<?= !empty($userData['foto']) ? base_url('public/img_user/'.$userData['foto']) : base_url('recursos_encuestador/images/user.png') ?>" alt="Foto de perfil">
        </div>

        <div class="form-group">
            <label>Nombre de Usuario</label>
            <input type="text" name="usuario" value="<?= esc($userData['usuario']) ?>" class="form-control" readonly>
        </div>

        <div class="form-group">
            <label>Nombre(s)</label>
            <input type="text" name="nombre" value="<?= esc($userData['nombre']) ?>" class="form-control">
        </div>

        <div class="form-group">
            <label>Apellido Paterno</label>
            <input type="text" name="apellido_paterno" value="<?= esc($userData['apellido_paterno']) ?>" class="form-control">
        </div>

        <div class="form-group">
            <label>Apellido Materno</label>
            <input type="text" name="apellido_materno" value="<?= esc($userData['apellido_materno']) ?>" class="form-control">
        </div>

        <div class="form-group">
            <label>Teléfono</label>
            <input type="text" name="telefono" value="<?= esc($userData['telefono']) ?>" class="form-control">
        </div>

        <div class="form-group">
            <label>Actualizar Foto de Perfil</label>
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
<script src="https://cdn.jsdelivr.net/npm/dexie@latest/dist/dexie.js"></script>
    <script src="<?= base_url('js/offline_handler.js') ?>"></script>


</body>
</html>
