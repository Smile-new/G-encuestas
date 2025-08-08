<?php
// Obtener la instancia de la sesión al inicio del archivo
$session = session();

// Preparar los datos del usuario para mostrar en la plantilla
$isLoggedIn = $session->get('isLoggedIn');
$userData = $session->get('usuario'); // Obtener todo el array 'usuario' de la sesión

// Definir valores por defecto si el usuario no está logueado o los datos no existen
$nombreCompleto = "Invitado";
$nombreUsuario = "invitado";
$rolTexto = "Rol Desconocido";
$rutaFotoPerfil = base_url(RECURSOS_ADMIN_IMAGES . '/faces/face15.jpg');

if ($isLoggedIn && is_array($userData)) {
    $nombreCompleto = esc($userData['nombre']) . ' ' .
                      esc($userData['apellido_paterno']) . ' ' .
                      esc($userData['apellido_materno']);
    $nombreUsuario = esc($userData['usuario']);
    
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
    <title>Corona Admin - <?= esc($title ?? 'Gestión de Preguntas por Encuesta') ?></title>
    
    <!-- Enlaces a recursos CSS de la plantilla original -->
    <link rel="stylesheet" href="<?= base_url(RECURSOS_ADMIN_VENDORS . '/mdi/css/materialdesignicons.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url(RECURSOS_ADMIN_VENDORS . '/css/vendor.bundle.base.css') ?>">
    <link rel="stylesheet" href="<?= base_url(RECURSOS_ADMIN_CSS . '/style.css') ?>">
    
    <!-- Estilos CSS personalizados para el nuevo diseño -->
    <style>
        /* Estilos generales para el contenedor principal de la página */
        .content-wrapper {
            background-color: #1a1a1a;
            color: #f8f9fa;
        }
        
        /* Estilos para el selector de encuestas */
        #select-encuesta {
            width: 100%;
            padding: 10px 15px;
            margin-bottom: 25px;
            border: 1px solid #495057;
            border-radius: 6px;
            background-color: #343a40;
            color: #e9ecef;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        #select-encuesta:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25);
        }

        #select-encuesta option {
            background-color: #343a40;
            color: #e9ecef;
        }
        
        /* Estilos para las tarjetas de preguntas */
        .card-question {
            border: 1px solid #3a3a3a;
            border-left: 4px solid #007bff;
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }
        
        .card-question:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }
        
        .card-question .card-body {
            background-color: #2a2a2a;
            color: #f8f9fa;
        }

        /* Estilos para la lista de opciones de una pregunta */
        .list-group-flush {
            border-top: 1px solid #3a3a3a;
        }
        
        .list-group-item {
            background-color: transparent !important;
            border: none !important;
            color: #e0e0e0;
            padding: 0.75rem 0;
            font-size: 0.95rem;
        }
        
        .list-group-item:last-child {
            border-bottom: none;
        }

        .list-group-item:before {
            content: "•";
            color: #007bff;
            font-weight: bold;
            display: inline-block;
            width: 1em;
            margin-left: -1em;
        }

        /* Estilos para los botones de acción */
        .btn-outline-info {
            color: #17a2b8;
            border-color: #17a2b8;
        }
        
        .btn-outline-info:hover {
            background-color: #17a2b8;
            color: #fff;
        }
        
        .btn-outline-danger {
            color: #dc3545;
            border-color: #dc3545;
        }
        
        .btn-outline-danger:hover {
            background-color: #dc3545;
            color: #fff;
        }
        
        /* Estilos para el mensaje inicial y el de carga */
        .initial-message-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 200px; /* Altura mínima para el contenedor */
            text-align: center;
            padding: 20px;
        }
        
    </style>
</head>
<body>
    <div class="container-scroller">
        <!-- Sidebar and Navbar as provided by the user -->
        <!-- ... (código de la barra lateral y la barra de navegación) ... -->
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
                  <h5 class="mb-0 font-weight-normal"><?= $nombreCompleto ?></h5>
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
                    <ul class="navbar-nav navbar-nav-right">
              <li class="nav-item dropdown">
                <a class="nav-link" id="profileDropdown" href="#" data-toggle="dropdown">
                  <div class="navbar-profile">
                    <img class="img-xs rounded-circle" src="<?= $rutaFotoPerfil ?>" alt="Foto de perfil">
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

                <!-- Nuevo diseño con layout de dos columnas -->
                <div class="row">
                    <!-- Columna para el selector de encuesta -->
                    <div class="col-lg-4 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">🔍 Selecciona una Encuesta</h4>
                                <p class="card-description">
                                    Elige una encuesta del menú desplegable para ver sus preguntas.
                                </p>
                                <div class="form-group">
                                    <label for="select-encuesta">Encuesta:</label>
                                    <select id="select-encuesta" class="form-control">
                                        <option value="">-- Seleccionar --</option>
                                        <?php if (!empty($encuestas)): ?>
                                            <?php foreach ($encuestas as $encuesta_item): ?>
                                                <option value="<?= esc($encuesta_item['id_encuesta']) ?>">
                                                    <?= esc($encuesta_item['titulo']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Columna para mostrar las preguntas -->
                    <div class="col-lg-8 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">📋 Preguntas de la Encuesta</h4>
                                <p class="card-description" id="questions-description">
                                    Las preguntas y sus opciones se mostrarán a continuación.
                                </p>
                                <div id="preguntas-container" class="initial-message-container">
                                    <p class="text-muted text-center" id="initial-message">
                                        Selecciona una encuesta para ver sus preguntas.
                                    </p>
                                    <i class="mdi mdi-clipboard-text-outline text-muted" style="font-size: 50px;"></i>
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
        
        <!-- Script para la carga dinámica de preguntas -->
        <script>
            $(document).ready(function() {
                const baseUrl = "<?= base_url(); ?>";
                const preguntasContainer = $('#preguntas-container');

                $('#select-encuesta').change(function() {
                    const idEncuesta = $(this).val();

                    // Muestra un indicador de carga al inicio de la petición
                    preguntasContainer.html('<div class="initial-message-container"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Cargando...</span></div><p class="text-muted mt-3">Cargando preguntas...</p></div>');
                    
                    if (idEncuesta === "") {
                        preguntasContainer.html('<div class="initial-message-container"><p class="text-muted" id="initial-message">Selecciona una encuesta para ver sus preguntas.</p><i class="mdi mdi-clipboard-text-outline text-muted" style="font-size: 50px;"></i></div>');
                        return;
                    }

                    // Llamada AJAX para obtener preguntas y opciones de la encuesta seleccionada
                    $.ajax({
                        url: `${baseUrl}/preguntas/getPreguntasConOpcionesPorEncuesta/${idEncuesta}`,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            if (data.length > 0) {
                                let htmlContent = '<div class="d-flex flex-column gap-3 mt-3">';
                                $.each(data, function(index, pregunta) {
                                    // Genera el HTML para cada tarjeta de pregunta
                                    htmlContent += `
                                        <div class="card card-question">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <h5 class="card-title mb-0">
                                                        <span class="badge bg-primary me-2">#${index + 1}</span>
                                                        ${pregunta.texto_pregunta}
                                                    </h5>
                                                    <!-- Eliminado: Botones de acción aquí -->
                                                </div>
                                                <p class="card-subtitle mb-2 text-muted">Tipo de pregunta: <strong>${pregunta.tipo_pregunta}</strong></p>
                                                
                                                ${pregunta.opciones && pregunta.opciones.length > 0 ? `
                                                    <ul class="list-group list-group-flush mt-3">
                                                        ${pregunta.opciones.map(opcion => `<li class="list-group-item">${opcion.texto_opcion}</li>`).join('')}
                                                    </ul>
                                                ` : `
                                                    <div class="alert alert-warning mt-3 mb-0" role="alert">
                                                        Esta pregunta no tiene opciones.
                                                    </div>
                                                `}
                                            </div>
                                        </div>`;
                                });
                                htmlContent += '</div>';
                                preguntasContainer.html(htmlContent);
                            } else {
                                // Muestra un mensaje si no hay preguntas
                                preguntasContainer.html('<div class="initial-message-container"><div class="alert alert-info" role="alert">Esta encuesta no tiene preguntas registradas.</div></div>');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("Error al cargar preguntas:", status, error, xhr.responseText);
                            preguntasContainer.html('<div class="initial-message-container"><div class="alert alert-danger" role="alert">Error al cargar las preguntas. Por favor, intente de nuevo.</div></div>');
                        }
                    });
                });
            });
        </script>
    </body>
</html>
