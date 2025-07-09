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
    <title>Corona Admin - Gestión de Encuestas</title>
    <link rel="stylesheet" href="<?= base_url(RECURSOS_ADMIN_VENDORS . '/mdi/css/materialdesignicons.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url(RECURSOS_ADMIN_VENDORS . '/css/vendor.bundle.base.css') ?>">
    <link rel="stylesheet" href="<?= base_url(RECURSOS_ADMIN_CSS . '/style.css') ?>">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <meta name="csrf-token" content="<?= csrf_hash() ?>">
    <meta name="csrf-header" content="<?= csrf_header() ?>">

    <style>
        /* Estilos para el toggle switch si tu tema no los provee bien */
        .form-check.form-switch {
            display: flex;
            align-items: center;
            gap: 8px; /* Espacio entre el switch y el texto */
        }
        .form-check-input {
            cursor: pointer;
            width: 2.5em; /* Ancho del switch */
            height: 1.25em; /* Alto del switch */
        }
        .status-text {
            font-weight: bold;
        }
        .text-success { color: #28a745 !important; }
        .text-danger { color: #dc3545 !important; }
        /* Ajuste para el botón Eliminar */
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            line-height: 1.5;
            border-radius: 0.2rem;
        }

        /* Clase para truncar texto con un ancho máximo, puedes ajustar el valor */
        .truncate-text {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 200px; /* Ajusta este valor según cuánto texto quieres mostrar antes de truncar */
            display: inline-block; /* Necesario para que text-truncate funcione correctamente en td */
        }
        /* Ajuste específico para el título si necesita un max-width diferente o más pequeño */
        .truncate-title {
            max-width: 150px; /* Ajusta este valor según la longitud deseada para el título */
        }

        /* Asegurarte de que el tooltip se inicialice después de que el DOM esté listo */
        /* Se inicializará con JS al final del body */
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
                        <span class="menu-title">Preguntas</span> </a>
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
                    <h3 class="page-title"> Gestión de Encuestas </h3>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Encuestas</li>
                        </ol>
                    </nav>
                </div>

                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Lista de Encuestas</h4>
                                <p class="card-description"> Aquí puedes gestionar todas las encuestas de tu sistema. </p>

                                <a href="<?= base_url('encuestas/create'); ?>" class="btn btn-primary mb-3">Crear Nueva Encuesta</a>

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

                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Título</th>
                                                <th>Descripción</th>
                                                <th>Estado</th>
                                                <th>Fecha Creación</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($encuestas) && is_array($encuestas)): ?>
                                                <?php foreach ($encuestas as $encuesta): ?>
                                                    <tr>
                                                        <td><?= esc($encuesta['id_encuesta']); ?></td>
                                                        <td>
                                                            <span class="truncate-text truncate-title" title="<?= esc($encuesta['titulo']); ?>">
                                                                <?= esc($encuesta['titulo']); ?>
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="truncate-text" title="<?= esc($encuesta['descripcion']); ?>">
                                                                <?= esc($encuesta['descripcion']); ?>
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input toggle-status" type="checkbox" role="switch"
                                                                    id="toggleStatus-<?= esc($encuesta['id_encuesta']); ?>"
                                                                    data-id="<?= esc($encuesta['id_encuesta']); ?>"
                                                                    <?= $encuesta['activa'] ? 'checked' : ''; ?>>
                                                                <label class="form-check-label" for="toggleStatus-<?= esc($encuesta['id_encuesta']); ?>">
                                                                    <span class="status-text <?= $encuesta['activa'] ? 'text-success' : 'text-danger'; ?>">
                                                                        <?= $encuesta['activa'] ? 'Activa' : 'Inactiva'; ?>
                                                                    </span>
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td><?= esc($encuesta['fecha_creacion']); ?></td>
                                                        <td>
                                                            
                                                            <a href="<?= base_url('encuestas/edit/' . $encuesta['id_encuesta']); ?>" class="btn btn-warning btn-sm me-2" title="Editar Encuesta">
                                                                Editar
                                                            </a>
                                                            <form id="deleteForm-<?= esc($encuesta['id_encuesta']); ?>" action="<?= base_url('encuestas/delete/' . $encuesta['id_encuesta']); ?>" method="post" class="d-inline">
                                                                <?= csrf_field() ?>
                                                                <input type="hidden" name="_method" value="DELETE">
                                                                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(<?= esc($encuesta['id_encuesta']); ?>, '<?= esc($encuesta['titulo']); ?>')" title="Eliminar Encuesta">
                                                                    Eliminar
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="6" class="text-center">No hay encuestas registradas.</td>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    // Confirmación al eliminar
    function confirmDelete(id, tituloEncuesta) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: `Estás a punto de eliminar la encuesta "${tituloEncuesta}". Esta acción es irreversible.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, eliminarla',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteForm-' + id).submit();
            }
        });
    }

    // Cambio de estatus con AJAX (GET)
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.toggle-status').forEach(function (switchBtn) {
            switchBtn.addEventListener('change', function () {
                const encuestaId = this.dataset.id;
                const statusLabel = this.closest('.form-check').querySelector('.status-text');
                const originalChecked = this.checked;
                this.disabled = true;

                const url = `<?= base_url('encuestas/estatus'); ?>/${encuestaId}`;

                fetch(url, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        return response.text().then(text => {
                            try {
                                const errorData = JSON.parse(text);
                                throw new Error(errorData.message || 'Error del servidor.');
                            } catch {
                                throw new Error('Error de red o del servidor: ' + text);
                            }
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        if (statusLabel) {
                            statusLabel.textContent = data.textoEstado;
                            statusLabel.classList.toggle('text-success', data.nuevoEstado === 1);
                            statusLabel.classList.toggle('text-danger', data.nuevoEstado === 0);
                        }

                        Swal.fire({
                            icon: 'success',
                            title: '¡Estado actualizado!',
                            text: `La encuesta ahora está ${data.textoEstado.toLowerCase()}.`,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    } else {
                        throw new Error(data.message || 'Error inesperado al actualizar.');
                    }
                })
                .catch(error => {
                    console.error("Error en la solicitud Fetch:", error);
                    this.checked = originalChecked; // Revertir el cambio si falla
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: error.message || 'No se pudo cambiar el estado.',
                        timer: 3000,
                        showConfirmButton: false
                    });
                })
                .finally(() => {
                    this.disabled = false;
                });
            });
        });
    });
</script>


</body>
</html>