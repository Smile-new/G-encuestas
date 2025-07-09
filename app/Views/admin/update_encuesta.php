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
    <title>Corona Admin - Actualizar Encuesta</title>
    <!-- Tus estilos CSS aquí -->
    <link rel="stylesheet" href="<?= base_url(RECURSOS_ADMIN_VENDORS . '/mdi/css/materialdesignicons.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url(RECURSOS_ADMIN_VENDORS . '/css/vendor.bundle.base.css') ?>">
    <link rel="stylesheet" href="<?= base_url(RECURSOS_ADMIN_CSS . '/style.css') ?>">
    
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        /* Estilos adicionales para mejorar la interfaz */
        .question-card {
            border: 1px solid #333; /* Un borde más oscuro para distinguir las preguntas */
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border-radius: 8px;
            background-color: #2a2a2a; /* Fondo más oscuro para la tarjeta */
        }
        .option-item {
            display: flex;
            align-items: center;
            gap: 10px; /* Espacio entre el input y el botón de eliminar */
            margin-bottom: 10px;
        }
        .option-item input {
            flex-grow: 1; /* Para que el input ocupe el espacio disponible */
        }
        .delete-btn-sm {
            padding: 0.3rem 0.6rem; /* Ajustar padding para botones pequeños */
            font-size: 0.75rem;
        }
        .form-group label {
            font-weight: bold;
        }
        .form-check {
            margin-top: 10px;
            margin-bottom: 20px;
        }
        .form-check-input {
            margin-top: 0.3em;
        }
        .btn-custom-margin {
            margin-right: 10px; /* Espacio entre botones si es necesario */
        }
        .text-danger {
            font-size: 0.875em; /* Tamaño de letra para mensajes de error */
        }
    </style>
</head>
<body>
    <div class="container-scroller">
        <!-- Barra Lateral (Sidebar) -->
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

        <!-- Contenido principal -->
        <div class="main-panel">
            <!-- Navbar Superior -->
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

            <!-- Contenido de la Página -->
            <div class="content-wrapper">
                <div class="page-header">
                    <h3 class="page-title"> Actualizar Encuesta </h3>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="<?= base_url('encuestas') ?>">Encuestas</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Actualizar</li>
                        </ol>
                    </nav>
                </div>

                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Formulario de Actualización de Encuesta</h4>
                                <p class="card-description"> Edita los detalles de la encuesta "<?= esc($encuesta['titulo'] ?? '') ?>". </p>

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

                                <!-- Formulario de Actualización de Encuesta -->
                                <form class="forms-sample" action="<?= base_url('encuestas/update/' . esc($encuesta['id_encuesta'])) ?>" method="post">
                                    <?= csrf_field() ?>
                                    
                                    <div class="form-group">
                                        <label for="titulo">Título de la Encuesta <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="titulo" name="titulo" 
                                               placeholder="Ingresa el título de la encuesta" 
                                               value="<?= old('titulo', esc($encuesta['titulo'] ?? '')) ?>" required>
                                        <?php if (isset($errors) && array_key_exists('titulo', $errors)): ?>
                                            <p class="text-danger mt-1"><?= esc($errors['titulo']) ?></p>
                                        <?php endif; ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="descripcion">Descripción</label>
                                        <textarea class="form-control" id="descripcion" name="descripcion" 
                                                  rows="4" placeholder="Describe brevemente la encuesta"><?= old('descripcion', esc($encuesta['descripcion'] ?? '')) ?></textarea>
                                        <?php if (isset($errors) && array_key_exists('descripcion', $errors)): ?>
                                            <p class="text-danger mt-1"><?= esc($errors['descripcion']) ?></p>
                                        <?php endif; ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="activa">Estado</label>
                                        <select class="form-control" id="activa" name="activa" required>
                                            <option value="1" <?= old('activa', $encuesta['activa'] ?? 0) == '1' ? 'selected' : '' ?>>Activa</option>
                                            <option value="0" <?= old('activa', $encuesta['activa'] ?? 0) == '0' ? 'selected' : '' ?>>Inactiva</option>
                                        </select>
                                        <?php if (isset($errors) && array_key_exists('activa', $errors)): ?>
                                            <p class="text-danger mt-1"><?= esc($errors['activa']) ?></p>
                                        <?php endif; ?>
                                    </div>

                                    <hr class="my-4">
                                    <h4 class="card-title">Preguntas de la Encuesta</h4>
                                    <p class="card-description">Edita las preguntas y opciones existentes, o añade nuevas. Cada pregunta debe tener al menos dos opciones.</p>

                                    <div id="preguntas-container">
                                        <?php
                                        // Variable para los datos antiguos (si hubo un error de validación) o los datos existentes de la encuesta
                                        $displayQuestions = old('preguntas') ? old('preguntas') : ($preguntas ?? []);

                                        if (!empty($displayQuestions)):
                                            foreach ($displayQuestions as $qIndex => $question):
                                                // Ajusta el texto de la pregunta según si viene de old() o de la base de datos
                                                $questionText = isset($question['texto_pregunta']) ? $question['texto_pregunta'] : (isset($question['pregunta']) ? $question['pregunta'] : '');
                                                $questionText = esc($questionText); // Escapar para seguridad XSS

                                                // Asegurarse de que el tipo de pregunta esté presente, por defecto 'opcion_multiple'
                                                $questionType = isset($question['tipo_pregunta']) ? $question['tipo_pregunta'] : 'opcion_multiple';

                                                // Manejar las opciones, si vienen de old() o de la base de datos
                                                $displayOptions = isset($question['opciones']) ? $question['opciones'] : [];
                                                ?>
                                                <div class="question-card" data-question-index="<?= $qIndex ?>">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <h5 class="mb-0">Pregunta <span class="question-number"><?= $qIndex + 1 ?></span></h5>
                                                        <button type="button" class="btn btn-danger btn-sm remove-question-btn">Eliminar Pregunta</button>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Texto de la Pregunta <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="preguntas[<?= $qIndex ?>][texto_pregunta]" 
                                                               placeholder="Ej: ¿Cuál es su nivel de satisfacción?" 
                                                               value="<?= $questionText ?>" required>
                                                        <input type="hidden" name="preguntas[<?= $qIndex ?>][tipo_pregunta]" value="<?= esc($questionType) ?>">
                                                        <?php if (isset($errors) && array_key_exists("preguntas.{$qIndex}.texto_pregunta", $errors)): ?>
                                                            <p class="text-danger mt-1"><?= esc($errors["preguntas.{$qIndex}.texto_pregunta"]) ?></p>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="options-container">
                                                        <h6>Opciones de la Pregunta <span class="text-danger">*</span></h6>
                                                        <?php
                                                        if (!empty($displayOptions)):
                                                            foreach ($displayOptions as $oIndex => $option):
                                                                $optionText = isset($option['texto_opcion']) ? $option['texto_opcion'] : '';
                                                                $optionText = esc($optionText);
                                                                ?>
                                                                <div class="option-item" data-option-index="<?= $oIndex ?>">
                                                                    <input type="text" class="form-control" name="preguntas[<?= $qIndex ?>][opciones][<?= $oIndex ?>][texto_opcion]" 
                                                                           placeholder="Opción <?= $oIndex + 1 ?>" 
                                                                           value="<?= $optionText ?>" required>
                                                                    <button type="button" class="btn btn-outline-danger btn-sm remove-option-btn delete-btn-sm">Eliminar</button>
                                                                    <?php if (isset($errors) && array_key_exists("preguntas.{$qIndex}.opciones.{$oIndex}.texto_opcion", $errors)): ?>
                                                                        <p class="text-danger mt-1"><?= esc($errors["preguntas.{$qIndex}.opciones.{$oIndex}.texto_opcion"]) ?></p>
                                                                    <?php endif; ?>
                                                                </div>
                                                                <?php
                                                            endforeach;
                                                        endif;
                                                        ?>
                                                    </div>
                                                    <button type="button" class="btn btn-info btn-sm add-option-btn mt-2">Añadir Opción</button>
                                                    <?php if (isset($errors) && array_key_exists("preguntas.{$qIndex}.opciones", $errors)): ?>
                                                        <p class="text-danger mt-1"><?= esc($errors["preguntas.{$qIndex}.opciones"]) ?></p>
                                                    <?php endif; ?>
                                                </div>
                                                <?php
                                            endforeach;
                                        else:
                                            // Si no hay preguntas existentes o viejas, añade una por defecto (similar a crear)
                                            ?>
                                            <!-- El JavaScript se encargará de añadir la primera pregunta si no hay ninguna precargada -->
                                        <?php endif; ?>
                                    </div>

                                    <button type="button" class="btn btn-success mt-3" id="add-question-btn">Añadir Nueva Pregunta</button>

                                    <div class="mt-4">
                                        <button type="submit" class="btn btn-primary me-2 btn-custom-margin">Guardar Cambios</button>
                                        <a href="<?= base_url('encuestas') ?>" class="btn btn-dark">Cancelar</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer -->
            <footer class="footer">
                <div class="d-sm-flex justify-content-center justify-content-sm-between">
                    <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © 2025 Your Company. All rights reserved.</span>
                </div>
            </footer>
        </div>
    </div>

    <!-- Plantillas HTML para añadir preguntas y opciones dinámicamente con JavaScript -->
    <template id="question-template">
        <div class="question-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Pregunta <span class="question-number"></span></h5>
                <button type="button" class="btn btn-danger btn-sm remove-question-btn">Eliminar Pregunta</button>
            </div>
            <div class="form-group">
                <label>Texto de la Pregunta <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="preguntas[idx_q][texto_pregunta]" placeholder="Ej: ¿Cuál es su nivel de satisfacción?" required>
                <input type="hidden" name="preguntas[idx_q][tipo_pregunta]" value="opcion_multiple">
            </div>
            <div class="options-container">
                <h6>Opciones de la Pregunta <span class="text-danger">*</span></h6>
                <!-- Las opciones se añadirán aquí inicialmente con dos por defecto -->
                <div class="option-item">
                    <input type="text" class="form-control" name="preguntas[idx_q][opciones][0][texto_opcion]" placeholder="Opción 1" required>
                    <button type="button" class="btn btn-outline-danger btn-sm remove-option-btn delete-btn-sm">Eliminar</button>
                </div>
                <div class="option-item">
                    <input type="text" class="form-control" name="preguntas[idx_q][opciones][1][texto_opcion]" placeholder="Opción 2" required>
                    <button type="button" class="btn btn-outline-danger btn-sm remove-option-btn delete-btn-sm">Eliminar</button>
                </div>
            </div>
            <button type="button" class="btn btn-info btn-sm add-option-btn mt-2">Añadir Opción</button>
        </div>
    </template>

    <template id="option-template">
        <div class="option-item">
            <input type="text" class="form-control" name="preguntas[idx_q][opciones][idx_o][texto_opcion]" placeholder="Opción">
            <button type="button" class="btn btn-outline-danger btn-sm remove-option-btn delete-btn-sm">Eliminar</button>
        </div>
    </template>

    <!-- Scripts JS -->
    <script src="<?= base_url(RECURSOS_ADMIN_VENDORS . '/js/vendor.bundle.base.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_ADMIN_JS . '/off-canvas.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_ADMIN_JS . '/hoverable-collapse.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_ADMIN_JS . '/misc.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_ADMIN_JS . '/settings.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_ADMIN_JS . '/todolist.js') ?>"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
   <script>
document.addEventListener('DOMContentLoaded', () => {
    /* ---------- referencias ---------- */
    const preguntasContainer = document.getElementById('preguntas-container');
    const addQuestionBtn     = document.getElementById('add-question-btn');
    const questionTemplate   = document.getElementById('question-template');
    const optionTemplate     = document.getElementById('option-template');
    const form               = document.querySelector('.forms-sample');

    let questionIndex = preguntasContainer.children.length;   // índice actual

    /* ---------- utilidades ---------- */
    function updateIndexes () {
        Array.from(preguntasContainer.children).forEach((qCard, qIdx) => {
            qCard.dataset.questionIndex = qIdx;

            // encabezado “Pregunta N”
            const number = qCard.querySelector('.question-number');
            if (number) number.textContent = qIdx + 1;

            // inputs de la pregunta
            const qText = qCard.querySelector('input[name*="[texto_pregunta]"]');
            const qType = qCard.querySelector('input[name*="[tipo_pregunta]"]');
            if (qText) qText.name = `preguntas[${qIdx}][texto_pregunta]`;
            if (qType) qType.name = `preguntas[${qIdx}][tipo_pregunta]`;

            // opciones
            const options = Array.from(qCard.querySelectorAll('.options-container .option-item'));
            options.forEach((opt, oIdx) => {
                opt.dataset.optionIndex = oIdx;
                const oText = opt.querySelector('input[name*="[texto_opcion]"]');
                if (oText) {
                    oText.name  = `preguntas[${qIdx}][opciones][${oIdx}][texto_opcion]`;
                    if (!oText.value) oText.placeholder = `Opción ${oIdx + 1}`;
                }
            });
        });

        questionIndex = preguntasContainer.children.length;
    }

    function addQuestion () {
        const clone = questionTemplate.content.cloneNode(true);
        const tmp   = document.createElement('div');
        tmp.appendChild(clone);
        tmp.innerHTML = tmp.innerHTML.replace(/idx_q/g, questionIndex);

        preguntasContainer.appendChild(tmp.firstElementChild);
        updateIndexes();
    }

    /* ---------- carga inicial ---------- */
    const initialCount = <?= json_encode(isset($preguntas) ? count($preguntas ?? []) : 0) ?>;
    const hasOldData   = <?= json_encode((bool) old('preguntas')) ?>;
    if (initialCount === 0 && !hasOldData) {
        addQuestion();
    } else {
        updateIndexes();
    }

    /* ---------- manejadores ---------- */
    addQuestionBtn.addEventListener('click', addQuestion);

    preguntasContainer.addEventListener('click', e => {
        const target = e.target;

        /* eliminar pregunta */
        if (target.classList.contains('remove-question-btn')) {
            const qCard = target.closest('.question-card');
            if (preguntasContainer.children.length > 1) {
                Swal.fire({
                    title: '¿Eliminar pregunta?',
                    text: 'Se eliminará la pregunta y sus opciones.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then(res => {
                    if (res.isConfirmed) {
                        qCard.remove();
                        updateIndexes();
                    }
                });
            } else {
                Swal.fire('Atención', 'Debe haber al menos una pregunta.', 'info');
            }
            return;
        }

        /* añadir opción */
        if (target.classList.contains('add-option-btn')) {
            const qCard            = target.closest('.question-card');
            const optionsContainer = qCard.querySelector('.options-container');
            const qIdx             = qCard.dataset.questionIndex;

            const currentOptions = optionsContainer.querySelectorAll('.option-item').length;
            const clone          = optionTemplate.content.cloneNode(true);
            const tmp            = document.createElement('div');
            tmp.appendChild(clone);
            tmp.innerHTML = tmp.innerHTML
                              .replace(/idx_q/g, qIdx)
                              .replace(/idx_o/g, currentOptions);

            optionsContainer.insertAdjacentHTML('beforeend', tmp.innerHTML);
            updateIndexes();
            return;
        }

        /* eliminar opción */
        if (target.classList.contains('remove-option-btn')) {
            const optionItem       = target.closest('.option-item');
            const optionsContainer = optionItem.closest('.options-container');
            const realOptions      = optionsContainer.querySelectorAll('.option-item').length;

            if (realOptions > 2) {
                optionItem.remove();
                updateIndexes();
            } else {
                Swal.fire('Atención',
                          'Cada pregunta debe tener al menos dos opciones.',
                          'info');
            }
        }
    });

    /* ---------- validación al enviar ---------- */
    form.addEventListener('submit', e => {
        let valid = true;

        if (preguntasContainer.children.length === 0) {
            Swal.fire('Error', 'Debe haber al menos una pregunta.', 'error');
            valid = false;
        }

        Array.from(preguntasContainer.children).forEach(qCard => {
            const qText = qCard.querySelector('input[name*="[texto_pregunta]"]');
            if (!qText.value.trim()) {
                Swal.fire('Error', 'Todas las preguntas deben tener texto.', 'error');
                valid = false;
            }

            const optionInputs = Array.from(
                qCard.querySelectorAll('.options-container .option-item input')
            );

            if (optionInputs.length < 2) {
                Swal.fire('Error',
                          'Cada pregunta debe tener al menos dos opciones.',
                          'error');
                valid = false;
            }

            optionInputs.forEach(inp => {
                if (!inp.value.trim()) {
                    Swal.fire('Error',
                              'Todas las opciones deben tener texto.',
                              'error');
                    valid = false;
                }
            });
        });

        if (!valid) e.preventDefault();
    });
});
</script>


</body>
</html>
