<?php
$session = session();
$isLoggedIn = $session->get('isLoggedIn') ?? false;
$userData = $session->get('usuario') ?? [];

$nombreCompleto = "Invitado";
$rolTexto = "Rol Desconocido";
$rutaFotoPerfil = base_url('recursos_operador/images/layout_img/user_img.jpg');

if ($isLoggedIn && $userData) {
    $nombreCompleto = esc($userData['nombre'] . ' ' . $userData['apellido_paterno'] . ' ' . $userData['apellido_materno']);
    $id_rol = $userData['id_rol'] ?? null;
    switch ($id_rol) {
        case 1: $rolTexto = 'Administrador'; break;
        case 2: $rolTexto = 'Operador'; break;
        case 3: $rolTexto = 'Encuestador'; break;
        default: $rolTexto = 'Miembro'; break;
    }
    if (!empty($userData['foto'])) {
        $rutaFotoPerfil = base_url('public/img_user/' . esc($userData['foto']));
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Vota y Opina - Perfil</title>
    <link rel="stylesheet" href="<?= base_url(RECURSOS_ADMIN_VENDORS . '/mdi/css/materialdesignicons.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url(RECURSOS_ADMIN_VENDORS . '/css/vendor.bundle.base.css') ?>">
    <link rel="stylesheet" href="<?= base_url(RECURSOS_ADMIN_CSS . '/style.css') ?>">
    <style>
        .card { border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .card-body { padding: 1.5rem; }
        .rounded-circle { object-fit: cover; }
        @media (max-width: 767px) { .sidebar { display: none; } }

        .text-usuario {
    color: rgba(0, 0, 0, 1); /* azul */
}

.text-rol {
    color: #000000ff; /* verde */
}


    </style>
</head>
<body>
<div class="container-scroller">
<nav class="sidebar sidebar-offcanvas" id="sidebar">
        <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
          <a class="sidebar-brand brand-logo" href="<?= base_url('dashboard') ?>"><img src="<?= base_url(RECURSOS_ADMIN_IMAGES . '/logo.png') ?>" alt="logo" /> </a>
        </div>
        <ul class="nav">
          <li class="nav-item profile">
            <div class="profile-desc">
              <div class="profile-pic">
                <div class="count-indicator">
                  <img class="img-xs rounded-circle" src="<?= $rutaFotoPerfil ?>" alt="Foto de perfil">
                  <span class="count bg-success"></span>
                </div>
                <div class="profile-name">
                  <h5 class="mb-0 font-weight-normal"><?= esc($nombreCompleto) ?></h5>
                  <span><?= esc($rolTexto) ?></span>
                </div>
              </div>
            </div>
          </li>
          <li class="nav-item nav-category">
            <span class="nav-link">Navigation</span>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="<?= base_url('dashboard') ?>">
              <span class="menu-icon">
                <i class="mdi mdi-speedometer"></i>
              </span>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="<?= base_url('encuestas') ?>">
              <span class="menu-icon">
                <i class="mdi mdi-playlist-play"></i>
              </span>
              <span class="menu-title">Encuestas</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="<?= base_url('preguntas') ?>">
              <span class="menu-icon">
                <i class="mdi mdi-table-large"></i>
              </span>
              <span class="menu-title">Preguntas</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="<?= base_url('estadistica') ?>">
              <span class="menu-icon">
                <i class="mdi mdi-chart-bar"></i>
              </span>
              <span class="menu-title">Estadisticas</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="<?= base_url('usuarios') ?>">
              <span class="menu-icon">
                <i class="mdi mdi-contacts"></i>
              </span>
              <span class="menu-title">Usuarios</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="<?= base_url('admin/perfil') ?>">
              <span class="menu-icon">
                <i class="mdi mdi-account-circle"></i>
              </span>
              <span class="menu-title">Perfil</span>
            </a>
          </li>
        </ul>
      </nav>
      <div class="container-fluid page-body-wrapper">
        <nav class="navbar p-0 fixed-top d-flex flex-row">
          <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
            <a class="navbar-brand brand-logo-mini" href="<?= base_url('dashboard') ?>"><img src="<?= base_url(RECURSOS_ADMIN_IMAGES . '/logo-mini.svg') ?>" alt="logo" /></a>
          </div>
          <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
              <span class="mdi mdi-menu"></span>
            </button>
            
            <ul class="navbar-nav navbar-nav-right">
              <li class="nav-item dropdown">
                <a class="nav-link" id="profileDropdown" href="#" data-toggle="dropdown">
                  <div class="navbar-profile">
                    <img class="img-xs rounded-circle" src="<?= $rutaFotoPerfil ?>" alt="Foto de perfil">
                    <p class="mb-0 d-none d-sm-block navbar-profile-name"><?= esc($nombreCompleto) ?></p>
                    <i class="mdi mdi-menu-down d-none d-sm-block"></i>
                  </div>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="profileDropdown">
                  <h6 class="p-3 mb-0">Perfil</h6>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item" href="<?= base_url('settings') ?>">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-settings text-success"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject mb-1">Configuración</p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item" href="<?= base_url('logout') ?>">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-logout text-danger"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject mb-1">Cerrar Sesión</p>
                    </div>
                  </a>
                </div>
              </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
              <span class="mdi mdi-format-line-spacing"></span>
            </button>
          </div>
        </nav>
<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Editar Perfil</h4>
            <p class="card-description">Actualiza tu información personal</p>

            <?php if(session()->getFlashdata('errors')): ?>
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul>
                  <?php foreach(session()->getFlashdata('errors') as $error): ?>
                    <li><?= $error ?></li>
                  <?php endforeach; ?>
                </ul>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
              </div>
            <?php endif; ?>

            <form class="forms-sample" action="<?= base_url('operador/perfil/update') ?>" method="post" enctype="multipart/form-data">
              <?= csrf_field() ?>

<div class="form-group">
    <label>Usuario</label>
    <input type="text" class="form-control text-usuario" value="<?= esc($userData['usuario'] ?? '') ?>" readonly>
</div>

<div class="form-group">
    <label>Rol</label>
    <input type="text" class="form-control text-rol" value="<?= esc($rolTexto) ?>" readonly>
</div>


              <div class="form-group">
                <label>Nombre</label>
                <input type="text" class="form-control" name="nombre" value="<?= esc($userData['nombre'] ?? '') ?>" required>
              </div>

              <div class="form-group">
                <label>Apellido Paterno</label>
                <input type="text" class="form-control" name="apellido_paterno" value="<?= esc($userData['apellido_paterno'] ?? '') ?>" required>
              </div>

              <div class="form-group">
                <label>Apellido Materno</label>
                <input type="text" class="form-control" name="apellido_materno" value="<?= esc($userData['apellido_materno'] ?? '') ?>">
              </div>

              <div class="form-group">
                <label>Teléfono</label>
                <input type="text" class="form-control" name="telefono" value="<?= esc($userData['telefono'] ?? '') ?>">
              </div>

              <div class="form-group">
                <label>Foto de Perfil Actual</label><br>
                <?php if(!empty($userData['foto'])): ?>
                  <img src="<?= base_url('public/img_user/' . $userData['foto']) ?>" class="img-xs rounded-circle mb-2" alt="Foto de perfil">
                <?php else: ?>
                  <p>No hay foto de perfil.</p>
                <?php endif; ?>
              </div>

              <div class="form-group">
                <label>Cambiar Foto de Perfil</label>
                <input type="file" class="form-control-file" name="foto">
              </div>

              <button type="submit" class="btn btn-primary mr-2">Actualizar</button>
              <a href="<?= base_url('dashboard') ?>" class="btn btn-light">Cancelar</a>
            </form>

          </div>
        </div>
      </div>
    </div>
        <footer class="footer">
        <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-sm-inline-block">Copyright © bootstrapdash.com 2020</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> Free <a href="https://www.bootstrapdash.com/bootstrap-admin-template/" target="_blank">Bootstrap admin templates</a></span>
        </div>
        </footer>
  </div>
</div>
<script src="<?= base_url(RECURSOS_ADMIN_VENDORS . '/js/vendor.bundle.base.js') ?>"></script>
<script src="<?= base_url(RECURSOS_ADMIN_JS . '/off-canvas.js') ?>"></script>
<script src="<?= base_url(RECURSOS_ADMIN_JS . '/hoverable-collapse.js') ?>"></script>
<script src="<?= base_url(RECURSOS_ADMIN_JS . '/misc.js') ?>"></script>
</body>
</html>
