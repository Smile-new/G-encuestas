<!DOCTYPE html>
<html class="loading" lang="es" data-textdirection="ltr">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <title>Perfil - Vota y Opina</title>
  <link rel="apple-touch-icon" href="<?= base_url(RECURSOS_CONTROLADOR_IMAGES . 'ico/apple-icon-120.png') ?>">
  <link rel="shortcut icon" type="image/x-icon" href="<?= base_url(RECURSOS_CONTROLADOR_IMAGES . 'ico/favicon.ico') ?>">
  <link href="https://fonts.googleapis.com/css?family=Muli:300,400,600,700|Comfortaa:300,400,700" rel="stylesheet">
  <link href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css" rel="stylesheet">

  <link rel="stylesheet" type="text/css" href="<?= base_url(RECURSOS_CONTROLADOR_CSS . 'vendors.css') ?>">
  <link rel="stylesheet" type="text/css" href="<?= base_url(RECURSOS_CONTROLADOR_CSS . 'app-lite.css') ?>">
  <link rel="stylesheet" type="text/css" href="<?= base_url(RECURSOS_CONTROLADOR_CSS . 'core/menu/menu-types/vertical-menu.css') ?>">
  <link rel="stylesheet" type="text/css" href="<?= base_url(RECURSOS_CONTROLADOR_CSS . 'core/colors/palette-gradient.css') ?>">
</head>
<body class="vertical-layout vertical-menu 2-columns menu-expanded fixed-navbar" data-open="click" data-menu="vertical-menu" data-color="bg-chartbg" data-col="2-columns">

<?php
// Preparar datos del usuario (debe pasarse desde el controlador preferiblemente)
$isLoggedIn = session()->get('isLoggedIn') ?? false;
$userData = session()->get('usuario') ?? null;

$nombreCompleto = "Invitado";
$rolTexto = "Rol Desconocido";
$rutaFotoPerfil = base_url('recursos_operador/images/layout_img/user_img.jpg');

if ($isLoggedIn && $userData) {
    $nombreCompleto = $userData['nombre'] . ' ' . $userData['apellido_paterno'] . ' ' . $userData['apellido_materno'];
    $id_rol = $userData['id_rol'] ?? null;
    switch ($id_rol) {
        case 1: $rolTexto = 'Administrador'; break;
        case 2: $rolTexto = 'Operador'; break;
        case 3: $rolTexto = 'Encuestador'; break;
        default: $rolTexto = 'Miembro'; break;
    }
    if (!empty($userData['foto'])) {
        $rutaFotoPerfil = base_url('public/img_user/' . $userData['foto']);
    }
}
?>

<nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-semi-light">
      <div class="navbar-wrapper">
        <div class="navbar-container content">
          <div class="collapse navbar-collapse show" id="navbar-mobile">
            <ul class="nav navbar-nav mr-auto float-left">
              <li class="nav-item d-block d-md-none"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu"></i></a></li>
              <li class="nav-item d-none d-md-block"><a class="nav-link nav-link-expand" href="#"><i class="ficon ft-maximize"></i></a></li>
            </ul>
            <ul class="nav navbar-nav float-right">
              <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown"> <span class="avatar avatar-online"><img src="<?= $rutaFotoPerfil ?>" alt="avatar"><i></i></span></a>
                <div class="dropdown-menu dropdown-menu-right">
                  <div class="arrow_box_right"><a class="dropdown-item" href="#"><span class="avatar avatar-online"><img src="<?= $rutaFotoPerfil ?>" alt="avatar"><span class="user-name text-bold-700 ml-1"><?= esc($nombreCompleto) ?></span></span></a>
                    <div class="dropdown-divider"></div><a class="dropdown-item" href="/controlador/perfil"><i class="ft-user"></i> Editar Perfil</a>
                    <div class="dropdown-divider"></div><a class="dropdown-item" href="/logout"><i class="ft-power"></i> Cerrar Sesión</a>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </nav>

    <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow " data-scroll-to-active="true" data-img="<?= base_url(RECURSOS_CONTROLADOR_IMAGES . 'backgrounds/02.jpg') ?>">
      <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
          <li class="nav-item mr-auto"><a class="navbar-brand" href="<?= base_url('controlador/panel') ?>">
              <h3 class="brand-text">Vota y Opina</h3></a></li>
          <li class="nav-item d-md-none"><a class="nav-link close-navbar"><i class="ft-x"></i></a></li>
        </ul>
      </div>
      <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
          <li class="active"><a href="<?= base_url('controlador/panel') ?>"><i class="la la-home"></i><span class="menu-title">Panel</span></a></li>
          <li class=" nav-item"><a href="<?= base_url('controlador/graficas') ?>"><i class="la la-pie-chart"></i><span class="menu-title">Gráficas</span></a></li>
          <li class=" nav-item"><a href="<?= base_url('controlador/usuarios') ?>"><i class="la la-users"></i><span class="menu-title">Usuarios</span></a></li>
          <li class=" nav-item"><a href="<?= base_url('controlador/encuestas') ?>"><i class="la la-list-alt"></i><span class="menu-title">Encuestas</span></a></li>
          <li class=" nav-item"><a href="<?= base_url('controlador/respuestas') ?>"><i class="la la-check-square"></i><span class="menu-title">Respuestas</span></a></li>
          <li class=" nav-item"><a href="<?= base_url('controlador/perfil') ?>"><i class="la la-user"></i><span class="menu-title">Perfil</span></a></li>
        </ul>
      </div>
      <div class="navigation-background"></div>
    </div>
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-wrapper-before"></div>
        <div class="content-header row">
           <div class="content-header-left col-md-4 col-12 mb-2">
            <h3 class="content-header-title">Mi Perfil</h3>
          </div>
        </div>
        <div class="content-body">

  <!-- Contenido principal -->
 <div class="app-content content" style="margin-left: 20px;">
    <div class="content-wrapper">
      <div class="content-body mt-2">
        <section id="user-profile">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header bg-primary text-white">
                  <h4 class="card-title">Información del Usuario</h4>
                </div>
              <div class="card-body">
  <form action="<?= base_url('controlador/perfil/actualizar') ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <div class="row">
      
      <!-- Imagen de perfil -->
      <div class="col-md-4 text-center">
        <div class="mb-2">
          <?php if(!empty($userData['foto'])): ?>
            <img src="<?= base_url('public/img_user/' . $userData['foto']) ?>" 
                 alt="Foto actual" class="rounded-circle img-thumbnail"  
                 style="width: 150px; height: 150px; object-fit: cover;">
          <?php else: ?>
            <p>No hay foto de perfil actual.</p>
          <?php endif; ?>
        </div>
        <div class="form-group">
          <label for="foto">Cambiar Foto</label>
          <input type="file" name="foto" id="foto" class="form-control">
        </div>
      </div>

      <!-- Datos del usuario -->
      <div class="col-md-8">
        <div class="form-group row">
          <label for="nombre" class="col-sm-4 col-form-label">Nombre:</label>
          <div class="col-sm-8">
            <input type="text" name="nombre" id="nombre" class="form-control" 
                   value="<?= esc($userData['nombre']) ?>" required>
          </div>
        </div>

        <div class="form-group row">
          <label for="apellido_paterno" class="col-sm-4 col-form-label">Apellido Paterno:</label>
          <div class="col-sm-8">
            <input type="text" name="apellido_paterno" id="apellido_paterno" class="form-control" 
                   value="<?= esc($userData['apellido_paterno']) ?>" required>
          </div>
        </div>

        <div class="form-group row">
          <label for="apellido_materno" class="col-sm-4 col-form-label">Apellido Materno:</label>
          <div class="col-sm-8">
            <input type="text" name="apellido_materno" id="apellido_materno" class="form-control" 
                   value="<?= esc($userData['apellido_materno']) ?>">
          </div>
        </div>

        <div class="form-group row">
          <label for="telefono" class="col-sm-4 col-form-label">Teléfono:</label>
          <div class="col-sm-8">
            <input type="tel" name="telefono" id="telefono" class="form-control" 
                   value="<?= esc($userData['telefono']) ?>">
          </div>
        </div>

        <div class="form-group row">
          <label for="usuario" class="col-sm-4 col-form-label">Usuario:</label>
          <div class="col-sm-8">
            <input type="text" name="usuario" id="usuario" class="form-control" 
                   value="<?= esc($userData['usuario']) ?>" required>
          </div>
        </div>

        <div class="text-right mt-2">
          <button type="submit" class="btn btn-success">
            <i class="la la-save"></i> Guardar Cambios
          </button>
        </div>
      </div>

    </div>
  </form>
</div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>

  <footer class="footer footer-static footer-light navbar-border navbar-shadow" style="margin-left: 20px;">
    <div class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2">
      <span class="float-md-left d-block d-md-inline-block"><?= date('Y') ?> &copy; Vota y Opina</span>
    </div>
  </footer>

  <script src="<?= base_url(RECURSOS_CONTROLADOR_VENDORS . 'js/vendors.min.js') ?>"></script>
  <script src="<?= base_url(RECURSOS_CONTROLADOR_JS . 'core/app-menu-lite.js') ?>"></script>
  <script src="<?= base_url(RECURSOS_CONTROLADOR_JS . 'core/app-lite.js') ?>"></script>
</body>
</html>
