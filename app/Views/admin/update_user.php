<?php
// Obtener la instancia de la sesión al inicio del archivo
$session = session();

// Preparar los datos del usuario para mostrar en la plantilla
$isLoggedIn = $session->get('isLoggedIn');
$userData = $session->get('usuario'); // Obtener todo el array 'usuario' de la sesión

// Definir valores por defecto si el usuario no está logueado o los datos no existen
$nombreCompleto = "Invitado";
$nombreUsuario = "invitado"; // Se usará el campo 'usuario' (username)
$rolTexto = "Rol Desconocido";
$rutaFotoPerfil = base_url(RECURSOS_ADMIN_IMAGES . '/faces/face15.jpg'); // Imagen por defecto de la plantilla

if ($isLoggedIn && is_array($userData)) {
    $nombreCompleto = esc($userData['nombre']) . ' ' .
                      esc($userData['apellido_paterno']) . ' ' .
                      esc($userData['apellido_materno']);
    $nombreUsuario = esc($userData['usuario']); // Usamos el campo 'usuario' del array de sesión
    
    $id_rol = $userData['id_rol'] ?? null; // Usar id_rol para el rol
    switch ($id_rol) {
        case 1: $rolTexto = 'Administrador'; break;
        case 2: $rolTexto = 'Operador'; break;
        case 3: $rolTexto = 'Encuestador'; break;
        default: $rolTexto = 'Miembro'; break;
    }

    // Si hay una foto de usuario cargada en la sesión, usarla; de lo contrario, usar la por defecto
    if (!empty($userData['foto'])) {
        // Asegúrate de que 'public/img_user/' sea la ruta correcta donde guardas las fotos de usuario
        $rutaFotoPerfil = base_url('public/img_user/' . esc($userData['foto']));
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Corona Admin - Editar Usuario</title>
    <!-- CSS de la plantilla Corona Admin -->
    <link rel="stylesheet" href="<?= base_url(RECURSOS_ADMIN_VENDORS . '/mdi/css/materialdesignicons.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url(RECURSOS_ADMIN_VENDORS . '/css/vendor.bundle.base.css') ?>">
    <link rel="stylesheet" href="<?= base_url(RECURSOS_ADMIN_CSS . '/style.css') ?>">
    
    <!-- Aquí puedes agregar CSS adicional específico para esta vista si es necesario -->
</head>
<body>
    <div class="container-scroller">
        <!-- Barra lateral (Sidebar) -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
                <!-- Rutas ajustadas para ser "absolutas" -->
               <a class="sidebar-brand brand-logo" href="<?= base_url('dashboard') ?>"><img src="<?= base_url(RECURSOS_ADMIN_IMAGES . '/logo.png') ?>" alt="logo" /> </a>
            </div>
            <ul class="nav">
                <li class="nav-item profile">
                    <div class="profile-desc">
              <div class="profile-pic">
                <div class="count-indicator">
                  <!-- Foto de perfil dinámica en el sidebar -->
                  <img class="img-xs rounded-circle" src="<?= $rutaFotoPerfil ?>" alt="Foto de perfil">
                  <span class="count bg-success"></span>
                </div>
                <div class="profile-name">
                  <!-- Nombre completo dinámico en el sidebar -->
                  <h5 class="mb-0 font-weight-normal"><?= $nombreCompleto ?></h5>
                  <!-- Rol dinámico en el sidebar -->
                  <span><?= $rolTexto ?></span>
                </div>
              </div>
            </div>
                </li>
                <li class="nav-item nav-category">
                    <span class="nav-link">Navigation</span>
                </li>
                <li class="nav-item menu-items">
                    <!-- Rutas ajustadas para ser "absolutas" -->
                    <a class="nav-link" href="<?= base_url('dashboard') ?>">
                        <span class="menu-icon"><i class="mdi mdi-speedometer"></i></span>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item menu-items">
                    <!-- Rutas ajustadas para ser "absolutas" -->
                    <a class="nav-link" href="<?= base_url('encuestas') ?>">
                        <span class="menu-icon"><i class="mdi mdi-playlist-play"></i></span>
                        <span class="menu-title">Encuestas</span>
                    </a>
                </li>
                <li class="nav-item menu-items">
                    <!-- Rutas ajustadas para ser "absolutas" -->
                    <a class="nav-link" href="<?= base_url('preguntas') ?>">
                        <span class="menu-icon"><i class="mdi mdi-table-large"></i></span>
                        <span class="menu-title">Preguntas</span>
                    </a>
                </li>
                <li class="nav-item menu-items">
                    <!-- Rutas ajustadas para ser "absolutas" -->
                    <a class="nav-link" href="<?= base_url('estadistica') ?>">
                        <span class="menu-icon"><i class="mdi mdi-chart-bar"></i></span>
                        <span class="menu-title">Estadísticas</span>
                    </a>
                </li>
                <li class="nav-item menu-items">
                    <!-- Rutas ajustadas para ser "absolutas" -->
                    <a class="nav-link" href="<?= base_url('usuarios') ?>">
                        <span class="menu-icon"><i class="mdi mdi-contacts"></i></span>
                        <span class="menu-title">Usuarios</span>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- Panel principal (Main Panel) -->
        <div class="main-panel">
            <!-- Barra de navegación superior (Navbar) -->
            <nav class="navbar p-0 fixed-top d-flex flex-row">
                <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
                    <!-- Rutas ajustadas para ser "absolutas" -->
                   <a class="sidebar-brand brand-logo" href="<?= base_url('dashboard') ?>"><img src="<?= base_url(RECURSOS_ADMIN_IMAGES . '/logo.png') ?>" alt="logo" /> </a>
                </div>
                <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
                    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                        <span class="mdi mdi-menu"></span>
                    </button>
                    <ul class="navbar-nav w-100">
                        <li class="nav-item w-100">
                            <!-- Contenido del navbar si lo necesitas, ej. búsqueda -->
                        </li>
                    </ul>
                     <ul class="navbar-nav navbar-nav-right">
              <li class="nav-item dropdown">
                <a class="nav-link" id="profileDropdown" href="#" data-toggle="dropdown">
                  <div class="navbar-profile">
                    <!-- Foto de perfil dinámica en la navbar -->
                    <img class="img-xs rounded-circle" src="<?= $rutaFotoPerfil ?>" alt="Foto de perfil">
                    <!-- Nombre completo dinámico en la navbar (visible en desktop) -->
                    <p class="mb-0 d-none d-sm-block navbar-profile-name"><?= $nombreCompleto ?></p>
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
                  <!-- Enlace de cerrar sesión dinámico -->
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

            <!-- Contenido Principal (Content Wrapper) -->
            <div class="content-wrapper">
                <div class="page-header">
                    <h3 class="page-title"> Editar Usuario </h3>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <!-- Rutas ajustadas para ser "absolutas" -->
                            <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="<?= base_url('usuarios') ?>">Usuarios</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Editar</li>
                        </ol>
                    </nav>
                </div>

                <div class="row">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Formulario de Edición de Usuario: <?= esc($usuario['nombre'] . ' ' . $usuario['apellido_paterno']); ?></h4>
                                <p class="card-description"> Modifica los campos necesarios para actualizar el usuario </p>

                                <?php if (session()->getFlashdata('errors')): ?>
                                    <div class="alert alert-danger mt-3" role="alert">
                                        <ul>
                                            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                                <li><?= esc($error) ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>
                                
                                <!-- FORMULARIO DE ACTUALIZACIÓN -->
                                <form class="forms-sample" action="<?= base_url('usuarios/update/' . $usuario['id_usuario']); ?>" method="post" enctype="multipart/form-data">
                                    <?= csrf_field() ?> <!-- Protección CSRF de CodeIgniter -->

                                    <!-- Campo oculto para el ID del usuario -->
                                    <input type="hidden" name="id_usuario" value="<?= esc($usuario['id_usuario']); ?>">

                                    <div class="form-group">
                                        <label for="nombre">Nombre</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" value="<?= old('nombre', $usuario['nombre']); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="apellido_paterno">Apellido Paterno</label>
                                        <input type="text" class="form-control" id="apellido_paterno" name="apellido_paterno" placeholder="Apellido Paterno" value="<?= old('apellido_paterno', $usuario['apellido_paterno']); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="apellido_materno">Apellido Materno</label>
                                        <input type="text" class="form-control" id="apellido_materno" name="apellido_materno" placeholder="Apellido Materno" value="<?= old('apellido_materno', $usuario['apellido_materno']); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="telefono">Teléfono</label>
                                        <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Ej. 1234567890" value="<?= old('telefono', $usuario['telefono']); ?>" pattern="[0-9]{10}" title="Por favor, ingresa 10 dígitos numéricos">
                                    </div>
                                    <div class="form-group">
                                        <label for="usuario">Usuario (Nombre de Login)</label>
                                        <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Nombre de usuario único" value="<?= old('usuario', $usuario['usuario']); ?>" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="contrasena">Nueva Contraseña (dejar en blanco para mantener la actual)</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="contrasena" name="contrasena" placeholder="Nueva Contraseña">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary btn-inverse-primary" type="button" onclick="generateRandomPassword()">
                                                    <i class="mdi mdi-key-variant"></i> Generar
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="foto">Foto de Perfil Actual</label>
                                        <?php if (!empty($usuario['foto'])): ?>
                                            <div class="mb-2">
                                                <img src="<?= base_url('public/img_user/' . $usuario['foto']); ?>" alt="Foto actual" class="img-fluid rounded" style="max-width: 100px; max-height: 100px; object-fit: cover;">
                                            </div>
                                        <?php else: ?>
                                            <p class="text-muted">No hay foto actual.</p>
                                        <?php endif; ?>
                                        <label for="foto">Subir Nueva Foto (opcional)</label>
                                        <input type="file" name="foto" class="file-upload-default" accept="image/*">
                                        <div class="input-group col-xs-12">
                                            <input type="text" class="form-control file-upload-info" disabled placeholder="Subir Nueva Foto">
                                            <span class="input-group-append">
                                                <button class="file-upload-browse btn btn-primary" type="button">Subir</button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="id_rol">Rol</label>
                                        <select class="form-control" id="id_rol" name="id_rol" required>
                                            <option value="">Selecciona un Rol</option>
                                            <?php if (!empty($roles) && is_array($roles)): ?>
                                                <?php foreach ($roles as $rol): ?>
                                                    <option value="<?= esc($rol['id_rol']) ?>" 
                                                            <?= old('id_rol', $usuario['id_rol']) == $rol['id_rol'] ? 'selected' : '' ?>>
                                                        <?= esc($rol['nombre_rol']) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>

                                    <button type="submit" class="btn btn-primary mr-2">Actualizar Usuario</button>
                                    <!-- CAMBIO: Eliminar 'administrador/' -->
                                    <a href="<?= base_url('usuarios'); ?>" class="btn btn-dark">Cancelar</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Pie de página (Footer) -->
            <footer class="footer">
                <div class="d-sm-flex justify-content-center justify-content-sm-between">
                    <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © 2025 Your Company. All rights reserved.</span>
                </div>
            </footer>
        </div>
    </div>
    <!-- JS de la plantilla Corona Admin -->
    <script src="<?= base_url(RECURSOS_ADMIN_VENDORS . '/js/vendor.bundle.base.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_ADMIN_JS . '/off-canvas.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_ADMIN_JS . '/hoverable-collapse.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_ADMIN_JS . '/misc.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_ADMIN_JS . '/settings.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_ADMIN_JS . '/todolist.js') ?>"></script>
    <!-- JS adicional específico para esta vista -->
    <script>
        function generateRandomPassword() {
            const length = 12; // Longitud deseada de la contraseña
            const charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+~`|}{[]:;?><,./-=";
            let password = "";
            for (let i = 0, n = charset.length; i < length; ++i) {
                password += charset.charAt(Math.floor(Math.random() * n));
            }
            document.getElementById("contrasena").value = password;
        }
    </script>
    <script src="<?= base_url(RECURSOS_ADMIN_JS . '/file-upload.js') ?>"></script>
</body>
</html>