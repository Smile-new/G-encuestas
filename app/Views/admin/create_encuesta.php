<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Corona Admin - Crear Encuesta</title>
    <link rel="stylesheet" href="<?= base_url(RECURSOS_ADMIN_VENDORS . '/mdi/css/materialdesignicons.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url(RECURSOS_ADMIN_VENDORS . '/css/vendor.bundle.base.css') ?>">
    <link rel="stylesheet" href="<?= base_url(RECURSOS_ADMIN_CSS . '/style.css') ?>">
    
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
    </style>
</head>
<body>
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
                                <img class="img-xs rounded-circle " src="<?= $rutaFotoPerfil ?>" alt="Foto de perfil">
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
        <div class="container-fluid page-body-wrapper">
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
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">Crear Nueva Encuesta</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="<?= base_url('encuestas') ?>">Encuestas</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Crear</li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row">
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Detalles de la Encuesta</h4>
                                    <p class="card-description">Completa la información de la encuesta y añade tus preguntas.</p>

                                    <?php if (session()->getFlashdata('message')): ?>
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <?= session()->getFlashdata('message') ?>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (session()->getFlashdata('error')): ?>
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <?= session()->getFlashdata('error') ?>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (isset($errors) && is_array($errors)): ?>
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <ul>
                                                <?php foreach ($errors as $error): ?>
                                                    <li><?= esc($error) ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    <?php endif; ?>

                                    <form class="forms-sample" action="<?= base_url('encuestas/store') ?>" method="POST">
                                        <?= csrf_field() ?> 
                                        <div class="form-group">
                                            <label for="titulo">Título de la Encuesta <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Ej: Encuesta de satisfacción del cliente" value="<?= old('titulo') ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="descripcion">Descripción</label>
                                            <textarea class="form-control" id="descripcion" name="descripcion" rows="4" placeholder="Breve descripción de la encuesta"><?= old('descripcion') ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="activa">Estado</label>
                                            <select class="form-control" id="activa" name="activa" required>
                                                <option value="1" <?= old('activa') == '1' ? 'selected' : '' ?>>Activa</option>
                                                <option value="0" <?= old('activa') == '0' ? 'selected' : '' ?>>Inactiva</option>
                                            </select>
                                        </div>

                                        <hr class="my-4">
                                        <h4 class="card-title">Preguntas de la Encuesta</h4>
                                        <p class="card-description">Añade al menos una pregunta con al menos dos opciones.</p>

                                        <div id="preguntas-container">
                                            <?php
                                            // Lógica para precargar preguntas y opciones si hubo un error de validación
                                            if (old('preguntas') && is_array(old('preguntas'))) {
                                                foreach (old('preguntas') as $qIndex => $oldQuestion) {
                                                    ?>
                                                    <div class="question-card" data-question-index="<?= $qIndex ?>">
                                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                                            <h5 class="mb-0">Pregunta <span class="question-number"><?= $qIndex + 1 ?></span></h5>
                                                            <button type="button" class="btn btn-danger btn-sm remove-question-btn">Eliminar Pregunta</button>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Texto de la Pregunta <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" name="preguntas[<?= $qIndex ?>][texto_pregunta]" placeholder="Ej: ¿Cuál es su nivel de satisfacción?" value="<?= esc($oldQuestion['texto_pregunta'] ?? '') ?>" required>
                                                            <input type="hidden" name="preguntas[<?= $qIndex ?>][tipo_pregunta]" value="opcion_multiple">
                                                        </div>
                                                        <div class="options-container">
                                                            <h6>Opciones de la Pregunta <span class="text-danger">*</span></h6>
                                                            <?php
                                                            if (isset($oldQuestion['opciones']) && is_array($oldQuestion['opciones'])) {
                                                                foreach ($oldQuestion['opciones'] as $oIndex => $oldOption) {
                                                                    ?>
                                                                    <div class="option-item" data-option-index="<?= $oIndex ?>">
                                                                        <input type="text" class="form-control" name="preguntas[<?= $qIndex ?>][opciones][<?= $oIndex ?>][texto_opcion]" placeholder="Opción <?= $oIndex + 1 ?>" value="<?= esc($oldOption['texto_opcion'] ?? '') ?>" required>
                                                                        <button type="button" class="btn btn-outline-danger btn-sm remove-option-btn delete-btn-sm">Eliminar</button>
                                                                    </div>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                        <button type="button" class="btn btn-info btn-sm add-option-btn mt-2">Añadir Opción</button>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </div>

                                        <button type="button" class="btn btn-success mt-3" id="add-question-btn">Añadir Nueva Pregunta</button>

                                        <div class="mt-4">
                                            <button type="submit" class="btn btn-primary mr-2">Guardar Encuesta</button>
                                            <a href="<?= base_url('encuestas') ?>" class="btn btn-dark">Cancelar</a>
                                        </div>
                                    </form>
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
    </div>

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

    <script src="<?= base_url(RECURSOS_ADMIN_VENDORS . '/js/vendor.bundle.base.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_ADMIN_JS . '/off-canvas.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_ADMIN_JS . '/hoverable-collapse.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_ADMIN_JS . '/misc.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_ADMIN_JS . '/settings.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_ADMIN_JS . '/todolist.js') ?>"></script>
    

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const preguntasContainer = document.getElementById('preguntas-container');
        const addQuestionBtn = document.getElementById('add-question-btn');
        const questionTemplate = document.getElementById('question-template');
        const optionTemplate = document.getElementById('option-template');
        const form = document.querySelector('.forms-sample');

        let questionIndex = 0;

        function updateIndexes() {
            Array.from(preguntasContainer.children).forEach((questionCard, qIdx) => {
                questionCard.dataset.questionIndex = qIdx;
                const questionNumberSpan = questionCard.querySelector('.question-number');
                if (questionNumberSpan) {
                    questionNumberSpan.textContent = qIdx + 1;
                }

                const questionTextInput = questionCard.querySelector('input[name*="[texto_pregunta]"]');
                if (questionTextInput) questionTextInput.name = `preguntas[${qIdx}][texto_pregunta]`;
                const questionTypeInput = questionCard.querySelector('input[name*="[tipo_pregunta]"]');
                if (questionTypeInput) questionTypeInput.name = `preguntas[${qIdx}][tipo_pregunta]`;

                const optionsContainer = questionCard.querySelector('.options-container');
                if (optionsContainer) {
                    Array.from(optionsContainer.querySelectorAll('.option-item')).forEach((optionItem, oIdx) => {
                        optionItem.dataset.optionIndex = oIdx;
                        const optionTextInput = optionItem.querySelector('input[type="text"][name*="[texto_opcion]"]');
                        if (optionTextInput) {
                            optionTextInput.name = `preguntas[${qIdx}][opciones][${oIdx}][texto_opcion]`;
                            if (!optionTextInput.value) {
                                optionTextInput.placeholder = `Opción ${oIdx + 1}`;
                            }
                        }
                    });
                }
            });
            questionIndex = preguntasContainer.children.length;
        }

        function addQuestion() {
            const newQuestionCard = questionTemplate.content.cloneNode(true);
            const questionDiv = newQuestionCard.querySelector('.question-card');

            const tempDiv = document.createElement('div');
            tempDiv.appendChild(questionDiv);
            tempDiv.innerHTML = tempDiv.innerHTML.replace(/idx_q/g, questionIndex);

            const initialOptions = tempDiv.querySelectorAll('.option-item input[name*="[texto_opcion]"]');
            initialOptions.forEach((input, index) => {
                input.placeholder = `Opción ${index + 1}`;
            });

            preguntasContainer.appendChild(tempDiv.firstChild);
            updateIndexes();
        }

        const hasOldData = <?= json_encode(old('preguntas') ? true : false) ?>;
        if (preguntasContainer.children.length === 0 && !hasOldData) {
            addQuestion();
        } else {
            updateIndexes();
        }

        addQuestionBtn.addEventListener('click', function() {
            addQuestion();
        });

        preguntasContainer.addEventListener('click', function(event) {
            if (event.target.classList.contains('remove-question-btn')) {
                const questionCard = event.target.closest('.question-card');
                if (questionCard && preguntasContainer.children.length > 1) {
                    questionCard.remove();
                    updateIndexes();
                } else if (preguntasContainer.children.length <= 1) {
                    console.log('Atención: Debe haber al menos una pregunta en la encuesta.');
                }
            }

            if (event.target.classList.contains('add-option-btn')) {
                const questionCard = event.target.closest('.question-card');
                const optionsContainer = questionCard.querySelector('.options-container');
                const currentQuestionIndex = questionCard.dataset.questionIndex;
                const optionCount = optionsContainer.querySelectorAll('.option-item').length;

                const newOptionItem = optionTemplate.content.cloneNode(true);
                const optionDiv = newOptionItem.querySelector('.option-item');

                const tempDiv = document.createElement('div');
                tempDiv.appendChild(optionDiv);
                let optionHtml = tempDiv.innerHTML
                    .replace(/idx_q/g, currentQuestionIndex)
                    .replace(/idx_o/g, optionCount);

                optionsContainer.insertAdjacentHTML('beforeend', optionHtml);
                updateIndexes();
            }

            if (event.target.classList.contains('remove-option-btn')) {
                const optionItem = event.target.closest('.option-item');
                const optionsContainer = optionItem.closest('.options-container');

                if (optionItem && optionsContainer.querySelectorAll('.option-item').length > 2) {
                    optionItem.remove();
                    updateIndexes();
                } else {
                    console.log('Atención: Cada pregunta debe tener al menos dos opciones.');
                }
            }
        });

        form.addEventListener('submit', function(e) {
            let valid = true;
            const questions = preguntasContainer.children;

            if (questions.length === 0) {
                console.log('Error de validación: La encuesta debe tener al menos una pregunta.');
                valid = false;
            }

            Array.from(questions).forEach(questionCard => {
                const questionText = questionCard.querySelector('input[name*="[texto_pregunta]"]');
                if (!questionText || !questionText.value.trim()) {
                    console.log('Error de validación: Todas las preguntas deben tener texto.');
                    valid = false;
                }

                const optionsContainer = questionCard.querySelector('.options-container');
                const options = optionsContainer ? Array.from(optionsContainer.querySelectorAll('.option-item')) : [];

                if (options.length < 2) {
                    console.log('Error de validación: Cada pregunta debe tener al menos dos opciones.');
                    valid = false;
                }

                options.forEach(optionItem => {
                    const optionText = optionItem.querySelector('input[type="text"][name*="[texto_opcion]"]');
                    if (!optionText || !optionText.value.trim()) {
                        console.log('Error de validación: Todas las opciones deben tener texto.');
                        valid = false;
                    }
                });
            });

            if (!valid) {
                e.preventDefault();
            }
        });
    });
</script>

</body>
</html>
