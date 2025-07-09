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
    <title>Corona Admin - Gestión de Usuarios</title>
    <link rel="stylesheet" href="<?= base_url(RECURSOS_ADMIN_VENDORS . '/mdi/css/materialdesignicons.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url(RECURSOS_ADMIN_VENDORS . '/css/vendor.bundle.base.css') ?>">
    <link rel="stylesheet" href="<?= base_url(RECURSOS_ADMIN_CSS . '/style.css') ?>">
    
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
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
                    <a class="nav-link" href="<?= base_url('dashboard') ?>">
                        <span class="menu-icon"><i class="mdi mdi-speedometer"></i></span>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </li>
                
                <li class="nav-item menu-items">
                    <a class="nav-link" href="<?= base_url('encuestas') ?>">
                        <span class="menu-icon"><i class="mdi mdi-playlist-play"></i></span>
                        <span class="menu-title">Encuestas</span>
                    </a>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="<?= base_url('preguntas') ?>">
                        <span class="menu-icon"><i class="mdi mdi-table-large"></i></span>
                        <span class="menu-title">Preguntas</span>
                    </a>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="<?= base_url('estadistica') ?>">
                        <span class="menu-icon"><i class="mdi mdi-chart-bar"></i></span>
                        <span class="menu-title">Estadisticas</span>
                    </a>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="<?= base_url('usuarios') ?>">
                        <span class="menu-icon"><i class="mdi mdi-contacts"></i></span>
                        <span class="menu-title">Usuarios</span>
                    </a>
                </li>
            </ul>
        </nav>
        <div class="main-panel">
            <nav class="navbar p-0 fixed-top d-flex flex-row">
                <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
                    <a class="sidebar-brand brand-logo" href="<?= base_url('dashboard') ?>"><img src="<?= base_url(RECURSOS_ADMIN_IMAGES . '/logo.png') ?>" alt="logo" /> </a>
                </div>
                <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
                    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                        <span class="mdi mdi-menu"></span>
                    </button>
                    <ul class="navbar-nav w-100">
                        <li class="nav-item w-100">
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

            <div class="content-wrapper">
                <div class="page-header">
                    <h3 class="page-title"> Gestión de Usuarios </h3>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Usuarios</li>
                        </ol>
                    </nav>
                </div>

                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Lista de Usuarios</h4>
                                <p class="card-description"> Aquí puedes gestionar todos los usuarios de tu sistema. </p>

                                <!-- Botón Crear Nuevo Usuario -->
                                <a href="<?= base_url('usuarios/create'); ?>" class="btn btn-primary mb-3">Crear Nuevo Usuario</a>

                                <!-- Mensajes Flashdata con SweetAlert2 -->
                                <?php if (session()->getFlashdata('message')): ?>
                                    <script>
                                        Swal.fire({
                                            icon: 'success',
                                            title: '¡Éxito!',
                                            text: '<?= session()->getFlashdata('message') ?>',
                                            timer: 3000,
                                            showConfirmButton: false
                                        });
                                    </script>
                                <?php endif; ?>
                                <?php if (session()->getFlashdata('error')): ?>
                                    <script>
                                        Swal.fire({
                                            icon: 'error',
                                            title: '¡Error!',
                                            text: '<?= session()->getFlashdata('error') ?>',
                                            timer: 3000,
                                            showConfirmButton: false
                                        });
                                    </script>
                                <?php endif; ?>

                                <!-- FILTRO Y BUSCADOR -->
                                <form action="<?= base_url('usuarios'); ?>" method="get" class="mb-4">
                                    <div class="row">
                                        <div class="col-md-4 mb-2">
                                            <label for="id_rol_filter" class="form-label">Filtrar por Rol:</label>
                                            <select class="form-control" id="id_rol_filter" name="id_rol">
                                                <option value="">Todos los Roles</option>
                                                <?php if (!empty($roles) && is_array($roles)): ?>
                                                    <?php foreach ($roles as $rol): ?>
                                                        <option value="<?= esc($rol['id_rol']) ?>"
                                                                <?= (isset($_GET['id_rol']) && $_GET['id_rol'] == $rol['id_rol']) ? 'selected' : '' ?>>
                                                            <?= esc($rol['nombre_rol']) ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label for="search_term" class="form-label">Buscar por Nombre/Usuario:</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="search_term" name="search_term" 
                                                       placeholder="Buscar por nombre, apellido o usuario" 
                                                       value="<?= esc(isset($_GET['search_term']) ? $_GET['search_term'] : ''); ?>">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" type="submit">Buscar</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 d-flex align-items-end mb-2">
                                            <!-- CAMBIO: btn-secondary a btn-primary -->
                                            <a href="<?= base_url('usuarios'); ?>" class="btn btn-primary w-100">Limpiar Filtros</a>
                                        </div>
                                    </div>
                                </form>
                                <!-- FIN FILTRO Y BUSCADOR -->


                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Foto</th>
                                                <th>Nombre Completo</th>
                                                <th>Rol</th>
                                                <th>Usuario</th>
                                                <th>Teléfono</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($usuarios) && is_array($usuarios)): ?>
                                                <?php foreach ($usuarios as $usuario): ?>
                                                    <tr>
                                                        <td><?= esc($usuario['id_usuario']); ?></td>
                                                        <td>
                                                            <?php if (!empty($usuario['foto'])): ?>
                                                                <img src="<?= base_url('public/img_user/' . $usuario['foto']); ?>" alt="Foto de <?= esc($usuario['nombre']); ?>" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                                                            <?php else: ?>
                                                                <i class="mdi mdi-account-circle" style="font-size: 40px;"></i>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td><?= esc($usuario['nombre']) . ' ' . esc($usuario['apellido_paterno']) . ' ' . esc($usuario['apellido_materno']); ?></td>
                                                        <td>
                                                            <?php
                                                            $rolNombre = 'Desconocido';
                                                            foreach ($roles as $rol) {
                                                                if ($rol['id_rol'] == $usuario['id_rol']) {
                                                                    $rolNombre = esc($rol['nombre_rol']);
                                                                    break;
                                                                }
                                                            }
                                                            echo $rolNombre;
                                                            ?>
                                                        </td>
                                                        <td><?= esc($usuario['usuario']); ?></td>
                                                        <td><?= esc($usuario['telefono']); ?></td>
                                                        <td>
                                                            <a href="<?= base_url('usuarios/edit/' . $usuario['id_usuario']); ?>" class="btn btn-warning btn-sm me-2">Editar</a>

                                                            <form id="deleteForm-<?= esc($usuario['id_usuario']); ?>" action="<?= base_url('usuarios/delete/' . $usuario['id_usuario']); ?>" method="post" class="d-inline">
                                                                <?= csrf_field() ?>
                                                                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(<?= esc($usuario['id_usuario']); ?>, '<?= esc($usuario['nombre'] . ' ' . $usuario['apellido_paterno']); ?>')">Eliminar</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="7" class="text-center">No hay usuarios registrados que coincidan con los filtros.</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="footer">
                <div class="d-sm-flex justify-content-center justify-content-sm-between">
                    <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © 2025 Your Company. All rights reserved.</span>
                </div>
            </footer>
        </div>
    </div>
    <script src="<?= base_url(RECURSOS_ADMIN_VENDORS . '/js/vendor.bundle.base.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_ADMIN_JS . '/off-canvas.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_ADMIN_JS . '/hoverable-collapse.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_ADMIN_JS . '/misc.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_ADMIN_JS . '/settings.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_ADMIN_JS . '/todolist.js') ?>"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(id, nombreUsuario) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Estás a punto de eliminar al usuario " + nombreUsuario + ". ¡Esta acción es irreversible!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, eliminarlo!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm-' + id).submit();
                }
            });
        }
    </script>
</body>
</html>