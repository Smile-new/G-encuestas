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
    <link rel="manifest" href="<?= base_url('manifest.json') ?>">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="theme-color" content="#f44336">

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
            background-color: rgb(237, 102, 6) !important;
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
            background-color: rgba(197, 5, 107, 0.78) !important;
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

        .form-line select,
        .form-line textarea {
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
            border: 5px solid #FF3D00;
            /* Borde naranja visible */
            border-radius: 5px;
            padding: 10px;
            margin-top: 10px;
        }

        .form-line.focused textarea {
            border-color: var(--primary-red);
            box-shadow: 0 0 5px rgba(244, 67, 54, 0.5);
        }

        .form-line select:focus,
        .form-line textarea:focus {
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

        .form-line select:focus~label,
        .form-line select:not(:placeholder-shown)~label,
        .form-line select:valid~label,
        .form-line textarea:focus~label,
        .form-line textarea:not(:placeholder-shown)~label {
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
            background-color: #f9f9f9;
            /* Un fondo muy sutil */
            border: 1px solid var(--border-subtle);
            border-radius: 8px;
            /* Bordes redondeados */
            padding: 20px 25px;
            margin-top: 20px;
            margin-bottom: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            /* Sombra suave */
            position: relative;
        }

        /* 2. El título con un ícono */
        .referencias-container .referencias-title {
            display: flex;
            align-items: center;
            font-size: 1.1em;
            /* Un poco más pequeño */
            font-weight: 600;
            color: #eb4b40ff;
            /* Color del tema */
            margin-top: 0;
            margin-bottom: 15px;
        }

        .referencias-container .referencias-title .material-icons {
            margin-right: 10px;
            font-size: 26px;
            /* Tamaño del ícono */
            color: var(--primary-accent);
        }

        /* 3. El nuevo estilo del textarea */
        .referencias-container textarea.form-control {
            border: 2px solid #e0e0e0;
            /* Borde más suave */
            border-radius: 6px;
            background-color: #fff;
            padding: 12px;
            min-height: 100px;
            transition: all 0.2s ease-in-out;
            /* Transición suave */
            box-shadow: none;
            /* Quitar sombra inicial si la hubiera */
        }

        /* 4. Efecto al hacer clic (focus) en el textarea */
        .referencias-container textarea.form-control:focus {
            border-color: var(--primary-accent);
            /* Borde de color al seleccionar */
            box-shadow: 0 0 8px rgba(255, 61, 0, 0.25);
            /* Sombra de color */
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

        .logout_sidebar {
            position: absolute;
            bottom: 80px;
            /* queda justo arriba del bloque .legal */
            width: 100%;
            text-align: center;
        }

        .logout_sidebar a {
            display: block;
            padding: 12px;
            color: #fff;
            /* texto blanco */
            background-color: #f44336;
            /* rojo estilo Material */
            text-decoration: none;
            font-weight: bold;
        }

        .logout_sidebar a:hover {
            background-color: #d32f2f;
        }


        /* Convertir Checkbox en apariencia de Radio Botón */
        .chk-multi-radio.filled-in+label:after {
            border-radius: 50% !important;
            /* Esto lo hace círculo */
            border: 2px solid #555 !important;
        }

        .chk-multi-radio.filled-in:checked+label:after {
            border: 2px solid var(--primary-red) !important;
            background-color: var(--primary-red) !important;
        }

        .chk-multi-radio.filled-in:checked+label:before {
            border-right: 2px solid #fff !important;
            border-bottom: 2px solid #fff !important;
            border-radius: 0 !important;
            /* Mantiene el check blanco adentro */
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
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>

                <a class="navbar-brand" href="<?= base_url('/') ?>"
                    style="display: flex; align-items: center; padding: 5px 15px;">
                    <img src="<?= base_url(RECURSOS_USUARIO_IMG . '/logo/logo.png') ?>" alt="Vota y Opina"
                        style="height: 35px; width: auto; max-width: 150px; object-fit: contain;">
                </a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li class="pull-right"><a href="javascript:void(0);" class="js-right-sidebar" data-close="true"><i
                                class="material-icons">more_vert</i></a></li>
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
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?= $nombreCompleto ?>
                    </div>
                    <div class="email"><?= $nombreUsuario ?></div>
                    <div class="btn-group user-helper-dropdown">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="true">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="javascript:void(0);"><i class="material-icons">person</i>Perfil</a></li>
                            <li role="seperator" class="divider"></li>
                            <li><a href="<?= base_url('logout') ?>"><i class="material-icons">input</i>Cerrar Sesión</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="menu">
                <ul class="list">
                    <li class="header">NAVEGACIÓN PRINCIPAL</li>
                    <li>
                        <a href="<?= base_url('home') ?>">
                            <i class="material-icons">home</i>
                            <span>Inicio</span>
                        </a>
                    </li>
                    <li class="active">
                        <a href="<?= base_url('formularios') ?>">
                            <i class="material-icons">assignment</i>
                            <span>Formularios</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= site_url('perfil') ?>">
                            <i class="material-icons">account_circle</i>
                            <span>Perfil</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Botón fijo abajo -->
            <div class="logout_sidebar">
                <a href="<?= site_url('logout') ?>">
                    <i class="material-icons">input</i>
                    <span>Cerrar Sesión</span>
                </a>
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
                                                    <div class="form-line">
                                                        <select class="form-control show-tick" id="selectEstado"
                                                            name="id_estado" required>
                                                            <option value="">-- Seleccione Estado --</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <select class="form-control show-tick" id="selectDistritoFederal"
                                                            name="id_distrito_federal" required>
                                                            <option value="">-- Seleccione Distrito Federal --</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <select class="form-control show-tick" id="selectDistritoLocal"
                                                            name="id_distrito_local" required>
                                                            <option value="">-- Seleccione Distrito Local --</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <select class="form-control show-tick" id="selectMunicipio"
                                                            name="id_municipio" required>
                                                            <option value="">-- Seleccione Municipio --</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <select class="form-control show-tick" id="selectSeccion"
                                                            name="id_seccion" required>
                                                            <option value="">-- Seleccione Sección --</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <select class="form-control show-tick" id="selectComunidad"
                                                            name="id_comunidad" required>
                                                            <option value="">-- Seleccione Comunidad --</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group" style="margin-top: 20px;">
                                                    <h4
                                                        style="font-weight: bold; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                                                        <span>
                                                            <i class="material-icons"
                                                                style="vertical-align: middle; margin-right: 5px;">my_location</i>
                                                            Estado de la Ubicación
                                                        </span>
                                                        <button type="button" id="btnAjustarMapa"
                                                            class="btn btn-sm btn-info waves-effect"
                                                            style="display:none; border-radius: 4px; background-color: #00bcd4 !important; color: white;">
                                                            <i class="material-icons"
                                                                style="font-size: 16px; vertical-align: middle;">map</i>
                                                            Ajustar Manualmente
                                                        </button>
                                                    </h4>

                                                    <div id="ubicacion-status" class="font-italic col-grey p-l-5">
                                                        Solicitando permiso de ubicación... Es necesario para continuar.
                                                    </div>
                                                    <input type="hidden" name="latitud" id="latitud">
                                                    <input type="hidden" name="longitud" id="longitud">

                                                    <div id="mapa_manual_container" style="display: none; margin-top: 15px;">
                                                        <p style="font-size: 13px; color: #555; font-weight: bold; margin-bottom: 8px;">
                                                            <i class="material-icons" style="font-size: 16px; vertical-align: middle; color: #FF3D00;">touch_app</i> 
                                                            Busca un lugar o arrastra el marcador rojo para corregir.
                                                        </p>
                                                        
                                                        <input id="buscador_mapa" class="form-control" type="text" placeholder="🔍 Buscar municipio, calle o lugar..." style="margin-bottom: 10px; border: 2px solid #00bcd4; border-radius: 6px; padding: 10px 15px; font-weight: bold;">
                                                        
                                                        <div id="mapa_captura" style="width: 100%; height: 280px; border-radius: 8px; border: 2px solid #ddd;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="referencias-container">
                                            <p class="referencias-title">
                                                <i class="material-icons">edit_note</i>
                                                Referencias (ej. color de casa, número, etc.)
                                                <span id="asterisco-referencias" class="required-field"
                                                    style="color:red; font-weight:bold;">*</span>
                                            </p>

                                            <div class="form-group" style="margin-bottom: 0;">
                                                <div class="form-line">
                                                    <textarea name="referencias_texto" id="referencias_texto"
                                                        class="form-control" maxlength="100"
                                                        placeholder="Escribe aquí las referencias..." required></textarea>
                                                </div>
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
                                                                <input type="checkbox"
                                                                    name="respuesta_<?= esc($pregunta['id_pregunta']) ?>[]"
                                                                    id="opcion_<?= esc($opcion['id_opcion']) ?>"
                                                                    value="<?= esc($opcion['id_opcion']) ?>"
                                                                    class="filled-in chk-multi-radio"> <label
                                                                    for="opcion_<?= esc($opcion['id_opcion']) ?>">
                                                                    <?= esc($opcion['texto_opcion']) ?>
                                                                </label>
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
                                        <a href="<?= base_url('formularios') ?>" class="btn-back waves-effect">Volver a
                                            Formularios</a>
                                        <button type="submit" id="btnEnviarEncuesta" class="btn-back waves-effect"
                                            disabled>Enviar Respuestas</button>
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
    <script src="https://cdn.jsdelivr.net/npm/dexie@latest/dist/dexie.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?= esc($google_maps_api_key) ?>&libraries=visualization,places"></script>
    <script src="<?= base_url('js/offline_handler.js') ?>"></script>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(function () {
            // --- 1. DEFINICIÓN DE CONSTANTES DEL DOM ---
            const $form = $('#surveyForm');
            const $selectEstado = $('#selectEstado');
            const $selectDistritoFederal = $('#selectDistritoFederal');
            const $selectDistritoLocal = $('#selectDistritoLocal');
            const $selectMunicipio = $('#selectMunicipio');
            const $selectSeccion = $('#selectSeccion');
            const $selectComunidad = $('#selectComunidad');

            const $ubicacionStatus = $('#ubicacion-status');
            const $latitudInput = $('#latitud');
            const $longitudInput = $('#longitud');
            const $btnEnviarEncuesta = $('#btnEnviarEncuesta');
            const $referenciasTexto = $('#referencias_texto');
            const $referenciasCounter = $('#referencias-counter');

            const dataComunidades = <?= json_encode($comunidades) ?>;

            // Configuración global para Toasts
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });

            // --- 2. LÓGICA DE VALIDACIÓN Y ENVÍO ---
            $form.on('submit', function (e) {
                e.preventDefault();

                const refValue = $referenciasTexto.val().trim();

                if (refValue === "" || refValue.length < 5) {
                    $referenciasTexto.css('border', '2px solid #F44336');
                    $referenciasTexto.focus();
                    Swal.fire({
                        icon: 'error',
                        title: 'Referencias incompletas',
                        text: 'Es obligatorio indicar referencias de la ubicación con al menos 5 caracteres.',
                        confirmButtonColor: '#F44336'
                    });
                    return;
                }

                if ($selectComunidad.val() === "") {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Selecciona una comunidad',
                        text: 'Debes completar la cascada geográfica hasta la comunidad.',
                        confirmButtonColor: '#F44336'
                    });
                    return;
                }

                const respondidas = $(this).find('input[type="checkbox"]:checked').length;
                if (respondidas === 0) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Encuesta vacía',
                        text: 'Por favor, marque al menos una opción antes de enviar.',
                        confirmButtonColor: '#F44336'
                    });
                    return;
                }

                Swal.fire({
                    title: '¿Confirmar envío?',
                    text: "Se guardarán las respuestas y la ubicación GPS actual.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#4CAF50',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, enviar ahora',
                    cancelButtonText: 'Revisar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        if (navigator.onLine) {
                            Swal.fire({
                                title: 'Enviando...',
                                text: 'Información enviada, por favor espera.',
                                allowOutsideClick: false,
                                didOpen: () => { Swal.showLoading(); }
                            });
                            setTimeout(() => { this.submit(); }, 100);
                        } else {
                            if (typeof guardarOffline === "function") {
                                guardarOffline(this);
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error de sistema',
                                    text: 'El controlador offline no está disponible.'
                                });
                            }
                        }
                    }
                });
            });

            // --- 3. LÓGICA DE CASCADA MANUAL ---

            function refreshSelect($el) {
                if ($.fn.selectpicker) { $el.selectpicker('refresh'); }
                const formLine = $el.closest('.form-line');
                $el.val() !== "" ? formLine.find('label').addClass('active') : formLine.find('label').removeClass('active');
            }

            // Inicializar Estados
            function initEstados() {
                const estadosMap = {};
                dataComunidades.forEach(c => {
                    const e = c.seccion.municipio.distrito_local.distrito_federal.estado;
                    estadosMap[e.id_estado] = e.nombre_estado;
                });
                $selectEstado.empty().append('<option value="">-- Seleccione Estado --</option>');
                Object.entries(estadosMap).forEach(([id, nombre]) => {
                    $selectEstado.append(`<option value="${id}">${nombre}</option>`);
                });
                refreshSelect($selectEstado);
            }

            // Estado -> Distrito Federal
            $selectEstado.on('change', function () {
                const id = $(this).val();
                $selectDistritoFederal.empty().append('<option value="">-- Distrito Federal --</option>');
                $selectDistritoLocal.empty().append('<option value="">-- Distrito Local --</option>');
                $selectMunicipio.empty().append('<option value="">-- Municipio --</option>');
                $selectSeccion.empty().append('<option value="">-- Sección --</option>');
                $selectComunidad.empty().append('<option value="">-- Comunidad --</option>');

                if (id) {
                    const m = {};
                    dataComunidades.filter(c => c.seccion.municipio.distrito_local.distrito_federal.estado.id_estado == id)
                        .forEach(c => {
                            const df = c.seccion.municipio.distrito_local.distrito_federal;
                            m[df.id_distrito_federal] = df.nombre_distrito_federal;
                        });
                    Object.entries(m).forEach(([i, n]) => $selectDistritoFederal.append(`<option value="${i}">${n}</option>`));
                }
                [$selectDistritoFederal, $selectDistritoLocal, $selectMunicipio, $selectSeccion, $selectComunidad].forEach(s => refreshSelect(s));
            });

            // Distrito Federal -> Distrito Local
            $selectDistritoFederal.on('change', function () {
                const id = $(this).val();
                $selectDistritoLocal.empty().append('<option value="">-- Distrito Local --</option>');
                $selectMunicipio.empty().append('<option value="">-- Municipio --</option>');
                $selectSeccion.empty().append('<option value="">-- Sección --</option>');
                $selectComunidad.empty().append('<option value="">-- Comunidad --</option>');

                if (id) {
                    const m = {};
                    dataComunidades.filter(c => c.seccion.municipio.distrito_local.distrito_federal.id_distrito_federal == id)
                        .forEach(c => {
                            const dl = c.seccion.municipio.distrito_local;
                            m[dl.id_distrito_local] = dl.nombre_distrito_local;
                        });
                    Object.entries(m).forEach(([i, n]) => $selectDistritoLocal.append(`<option value="${i}">${n}</option>`));
                }
                [$selectDistritoLocal, $selectMunicipio, $selectSeccion, $selectComunidad].forEach(s => refreshSelect(s));
            });

            // Distrito Local -> Municipio
            $selectDistritoLocal.on('change', function () {
                const id = $(this).val();
                $selectMunicipio.empty().append('<option value="">-- Municipio --</option>');
                $selectSeccion.empty().append('<option value="">-- Sección --</option>');
                $selectComunidad.empty().append('<option value="">-- Comunidad --</option>');

                if (id) {
                    const m = {};
                    dataComunidades.filter(c => c.seccion.municipio.distrito_local.id_distrito_local == id)
                        .forEach(c => {
                            const mun = c.seccion.municipio;
                            m[mun.id_municipio] = mun.nombre_municipio;
                        });
                    Object.entries(m).forEach(([i, n]) => $selectMunicipio.append(`<option value="${i}">${n}</option>`));
                }
                [$selectMunicipio, $selectSeccion, $selectComunidad].forEach(s => refreshSelect(s));
            });

            // Municipio -> Sección
            $selectMunicipio.on('change', function () {
                const id = $(this).val();
                $selectSeccion.empty().append('<option value="">-- Sección --</option>');
                $selectComunidad.empty().append('<option value="">-- Comunidad --</option>');

                if (id) {
                    const m = {};
                    dataComunidades.filter(c => c.seccion.municipio.id_municipio == id)
                        .forEach(c => {
                            const sec = c.seccion;
                            m[sec.id_seccion] = sec.nombre_seccion;
                        });
                    Object.entries(m).forEach(([i, n]) => $selectSeccion.append(`<option value="${i}">${n}</option>`));
                }
                [$selectSeccion, $selectComunidad].forEach(s => refreshSelect(s));
            });

            // Sección -> Comunidad
            $selectSeccion.on('change', function () {
                const id = $(this).val();
                $selectComunidad.empty().append('<option value="">-- Comunidad --</option>');

                if (id) {
                    dataComunidades.filter(c => c.seccion.id_seccion == id)
                        .forEach(c => {
                            $selectComunidad.append(`<option value="${c.id_comunidad}">${c.nombre_comunidad}</option>`);
                        });
                }
                refreshSelect($selectComunidad);
            });

            // --- 4. OTROS EVENTOS ---

            $referenciasTexto.on('input', function () {
                if ($(this).val().trim().length >= 5) { $(this).css('border', '1px solid #4CAF50'); }
            });

            $referenciasTexto.on('keyup', function () {
                $referenciasCounter.text(100 - $(this).val().length);
            });

            // --- 5. GEOLOCALIZACIÓN ---

            // --- VARIABLES GLOBALES PARA EL MAPA ---
            let mapCaptura = null;
            let markerCaptura = null;

            /**
             * 1. Inicializa el mapa de Google con un marcador arrastrable.
             */
            // Función para crear/actualizar el mapa interactivo
            function initMapaCaptura(lat, lng) {
                const pos = { lat: parseFloat(lat), lng: parseFloat(lng) };

                if (!mapCaptura) {
                    mapCaptura = new google.maps.Map(document.getElementById('mapa_captura'), {
                        center: pos,
                        zoom: 17,
                        mapTypeId: 'hybrid', // Satélite + Calles
                        disableDefaultUI: true,
                        zoomControl: true
                    });

                    // Marcador arrastrable
                    markerCaptura = new google.maps.Marker({
                        position: pos,
                        map: mapCaptura,
                        draggable: true,
                        animation: google.maps.Animation.DROP,
                        title: "Arrastra para ajustar ubicación"
                    });

                    // --- NUEVO: Lógica del Buscador (Autocomplete) ---
                    const inputBuscador = document.getElementById("buscador_mapa");
                    const searchBox = new google.maps.places.SearchBox(inputBuscador);

                    // Evitar que al presionar "Enter" en el buscador se envíe la encuesta por error
                    $(inputBuscador).on('keydown', function(e) {
                        if (e.key === 'Enter') { e.preventDefault(); return false; }
                    });

                    // Cuando el usuario elige un lugar de las sugerencias
                    searchBox.addListener("places_changed", () => {
                        const places = searchBox.getPlaces();
                        if (places.length == 0) return;

                        const lugar = places[0];
                        if (!lugar.geometry || !lugar.geometry.location) return;

                        // Hacemos que el mapa y el marcador "vuelen" al lugar buscado
                        mapCaptura.setCenter(lugar.geometry.location);
                        mapCaptura.setZoom(17);
                        markerCaptura.setPosition(lugar.geometry.location);

                        // Actualizamos los inputs ocultos
                        $latitudInput.val(lugar.geometry.location.lat());
                        $longitudInput.val(lugar.geometry.location.lng());
                        
                        $ubicacionStatus.html(`<strong><i class="material-icons" style="font-size: 14px; vertical-align: middle;">edit_location</i> Ubicación ajustada por búsqueda</strong>`)
                            .removeClass('col-green col-red').css('color', '#FF9800');
                    });

                    // Evento al soltar el marcador (arrastre manual)
                    markerCaptura.addListener('dragend', function() {
                        const nuevaPos = markerCaptura.getPosition();
                        $latitudInput.val(nuevaPos.lat());
                        $longitudInput.val(nuevaPos.lng());
                        
                        $ubicacionStatus.html(`<strong><i class="material-icons" style="font-size: 14px; vertical-align: middle;">edit_location</i> Ubicación ajustada manualmente</strong>`)
                            .removeClass('col-green col-red').css('color', '#FF9800');
                    });
                } else {
                    mapCaptura.setCenter(pos);
                    markerCaptura.setPosition(pos);
                }
            }

            /**
             * 2. Modo de emergencia: Se activa si el GPS del celular falla o es denegado.
             */
            function activarModoManualFalloGPS() {
                $('#ubicacion-status').html(`<strong><i class="material-icons" style="font-size: 14px; vertical-align: middle;">warning</i> GPS no disponible. Ubica el punto en el mapa.</strong>`)
                    .removeClass('col-orange col-green').addClass('col-red');

                // Habilitamos el botón de enviar para que no se bloquee la encuesta
                $('#btnEnviarEncuesta').prop('disabled', false);

                // Ocultamos el botón de "Ajustar" porque el mapa se abrirá automáticamente
                $('#btnAjustarMapa').hide();
                $('#mapa_manual_container').slideDown();

                // Coordenadas por defecto (puedes ajustarlas al centro de tu ciudad)
                const latDefecto = 19.3181;
                const lngDefecto = -98.2375;

                $('#latitud').val(latDefecto);
                $('#longitud').val(lngDefecto);

                initMapaCaptura(latDefecto, lngDefecto);
            }

            /**
             * 3. Función principal: Intenta obtener la ubicación real al cargar la página.
             */
            function obtenerUbicacionParaFormulario() {
                if (!navigator.geolocation) {
                    activarModoManualFalloGPS();
                    return;
                }

                $('#ubicacion-status').html('<i class="material-icons" style="font-size: 14px; vertical-align: middle;">satellite</i> Buscando señal GPS...')
                    .removeClass('col-red col-green').addClass('col-orange');

                navigator.geolocation.getCurrentPosition(
                    (pos) => {
                        // ÉXITO
                        const lat = pos.coords.latitude;
                        const lng = pos.coords.longitude;

                        $('#latitud').val(lat);
                        $('#longitud').val(lng);

                        $('#ubicacion-status').html(`<strong><i class="material-icons" style="font-size: 14px; vertical-align: middle;">check_circle</i> Ubicación lista (GPS)</strong>`)
                            .removeClass('col-orange col-red').addClass('col-green');

                        $('#btnEnviarEncuesta').prop('disabled', false);

                        // Preparamos el mapa por si el usuario quiere corregirlo
                        initMapaCaptura(lat, lng);
                        $('#btnAjustarMapa').show();
                    },
                    (err) => {
                        // ERROR (Denegado, sin señal o timeout)
                        activarModoManualFalloGPS();
                    },
                    {
                        enableHighAccuracy: true,
                        timeout: 15000,
                        maximumAge: 0
                    }
                );
            }

            // --- EVENTO PARA EL BOTÓN DE AJUSTE MANUAL ---
            $(document).on('click', '#btnAjustarMapa', function () {
                $('#mapa_manual_container').slideToggle();

                // Refrescar el mapa después de que el contenedor se hace visible
                setTimeout(() => {
                    if (mapCaptura) {
                        google.maps.event.trigger(mapCaptura, 'resize');
                        mapCaptura.setCenter(markerCaptura.getPosition());
                    }
                }, 400);
            });

            // --- INICIALIZACIÓN ---
            initEstados();
            obtenerUbicacionParaFormulario();
        });
    </script>