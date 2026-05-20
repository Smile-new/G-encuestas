<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Cruces | Encuestas</title>
    <link rel="stylesheet" href="<?= base_url('recursos_admin/vendors/mdi/css/materialdesignicons.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('recursos_admin/vendors/css/vendor.bundle.base.css') ?>">
    <link rel="stylesheet" href="<?= base_url('recursos_admin/css/style.css') ?>">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

    <style>
        label {
            color: #ffffff;
        }

        select.form-control {
            color: #ffffff;
            background-color: #2a2c3d;
            border-color: #4a4a4a;
        }

        select.form-control:focus {
            color: #ffffff;
        }

        .criterio-row {
            background: #191c24;
            border: 1px solid #3e415b;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 10px;
            position: relative;
        }

        .btn-remove-criterio {
            position: absolute;
            top: -10px;
            right: -10px;
            border-radius: 50%;
            padding: 2px 8px;
            z-index: 10;
        }

        /* Contenedor con scroll para la gráfica */
        /* Contenedor con scroll para la gráfica */
        #wrapper_grafica_scrollable {
            max-height: 650px;
            overflow-y: auto;
            overflow-x: hidden;
            /* CAMBIO: Ahora es transparente para que resalten las tarjetas blancas */
            background: transparent !important;
            border: none;
            box-shadow: none;
            padding-right: 5px;
            /* Pequeño margen para el scrollbar */
        }

        /* Clase para cuando se exporta a PDF */
        .exporting-pdf #wrapper_grafica_scrollable {
            max-height: none !important;
            height: auto !important;
            overflow: visible !important;
            background: transparent !important;
        }

        .chart-container {
            background: transparent;
            border: none;
            padding: 0;
            /* Quitamos el padding viejo */
            width: 100%;
        }

        /* Estilo para hacer el scrollbar más elegante en el fondo oscuro */
        #wrapper_grafica_scrollable::-webkit-scrollbar {
            width: 8px;
        }

        #wrapper_grafica_scrollable::-webkit-scrollbar-track {
            background: #191c24;
        }

        #wrapper_grafica_scrollable::-webkit-scrollbar-thumb {
            background: #3e415b;
            border-radius: 4px;
        }

        #wrapper_grafica_scrollable::-webkit-scrollbar-thumb:hover {
            background: #0090e7;
        }

        /* Clase para cuando se exporta a PDF (mantiene el fondo blanco) */
        .exporting-pdf #wrapper_grafica_scrollable {
            max-height: none !important;
            height: auto !important;
            overflow: visible !important;
            background: #ffffff !important;
        }

        .chart-container {
            background: transparent;
            /* El fondo lo da el wrapper */
            border: none;
            padding: 15px;
            /* Un poco más de padding se ve mejor en blanco */
            width: 100%;
        }

        #mapa_uniones {
            width: 100%;
            height: 500px;
            border-radius: 12px;
            background: #191c24;
            border: 1px solid #2c2e33;
        }

        .table-dark-custom {
            background: #191c24;
            color: white;
        }

        .pagina-reporte {
            width: 297mm;
            height: 208mm;
            /* Reducido ligeramente para evitar saltos accidentales */
            margin: 0;
            padding: 0;
            position: relative;
            background-color: #ffffff;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            /* CAMBIO: flex-start mueve el contenido a la parte superior */
            justify-content: flex-start;
            align-items: center;
            box-sizing: border-box;
            page-break-after: always;
        }

        .pagina-reporte:last-child {
            page-break-after: auto;
        }

        .marca-agua {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: fill;
            z-index: 1;
            opacity: 1;
            pointer-events: none;
        }

        .contenido-superior {
            position: relative;
            z-index: 10;
            width: 90%;
            /* Añadimos un margen superior para que no pegue al borde físico */
            margin-top: 15mm;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
            text-align: center;
        }

        .tabla-reporte {
            width: 100%;
            border-collapse: collapse;
            background-color: rgba(255, 255, 255, 0.85);
            margin-top: 10mm;
        }

        .tabla-reporte th {
            background-color: #003366;
            color: white;
            padding: 12px;
            border: 1px solid #000;
            font-size: 16px;
        }

        .tabla-reporte td {
            padding: 12px;
            border: 1px solid #ddd;
            font-size: 14px;
            font-weight: bold;
            color: #000;
        }

        .mapa-img {
            width: 100%;
            max-width: 950px;
            display: block;
            /* IMPORTANTE: elimina espacio extra debajo de la imagen */
            margin: 10mm auto;
            /* Igual margen (10mm) arriba y abajo. 'auto' centra horizontalmente */
            border: 4px solid #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .color-indicador {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 8px;
            border: 1px solid rgba(0, 0, 0, 0.1);
            vertical-align: middle;
        }

        .texto-opcion {
            vertical-align: middle;
            font-size: 14px;
        }
    </style>


</head>

<body>
    <?php
    $isLoggedIn = session()->get('isLoggedIn');
    $userData = session()->get('usuario');

    $nombreCompleto = "Invitado";
    $rolTexto = "Rol Desconocido";
    $rutaFotoPerfil = base_url('recursos_admin/images/faces/face15.jpg');

    if ($isLoggedIn && $userData) {
        $nombreCompleto = trim(($userData['nombre'] ?? '') . ' ' . ($userData['apellido_paterno'] ?? '') . ' ' . ($userData['apellido_materno'] ?? ''));
        $rolTexto = esc($userData['nombre_rol'] ?? 'Rol desconocido');
        if (!empty($userData['foto'])) {
            $rutaFotoPerfil = base_url('public/img_user/' . $userData['foto']);
        }
    }
    $encuestas = $encuestas ?? [];
    $municipios = $municipios ?? [];
    ?>

    <div class="container-scroller">
        <!-- SIDEBAR -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
                <a class="sidebar-brand brand-logo" href="<?= base_url('dashboard') ?>">
                    <img src="<?= base_url(RECURSOS_ADMIN_IMAGES . '/logo.png') ?>" alt="logo" />
                </a>
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
                                <h5 class="mb-0 font-weight-normal">
                                    <?= esc($nombreCompleto) ?>
                                </h5>
                                <span>
                                    <?= esc($rolTexto) ?>
                                </span>
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
                        <span class="menu-title">Estadísticas</span>
                    </a>
                </li>

                <li class="nav-item menu-items">
                    <a class="nav-link" href="<?= base_url('uniones') ?>">
                        <span class="menu-icon"><i class="mdi mdi-source-branch"></i></span>
                        <span class="menu-title">Uniones</span>
                    </a>
                </li>

                <li class="nav-item menu-items">
                    <a class="nav-link" href="<?= base_url('cruces') ?>">
                        <span class="menu-icon"><i class="mdi mdi-compare"></i></span>
                        <span class="menu-title">Cruces</span>
                    </a>
                </li>

                <li class="nav-item menu-items">
                    <a class="nav-link" href="<?= base_url('usuarios') ?>">
                        <span class="menu-icon"><i class="mdi mdi-contacts"></i></span>
                        <span class="menu-title">Usuarios</span>
                    </a>
                </li>

                <li class="nav-item menu-items">
                    <a class="nav-link" href="<?= base_url('admin/perfil') ?>">
                        <span class="menu-icon"><i class="mdi mdi-account-circle"></i></span>
                        <span class="menu-title">Perfil</span>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- END SIDEBAR -->

        <!-- MAIN BODY WRAPPER -->
        <div class="container-fluid page-body-wrapper">

            <!-- TOP NAVBAR -->
            <nav class="navbar p-0 fixed-top d-flex flex-row">
                <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
                    <a class="navbar-brand brand-logo-mini" href="<?= site_url('dashboard') ?>">
                        <img src="<?= base_url('recursos_admin/images/logo.png') ?>" alt="logo" />
                    </a>
                </div>

                <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
                    <button class="navbar-toggler navbar-toggler align-self-center" type="button"
                        data-toggle="minimize">
                        <span class="mdi mdi-menu"></span>
                    </button>

                    <ul class="navbar-nav navbar-nav-right">
                        <li class="nav-item dropdown">
                            <a class="nav-link" id="profileDropdown" href="#" data-toggle="dropdown">
                                <div class="navbar-profile">
                                    <img class="img-xs rounded-circle" src="<?= $rutaFotoPerfil ?>"
                                        alt="Foto de perfil">
                                    <p class="mb-0 d-none d-sm-block navbar-profile-name"><?= $nombreCompleto ?></p>
                                    <i class="mdi mdi-menu-down d-none d-sm-block"></i>
                                </div>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                                aria-labelledby="profileDropdown">
                                <h6 class="p-3 mb-0">Perfil</h6>
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

                    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                        data-toggle="offcanvas">
                        <span class="mdi mdi-format-line-spacing"></span>
                    </button>
                </div>
            </nav>
            <!-- END TOP NAVBAR -->

            <!-- MAIN PANEL -->
            <div class="main-panel">
                <div class="content-wrapper">

                    <div class="page-header">
                        <h3 class="page-title">Reporte de filtrado en distribucion grafica</h3>
                    </div>

                    <div class="row">
                        <!-- LEFT COLUMN -->
                        <div class="col-lg-4">
                            <!-- CONFIGURACIÓN -->
                            <div class="card grid-margin">
                                <div class="card-body">
                                    <h4 class="card-title text-primary">1. Configuración</h4>

                                    <div class="form-group">
                                        <label>Encuesta Objetivo</label>
                                        <select class="form-control" id="id_encuesta">
                                            <option value="">Seleccione encuesta...</option>
                                            <?php foreach ($encuestas as $enc): ?>
                                                <option value="<?= $enc['id_encuesta'] ?>">
                                                    <?= $enc['titulo'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <h4 class="card-title text-primary mt-4">2. Criterios de Perfil</h4>
                                    <div id="contenedor_criterios"></div>

                                    <button type="button" class="btn btn-outline-info btn-block mt-2"
                                        id="btn_add_criterio" disabled>
                                        <i class="mdi mdi-plus"></i> Agregar Categoría
                                    </button>
                                </div>
                            </div>

                            <!-- GEOGRÁFICO -->
                            <div class="card grid-margin">
                                <div class="card-body">
                                    <h4 class="card-title text-info">3. Filtro Geográfico</h4>

                                    <div class="form-group">
                                        <label>Estado</label>
                                        <select class="form-control" id="id_estado">
                                            <option value="">Seleccione Estado</option>
                                            <?php foreach ($estados as $est): ?>
                                                <option value="<?= $est['id_estado'] ?>">
                                                    <?= $est['nombre_estado'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Distrito Federal</label>
                                        <select class="form-control" id="id_distritofederal" disabled>
                                            <option value="">Seleccione...</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Distrito Local</label>
                                        <select class="form-control" id="id_distritolocal" disabled>
                                            <option value="">Seleccione...</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Municipio</label>
                                        <select class="form-control" id="id_municipio" disabled>
                                            <option value="">Seleccione...</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Sección</label>
                                        <select class="form-control" id="id_seccion" disabled>
                                            <option value="">Seleccione...</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Comunidad</label>
                                        <select class="form-control" id="id_comunidad" disabled>
                                            <option value="">Seleccione...</option>
                                        </select>
                                    </div>

                                    <button class="btn btn-primary btn-block btn-lg mt-4" id="btn_procesar">
                                        <i class="mdi mdi-filter"></i> PROCESAR ANÁLISIS
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- END LEFT COLUMN -->

                        <!-- RIGHT COLUMN -->
                        <div class="col-lg-8">

                            <div class="card grid-margin" style="background: #191c24; border: 1px solid #2c2e33;">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-4 pb-2"
                                        style="border-bottom: 1px solid #2c2e33;">
                                        <h4 class="card-title mb-0" style="color: #0090e7;">Visualización de Resultados
                                        </h4>

                                        <div class="d-flex align-items-center">
                                            <div class="btn-group">
                                                <select
                                                    class="form-control-sm selector-tipo-maestro bg-dark text-white border-secondary"
                                                    id="selector_tipo_grafica">
                                                    <option value="bar_v" selected>Barras Verticales 3D</option>
                                                    <option value="velocimetro">Círculos Velocímetro</option>
                                                    <option value="anillo_3d">Anillo Moderno 3D</option>
                                                    <option value="puntos">Gráfica de Puntos Flotantes</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="dynamic-legend-container" class="mb-4 d-flex flex-wrap align-items-center"
                                        style="gap: 10px; min-height: 30px;">
                                        <small class="text-muted">Los selectores de color por perfil aparecerán aquí al
                                            procesar.</small>
                                    </div>

                                    <div id="loader" class="text-center p-5" style="display:none;">
                                        <div class="spinner-border text-primary"></div>
                                        <p class="mt-2 text-white">Calculando intersecciones...</p>
                                    </div>

                                    <div id="wrapper_grafica_scrollable"
                                        style="background: transparent !important; border: none; box-shadow: none;">

                                        <div class="chart-container" id="contenedor_grafica_principal"
                                            style="display:none; width: 100%;">
                                        </div>

                                    </div>
                                    <div id="no_data" class="text-center p-5">
                                        <i class="mdi mdi-database-off text-muted" style="font-size: 40px;"></i>
                                        <p class="text-muted mt-2">Ajuste los filtros en el panel izquierdo para generar
                                            el análisis.</p>
                                    </div>
                                </div>
                            </div>


                            <div class="card" id="seccion_mapa"
                                style="display:none; margin-top: 20px; border: 1px solid #2c2e33;">
                                <div class="card-body">
                                    <h4 class="card-title text-info">
                                        <i class="mdi mdi-map-marker-radius"></i> Geo-Localización del Perfil
                                    </h4>
                                    <div id="mapa_uniones"></div>
                                </div>
                            </div>

                            <button type="button" class="btn btn-success btn-lg btn-block mt-3"
                                id="btn_imprimir_reporte">
                                <i class="mdi mdi-printer"></i> GENERAR REPORTE
                            </button>


                            <div id="custom_colors_container" class="row mt-3 mb-3 justify-content-center"
                                style="display:none;">
                                <div class="col-12 text-center">
                                    <h6 class="text-white">Personalizar Colores de Barras</h6>
                                    <div id="color_pickers_wrapper"
                                        class="d-flex flex-wrap justify-content-center gap-2">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END RIGHT COLUMN -->
                    </div>

                </div>
            </div>
            <!-- END MAIN PANEL -->

        </div>
    </div>


    <script src="<?= base_url('recursos_admin/vendors/js/vendor.bundle.base.js') ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=<?= $google_maps_api_key ?>&libraries=visualization"></script>


    <?php
    $logoPath = FCPATH . 'public/img/logo.png';
    $logoData = base64_encode(file_get_contents($logoPath));
    $base64Logo = 'data:image/png;base64,' . $logoData;
    ?>
    <script>
        // 1. REGISTRO DE PLUGINS Y VARIABLES GLOBALES
        Chart.register(ChartDataLabels);

        let chartInstance = null;
        let currentChartType = 'bar';
        let lastChartData = null;
        let barColorsMap = {};
        let listaPreguntas = [];

        let map = null;
        let markers = [];
        let infoWindow = null;

        const PALETA_PRO = ['#4e79a7', '#f28e2b', '#e15759', '#76b7b2', '#59a14f', '#edc948', '#b07aa1'];

        $(document).ready(function () {
            initMap();
            cargarEstados();

            /* ==========================================
               2. GESTIÓN DE FILTROS
            ========================================== */
            $('#id_encuesta').change(function () {
                const id = $(this).val();
                if (!id) return $('#btn_add_criterio').prop('disabled', true);
                $.get(`<?= base_url('uniones/getPreguntas') ?>/${id}`, function (data) {
                    listaPreguntas = data;
                    $('#btn_add_criterio').prop('disabled', false);
                    $('#contenedor_criterios').empty();
                    agregarFilaCriterio();
                });
            });

            $('#btn_add_criterio').click(agregarFilaCriterio);

            function agregarFilaCriterio() {
                const uid = Date.now();
                let opts = listaPreguntas.map(p => `<option value="${p.id_pregunta}">${p.texto_pregunta}</option>`).join('');

                $('#contenedor_criterios').append(`
    <div class="criterio-row" id="row_${uid}" style="border: 1px solid #3e415b; padding: 15px; border-radius: 10px; margin-bottom: 10px; background: #191c24; position:relative;">
        <button class="btn btn-danger btn-sm" style="position:absolute; top:5px; right:5px;" onclick="$('#row_${uid}').remove()">×</button>
        
        <div class="form-group mb-2">
            <label class="small text-muted">Pregunta</label>
            <select class="form-control mb-2 select-pregunta" data-target="opciones_${uid}">
                <option value="">Seleccione...</option>
                ${opts}
            </select>
        </div>
        
        <div class="form-group mb-0">
            <label class="small text-muted">Seleccione una o varias opciones</label>
            
            <div id="opciones_${uid}" class="opciones-container form-control" style="min-height: 120px; max-height: 180px; overflow-y: auto; background: #2a2d3e; border: 1px solid #3e415b; padding: 10px; height: auto;">
                <span class="text-muted" style="font-size: 13px;">Seleccione una pregunta primero...</span>
            </div>
            
        </div>
    </div>`);
            }

            $(document).on('change', '.select-pregunta', function () {
                const idP = $(this).val();
                const target = $(this).data('target');

                // 1. Si regresan a "Seleccione...", limpiamos y mostramos el texto por defecto
                if (!idP) {
                    $(`#${target}`).html('<span class="text-muted" style="font-size: 13px;">Seleccione una pregunta primero...</span>');
                    return;
                }

                // 2. Mensaje temporal mientras carga de la base de datos
                $(`#${target}`).html('<span class="text-white" style="font-size: 13px;">Cargando opciones...</span>');

                // 3. Petición para traer las opciones
                $.get(`<?= base_url('uniones/getOpcionesPregunta') ?>/${idP}`, function (res) {

                    // CORRECCIÓN: Iterar para crear inputs tipo checkbox en lugar de <option>
                    const checkboxesHtml = res.map(o => `
            <div class="form-check" style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px; padding-left: 0;">
                <input class="check-opcion" type="checkbox" value="${o.id_opcion}" id="chk_${target}_${o.id_opcion}" style="cursor: pointer; width: 16px; height: 16px; margin: 0;">
                <label class="form-check-label text-white mb-0" style="cursor: pointer; width: 100%; font-size: 14px; user-select: none;" for="chk_${target}_${o.id_opcion}">
                    ${o.texto_opcion}
                </label>
            </div>
        `).join('');

                    // Inyectamos todo el bloque de checkboxes en el contenedor
                    $(`#${target}`).html(checkboxesHtml);
                });
            });

            /* ==========================================
               3. PROCESAMIENTO (BOTÓN PROCESAR)
            ========================================== */
            $('#btn_procesar').click(function () {
                let filtros = {};

                // 1. Recolección de criterios de perfil (con CHECKBOXES)
                $('.criterio-row').each(function () {
                    const idP = $(this).find('.select-pregunta').val();
                    let valO = [];

                    $(this).find('.check-opcion:checked').each(function () {
                        valO.push($(this).val());
                    });

                    if (idP && valO.length > 0) {
                        filtros[idP] = valO;
                    }
                });

                if (Object.keys(filtros).length === 0) {
                    alert("Por favor, seleccione al menos un criterio y marque una opción para el análisis.");
                    return;
                }

                $('#loader').show();
                $('.chart-container, #no_data, #seccion_mapa, #seccion_tabla_detalles, #dynamic-legend-container').hide();

                // 2. Mapeo geográfico
                let datosGeo = {
                    'id_estado': $('#id_estado').val() || '',
                    'id_distrito_federal': $('#id_distritofederal').val() || '',
                    'id_distrito_local': $('#id_distritolocal').val() || '',
                    'id_municipio': $('#id_municipio').val() || '',
                    'id_seccion': $('#id_seccion').val() || '',
                    'id_comunidad': $('#id_comunidad').val() || ''
                };

                // 3. Petición POST (Apunta a Cruces)
                $.post('<?= base_url('cruces/procesar') ?>', {
                    id_encuesta: $('#id_encuesta').val(),
                    filtros: filtros,
                    geo: datosGeo
                }, function (res) {
                    $('#loader').hide();

                    if (res.status === 'success') {
                        lastChartData = res;
                        window.datosGrafica = res;

                        // ── Guardar última opción marcada para el reporte ──────
                        window._ultimaOpcionReporte = "";
                        $('.criterio-row').each(function () {
                            $(this).find('.check-opcion:checked').each(function () {
                                const chkId = $(this).attr('id');
                                const txt = $(`label[for="${chkId}"]`).text().trim();
                                if (txt) window._ultimaOpcionReporte = txt;
                            });
                        });
                        // ───────────────────────────────────────────────────────

                        $('.chart-container, #seccion_mapa, #dynamic-legend-container, #seccion_tabla_detalles').show();

                        actualizarGrafica(res.desglose, res.resumen);

                        if (typeof generarSelectoresDeColor === 'function') generarSelectoresDeColor(res.desglose);
                        if (typeof actualizarMapa === 'function') actualizarMapa(res.puntos);
                        if (typeof actualizarTablaFiltros === 'function') actualizarTablaFiltros();

                    } else {
                        $('#no_data').show();
                        if (res.msg) console.error("Error del servidor: ", res.msg);
                    }

                }).fail(function (err) {
                    $('#loader').hide();
                    $('#no_data').show();
                    alert("Ocurrió un error al procesar los datos. Verifique su conexión.");
                    console.error("Error en POST:", err);
                });
            });


            $(document).on('change', '#selector_tipo_grafica', function () {
                currentChartType = $(this).val();
                if (lastChartData) actualizarGrafica(lastChartData.desglose, lastChartData.resumen);
            });

           // --- FUNCIÓN ACTUALIZAR GRAFICA (Mejor aprovechamiento de espacio) ---
            function actualizarGrafica(desgloseAgrupado, resumen) {
                const $contenedor = $('#contenedor_grafica_principal');

                // Limpiar instancias anteriores
                if (window.chartInstances && window.chartInstances.length > 0) {
                    window.chartInstances.forEach(chart => { if (chart) chart.destroy(); });
                }
                window.chartInstances = [];

                $contenedor.empty();
                $contenedor.css({
                    'display': 'flex', 'flex-wrap': 'wrap', 'gap': '20px',
                    'height': 'auto', 'min-width': '100%', 'padding': '10px 0'
                });

                $contenedor.parent().css({ 'overflow-y': 'auto', 'overflow-x': 'hidden' });

                // Tipo global elegido en el panel izquierdo
                let targetTypeGlobal = typeof currentChartType !== 'undefined' ? currentChartType : 'bar_v';
                const universoTotal = resumen.total_encuesta || 100;

                desgloseAgrupado.forEach((grupo, indexPregunta) => {
                    const opciones = grupo.opciones;
                    if (!opciones || opciones.length === 0) return;

                    // Memoria individual
                    let localTargetType = grupo.tipoElegido || targetTypeGlobal;

                    const numElementos = opciones.length;
                    const canvasId = `canvas_cruce_${indexPregunta}`;
                    const maxDataValue = Math.max(...opciones.map(d => Math.round(d.total))) || 1;

                    // Asignación de colores
                    const rawColors = opciones.map((d, i) => {
                        const key = d.perfil_corto || d.texto_opcion;
                        if (!barColorsMap[key]) barColorsMap[key] = PALETA_PRO[Object.keys(barColorsMap).length % PALETA_PRO.length];
                        return barColorsMap[key];
                    });

                    // ── ALTURA DINÁMICA MEJORADA ──
                    let alturaGrafica = 300;
                    if (localTargetType === 'velocimetro') {
                        const cols = Math.min(3, numElementos);
                        const rows = Math.ceil(numElementos / cols);
                        alturaGrafica = rows * 160; 
                    } else if (localTargetType === 'anillo_3d') {
                        // ¡AQUÍ ESTÁ LA MAGIA! Le damos 450px de altura para que la dona crezca
                        alturaGrafica = 450; 
                    } else if (localTargetType === 'puntos') {
                        alturaGrafica = 350;
                    }

                    // Creación de la tarjeta
                    $contenedor.append(`
                        <div class="grafica-tarjeta" style="flex: 1 1 calc(50% - 20px); min-width: 380px; background: #ffffff; padding: 20px; border-radius: 12px; border: 1px solid #d1d3e2; box-shadow: 0 4px 15px rgba(0,0,0,0.05); display: flex; flex-direction: column;">
                            
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; gap: 15px; border-bottom: 2px solid #f0f5f9; padding-bottom: 10px;">
                                <h4 style="color: #003366; margin: 0; font-weight: bold; font-size: 14px; text-transform: uppercase; flex: 1 1 0%; min-width: 0; word-wrap: break-word; line-height: 1.4; text-align: left;">
                                    ${grupo.pregunta}
                                </h4>
                                
                                <select class="form-control form-control-sm selector-individual-cruce" data-index="${indexPregunta}" style="width: 175px; flex-shrink: 0; background-color: #2a2c3d; color: #ffffff; border-color: #4a4a4a;">
                                    <option value="bar_v" ${localTargetType === 'bar_v' ? 'selected' : ''}>Barras Verticales 3D</option>
                                    <option value="velocimetro" ${localTargetType === 'velocimetro' ? 'selected' : ''}>Círculos Velocímetro</option>
                                    <option value="anillo_3d" ${localTargetType === 'anillo_3d' ? 'selected' : ''}>Anillo Moderno 3D</option>
                                    <option value="puntos" ${localTargetType === 'puntos' ? 'selected' : ''}>Puntos Flotantes</option>
                                </select>
                            </div>

                            <div style="position: relative; height: ${alturaGrafica}px; width: 100%;">
                                <canvas id="${canvasId}" style="width:100%; height:100%;"></canvas>
                            </div>
                        </div>
                    `);

                    const canvasEl = document.getElementById(canvasId);
                    const ctx = canvasEl.getContext('2d');

                    // Preparación de datos para Chart.js
                    const labelsGrafica = opciones.map(d => d.perfil_corto || d.texto_opcion);
                    const dataGrafica = opciones.map(d => Math.round(d.total));

                    // Funciones de color (Aclarar/Oscurecer)
                    const lightenColor = (hex, amt) => {
                        let r = parseInt(hex.slice(1, 3), 16), g = parseInt(hex.slice(3, 5), 16), b = parseInt(hex.slice(5, 7), 16);
                        r = Math.min(255, Math.max(0, Math.round(r * (100 + amt) / 100)));
                        g = Math.min(255, Math.max(0, Math.round(g * (100 + amt) / 100)));
                        b = Math.min(255, Math.max(0, Math.round(b * (100 + amt) / 100)));
                        return `rgb(${r},${g},${b})`;
                    };
                    const darkenColor = (hex, amt) => lightenColor(hex, -amt);

                    // ====================================================================
                    // 1. VELOCÍMETROS
                    // ====================================================================
                    if (localTargetType === 'velocimetro') {
                        const parent = canvasEl.parentElement;
                        const dpr = window.devicePixelRatio || 1;
                        const cssW = parent.offsetWidth || 400;
                        const cssH = parent.offsetHeight || alturaGrafica;

                        canvasEl.width = cssW * dpr;
                        canvasEl.height = cssH * dpr;
                        canvasEl.style.width = cssW + 'px';
                        canvasEl.style.height = cssH + 'px';

                        const c = ctx;
                        c.scale(dpr, dpr);

                        const cw = cssW, ch = cssH, total = opciones.length;
                        const cols = Math.min(4, total), rows = Math.ceil(total / cols);
                        const cellW = cw / cols, cellH = ch / rows, ballR = Math.min(cellW, cellH) * 0.38;

                        const hexRgba = (hex, a) => {
                            const r = parseInt(hex.slice(1, 3), 16), g = parseInt(hex.slice(3, 5), 16), b = parseInt(hex.slice(5, 7), 16);
                            return `rgba(${r},${g},${b},${a})`;
                        };

                        opciones.forEach((d, i) => {
                            const val = Math.round(d.total), pct = Math.min(100, (val / universoTotal) * 100), color = rawColors[i];
                            const col = i % cols, row = Math.floor(i / cols);
                            const cx = col * cellW + cellW / 2, cy = row * cellH + cellH / 2 - 10;
                            const fillRatio = pct / 100, liquidY = cy + ballR - fillRatio * ballR * 2, waveAmp = ballR * 0.06;

                            c.save(); c.beginPath(); c.arc(cx, cy, ballR, 0, Math.PI * 2); c.clip();
                            c.fillStyle = hexRgba(color, 0.15); c.fillRect(cx - ballR, cy - ballR, ballR * 2, ballR * 2);

                            const gradLiq = c.createLinearGradient(cx - ballR, liquidY, cx + ballR, liquidY);
                            gradLiq.addColorStop(0, lightenColor(color, 30)); gradLiq.addColorStop(0.5, color); gradLiq.addColorStop(1, darkenColor(color, 15));

                            c.beginPath(); c.moveTo(cx - ballR, cy + ballR); c.lineTo(cx - ballR, liquidY);
                            const steps = 40;
                            for (let s = 0; s <= steps; s++) c.lineTo(cx - ballR + (s / steps) * ballR * 2, liquidY + Math.sin((s / steps) * Math.PI * 3) * waveAmp);
                            c.lineTo(cx + ballR, cy + ballR); c.closePath(); c.fillStyle = gradLiq; c.fill();

                            c.beginPath(); c.moveTo(cx - ballR, liquidY);
                            for (let s = 0; s <= steps; s++) c.lineTo(cx - ballR + (s / steps) * ballR * 2, liquidY + Math.sin((s / steps) * Math.PI * 3) * waveAmp);
                            c.lineTo(cx + ballR, liquidY - waveAmp * 2); c.closePath();
                            const shineGrad = c.createLinearGradient(cx, liquidY - waveAmp * 3, cx, liquidY + waveAmp * 3);
                            shineGrad.addColorStop(0, 'rgba(255,255,255,0.35)'); shineGrad.addColorStop(1, 'rgba(255,255,255,0)');
                            c.fillStyle = shineGrad; c.fill(); c.restore();

                            c.save(); c.shadowColor = hexRgba(color, 0.4); c.shadowBlur = 18; c.shadowOffsetY = 6;
                            c.beginPath(); c.arc(cx, cy, ballR, 0, Math.PI * 2); c.strokeStyle = darkenColor(color, 10); c.lineWidth = 2; c.stroke(); c.restore();

                            c.save(); c.beginPath(); c.arc(cx, cy, ballR, 0, Math.PI * 2); c.clip();
                            const shineTop = c.createRadialGradient(cx - ballR * 0.3, cy - ballR * 0.35, 1, cx - ballR * 0.1, cy - ballR * 0.15, ballR * 0.65);
                            shineTop.addColorStop(0, 'rgba(255,255,255,0.55)'); shineTop.addColorStop(1, 'rgba(255,255,255,0)');
                            c.beginPath(); c.arc(cx, cy, ballR, 0, Math.PI * 2); c.fillStyle = shineTop; c.fill(); c.restore();

                            c.save(); c.textAlign = 'center'; c.textBaseline = 'middle'; c.shadowColor = 'rgba(0,0,0,0.4)'; c.shadowBlur = 4;
                            c.font = `bold ${Math.max(12, ballR * 0.30)}px sans-serif`; c.fillStyle = fillRatio > 0.4 ? '#ffffff' : darkenColor(color, 30);
                            c.fillText(`${pct.toFixed(1)}%`, cx, cy); c.restore();

                            c.save(); c.textAlign = 'center'; c.textBaseline = 'top';
                            const nombre = d.perfil_corto || d.texto_opcion || ''; let fs = Math.max(9, ballR * 0.22); c.font = `bold ${fs}px sans-serif`;
                            while (c.measureText(nombre).width > (cellW - 10) && fs > 7) { fs -= 0.5; c.font = `bold ${fs}px sans-serif`; }
                            c.fillStyle = '#333'; c.fillText(nombre, cx, cy + ballR + 8); c.restore();
                        });

                        window.chartInstances.push(null);
                        return;
                    }

                    // ====================================================================
                    // 2. ANILLO MODERNO 3D (Espacio Optimizado)
                    // ====================================================================
                 
                    if (localTargetType === 'anillo_3d') {
                        const nuevaGrafica = new Chart(ctx, {
                            type: 'doughnut',
                            data: {
                                labels: labelsGrafica,
                                datasets: [{
                                    data: dataGrafica,
                                    backgroundColor: rawColors,
                                    borderRadius: 12, spacing: 4, borderWidth: 3, borderColor: '#ffffff',
                                    hoverOffset: 10 // Reducido para que no brinque fuera del borde al pasar el mouse
                                }]
                            },
                            options: {
                                responsive: true, maintainAspectRatio: false,
                                cutout: '60%',
                                // MÁRGENES DE SEGURIDAD EN LOS 4 LADOS (Contiene las etiquetas)
                                layout: { padding: { top: 60, bottom: 120, left: 80, right: 80 } },
                                animation: { animateRotate: true, animateScale: true, duration: 1600, easing: 'easeOutExpo' },
                                plugins: {
                                    legend: { 
                                        display: true, position: 'bottom', 
                                        // PADDING 40 empuja la leyenda más abajo
                                        labels: { color: '#333', font: { size: 12, weight: '600' }, padding: 40, usePointStyle: true, pointStyle: 'circle', boxWidth: 10, boxHeight: 10 } 
                                    },
                                    tooltip: {
                                        backgroundColor: 'rgba(15,20,40,0.92)', titleColor: '#fff', bodyColor: '#ccc', padding: 14, cornerRadius: 10, borderColor: 'rgba(255,255,255,0.12)', borderWidth: 1,
                                        callbacks: { label: (ctx) => `  ${((ctx.raw / universoTotal) * 100).toFixed(1)}%` }
                                    },
                                    datalabels: { display: false } 
                                }
                            },
                            plugins: [
                                {
                                    id: 'gradientFill',
                                    beforeDatasetsDraw(chart) {
                                        const { ctx, chartArea } = chart; if (!chartArea) return;
                                        chart.data.datasets[0].backgroundColor = chart.data.labels.map((label, idx) => {
                                            const base = rawColors[idx];
                                            const grad = ctx.createLinearGradient(chartArea.left, chartArea.top, chartArea.right, chartArea.bottom);
                                            grad.addColorStop(0, lightenColor(base, 65)); grad.addColorStop(0.35, base);
                                            grad.addColorStop(0.75, darkenColor(base, 20)); grad.addColorStop(1, darkenColor(base, 50));
                                            return grad;
                                        });
                                    }
                                },
                                {
                                    id: 'shadow3D',
                                    beforeDatasetsDraw(chart) {
                                        const { ctx } = chart; ctx.save(); ctx.shadowColor = 'rgba(0,0,0,0.25)'; ctx.shadowBlur = 15; ctx.shadowOffsetX = 3; ctx.shadowOffsetY = 8;
                                    },
                                    afterDatasetsDraw(chart) { chart.ctx.restore(); }
                                },
                                {
                                    id: 'brilloAnillo',
                                    afterDatasetsDraw(chart) {
                                        const { ctx, chartArea } = chart; const meta = chart.getDatasetMeta(0);
                                        const cx = (chartArea.left + chartArea.right) / 2, cy = (chartArea.top + chartArea.bottom) / 2;
                                        meta.data.forEach((arc) => {
                                            const innerR = arc.innerRadius, outerR = arc.outerRadius, start = arc.startAngle, end = arc.endAngle;
                                            ctx.save(); ctx.beginPath(); ctx.arc(cx, cy, outerR, start, end); ctx.arc(cx, cy, outerR - (outerR - innerR) * 0.3, end, start, true);
                                            ctx.closePath(); ctx.fillStyle = 'rgba(255,255,255,0.15)'; ctx.fill(); ctx.restore();
                                            ctx.save(); ctx.beginPath(); ctx.arc(cx, cy, innerR + 1, start, end); ctx.strokeStyle = 'rgba(255,255,255,0.3)'; ctx.lineWidth = 2; ctx.stroke(); ctx.restore();
                                        });
                                    }
                                },
                                {
                                    id: 'banderillaAnillo3D',
                                    afterDatasetsDraw(chart) {
                                        const { ctx, chartArea } = chart; const meta = chart.getDatasetMeta(0);
                                        const cx = (chartArea.left + chartArea.right) / 2, cy = (chartArea.top + chartArea.bottom) / 2;
                                        const labels = [];
                                        meta.data.forEach((arc, i) => {
                                            const pct = universoTotal > 0 ? ((chart.data.datasets[0].data[i] / universoTotal) * 100) : 0;
                                            if (pct < 2) return;
                                            const color = rawColors[i], midAngle = (arc.startAngle + arc.endAngle) / 2, outerR = arc.outerRadius, isRight = Math.cos(midAngle) >= 0;
                                            
                                            // --- CORRECCIÓN: LÍNEAS MÁS CORTAS ---
                                            // Antes eran 50/35, ahora son 25/15. Así no escapan del canvas.
                                            const lineLen = pct < 5 ? 25 : 15; 
                                            const p2x = cx + Math.cos(midAngle) * (outerR + lineLen), p2y = cy + Math.sin(midAngle) * (outerR + lineLen);
                                            
                                            // Brazo horizontal más corto
                                            const horizLen = isRight ? 15 : -15; 

                                            // La línea nace casi pegada al anillo (outerR + 2)
                                            labels.push({ color, isRight, p1x: cx + Math.cos(midAngle) * (outerR + 2), p1y: cy + Math.sin(midAngle) * (outerR + 2), p2x, p2y, p3x: p2x + horizLen, p3y: p2y, label: `${pct.toFixed(1)}%` });
                                        });

                                        const resolver = (grupo) => {
                                            for (let iter = 0; iter < 15; iter++) {
                                                for (let i = 1; i < grupo.length; i++) {
                                                    const prev = grupo[i - 1], curr = grupo[i], diff = curr.p3y - prev.p3y;
                                                    if (diff < 20) { const adj = (20 - diff) / 2; prev.p3y -= adj; prev.p2y -= adj; curr.p3y += adj; curr.p2y += adj; }
                                                }
                                            }
                                        };
                                        const left = labels.filter(l => !l.isRight).sort((a, b) => a.p3y - b.p3y), right = labels.filter(l => l.isRight).sort((a, b) => a.p3y - b.p3y);
                                        resolver(left); resolver(right);

                                        [...left, ...right].forEach(({ color, isRight, p1x, p1y, p2x, p2y, p3x, p3y, label }) => {
                                            const textX = isRight ? p3x + 5 : p3x - 5, textAlign = isRight ? 'left' : 'right';
                                            ctx.save(); ctx.beginPath(); ctx.moveTo(p1x, p1y); ctx.lineTo(p2x, p2y); ctx.lineTo(p3x, p3y); ctx.strokeStyle = color; ctx.lineWidth = 1.5; ctx.stroke();
                                            ctx.font = 'bold 11px sans-serif'; const tw = ctx.measureText(label).width + 10, th = 18; const bgX = textAlign === 'left' ? textX - 2 : textX - tw + 2;
                                            ctx.fillStyle = 'rgba(255,255,255,0.96)'; ctx.beginPath(); ctx.roundRect(bgX, p3y - th / 2, tw, th, 4); ctx.fill();
                                            ctx.strokeStyle = color; ctx.lineWidth = 1; ctx.stroke();
                                            ctx.fillStyle = darkenColor(color, 30); ctx.textAlign = textAlign; ctx.textBaseline = 'middle'; ctx.fillText(label, textX, p3y); ctx.restore();
                                        });
                                    }
                                }
                            ]
                        });
                        window.chartInstances.push(nuevaGrafica);
                        return;
                    }
                
                    // ====================================================================
                    // 3. PUNTOS FLOTANTES (Fondo Fijo Dorado y Contornos Rojos)
                    // ====================================================================
                    
                    // ====================================================================
                    // ====================================================================
                    // 3. PUNTOS FLOTANTES (Fondo Transparente, Línea Fija y Sombra Grisosa)
                    // ====================================================================
                    if (localTargetType === 'puntos') {
                        // Color de la línea de conexión (Fijo y elegante, no se afecta por selectores)
                        const colorLineaFija = '#475569'; // Gris pizarra oscuro
                        // Color de los contornos de los círculos (Rojo fijo)
                        const colorContornoRojo = '#e32727'; 

                        const nuevaGrafica = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: labelsGrafica,
                                datasets: [{
                                    data: dataGrafica,
                                    
                                    // Línea principal
                                    borderColor: colorLineaFija, 
                                    borderWidth: 3,
                                    fill: false, // Fondo transparente (Sin relleno)
                                    
                                    // Diseño de Puntos (Círculos)
                                    pointBackgroundColor: '#ffffff', // Centro blanco
                                    pointBorderColor: colorContornoRojo, // Borde ROJO fijo
                                    pointBorderWidth: 4,
                                    pointRadius: 8, 
                                    pointHoverRadius: 12,
                                    pointHoverBackgroundColor: '#ffffff',
                                    pointHoverBorderColor: '#b91c1c', // Rojo más oscuro al pasar el mouse
                                    pointHoverBorderWidth: 4,
                                    
                                    showLine: true, 
                                    tension: 0.4 // Curva suave
                                }]
                            },
                            options: {
                                responsive: true, maintainAspectRatio: false,
                                layout: { padding: { top: 50, bottom: 20, left: 20, right: 20 } },
                                animation: {
                                    y: { duration: 2000, easing: 'easeOutElastic' }
                                },
                                plugins: {
                                    legend: { display: false }, 
                                    datalabels: {
                                        align: 'top', anchor: 'end', offset: 12, 
                                        color: '#1e293b', font: { weight: '800', size: 11 },
                                        backgroundColor: 'rgba(255,255,255,0.95)', 
                                        borderRadius: 6, 
                                        padding: {top: 4, bottom: 4, left: 8, right: 8},
                                        borderWidth: 1, borderColor: 'rgba(100, 116, 139, 0.2)',
                                        textShadowBlur: 0, textShadowColor: 'transparent',
                                        formatter: (val) => `${((val / universoTotal) * 100).toFixed(1)}%`
                                    }
                                },
                                scales: {
                                    x: { 
                                        grid: { display: true, color: 'rgba(200,200,200,0.15)', drawBorder: false }, 
                                        ticks: { font: { weight: 'bold', size: 11 }, color: '#64748b', padding: 10 } 
                                    },
                                    y: { 
                                        display: true, 
                                        grid: { display: true, color: 'rgba(200,200,200,0.2)', drawBorder: false, borderDash: [5, 5] },
                                        ticks: { display: false }, 
                                        beginAtZero: true, 
                                        max: Math.ceil(maxDataValue * 1.3)
                                    }
                                }
                            },
                            plugins: [ChartDataLabels, {
                                id: 'puntosShadowPremium',
                                beforeDatasetsDraw(chart) {
                                    const { ctx } = chart; 
                                    ctx.save(); 
                                    // Sombra "grisosa" proyectada por la línea
                                    ctx.shadowColor = 'rgba(71, 85, 105, 0.35)'; // Tono gris azulado oscuro transparente
                                    ctx.shadowBlur = 12; 
                                    ctx.shadowOffsetY = 6;
                                },
                                afterDatasetsDraw(chart) { chart.ctx.restore(); }
                            }]
                        });
                        window.chartInstances.push(nuevaGrafica);
                        return;
                    }
                    // ====================================================================
                    // 4. BARRAS VERTICALES 3D (Por defecto)
                    // ====================================================================
                    const nuevaGraficaBar = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labelsGrafica,
                            datasets: [{
                                data: dataGrafica, backgroundColor: 'rgba(0,0,0,0)', borderColor: 'rgba(0,0,0,0)', borderWidth: 0, barPercentage: 0.6, maxBarThickness: 45
                            }]
                        },
                        options: {
                            responsive: true, maintainAspectRatio: false, indexAxis: 'x',
                            layout: { padding: { top: 40, bottom: 10, left: 10, right: 10 } },
                            plugins: { legend: { display: false }, datalabels: { display: false } },
                            scales: {
                                x: { grid: { display: false }, border: { display: false }, ticks: { color: '#444', font: { size: 10, weight: 'bold' } } },
                                y: { display: false, beginAtZero: true, max: Math.ceil(maxDataValue * 1.45) }
                            }
                        },
                        plugins: [{
                            id: 'bar3DPluginReducido',
                            afterDatasetsDraw(chart) {
                                const { ctx, scales, chartArea } = chart; const meta = chart.getDatasetMeta(0); const yZero = scales.y.getPixelForValue(0); const depth = 8;
                                meta.data.forEach((bar, i) => {
                                    const color = rawColors[i % rawColors.length]; const bx = bar.x - bar.width / 2, yTop = bar.y, height = yZero - yTop;
                                    if (height <= 0) return;
                                    ctx.save(); const fullTop = chartArea.top + 5; ctx.fillStyle = 'rgba(200,205,215,0.4)';
                                    ctx.beginPath(); ctx.roundRect(bx, fullTop, bar.width, yZero - fullTop, [4, 4, 0, 0]); ctx.fill();
                                    const grad = ctx.createLinearGradient(bx, yTop, bx + bar.width, yTop);
                                    grad.addColorStop(0, lightenColor(color, 30)); grad.addColorStop(0.5, color); grad.addColorStop(1, darkenColor(color, 20));
                                    ctx.beginPath(); ctx.roundRect(bx, yTop, bar.width, height, [2, 2, 0, 0]); ctx.fillStyle = grad; ctx.fill();
                                    ctx.beginPath(); ctx.moveTo(bx, yTop); ctx.lineTo(bx + bar.width, yTop); ctx.lineTo(bx + bar.width + depth, yTop - depth * 0.6); ctx.lineTo(bx + depth, yTop - depth * 0.6); ctx.closePath(); ctx.fillStyle = lightenColor(color, 40); ctx.fill();
                                    ctx.beginPath(); ctx.moveTo(bx + bar.width, yTop); ctx.lineTo(bx + bar.width + depth, yTop - depth * 0.6); ctx.lineTo(bx + bar.width + depth, yZero - depth * 0.6); ctx.lineTo(bx + bar.width, yZero); ctx.closePath(); ctx.fillStyle = darkenColor(color, 20); ctx.fill();
                                    const valor = dataGrafica[i], pct = ((valor / universoTotal) * 100).toFixed(1);
                                    ctx.translate(bar.x, yTop - depth * 0.6 - 5); ctx.rotate(-Math.PI / 2); ctx.textAlign = 'left'; ctx.textBaseline = 'middle'; ctx.fillStyle = '#222'; ctx.font = 'bold 11px sans-serif'; ctx.fillText(`${valor} (${pct}%)`, 2, 0); ctx.restore();
                                });
                            }
                        }]
                    });
                    window.chartInstances.push(nuevaGraficaBar);
                });

                // ====================================================================
                // EVENTO DEL SELECTOR INDIVIDUAL
                // ====================================================================
                $('.selector-individual-cruce').off('change').on('change', function() {
                    const idx = $(this).data('index');
                    const newType = $(this).val();
                    desgloseAgrupado[idx].tipoElegido = newType;
                    actualizarGrafica(desgloseAgrupado, resumen);
                });
            }
            // Helper simple por si no existe en tu entorno
            function hexToRgba(hex, alpha) {
                let r = 0, g = 0, b = 0;
                if (hex.length == 4) {
                    r = "0x" + hex[1] + hex[1];
                    g = "0x" + hex[2] + hex[2];
                    b = "0x" + hex[3] + hex[3];
                } else if (hex.length == 7) {
                    r = "0x" + hex[1] + hex[2];
                    g = "0x" + hex[3] + hex[4];
                    b = "0x" + hex[5] + hex[6];
                }
                return "rgba(" + +r + "," + +g + "," + +b + "," + alpha + ")";
            }
            // --- FUNCIÓN FALTANTE 1: Selectores de color dinámicos ---
            function generarSelectoresDeColor(desgloseAgrupado) {
                const $container = $('#dynamic-legend-container').empty();

                // Usamos un Set para evitar dibujar cuadritos duplicados si se repiten opciones
                const agregados = new Set();

                // Iteramos primero por cada grupo (pregunta)
                desgloseAgrupado.forEach(grupo => {
                    // Luego iteramos por las opciones de esa pregunta
                    grupo.opciones.forEach((item) => {
                        const key = item.texto_completo || item.texto_opcion || item.perfil_corto;

                        if (!barColorsMap[key]) {
                            barColorsMap[key] = PALETA_PRO[Object.keys(barColorsMap).length % PALETA_PRO.length];
                        }

                        // Solo agregamos el selector si no existe ya
                        if (!agregados.has(key)) {
                            agregados.add(key);

                            // Diseño idéntico a tu captura: Columna con texto arriba y cajita ancha abajo
                            $container.append(`
                                <div style="display: flex; flex-direction: column; align-items: center; margin: 8px 12px;">
                                    <span style="color: #cdd4ea; font-size: 11px; margin-bottom: 5px;">${key}</span>
                                    <input type="color" class="individual-picker" data-key="${key}" value="${barColorsMap[key]}" 
                                           style="width: 50px; height: 26px; cursor: pointer; border: 1px solid #5a5f73; border-radius: 4px; background: transparent; padding: 0;">
                                </div>
                            `);
                        }
                    });
                });

                // Evento vinculado: Al cambiar el color, redibuja con los datos guardados
                $('.individual-picker').off('input change').on('input change', function () {
                    const newColor = $(this).val();
                    const key = $(this).data('key');
                    barColorsMap[key] = newColor;

                    if (window.chartInstances && window.chartInstances.length) {
                        window.chartInstances.forEach(chart => {
                            if (!chart) return;

                            chart.data.datasets.forEach(dataset => {
                                dataset.backgroundColor = chart.data.labels.map(label => {
                                    return barColorsMap[label] || '#ccc';
                                });
                            });

                            chart.update();
                        });
                    }
                });
            }
            // --- FUNCIÓN FALTANTE 2: Convertidor HEX a RGBA ---


            /* ==========================================
               5. FUNCIONES DE MAPA Y TABLA
            ========================================== */
            function initMap() {
                infoWindow = new google.maps.InfoWindow();
                map = new google.maps.Map(document.getElementById("mapa_uniones"), {
                    zoom: 5, center: { lat: 19.43, lng: -99.13 }, mapTypeId: 'hybrid', tilt: 45
                });
            }

            function actualizarMapa(puntos) {
                markers.forEach(m => m.setMap(null)); markers = [];
                if (!puntos) return;
                const bounds = new google.maps.LatLngBounds();
                puntos.forEach(p => {
                    if (p.latitud && p.longitud) {
                        const pos = { lat: parseFloat(p.latitud), lng: parseFloat(p.longitud) };
                        let marker = new google.maps.Marker({
                            position: pos, map: map, animation: google.maps.Animation.DROP,
                            icon: { path: google.maps.SymbolPath.BACKWARD_CLOSED_ARROW, scale: 8, fillColor: "#FF0000", fillOpacity: 1, strokeColor: "#FFFF00", strokeWeight: 2.5 }
                        });
                        marker.addListener("click", () => {
                            infoWindow.setContent(`<strong>Folio: #${p.referencias}</strong>`);
                            infoWindow.open(map, marker);
                        });
                        markers.push(marker);
                        bounds.extend(pos);
                    }
                });
                map.fitBounds(bounds);
            }

            // Variable del logo (usamos Base64 si es posible para evitar errores de carga)
            const rutaLogo = "<?= base_url('/public/img/logo.png') ?>";

            function inyectarMarcaAgua() {
                // Agregamos crossorigin para evitar bloqueos de seguridad
                return `<img src="${rutaLogo}" class="marca-agua" crossorigin="anonymous">`;
            }



            // ASISTENTE DE IMAGEN
            function obtenerImagenGraficaLimpia(grupo) {
                return new Promise((resolve) => {
                    const opciones = grupo.opciones;
                    const universoTotal = lastChartData.resumen.total_encuesta || 100;
                    const maxDataValue = Math.max(...opciones.map(d => Math.round(d.total))) || 1;
                    const PALETA = ['#4e79a7', '#f28e2b', '#e15759', '#76b7b2', '#59a14f', '#edc948', '#b07aa1'];

                    const rawColors = opciones.map((d, i) => {
                        const key = d.perfil_corto || d.texto_opcion;
                        return barColorsMap[key] || PALETA[i % PALETA.length];
                    });

                    const isVeloci = (typeof currentChartType !== 'undefined' && currentChartType === 'radial'); // Corregido a 'radial' según el selector actual

                    // Altura dinámica según número de elementos
                    const tempCanvas = document.createElement('canvas');
                    tempCanvas.width = 800;
                    tempCanvas.height = isVeloci
                        ? Math.ceil(opciones.length / 3) * 200 // Un poco más de espacio vertical para que no se corten
                        : 300;

                    const tempCtx = tempCanvas.getContext('2d');

                    // Fondo blanco
                    tempCtx.fillStyle = '#ffffff';
                    tempCtx.fillRect(0, 0, tempCanvas.width, tempCanvas.height);

                    if (isVeloci) {
                        // Forzamos un máximo de 3 columnas para que los círculos nunca se encojan
                        const cols = Math.min(3, opciones.length);
                        const rows = Math.ceil(opciones.length / cols);
                        const dpr = 3;

                        // TAMAÑOS ABSOLUTAMENTE FIJOS
                        const cellWidth = 800 / 3; // Dividimos el canvas (800) en 3 partes iguales fijas
                        const cellHeight = 200;    // Altura fija por fila
                        const ballR = 60;          // Radio del círculo estrictamente fijo

                        tempCanvas.width = 800 * dpr;
                        tempCanvas.height = rows * cellHeight * dpr;

                        const c = tempCanvas.getContext('2d');
                        c.fillStyle = '#ffffff';
                        c.fillRect(0, 0, tempCanvas.width, tempCanvas.height);
                        c.scale(dpr, dpr);

                        const lighten = (hex, amt) => {
                            let r = parseInt(hex.slice(1, 3), 16),
                                g = parseInt(hex.slice(3, 5), 16),
                                b = parseInt(hex.slice(5, 7), 16);
                            r = Math.min(255, Math.round(r * (100 + amt) / 100));
                            g = Math.min(255, Math.round(g * (100 + amt) / 100));
                            b = Math.min(255, Math.round(b * (100 + amt) / 100));
                            return `rgb(${r},${g},${b})`;
                        };
                        const darken = (hex, amt) => lighten(hex, -amt);
                        const hexRgba = (hex, a) => {
                            const r = parseInt(hex.slice(1, 3), 16),
                                g = parseInt(hex.slice(3, 5), 16),
                                b = parseInt(hex.slice(5, 7), 16);
                            return `rgba(${r},${g},${b},${a})`;
                        };

                        // Calcular el centro del bloque entero para centrar las filas que no estén llenas
                        const totalGridWidth = cols * cellWidth;
                        const startOffsetX = (800 - totalGridWidth) / 2;

                        opciones.forEach((d, i) => {
                            const val = Math.round(d.total);
                            // Lógica de llenado estricta: % real respecto al Universo Total
                            const pct = Math.min(100, (val / universoTotal) * 100);
                            const color = rawColors[i];

                            const col = i % cols;
                            const row = Math.floor(i / cols);

                            // Si estamos en la última fila y tiene menos de 'cols' elementos, la centramos
                            let rowItems = cols;
                            if (row === rows - 1) {
                                rowItems = opciones.length - (row * cols);
                            }
                            const rowWidth = rowItems * cellWidth;
                            const rowOffsetX = (800 - rowWidth) / 2;

                            const cx = rowOffsetX + (col * cellWidth) + (cellWidth / 2);
                            const cy = (row * cellHeight) + (cellHeight / 2) - 15; // -15 para dar espacio al texto abajo

                            // Llenado estrictamente lineal (0% = abajo, 100% = arriba)
                            const fillRatio = pct / 100;
                            const liquidY = cy + ballR - (fillRatio * ballR * 2);
                            const waveAmp = fillRatio === 0 || fillRatio === 1 ? 0 : ballR * 0.05; // Sin ola si está vacío o lleno
                            const steps = 40;

                            // Clip a la esfera
                            c.save();
                            c.beginPath();
                            c.arc(cx, cy, ballR, 0, Math.PI * 2);
                            c.clip();

                            // Fondo vacío
                            c.fillStyle = hexRgba(color, 0.15);
                            c.fillRect(cx - ballR, cy - ballR, ballR * 2, ballR * 2);

                            // Líquido con ola
                            if (fillRatio > 0) {
                                const gradLiq = c.createLinearGradient(cx - ballR, liquidY, cx + ballR, liquidY);
                                gradLiq.addColorStop(0, lighten(color, 30));
                                gradLiq.addColorStop(0.5, color);
                                gradLiq.addColorStop(1, darken(color, 15));

                                c.beginPath();
                                c.moveTo(cx - ballR, cy + ballR);
                                c.lineTo(cx - ballR, liquidY);
                                for (let s = 0; s <= steps; s++) {
                                    const wx = cx - ballR + (s / steps) * ballR * 2;
                                    const wy = liquidY + Math.sin((s / steps) * Math.PI * 3) * waveAmp;
                                    c.lineTo(wx, wy);
                                }
                                c.lineTo(cx + ballR, cy + ballR);
                                c.closePath();
                                c.fillStyle = gradLiq;
                                c.fill();

                                // Brillo en la ola
                                c.beginPath();
                                c.moveTo(cx - ballR, liquidY);
                                for (let s = 0; s <= steps; s++) {
                                    const wx = cx - ballR + (s / steps) * ballR * 2;
                                    const wy = liquidY + Math.sin((s / steps) * Math.PI * 3) * waveAmp;
                                    c.lineTo(wx, wy);
                                }
                                c.lineTo(cx + ballR, liquidY - waveAmp * 2);
                                c.closePath();
                                const shineWave = c.createLinearGradient(cx, liquidY - waveAmp * 3, cx, liquidY + waveAmp * 3);
                                shineWave.addColorStop(0, 'rgba(255,255,255,0.35)');
                                shineWave.addColorStop(1, 'rgba(255,255,255,0)');
                                c.fillStyle = shineWave;
                                c.fill();
                            }

                            c.restore();

                            // Borde esfera
                            c.save();
                            c.shadowColor = hexRgba(color, 0.3);
                            c.shadowBlur = 10;
                            c.shadowOffsetY = 4;
                            c.beginPath();
                            c.arc(cx, cy, ballR, 0, Math.PI * 2);
                            c.strokeStyle = darken(color, 10);
                            c.lineWidth = 2.5;
                            c.stroke();
                            c.restore();

                            // Brillo superior
                            c.save();
                            c.beginPath();
                            c.arc(cx, cy, ballR, 0, Math.PI * 2);
                            c.clip();
                            const shineTop = c.createRadialGradient(
                                cx - ballR * 0.3, cy - ballR * 0.35, 1,
                                cx - ballR * 0.1, cy - ballR * 0.15, ballR * 0.65
                            );
                            shineTop.addColorStop(0, 'rgba(255,255,255,0.55)');
                            shineTop.addColorStop(1, 'rgba(255,255,255,0)');
                            c.fillStyle = shineTop;
                            c.fill();
                            c.restore();

                            // Porcentaje y Valor (Texto dentro del círculo)
                            c.save();
                            c.textAlign = 'center';
                            c.textBaseline = 'middle';
                            c.shadowColor = 'rgba(0,0,0,0.5)';
                            c.shadowBlur = 3;

                            // Porcentaje grande
                            c.font = `bold 18px sans-serif`;
                            c.fillStyle = fillRatio > 0.4 ? '#ffffff' : darken(color, 40);
                            c.fillText(`${pct.toFixed(1)}%`, cx, cy - 4);

                            // Valor total pequeñito abajo
                            c.font = `normal 10px sans-serif`;
                            c.fillStyle = fillRatio > 0.4 ? 'rgba(255,255,255,0.9)' : darken(color, 20);
                            c.fillText(`${val} pers.`, cx, cy + 12);
                            c.restore();

                            // Nombre debajo de la esfera
                            c.save();
                            c.textAlign = 'center';
                            c.textBaseline = 'top';
                            const nombre = d.perfil_corto || d.texto_opcion || '';
                            const maxW = cellWidth - 20;
                            let fs = 12;
                            c.font = `bold ${fs}px sans-serif`;
                            while (c.measureText(nombre).width > maxW && fs > 8) {
                                fs--;
                                c.font = `bold ${fs}px sans-serif`;
                            }
                            c.fillStyle = '#333';
                            c.fillText(nombre, cx, cy + ballR + 12);
                            c.restore();
                        });

                        resolve(tempCanvas.toDataURL('image/png'));
                    } else {
                        const config = {
                            type: 'bar',
                            data: {
                                labels: opciones.map(d => d.perfil_corto || d.texto_opcion),
                                datasets: [{
                                    data: opciones.map(d => Math.round(d.total)),
                                    backgroundColor: 'rgba(0,0,0,0)',
                                    borderColor: 'rgba(0,0,0,0)',
                                    borderWidth: 0,
                                    barPercentage: 0.6,
                                    maxBarThickness: 60
                                }]
                            },
                            options: {
                                responsive: false,
                                animation: false,
                                indexAxis: 'x',
                                layout: { padding: { top: 40, bottom: 10, left: 10, right: 10 } },
                                plugins: { legend: { display: false }, datalabels: { display: false } },
                                scales: {
                                    x: { grid: { display: false }, border: { display: false }, ticks: { color: '#333', font: { size: 11, weight: 'bold' } } },
                                    y: { display: false, beginAtZero: true, max: Math.ceil(maxDataValue * 1.45) }
                                }
                            },
                            plugins: [ChartDataLabels, {
                                id: 'bar3DTemp',
                                afterDatasetsDraw(chart) {
                                    const { ctx, scales, chartArea } = chart;
                                    const meta = chart.getDatasetMeta(0);
                                    const yZero = scales.y.getPixelForValue(0);
                                    const depth = 10;

                                    const lighten = (hex, amt) => {
                                        let r = Math.min(255, Math.round(parseInt(hex.slice(1, 3), 16) * (100 + amt) / 100)),
                                            g = Math.min(255, Math.round(parseInt(hex.slice(3, 5), 16) * (100 + amt) / 100)),
                                            b = Math.min(255, Math.round(parseInt(hex.slice(5, 7), 16) * (100 + amt) / 100));
                                        return `rgb(${r},${g},${b})`;
                                    };
                                    const darken = (hex, amt) => lighten(hex, -amt);

                                    meta.data.forEach((bar, i) => {
                                        const color = rawColors[i % rawColors.length];
                                        const bx = bar.x - bar.width / 2;
                                        const yTop = bar.y;
                                        const height = yZero - yTop;
                                        if (height <= 0) return;

                                        ctx.save();
                                        const fullTop = chartArea.top + 5;

                                        ctx.fillStyle = 'rgba(200,205,215,0.4)';
                                        ctx.beginPath();
                                        ctx.roundRect(bx, fullTop, bar.width, yZero - fullTop, [4, 4, 0, 0]);
                                        ctx.fill();

                                        const grad = ctx.createLinearGradient(bx, yTop, bx + bar.width, yTop);
                                        grad.addColorStop(0, lighten(color, 30));
                                        grad.addColorStop(0.5, color);
                                        grad.addColorStop(1, darken(color, 20));
                                        ctx.beginPath();
                                        ctx.roundRect(bx, yTop, bar.width, height, [2, 2, 0, 0]);
                                        ctx.fillStyle = grad;
                                        ctx.fill();

                                        ctx.beginPath();
                                        ctx.moveTo(bx, yTop);
                                        ctx.lineTo(bx + bar.width, yTop);
                                        ctx.lineTo(bx + bar.width + depth, yTop - depth * 0.6);
                                        ctx.lineTo(bx + depth, yTop - depth * 0.6);
                                        ctx.closePath();
                                        ctx.fillStyle = lighten(color, 40);
                                        ctx.fill();

                                        ctx.beginPath();
                                        ctx.moveTo(bx + bar.width, yTop);
                                        ctx.lineTo(bx + bar.width + depth, yTop - depth * 0.6);
                                        ctx.lineTo(bx + bar.width + depth, yZero - depth * 0.6);
                                        ctx.lineTo(bx + bar.width, yZero);
                                        ctx.closePath();
                                        ctx.fillStyle = darken(color, 20);
                                        ctx.fill();

                                        const valor = Math.round(opciones[i]?.total || 0);
                                        const pct = ((valor / universoTotal) * 100).toFixed(1);
                                        ctx.translate(bar.x, yTop - depth * 0.6 - 5);
                                        ctx.rotate(-Math.PI / 2);
                                        ctx.textAlign = 'left';
                                        ctx.textBaseline = 'middle';
                                        ctx.fillStyle = '#222';
                                        ctx.font = 'bold 11px sans-serif';
                                        ctx.fillText(`${valor} (${pct}%)`, 2, 0);
                                        ctx.restore();
                                    });
                                }
                            }]
                        };

                        const tempChart = new Chart(tempCtx, config);
                        setTimeout(() => {
                            resolve(tempCanvas.toDataURL('image/png'));
                            tempChart.destroy();
                        }, 300);
                    }
                });
            }

            async function obtenerHtmlPagina1() {
                const obtenerTexto = (id, label) => {
                    const val = $(id).val();
                    const texto = $(id + " option:selected").text();
                    return (val && val !== "" && texto !== "Seleccione...") ? `<b>${label}:</b> ${texto}` : null;
                };

                const filtrosGeo = [
                    obtenerTexto('#id_estado', 'Edo'),
                    obtenerTexto('#id_distritofederal', 'Dtto. Fed'),
                    obtenerTexto('#id_distritolocal', 'Dtto. Loc'),
                    obtenerTexto('#id_municipio', 'Mpio'),
                    obtenerTexto('#id_seccion', 'Secc'),
                    obtenerTexto('#id_comunidad', 'Comunidad')
                ].filter(f => f !== null).join(' | ');

                // 🔥 Detectar la última pregunta seleccionada en los criterios de perfil
                let ultimaPreguntaTexto = '';
                $('.criterio-row').each(function () {
                    const textoPregunta = $(this).find('.select-pregunta option:selected').text().trim();
                    if (textoPregunta && textoPregunta !== 'Seleccione...') {
                        ultimaPreguntaTexto = textoPregunta;
                    }
                });

                // Fallback si no hay pregunta detectada
                const tituloPrincipal = ultimaPreguntaTexto
                    || (lastChartData?.resumen?.encuesta_nombre)
                    || 'Análisis de Datos';

                const subencabezadoDinamico =
                    (window._ultimaOpcionReporte && window._ultimaOpcionReporte !== '')
                        ? window._ultimaOpcionReporte
                        : (lastChartData && lastChartData.resumen.encuesta_nombre
                            ? lastChartData.resumen.encuesta_nombre
                            : "Análisis de Datos Vota y Opina");

                const grupos = lastChartData.desglose_agrupado || lastChartData.desglose || [];

                const tarjetas = grupos.map((grupo, i) => {
                    const canvas = document.getElementById(`canvas_cruce_${i}`);
                    const imgData = canvas ? canvas.toDataURL('image/png') : '';
                    return {
                        titulo: grupo.pregunta || '',
                        imgData: imgData
                    };
                });

                const POR_PAGINA = 8;
                const paginas = [];
                for (let p = 0; p < tarjetas.length; p += POR_PAGINA) {
                    paginas.push(tarjetas.slice(p, p + POR_PAGINA));
                }

                const encabezadoHtml = (completo) => completo ? `
        <div style="text-align:center; width:100%; margin-bottom:3mm;">
            <h1 style="color:#003366; margin:0; font-size:20px; text-transform:uppercase; letter-spacing:1px;">
                ${tituloPrincipal}
            </h1>
           
            <div style="padding:2px 8px; background:rgba(0,0,0,0.03); border-radius:4px; font-size:10px; color:#555; display:inline-block;">
                ${filtrosGeo || "<i>Análisis Global (Sin filtros geográficos)</i>"}
            </div>
        </div>` : `
        <div style="text-align:center; width:100%; margin-bottom:2mm;">
            <span style="color:#003366; font-size:12px; font-weight:bold; text-transform:uppercase;">
                ${tituloPrincipal} — ${subencabezadoDinamico}
            </span>
        </div>`;

                return paginas.map((grupo, p) => {
                    const filas = Math.ceil(grupo.length / 2);
                    const alturaImg = Math.floor(155 / filas);

                    const tarjetasHtml = grupo.map(({ titulo, imgData }) => `
            <div style="
                flex: 1 1 calc(50% - 4px);
                max-width: calc(50% - 4px);
                box-sizing: border-box;
                padding: 3px 4px 2px;
                display: flex;
                flex-direction: column;
                align-items: center;
            ">
                <div style="
                    color: #003366;
                    font-size: 10px;
                    font-weight: bold;
                    text-align: center;
                    text-transform: uppercase;
                    border-bottom: 1px solid #d1d3e2;
                    padding-bottom: 2px;
                    margin-bottom: 2px;
                    width: 100%;
                ">${titulo}</div>
                <img src="${imgData}" style="
                    width: 100%;
                    height: ${alturaImg}mm;
                    object-fit: contain;
                    object-position: center bottom;
                    image-rendering: crisp-edges;
                    display: block;
                ">
            </div>
        `).join('');

                    return `
<div class="pagina-reporte">
    ${inyectarMarcaAgua()}
    <div style="position:relative; z-index:10; width:96%; margin-top:4mm; display:flex; flex-direction:column; align-items:center;">
        ${encabezadoHtml(p === 0)}
        <div style="display:flex; flex-wrap:wrap; gap:4px; width:100%; align-content:flex-start;">
            ${tarjetasHtml}
        </div>
    </div>
</div>`;
                }).join('');
            }

            async function obtenerHtmlPagina3() {
                const centro = map.getCenter();
                const zoom = map.getZoom();

                let staticUrl = `https://maps.googleapis.com/maps/api/staticmap?center=${centro.lat()},${centro.lng()}&zoom=${zoom}&size=1200x600&maptype=hybrid&key=<?= $google_maps_api_key ?>`;

                if (typeof markers !== 'undefined' && markers.length > 0) {
                    markers.slice(0, 50).forEach(marker => {
                        const pos = marker.getPosition();
                        staticUrl += `&markers=color:red%7C${pos.lat()},${pos.lng()}`;
                    });
                }

                let mapaBase64 = '';
                try {
                    const response = await fetch(staticUrl);
                    const blob = await response.blob();
                    mapaBase64 = await new Promise((resolve) => {
                        const reader = new FileReader();
                        reader.onload = () => resolve(reader.result);
                        reader.readAsDataURL(blob);
                    });
                } catch (e) {
                    console.error('Error cargando mapa:', e);
                }

                const mapaHtml = mapaBase64
                    ? `<img src="${mapaBase64}" style="
            width: 100%;
            height: 160mm;
            object-fit: cover;
            border-radius: 10px;
            border: 2px solid #003366;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            display: block;
          ">`
                    : `<div style="text-align:center; padding:40px; color:#888; font-size:14px; border:1px dashed #ccc; border-radius:8px;">
               ⚠️ No se pudo cargar el mapa.
           </div>`;

                // Contar marcadores para el resumen
                const totalPuntos = (typeof markers !== 'undefined') ? markers.length : 0;

                return `
<div class="pagina-reporte">
    ${inyectarMarcaAgua()}
    <div style="position:relative; z-index:10; width:92%; margin-top:8mm; display:flex; flex-direction:column; align-items:center;">

        <!-- Encabezado -->
        <div style="width:100%; text-align:center; margin-bottom:5mm;">
            <h3 style="
                color: #003366;
                font-size: 20px;
                font-weight: bold;
                text-transform: uppercase;
                letter-spacing: 1px;
                margin: 0 0 4px 0;
            ">Distribución Geográfica</h3>
            <div style="
                display: inline-block;
                background: #003366;
                color: #fff;
                font-size: 11px;
                padding: 3px 12px;
                border-radius: 20px;
            ">
                ${totalPuntos} punto${totalPuntos !== 1 ? 's' : ''} registrado${totalPuntos !== 1 ? 's' : ''}
            </div>
            <div style="
                width: 100%;
                height: 2px;
                background: linear-gradient(to right, transparent, #003366, transparent);
                margin-top: 6px;
            "></div>
        </div>

        <!-- Mapa -->
        <div style="width:100%;">
            ${mapaHtml}
        </div>

    </div>
</div>`;
            }

            // VINCULACIÓN AL BOTÓN
            $('#btn_imprimir_reporte').off('click').on('click', async function () {
                if (!lastChartData) {
                    alert("Primero procese un análisis.");
                    return;
                }

                window.scrollTo(0, 0);

                // Ambas funciones son async ahora
                const paginasHtml = await obtenerHtmlPagina1();
                const paginaMapa = await obtenerHtmlPagina3();

                const container = document.createElement('div');
                container.innerHTML = (paginasHtml + paginaMapa).trim();

                const opt = {
                    margin: 0,
                    filename: 'Cruces_informacion.pdf',
                    image: { type: 'png', quality: 1 },
                    html2canvas: {
                        scale: 2,
                        useCORS: true,
                        letterRendering: true,
                        allowTaint: false
                    },
                    jsPDF: { unit: 'mm', format: 'a4', orientation: 'landscape' },
                    pagebreak: { mode: 'css' }
                };

                html2pdf().set(opt).from(container).save();
            });


            function cargarEstados() {
                $.get('<?= base_url('uniones/getEstados') ?>', res => $('#id_estado').html('<option value="">Seleccione Estado</option>' + res.map(e => `<option value="${e.id_estado}">${e.nombre_estado}</option>`).join('')));
            }

            function cargarHijo(url, $select, placeholder, hijosParaLimpiar = []) {
                $select.prop('disabled', false).html('<option value="">Cargando...</option>');
                hijosParaLimpiar.forEach(h => $(h).val('').prop('disabled', true).html('<option value="">Seleccione...</option>'));
                $.get(url, function (res) {
                    let html = `<option value="">${placeholder}</option>` + res.map(item => `<option value="${Object.values(item)[0]}">${Object.values(item)[1]}</option>`).join('');
                    $select.html(html);
                });
            }

            $('#id_estado').change(function () { cargarHijo(`<?= base_url('uniones/getDistritosFederales') ?>/${$(this).val()}`, $('#id_distritofederal'), 'Dtto. Federal', ['#id_distritolocal', '#id_municipio', '#id_seccion', '#id_comunidad']); });
            $('#id_distritofederal').change(function () { cargarHijo(`<?= base_url('uniones/getDistritosLocales') ?>/${$(this).val()}`, $('#id_distritolocal'), 'Dtto. Local', ['#id_municipio', '#id_seccion', '#id_comunidad']); });
            $('#id_distritolocal').change(function () { cargarHijo(`<?= base_url('uniones/getMunicipios') ?>/${$(this).val()}`, $('#id_municipio'), 'Municipio', ['#id_seccion', '#id_comunidad']); });
            $('#id_municipio').change(function () { cargarHijo(`<?= base_url('uniones/getSecciones') ?>/${$(this).val()}`, $('#id_seccion'), 'Sección', ['#id_comunidad']); });
            $('#id_seccion').change(function () { cargarHijo(`<?= base_url('uniones/getComunidades') ?>/${$(this).val()}`, $('#id_comunidad'), 'Comunidad'); });

            $('.btn-chart-type').click(function () {
                $('.btn-chart-type').removeClass('active');
                $(this).addClass('active');
                currentChartType = $(this).data('type');
                if (chartInstance) $('#btn_procesar').click();
            });
        });
    </script>
</body>

</html>