<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Vota y Opina | Ver Encuesta</title>

    <link rel="icon" href="<?= base_url(RECURSOS_ENCUESTADOR_IMAGES . '/favicon.ico') ?>" type="image/x-icon">
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
            --primary-accent: #FF3D00;
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
            background-color: var(--primary-red);
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
            border-bottom: none;
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

        .btn-back {
            background-color:rgb(237, 102, 6) !important;
            color: #fff;
            border: none;
            padding: 14px 28px;
            border-radius: 8px;
            font-weight: bold;
            letter-spacing: 1px;
            text-transform: uppercase;
            text-decoration: none;
            transition: all 0.3s ease-in-out;
            box-shadow: 0 6px 12px rgba(69, 1, 242, 0.8);
            display: inline-block;
            margin-top: 30px;
            font-size: 1.05em;
        }
        
        .btn-back:hover {
            background-color:rgba(197, 5, 107, 0.78) !important;
            transform: translateY(-3px);
            box-shadow: 0 8px 16px rgba(128, 0, 128, 0.4);
        }
        
        .form-line.disabled select {
            background-color: #f5f5f5;
            cursor: not-allowed;
            border-bottom: 1px dashed #ccc;
        }

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

        .form-group.form-float {
            margin-bottom: 25px;
        }

        .form-line {
            position: relative;
            padding-top: 20px;
            padding-bottom: 5px;
        }
        
        .form-line.focused label {
            top: 0;
            font-size: 12px;
            color: var(--primary-red) !important;
        }

        .form-line select, .form-line textarea {
            width: 100%;
            border: none;
            border-bottom: 1px solid #ddd;
            padding: 8px 0;
            background-color: transparent;
            font-size: 16px;
            outline: none;
            transition: border-color 0.2s ease-in-out;
        }
        
        .form-line textarea {
            min-height: 80px;
            resize: vertical;
            padding-top: 10px;
            border: 5px solid #FF3D00; /* Borde naranja visible */
            border-radius: 5px;
            padding: 10px;
            margin-top: 10px;
        }
        
        .form-line.focused textarea {
            border-color: var(--primary-red);
            box-shadow: 0 0 5px rgba(244, 67, 54, 0.5);
        }

        .form-line select:focus, .form-line textarea:focus {
            border-bottom-color: var(--primary-red);
        }

        .form-line label {
            position: absolute;
            left: 0;
            top: 24px;
            font-size: 16px;
            color: #aaa;
            pointer-events: none;
            transition: 0.2s ease all;
        }

        .form-line select:focus ~ label,
        .form-line select:not(:placeholder-shown) ~ label,
        .form-line select:valid ~ label,
        .form-line textarea:focus ~ label,
        .form-line textarea:not(:placeholder-shown) ~ label {
            top: 0;
            font-size: 12px;
            color: var(--primary-red);
        }

        .form-line .invalid-feedback {
            color: red;
            font-size: 0.85em;
            margin-top: 5px;
        }
        
        .referencias-title {
            font-size: 1.3em;
            font-weight: bold;
            color: var(--text-dark);
            margin-top: 20px;
            margin-bottom: 10px;
        }

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
                padding: 12px 0;
                font-size: 0.95em;
                margin-top: 20px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
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

        .buttons-container {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 15px;
            margin-top: 30px;
        }


        /* --- NUEVOS ESTILOS PARA EL ÁREA DE REFERENCIAS --- */

/* 1. El contenedor principal */
.referencias-container {
    background-color: #f9f9f9; /* Un fondo muy sutil */
    border: 1px solid var(--border-subtle);
    border-radius: 8px; /* Bordes redondeados */
    padding: 20px 25px;
    margin-top: 20px;
    margin-bottom: 25px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06); /* Sombra suave */
    position: relative;
}

/* 2. El título con un ícono */
.referencias-container .referencias-title {
    display: flex;
    align-items: center;
    font-size: 1.1em; /* Un poco más pequeño */
    font-weight: 600;
    color: #eb4b40ff ; /* Color del tema */
    margin-top: 0;
    margin-bottom: 15px;
}

.referencias-container .referencias-title .material-icons {
    margin-right: 10px;
    font-size: 26px; /* Tamaño del ícono */
    color: var(--primary-accent);
}

/* 3. El nuevo estilo del textarea */
.referencias-container textarea.form-control {
    border: 2px solid #e0e0e0; /* Borde más suave */
    border-radius: 6px;
    background-color: #fff;
    padding: 12px;
    min-height: 100px;
    transition: all 0.2s ease-in-out; /* Transición suave */
    box-shadow: none; /* Quitar sombra inicial si la hubiera */
}

/* 4. Efecto al hacer clic (focus) en el textarea */
.referencias-container textarea.form-control:focus {
    border-color: var(--primary-accent); /* Borde de color al seleccionar */
    box-shadow: 0 0 8px rgba(255, 61, 0, 0.25); /* Sombra de color */
    background-color: #fff;
}

/* 5. El contador de caracteres */
.referencias-container .help-info {
    text-align: right;
    width: 100%;
    margin-top: 8px;
    font-size: 0.85em;
    color: #999;
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
                <a class="navbar-brand" href="<?= base_url('home') ?>">VOTA Y OPINA</a>
            </div>
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
                                                <div class="form-line">
                                                    <select class="form-control show-tick" id="selectSeccion" name="id_seccion" required>
                                                        <option value="">-- Seleccione una Sección --</option>
                                                        <?php
                                                            $seccionesUnicas = [];
                                                            foreach ($comunidades as $comunidad) {
                                                                if (isset($comunidad['seccion'])) {
                                                                    $seccionesUnicas[$comunidad['seccion']['id_seccion']] = $comunidad['seccion'];
                                                                }
                                                            }
                                                            foreach ($seccionesUnicas as $seccion): ?>
                                                                <option value="<?= esc($seccion['id_seccion']) ?>"><?= esc($seccion['nombre_seccion']) ?></option>
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
                                                                class="comunidad-option seccion-<?= esc($comunidad['seccion']['id_seccion']) ?>"
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

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group" style="margin-top: 20px;">
                                                <h4 style="font-weight: bold;">
                                                    <i class="material-icons" style="vertical-align: middle; margin-right: 5px;">my_location</i>
                                                    Estado de la Ubicación
                                                </h4>
                                                <div id="ubicacion-status" class="font-italic col-grey p-l-5">
                                                    Solicitando permiso de ubicación... Es necesario para continuar.
                                                </div>
                                                <input type="hidden" name="latitud" id="latitud">
                                                <input type="hidden" name="longitud" id="longitud">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="referencias-container">
    <p class="referencias-title">
        <i class="material-icons">edit_note</i>
        Referencias (ej. color de casa, número, etc.) <span class="required-field">*</span>
    </p>
    
    <div class="form-group" style="margin-bottom: 0;">
        <div class="form-line">
            <textarea name="referencias_texto" id="referencias_texto" class="form-control" maxlength="100" placeholder="Escribe aquí las referencias..." required></textarea> </div>
        <div class="help-info">
            <span id="referencias-counter">100</span> caracteres restantes
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

                                <div class="buttons-container">
                                    <a href="<?= base_url('formularios') ?>" class="btn-back waves-effect">Volver a Formularios</a>
                                    <button type="submit" id="btnEnviarEncuesta" class="btn-back waves-effect" disabled>Enviar Respuestas</button>
                                </div>
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
    // --- 1. DEFINICIÓN DE CONSTANTES DEL DOM ---
    // Selectores para los menús desplegables de ubicación
    const $selectComunidad = $('#selectComunidad');
    const $selectSeccion = $('#selectSeccion');
    const $selectMunicipio = $('#selectMunicipio');
    const $selectDistritoLocal = $('#selectDistritoLocal');
    const $selectDistritoFederal = $('#selectDistritoFederal');
    const $selectEstado = $('#selectEstado');
    const allSelects = [$selectEstado, $selectDistritoFederal, $selectDistritoLocal, $selectMunicipio, $selectSeccion, $selectComunidad];
    
    // Selectores para la geolocalización y el formulario
    const $ubicacionStatus = $('#ubicacion-status');
    const $latitudInput = $('#latitud');
    const $longitudInput = $('#longitud');
    const $btnEnviarEncuesta = $('#btnEnviarEncuesta');
    const $referenciasTexto = $('#referencias_texto');
    const $referenciasCounter = $('#referencias-counter');
    
    // --- 2. LÓGICA PARA LOS SELECTORES DE UBICACIÓN (CASCADA) ---
    const dataComunidades = <?= json_encode($comunidades) ?>;

    function floatLabel($element) {
        const formLine = $element.closest('.form-line');
        if ($element.val() && $element.val() !== '') {
            formLine.find('label').addClass('active').css({ top: '0px', fontSize: '12px' });
        } else {
            formLine.find('label').removeClass('active').css({ top: '24px', fontSize: '16px' });
        }
        if ($.fn.selectpicker) {
            $element.selectpicker('refresh');
        }
    }

    function populateComunidades(seccionId) {
        $selectComunidad.empty().append('<option value="">-- Seleccione Comunidad --</option>');
        const comunidadesFiltradas = dataComunidades.filter(c => c.seccion && c.seccion.id_seccion == seccionId);
        
        comunidadesFiltradas.forEach(c => {
            // VERSIÓN CORREGIDA: Usa la variable de JS 'c' en lugar de la de PHP
            const option = `<option 
                class="comunidad-option seccion-${c.seccion.id_seccion}"
                value="${c.id_comunidad}"
                data-seccion-id="${c.seccion.id_seccion}"
                data-municipio-id="${c.seccion.municipio.id_municipio}"
                data-distrito-local-id="${c.seccion.municipio.distrito_local.id_distrito_local}"
                data-distrito-federal-id="${c.seccion.municipio.distrito_local.distrito_federal.id_distrito_federal}"
                data-estado-id="${c.seccion.municipio.distrito_local.distrito_federal.estado.id_estado}"
            >
                ${c.nombre_comunidad}
            </option>`;
            $selectComunidad.append(option);
        });
        floatLabel($selectComunidad);
        if ($.fn.selectpicker) {
            $selectComunidad.selectpicker('refresh');
        }
    }
    
    function populateAllSelects() {
        // Esta función llena los selects deshabilitados la primera vez
        const unicos = { estados: {}, distritosFederales: {}, distritosLocales: {}, municipios: {}, secciones: {} };

        dataComunidades.forEach(comunidad => {
            if (comunidad.seccion && comunidad.seccion.municipio && comunidad.seccion.municipio.distrito_local && comunidad.seccion.municipio.distrito_local.distrito_federal && comunidad.seccion.municipio.distrito_local.distrito_federal.estado) {
                const estado = comunidad.seccion.municipio.distrito_local.distrito_federal.estado;
                const df = comunidad.seccion.municipio.distrito_local.distrito_federal;
                const dl = comunidad.seccion.municipio.distrito_local;
                const mun = comunidad.seccion.municipio;
                const sec = comunidad.seccion;

                unicos.estados[estado.id_estado] = estado.nombre_estado;
                unicos.distritosFederales[df.id_distrito_federal] = df.nombre_distrito_federal;
                unicos.distritosLocales[dl.id_distrito_local] = dl.nombre_distrito_local;
                unicos.municipios[mun.id_municipio] = mun.nombre_municipio;
                unicos.secciones[sec.id_seccion] = sec.nombre_seccion;
            }
        });

        // Llenar selects. Limpiamos primero por si acaso.
        $selectEstado.empty().append('<option value="">-- Estado --</option>');
        Object.entries(unicos.estados).forEach(([id, nombre]) => $selectEstado.append(`<option value="${id}">${nombre}</option>`));
        
        $selectDistritoFederal.empty().append('<option value="">-- Distrito Federal --</option>');
        Object.entries(unicos.distritosFederales).forEach(([id, nombre]) => $selectDistritoFederal.append(`<option value="${id}">${nombre}</option>`));

        $selectDistritoLocal.empty().append('<option value="">-- Distrito Local --</option>');
        Object.entries(unicos.distritosLocales).forEach(([id, nombre]) => $selectDistritoLocal.append(`<option value="${id}">${nombre}</option>`));
        
        $selectMunicipio.empty().append('<option value="">-- Municipio --</option>');
        Object.entries(unicos.municipios).forEach(([id, nombre]) => $selectMunicipio.append(`<option value="${id}">${nombre}</option>`));

        $selectSeccion.empty().append('<option value="">-- Seleccione una Sección --</option>');
        Object.entries(unicos.secciones).forEach(([id, nombre]) => $selectSeccion.append(`<option value="${id}">${nombre}</option>`));
    }

    $selectSeccion.on('change', function () {
        const seccionId = $(this).val();
        populateComunidades(seccionId);
        
        // Autocompletar los selects padres deshabilitados
        if (seccionId) {
            const comunidadDeReferencia = dataComunidades.find(c => c.seccion.id_seccion == seccionId);
            if (comunidadDeReferencia) {
                const seccionData = comunidadDeReferencia.seccion;
                $selectMunicipio.val(seccionData.municipio.id_municipio);
                $selectDistritoLocal.val(seccionData.municipio.distrito_local.id_distrito_local);
                $selectDistritoFederal.val(seccionData.municipio.distrito_local.distrito_federal.id_distrito_federal);
                $selectEstado.val(seccionData.municipio.distrito_local.distrito_federal.estado.id_estado);
            }
        } else {
            // Si se deselecciona, limpiar todo
            $selectMunicipio.val('');
            $selectDistritoLocal.val('');
            $selectDistritoFederal.val('');
            $selectEstado.val('');
        }
        allSelects.forEach($select => floatLabel($select));
    });

    $selectComunidad.on('change', function () {
        const selectedOption = $(this).find('option:selected');
        if (selectedOption.val()) {
            // Autoseleccionar todos los padres basados en los data-attributes
            $selectSeccion.val(selectedOption.data('seccion-id'));
            $selectMunicipio.val(selectedOption.data('municipio-id'));
            $selectDistritoLocal.val(selectedOption.data('distrito-local-id'));
            $selectDistritoFederal.val(selectedOption.data('distrito-federal-id'));
            $selectEstado.val(selectedOption.data('estado-id'));
        }
        allSelects.forEach($select => floatLabel($select));
    });

    // --- 3. LÓGICA PARA EL CAMPO DE TEXTO "REFERENCIAS" ---
    $referenciasTexto.on('keyup', function() {
        const maxLength = $(this).attr('maxlength');
        const currentLength = $(this).val().length;
        const remaining = maxLength - currentLength;
        $referenciasCounter.text(remaining);
    });

    // --- 4. LÓGICA DE GEOLOCALIZACIÓN ---
    
    function obtenerUbicacionParaFormulario() {
        if (!navigator.geolocation) {
            $ubicacionStatus.text('Geolocalización no soportada.').addClass('col-red');
            $btnEnviarEncuesta.prop('disabled', true);
            return;
        }

        $ubicacionStatus.text('Obteniendo ubicación para el formulario...').addClass('col-orange');
        navigator.geolocation.getCurrentPosition(
            (position) => {
                $latitudInput.val(position.coords.latitude);
                $longitudInput.val(position.coords.longitude);
                $ubicacionStatus.html(`<strong><i class="material-icons" style="font-size: 1em; vertical-align: sub;">check_circle</i> Ubicación obtenida.</strong>`).removeClass('col-orange col-red').addClass('col-green');
                $btnEnviarEncuesta.prop('disabled', false);
            },
            (err) => {
                $btnEnviarEncuesta.prop('disabled', true);
                let msg = "Error al obtener ubicación. Intente de nuevo.";
                if (err.code === 1) msg = "Permiso de ubicación denegado.";
                if (err.code === 2) msg = "Ubicación no disponible. Revise su GPS.";
                if (err.code === 3) msg = "Tiempo de espera agotado.";
                $ubicacionStatus.text(msg).removeClass('col-orange col-green').addClass('col-red');
            },
            { enableHighAccuracy: true, timeout: 20000, maximumAge: 0 }
        );
    }

    function iniciarMonitoreoContinuo() {
        if (!navigator.geolocation) {
            console.warn('Monitoreo no disponible: geolocalización no soportada.');
            return;
        }
        
        const enviarUbicacion = (position) => {
            fetch('<?= base_url('encuestador/guardar_ubicacion_monitoreo') ?>', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                body: JSON.stringify({
                    latitud: position.coords.latitude,
                    longitud: position.coords.longitude
                })
            })
            .then(res => res.json())
            .then(data => data.success ? console.log('Monitoreo: Posición actualizada.') : console.error('Monitoreo:', data.message))
            .catch(err => console.error('Monitoreo (Error de Red):', err));
        };

        navigator.geolocation.watchPosition(
            enviarUbicacion,
            (err) => console.warn(`Monitoreo (Error de GPS): ${err.message}`),
            { enableHighAccuracy: true, timeout: 15000, maximumAge: 0 }
        );
    }

    // --- 5. EJECUCIÓN INICIAL AL CARGAR LA PÁGINA ---
    populateAllSelects(); // Llama a la función para llenar los selectores
    obtenerUbicacionParaFormulario();
    iniciarMonitoreoContinuo();

    // Inicializa plugins de estilo
    setTimeout(() => {
        if ($.fn.selectpicker) {
            $('.form-control.show-tick').selectpicker('refresh');
        }
        floatLabel($('#referencias_texto'));
    }, 200);
});
</script>

