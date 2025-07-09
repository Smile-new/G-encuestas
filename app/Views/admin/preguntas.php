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
    <title>Corona Admin - <?= esc($title ?? 'Gestión de Preguntas por Encuesta') ?></title>
    <!-- Tus estilos CSS y enlaces a recursos aquí (asumiendo que RECURSOS_ADMIN_VENDORS, etc., están definidos) -->
    <link rel="stylesheet" href="<?= base_url(RECURSOS_ADMIN_VENDORS . '/mdi/css/materialdesignicons.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url(RECURSOS_ADMIN_VENDORS . '/css/vendor.bundle.base.css') ?>">
    <link rel="stylesheet" href="<?= base_url(RECURSOS_ADMIN_CSS . '/style.css') ?>">
    
    <!-- Incluye jQuery si no está ya en vendor.bundle.base.js -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* Estilos ajustados para una apariencia más sencilla y compacta */
        .accordion-item {
            margin-bottom: 10px; /* Reducido de 15px */
            border: 1px solid #3a3a3a; /* Un borde ligeramente más suave */
            border-radius: 6px; /* Bordes un poco menos redondeados */
            overflow: hidden;
        }
        .accordion-button {
            background-color:rgb(3, 0, 32) !important;
            color: #fff !important;
            font-weight: bold;
            padding: 0.8rem 1rem; /* Reducido de 1rem 1.25rem */
            border-bottom: 1px solid #444;
            font-size: 0.95rem; /* Fuente ligeramente más pequeña */
        }
        .accordion-button:not(.collapsed) {
            background-color:rgb(3, 0, 32) !important;
            color: #fff !important;
        }
        .accordion-body {
            background-color: #1a1a1a;
            padding: 1rem; /* Reducido de 1.25rem */
            border-top: 1px solid #444;
        }
        .list-group-item {
            background-color: #2a2a2a;
            color: #e0e0e0;
            border: 1px solid #3a3a3a;
            margin-bottom: 3px; /* Reducido de 5px */
            padding: 0.6rem 0.8rem; /* Reducido para opciones más compactas */
            font-size: 0.9rem; /* Fuente más pequeña para opciones */
            border-radius: 4px; /* Ligeramente redondeado */
        }
        /* Estilos para el select */
        #select-encuesta {
            width: 100%;
            padding: 8px 12px; /* Reducido */
            margin-bottom: 15px; /* Reducido */
            border: 1px solid #444;
            border-radius: 4px; /* Reducido */
            background-color: #2a2a2a;
            color: #fff;
            font-size: 0.95rem; /* Ligeramente más pequeño */
        }
        #select-encuesta option {
            background-color:rgb(13, 0, 51));
            color: #fff;
        }
        .card-body {
            padding: 20px; /* Reducido de 30px */
        }
        .card-title {
            font-size: 1.15rem; /* Ligeramente más pequeño */
        }
        .card-description {
            font-size: 0.9rem; /* Ligeramente más pequeño */
            margin-bottom: 15px; /* Ajuste */
        }
    </style>
</head>
<body>
    <div class="container-scroller">
        <!-- Sidebar -->
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

        <!-- Main Panel -->
        <div class="main-panel">
            <nav class="navbar p-0 fixed-top d-flex flex-row">
                <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
                   <a class="sidebar-brand brand-logo" href="<?= base_url('dashboard') ?>"><img src="<?= base_url(RECURSOS_ADMIN_IMAGES . '/logo.png') ?>" alt="logo" /> </a>
                </div>
                <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
                    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                        <span class="mdi mdi-menu"></span>
                    </button>
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

            <!-- Content Wrapper -->
            <div class="content-wrapper">
                <div class="page-header">
                    <h3 class="page-title"><?= esc($title ?? 'Gestión de Preguntas') ?></h3>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="<?= base_url('encuestas') ?>">Encuestas</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Preguntas</li>
                        </ol>
                    </nav>
                </div>

                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Selecciona una Encuesta</h4>
                                <p class="card-description">Elige una encuesta del menú desplegable para ver y gestionar sus preguntas.</p>

                                <div class="form-group">
                                    <label for="select-encuesta">Encuesta:</label>
                                    <select id="select-encuesta" class="form-control">
                                        <option value="">-- Selecciona una Encuesta --</option>
                                        <?php if (!empty($encuestas)): ?>
                                            <?php foreach ($encuestas as $encuesta_item): ?>
                                                <option value="<?= esc($encuesta_item['id_encuesta']) ?>"><?= esc($encuesta_item['titulo']) ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>

                                <div id="preguntas-container" style="margin-top: 20px;"> <!-- Reducido de 30px -->
                                    <!-- Las preguntas y opciones se cargarán aquí dinámicamente -->
                                    <p class="text-muted text-center" id="initial-message">Selecciona una encuesta para ver sus preguntas y opciones.</p>
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
        <!-- Scripts JS -->
        <script src="<?= base_url(RECURSOS_ADMIN_VENDORS . '/js/vendor.bundle.base.js') ?>"></script>
        <!-- ¡Aquí se añade el script de Bootstrap 5 Bundle! -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="<?= base_url(RECURSOS_ADMIN_JS . '/off-canvas.js') ?>"></script>
        <script src="<?= base_url(RECURSOS_ADMIN_JS . '/hoverable-collapse.js') ?>"></script>
        <script src="<?= base_url(RECURSOS_ADMIN_JS . '/misc.js') ?>"></script>
        <script src="<?= base_url(RECURSOS_ADMIN_JS . '/settings.js') ?>"></script>
        <script src="<?= base_url(RECURSOS_ADMIN_JS . '/todolist.js') ?>"></script>
        <script>
            $(document).ready(function() {
                const baseUrl = "<?= base_url(); ?>";

                $('#select-encuesta').change(function() {
                    const idEncuesta = $(this).val();
                    const preguntasContainer = $('#preguntas-container');
                    preguntasContainer.html('<p class="text-muted text-center">Cargando preguntas...</p>');

                    if (idEncuesta === "") {
                        preguntasContainer.html('<p class="text-muted text-center">Selecciona una encuesta para ver sus preguntas y opciones.</p>');
                        return;
                    }

                    // Llamada AJAX para obtener preguntas y opciones de la encuesta seleccionada
                    $.ajax({
                        url: `${baseUrl}/preguntas/getPreguntasConOpcionesPorEncuesta/${idEncuesta}`,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            if (data.length > 0) {
                                let htmlContent = '<div class="accordion" id="accordionPreguntas">';
                                $.each(data, function(index, pregunta) {
                                    // Utiliza `pregunta.id_pregunta` para los IDs de collapse y heading
                                    htmlContent += `
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="heading${pregunta.id_pregunta}">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse${pregunta.id_pregunta}" aria-expanded="false" aria-controls="collapse${pregunta.id_pregunta}">
                                                    Pregunta ${index + 1}: ${pregunta.texto_pregunta}
                                                    <!-- Eliminado: <small class="ms-auto text-muted">(Tipo: ${pregunta.tipo_pregunta})</small> -->
                                                </button>
                                            </h2>
                                            <div id="collapse${pregunta.id_pregunta}" class="accordion-collapse collapse" aria-labelledby="heading${pregunta.id_pregunta}" data-bs-parent="#accordionPreguntas">
                                                <div class="accordion-body">
                                                    `;
                                    if (pregunta.opciones && pregunta.opciones.length > 0) {
                                        htmlContent += `<h6>Opciones:</h6><ul class="list-group">`;
                                        $.each(pregunta.opciones, function(opIndex, opcion) {
                                            htmlContent += `<li class="list-group-item">${opcion.texto_opcion}</li>`;
                                        });
                                        htmlContent += `</ul>`;
                                    } else {
                                        htmlContent += `<p class="text-muted">Esta pregunta no tiene opciones registradas.</p>`;
                                    }
                                    htmlContent += `
                                                </div>
                                            </div>
                                        </div>`;
                                });
                                htmlContent += `</div>`;
                                preguntasContainer.html(htmlContent);
                            } else {
                                preguntasContainer.html('<div class="alert alert-info text-center" role="alert">Esta encuesta no tiene preguntas registradas.</div>');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("Error al cargar preguntas:", status, error, xhr.responseText);
                            preguntasContainer.html('<div class="alert alert-danger text-center" role="alert">Error al cargar las preguntas. Por favor, intente de nuevo.</div>');
                        }
                    });
                });
            });
        </script>
    </body>
</html>
