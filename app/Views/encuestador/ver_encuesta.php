<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Vota y Opina | Ver Encuesta</title>

    <link rel="icon" href="<?= base_url(RECURSOS_ENCUESTADOR_IMAGES . '/favicon.ico') ?>" type="image/x-xicon">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <link href="<?= base_url(RECURSOS_ENCUESTADOR_PLUGINS . '/bootstrap/css/bootstrap.css') ?>" rel="stylesheet">
    <link href="<?= base_url(RECURSOS_ENCUESTADOR_PLUGINS . '/node-waves/waves.css') ?>" rel="stylesheet" />
    <link href="<?= base_url(RECURSOS_ENCUESTADOR_PLUGINS . '/animate-css/animate.css') ?>" rel="stylesheet" />
    <link href="<?= base_url(RECURSOS_ENCUESTADOR_CSS . '/style.css') ?>" rel="stylesheet">
    <link href="<?= base_url(RECURSOS_ENCUESTADOR_CSS . '/themes/all-themes.css') ?>" rel="stylesheet" />

    <style>
        :root {
            --primary-red: #F44336;
            --primary-red-dark: #C62828;
            --primary-red-light: #FFCDD2;
            --primary-accent: #FF3D00; /* Se usa para header y botón */
            --text-dark: #212121;
            --text-medium: #616161;
            --bg-page: #FAFAFA;
            --bg-card: #FFFFFF;
            --border-subtle: #E0E0E0;
            --shadow-subtle: rgba(0, 0, 0, 0.08);
            --shadow-hover: rgba(0, 0, 0, 0.18);
        }

        body {
            background-color: var(--bg-page);
            font-family: 'Roboto', sans-serif;
        }

        .survey-detail-card {
            margin-bottom: 25px;
            border: none;
            border-radius: 10px;
            overflow: hidden;
            background-color: var(--bg-card);
            box-shadow: 0 6px 12px var(--shadow-subtle);
        }

        .survey-detail-card .header {
            background-color: var(--primary-red); /* Usar un color principal para el header */
            color: white;
            padding: 20px 25px;
        }

        .survey-detail-card .header h2 {
            font-weight: bold;
            font-size: 1.8em;
            margin: 0 0 8px;
            color: white;
        }

        .survey-detail-card .header .survey-description-header {
            font-size: 1.1em;
            color: rgba(255, 255, 255, 0.9);
            margin-top: 5px;
        }

        .survey-detail-card .body {
            padding: 25px;
            background-color: var(--bg-card);
            color: var(--text-dark);
        }

        .question-block {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border-subtle);
        }

        .question-block:last-child {
            border-bottom: none; /* No border for the last question */
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .question-block h3 {
            font-size: 1.3em;
            font-weight: 600;
            color: var(--text-dark);
            margin-top: 0;
            margin-bottom: 15px;
        }

        .question-block .options-list {
            list-style: none;
            padding-left: 0;
            margin-top: 10px;
        }

        .question-block .options-list li {
            background-color: #f9f9f9;
            border: 1px solid var(--border-subtle);
            border-radius: 5px;
            padding: 10px 15px;
            margin-bottom: 8px;
            font-size: 0.95em;
            color: var(--text-medium);
            display: flex;
            align-items: center;
        }

        .question-block .options-list li .material-icons {
            font-size: 18px;
            margin-right: 8px;
            color: var(--primary-accent);
        }

        /* ESTILOS MEJORADOS PARA EL BOTÓN "VOLVER A FORMULARIOS" */
        .btn-back {
            background-color:rgb(237, 102, 6) !important; /* Fondo naranja */
            color: #fff;
            border: none;
            padding: 14px 28px; /* Un poco más grande */
            border-radius: 8px; /* Más redondeado */
            font-weight: bold;
            letter-spacing: 1px;
            text-transform: uppercase;
            text-decoration: none; /* Elimina la línea */
            transition: all 0.3s ease-in-out; /* Transición más suave */
            box-shadow: 0 6px 12px rgba(69, 1, 242, 0.8); /* Sombra más pronunciada para el negro */
            display: inline-block;
            margin-top: 30px; /* Más espacio superior */
            font-size: 1.05em; /* Ligeramente más grande */
        }
        
        .btn-back:hover {
            background-color:rgba(197, 5, 107, 0.78) !important; /* Fondo morado al pasar el ratón */
            transform: translateY(-3px); /* Efecto de elevación al pasar el ratón */
            box-shadow: 0 8px 16px rgba(128, 0, 128, 0.4); /* Sombra más grande y morada al pasar el ratón */
        }
        
        /* ESTILOS PARA CAMPOS DESHABILITADOS */
        .form-line.disabled select {
            background-color: #f5f5f5; /* Fondo gris para indicar que está deshabilitado */
            cursor: not-allowed;
            border-bottom: 1px dashed #ccc;
        }

        /* CONTENEDOR GENERAL */
        .location-select-container {
            margin-bottom: 25px;
            padding: 20px;
            background-color: var(--bg-card);
            border-radius: 10px;
            box-shadow: 0 3px 6px var(--shadow-subtle);
        }

        .location-select-container h3 {
            font-size: 1.4em;
            font-weight: 700;
            color: var(--primary-red);
            margin-top: 0;
            margin-bottom: 20px;
            border-bottom: 2px solid var(--border-subtle);
            padding-bottom: 10px;
        }

        /* GRUPO DEL FORMULARIO */
        .form-group.form-float {
            margin-bottom: 25px;
        }

        /* LÍNEA FLOTANTE */
        .form-line {
            position: relative;
            padding-top: 20px; /* Espacio para el label */
            padding-bottom: 5px;
        }

        /* SELECT */
        .form-line select {
            width: 100%;
            border: none;
            border-bottom: 1px solid #ddd;
            padding: 8px 0;
            background-color: transparent;
            font-size: 16px;
            outline: none;
            transition: border-color 0.2s ease-in-out;
        }

        /* ESTADO ACTIVO DEL SELECT */
        .form-line select:focus {
            border-bottom-color: var(--primary-red);
        }

        /* LABEL FLOTANTE */
        .form-line label {
            position: absolute;
            left: 0;
            top: 24px;
            font-size: 16px;
            color: #aaa;
            pointer-events: none;
            transition: 0.2s ease all;
        }

        /* CUANDO HAY FOCO O VALOR SELECCIONADO */
        .form-line select:focus ~ label,
        .form-line select:not(:placeholder-shown) ~ label,
        .form-line select:valid ~ label {
            top: 0;
            font-size: 12px;
            color: var(--primary-red);
        }

        /* FEEDBACK INVÁLIDO */
        .form-line .invalid-feedback {
            color: red;
            font-size: 0.85em;
            margin-top: 5px;
        }

        /* Responsive adjustments */
        @media screen and (max-width: 768px) {
            .survey-detail-card .header {
                padding: 15px 20px;
            }
            .survey-detail-card .header h2 {
                font-size: 1.5em;
            }
            .survey-detail-card .header .survey-description-header {
                font-size: 1em;
            }
            .survey-detail-card .body {
                padding: 20px;
            }
            .question-block h3 {
                font-size: 1.2em;
            }
            .question-block .options-list li {
                padding: 8px 12px;
                font-size: 0.9em;
            }
            .btn-back {
                width: 100%;
                padding: 12px 0; /* Ajuste para móviles */
                font-size: 0.95em;
                margin-top: 20px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Sombra más sutil en móviles */
            }
            .location-select-container {
                padding: 15px;
            }
            .location-select-container h3 {
                font-size: 1.2em;
                margin-bottom: 15px;
                padding-bottom: 8px;
            }
            .form-group.form-float {
                margin-bottom: 15px;
            }
        }
    </style>

</head>
<body class="theme-red">
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
    <div class="overlay"></div>
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="<?= base_url('home') ?>">VOTA Y OPINA</a> </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li class="pull-right"><a href="javascript:void(0);" class="js-right-sidebar" data-close="true"><i class="material-icons">more_vert</i></a></li>
                </ul>
            </div>
        </div>
    </nav>
    <section>
        <aside id="leftsidebar" class="sidebar">
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
                            <li><a href="javascript:void(0);"><i class="material-icons">person</i>Perfil</a></li>
                            <li role="seperator" class="divider"></li>
                            <li><a href="<?= base_url('logout') ?>"><i class="material-icons">input</i>Cerrar Sesión</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="menu">
                <ul class="list">
                    <li class="header">NAVEGACIÓN PRINCIPAL</li>
                    <li class="active">
                        <a href="<?= base_url('home') ?>">
                            <i class="material-icons">home</i>
                            <span>Inicio</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('formularios') ?>">
                            <i class="material-icons">assignment</i>
                            <span>Formularios</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('cam') ?>">
                            <i class="material-icons">camera_alt</i> <span>Cámara</span>
                        </a>
                    </li>
                    </ul>
            </div>
            <div class="legal">
                <div class="copyright">
                    &copy; <?= date('Y') ?> <a href="javascript:void(0);">Vota y Opina</a>.
                </div>
                <div class="version">
                    <b>Version: </b> 1.0.0
                </div>
            </div>
            </aside>
        
    </section>

    <section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>DETALLES DE LA ENCUESTA</h2>
        </div>

        <?php if (isset($encuesta) && !empty($encuesta)): ?>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card survey-detail-card">
                        <div class="header">
                            <h2><?= esc($encuesta['titulo']) ?></h2>
                            <p class="survey-description-header"><?= esc($encuesta['descripcion']) ?></p>
                        </div>
                        <div class="body">
                            <form action="<?= base_url('encuestas/guardar') ?>" method="post" id="surveyForm">
                                <input type="hidden" name="id_encuesta" value="<?= esc($encuesta['id_encuesta']) ?>">
                                <input type="hidden" name="id_encuestador" value="<?= esc($id_encuestador) ?>">

                                <div class="location-select-container">
                                    <h3>Datos Geográficos de la Encuesta</h3>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group form-float">
                                                <div class="form-line disabled">
                                                    <select class="form-control show-tick" id="selectEstado" name="id_estado" required disabled>
                                                        <option value="">-- Estado --</option>
                                                        <?php foreach ($comunidades as $comunidad): ?>
                                                            <option value="<?= esc($comunidad['seccion']['municipio']['distrito_local']['distrito_federal']['estado']['id_estado']) ?>">
                                                                <?= esc($comunidad['seccion']['municipio']['distrito_local']['distrito_federal']['estado']['nombre_estado']) ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group form-float">
                                                <div class="form-line disabled">
                                                    <select class="form-control show-tick" id="selectDistritoFederal" name="id_distrito_federal" required disabled>
                                                        <option value="">-- Distrito Federal --</option>
                                                        <?php foreach ($comunidades as $comunidad): ?>
                                                            <option value="<?= esc($comunidad['seccion']['municipio']['distrito_local']['distrito_federal']['id_distrito_federal']) ?>">
                                                                <?= esc($comunidad['seccion']['municipio']['distrito_local']['distrito_federal']['nombre_distrito_federal']) ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group form-float">
                                                <div class="form-line disabled">
                                                    <select class="form-control show-tick" id="selectDistritoLocal" name="id_distrito_local" required disabled>
                                                        <option value="">-- Distrito Local --</option>
                                                        <?php foreach ($comunidades as $comunidad): ?>
                                                            <option value="<?= esc($comunidad['seccion']['municipio']['distrito_local']['id_distrito_local']) ?>">
                                                                <?= esc($comunidad['seccion']['municipio']['distrito_local']['nombre_distrito_local']) ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group form-float">
                                                <div class="form-line disabled">
                                                    <select class="form-control show-tick" id="selectMunicipio" name="id_municipio" required disabled>
                                                        <option value="">-- Municipio --</option>
                                                        <?php foreach ($comunidades as $comunidad): ?>
                                                            <option value="<?= esc($comunidad['seccion']['municipio']['id_municipio']) ?>">
                                                                <?= esc($comunidad['seccion']['municipio']['nombre_municipio']) ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group form-float">
                                                <div class="form-line disabled">
                                                    <select class="form-control show-tick" id="selectSeccion" name="id_seccion" required disabled>
                                                        <option value="">-- Sección --</option>
                                                        <?php foreach ($comunidades as $comunidad): ?>
                                                            <option value="<?= esc($comunidad['seccion']['id_seccion']) ?>">
                                                                <?= esc($comunidad['seccion']['nombre_seccion']) ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <select class="form-control show-tick" id="selectComunidad" name="id_comunidad" required>
                                                        <option value="">-- Seleccione una Comunidad --</option>
                                                        <?php foreach ($comunidades as $comunidad): ?>
                                                            <option 
                                                                value="<?= esc($comunidad['id_comunidad']) ?>"
                                                                data-seccion-id="<?= esc($comunidad['seccion']['id_seccion']) ?>"
                                                                data-municipio-id="<?= esc($comunidad['seccion']['municipio']['id_municipio']) ?>"
                                                                data-distrito-local-id="<?= esc($comunidad['seccion']['municipio']['distrito_local']['id_distrito_local']) ?>"
                                                                data-distrito-federal-id="<?= esc($comunidad['seccion']['municipio']['distrito_local']['distrito_federal']['id_distrito_federal']) ?>"
                                                                data-estado-id="<?= esc($comunidad['seccion']['municipio']['distrito_local']['distrito_federal']['estado']['id_estado']) ?>"
                                                            >
                                                                <?= esc($comunidad['nombre_comunidad']) ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php if (isset($preguntas) && !empty($preguntas)): ?>
                                    <?php foreach ($preguntas as $pregunta): ?>
                                        <div class="question-block">
                                            <h3><?= esc($pregunta['texto_pregunta']) ?></h3>
                                            <?php if (isset($pregunta['opciones']) && !empty($pregunta['opciones'])): ?>
                                                <ul class="options-list">
                                                    <?php foreach ($pregunta['opciones'] as $opcion): ?>
                                                        <li>
                                                            <input type="radio" name="respuesta_<?= esc($pregunta['id_pregunta']) ?>" id="opcion_<?= esc($opcion['id_opcion']) ?>" value="<?= esc($opcion['id_opcion']) ?>" required>
                                                            <label for="opcion_<?= esc($opcion['id_opcion']) ?>"><?= esc($opcion['texto_opcion']) ?></label>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            <?php else: ?>
                                                <p>No hay opciones para esta pregunta.</p>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p>Esta encuesta no tiene preguntas definidas.</p>
                                <?php endif; ?>

                                <a href="<?= base_url('formularios') ?>" class="btn-back waves-effect">Volver a Formularios</a>
                                <button type="submit" class="btn-back waves-effect">Enviar Respuestas</button>
                            </form>
                            </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="card no-surveys-message">
                <i class="material-icons">sentiment_dissatisfied</i>
                <h2>Encuesta no encontrada o no disponible.</h2>
                <p>Es posible que la encuesta haya sido eliminada o que el enlace sea incorrecto.</p>
                <a href="<?= base_url('formularios') ?>" class="btn-back waves-effect">Volver a Formularios</a>
                <a href="<?= base_url('formularios') ?>" class="btn-back waves-effect">Enviar Respuetas</a>
            </div>
        <?php endif; ?>
    </div>
</section>

<script src="<?= base_url(RECURSOS_ENCUESTADOR_PLUGINS . '/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url(RECURSOS_ENCUESTADOR_PLUGINS . '/bootstrap/js/bootstrap.js') ?>"></script>
<script src="<?= base_url(RECURSOS_ENCUESTADOR_PLUGINS . '/node-waves/waves.js') ?>"></script>
<script src="<?= base_url(RECURSOS_ENCUESTADOR_JS . '/admin.js') ?>"></script>

<script>
    $(function () {
        // Obtenemos los selectores
        const $selectComunidad = $('#selectComunidad');
        const $selectSeccion = $('#selectSeccion');
        const $selectMunicipio = $('#selectMunicipio');
        const $selectDistritoLocal = $('#selectDistritoLocal');
        const $selectDistritoFederal = $('#selectDistritoFederal');
        const $selectEstado = $('#selectEstado');
        const allSelects = [$selectEstado, $selectDistritoFederal, $selectDistritoLocal, $selectMunicipio, $selectSeccion];

        // Función para manejar el "flotado" del label
        function floatLabel($select) {
            const formLine = $select.closest('.form-line');
            if ($select.val() && $select.val() !== '') {
                formLine.find('label').addClass('active').css({ top: '0px', fontSize: '12px' });
            } else {
                formLine.find('label').removeClass('active').css({ top: '24px', fontSize: '16px' });
            }
            if ($.fn.selectpicker) {
                $select.selectpicker('refresh');
            }
        }

        // Llenar los selectores de nivel superior con los datos disponibles (sin duplicados)
        // Usamos un Set para evitar opciones repetidas
        function populateAllSelects() {
            const dataComunidades = <?= json_encode($comunidades) ?>;

            const estadosSet = new Set();
            const dfSet = new Set();
            const dlSet = new Set();
            const municipioSet = new Set();
            const seccionSet = new Set();

            dataComunidades.forEach(comunidad => {
                if (comunidad.seccion && comunidad.seccion.municipio && comunidad.seccion.municipio.distrito_local && comunidad.seccion.municipio.distrito_local.distrito_federal && comunidad.seccion.municipio.distrito_local.distrito_federal.estado) {
                    estadosSet.add(JSON.stringify(comunidad.seccion.municipio.distrito_local.distrito_federal.estado));
                    dfSet.add(JSON.stringify(comunidad.seccion.municipio.distrito_local.distrito_federal));
                    dlSet.add(JSON.stringify(comunidad.seccion.municipio.distrito_local));
                    municipioSet.add(JSON.stringify(comunidad.seccion.municipio));
                    seccionSet.add(JSON.stringify(comunidad.seccion));
                }
            });

            const estados = Array.from(estadosSet).map(item => JSON.parse(item));
            const dfs = Array.from(dfSet).map(item => JSON.parse(item));
            const dls = Array.from(dlSet).map(item => JSON.parse(item));
            const municipios = Array.from(municipioSet).map(item => JSON.parse(item));
            const secciones = Array.from(seccionSet).map(item => JSON.parse(item));
            
            // Llenar selectores con los datos únicos
            $selectEstado.empty().append('<option value="">-- Estado --</option>');
            estados.forEach(e => $selectEstado.append(`<option value="${e.id_estado}">${e.nombre_estado}</option>`));

            $selectDistritoFederal.empty().append('<option value="">-- Distrito Federal --</option>');
            dfs.forEach(d => $selectDistritoFederal.append(`<option value="${d.id_distrito_federal}">${d.nombre_distrito_federal}</option>`));

            $selectDistritoLocal.empty().append('<option value="">-- Distrito Local --</option>');
            dls.forEach(d => $selectDistritoLocal.append(`<option value="${d.id_distrito_local}">${d.nombre_distrito_local}</option>`));

            $selectMunicipio.empty().append('<option value="">-- Municipio --</option>');
            municipios.forEach(m => $selectMunicipio.append(`<option value="${m.id_municipio}">${m.nombre_municipio}</option>`));

            $selectSeccion.empty().append('<option value="">-- Sección --</option>');
            secciones.forEach(s => $selectSeccion.append(`<option value="${s.id_seccion}">${s.nombre_seccion}</option>`));
        }

        // Llamar a la función al cargar la página para llenar todos los selectores
        populateAllSelects();

        // Inicializar los selectores y sus etiquetas
        allSelects.forEach($select => floatLabel($select));
        floatLabel($selectComunidad);
        
        // --- Evento para la lógica inversa (bottom-up) cuando se selecciona una comunidad ---
        $selectComunidad.on('change', function () {
            const selectedOption = $(this).find('option:selected');

            // Resetear todos los selectores superiores
            allSelects.forEach($select => {
                $select.val('');
            });

            if (selectedOption.val()) {
                // Obtener los IDs de los atributos data-
                const estadoId = selectedOption.data('estado-id');
                const distritoFederalId = selectedOption.data('distrito-federal-id');
                const distritoLocalId = selectedOption.data('distrito-local-id');
                const municipioId = selectedOption.data('municipio-id');
                const seccionId = selectedOption.data('seccion-id');

                // Establecer los valores en los selectores correspondientes
                $selectEstado.val(estadoId);
                $selectDistritoFederal.val(distritoFederalId);
                $selectDistritoLocal.val(distritoLocalId);
                $selectMunicipio.val(municipioId);
                $selectSeccion.val(seccionId);
            }
            
            // Actualizar los selectores visualmente (flotar etiquetas y refrescar selectpicker)
            allSelects.forEach($select => floatLabel($select));
        });

        // Refrescar todos los selectores de Bootstrap al final de la carga
        setTimeout(function () {
            if ($.fn.selectpicker) {
                $('.form-control.show-tick').selectpicker('refresh');
            }
        }, 100);
    });
</script>
</body>
</html>
