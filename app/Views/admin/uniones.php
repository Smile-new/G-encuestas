<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Uniones | Encuestas</title>
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
        #wrapper_grafica_scrollable {
            max-height: 650px;
            overflow-y: auto;
            overflow-x: hidden;
            /* CAMBIO PRINCIPAL: Fondo blanco */
            background: #ffffff !important;
            /* CAMBIO: Borde más claro para que combine con el fondo blanco */
            border: 1px solid #d1d3e2;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            /* Sombra suave opcional */
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
                                <h5 class="mb-0 font-weight-normal"><?= esc($nombreCompleto) ?></h5>
                                <span><?= esc($rolTexto) ?></span>
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
                        <h3 class="page-title">Análisis de Segmentación Dinámica (Mapa y Gráficas)</h3>
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
                                                    <option value="bar" selected>Barras Horizontales</option>
                                                    <option value="bar_v">Barras Verticales</option>
                                                    <option value="pie">Pastel</option>
                                                    <option value="doughnut">Dona</option>
                                                    <option value="line">Gráfica de Puntos / Línea</option>
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

                                    <div id="wrapper_grafica_scrollable">
                                        <div class="chart-container" id="contenedor_grafica_principal"
                                            style="display:none; position: relative;">
                                            <canvas id="canvasUniones"></canvas>
                                        </div>
                                    </div>

                                    <div id="no_data" class="text-center p-5">
                                        <i class="mdi mdi-database-off text-muted" style="font-size: 40px;"></i>
                                        <p class="text-muted mt-2">Ajuste los filtros en el panel izquierdo para generar
                                            el análisis.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="card" id="seccion_tabla_detalles"
                                style="display: none; background: #191c24; margin-top: 20px; border: 1px solid #2c2e33;">
                                <div class="card-body">
                                    <h4 class="card-title text-warning">Detalle de Filtros Aplicados</h4>
                                    <div class="table-responsive">
                                        <table class="table table-hover" style="color: #fff;">
                                            <thead>
                                                <tr>
                                                    <th>Categoría (Pregunta)</th>
                                                    <th>Opciones Seleccionadas</th>
                                                    <th class="text-center">Estado</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tabla_filtros_body">
                                            </tbody>
                                        </table>
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
                        <label class="small text-muted">Opciones (Ctrl + Click)</label>
                        <select class="form-control select-opcion" id="opciones_${uid}" multiple style="min-height: 100px; height: auto;"></select>
                    </div>
                </div>`);
            }

            $(document).on('change', '.select-pregunta', function () {
                const idP = $(this).val();
                const target = $(this).data('target');
                if (!idP) return $(`#${target}`).empty();
                $(`#${target}`).html('<option>Cargando...</option>');
                $.get(`<?= base_url('uniones/getOpcionesPregunta') ?>/${idP}`, function (res) {
                    $(`#${target}`).html(res.map(o => `<option value="${o.id_opcion}">${o.texto_opcion}</option>`).join(''));
                });
            });

            /* ==========================================
               3. PROCESAMIENTO (BOTÓN PROCESAR)
            ========================================== */
            $('#btn_procesar').click(function () {
                let filtros = {};
                $('.criterio-row').each(function () {
                    const idP = $(this).find('.select-pregunta').val();
                    const valO = $(this).find('.select-opcion').val();
                    if (idP && valO && valO.length > 0) filtros[idP] = valO;
                });

                if (Object.keys(filtros).length === 0) return alert("Seleccione criterios.");

                $('#loader').show();
                $('.chart-container, #no_data, #seccion_mapa, #seccion_tabla_detalles, #dynamic-legend-container').hide();

                $.post('<?= base_url('uniones/procesar') ?>', {
                    id_encuesta: $('#id_encuesta').val(),
                    filtros: filtros,
                    geo: {
                        id_estado: $('#id_estado').val(),
                        id_distritofederal: $('#id_distrito_federal').val(),
                        id_distritolocal: $('#id_distrito_local').val(),
                        id_municipio: $('#id_municipio').val(),
                        id_seccion: $('#id_seccion').val(),
                        id_comunidad: $('#id_comunidad').val()
                    }
                }, function (res) {
                    $('#loader').hide();

                    if (res.status === 'success') {

                        lastChartData = res;
                        window.datosGrafica = res; // 🔥🔥 ESTA LÍNEA ARREGLA TODO

                        $('.chart-container, #seccion_mapa, #dynamic-legend-container').show();
                        actualizarGrafica(res.desglose, res.resumen);
                        generarSelectoresDeColor(res.desglose);
                        actualizarMapa(res.puntos);
                        actualizarTablaFiltros();

                    } else {
                        $('#no_data').show();
                    }
                });
            });


            $(document).on('change', '#selector_tipo_grafica', function () {
                currentChartType = $(this).val();
                if (lastChartData) actualizarGrafica(lastChartData.desglose, lastChartData.resumen);
            });


            function actualizarGrafica(desglose, resumen) {

                const canvas = document.getElementById('canvasUniones');
                const ctx = canvas.getContext('2d');

                if (window.chartInstance) {
                    window.chartInstance.destroy();
                }
                ctx.clearRect(0, 0, canvas.width, canvas.height);

                let targetType = typeof currentChartType !== 'undefined' ? currentChartType : 'bar';
                let indexAxis = (targetType === 'bar_v' || targetType === 'line') ? 'x' : 'y';

                if (targetType === 'bar_v' || targetType === 'line') {
                    targetType = (targetType === 'line') ? 'line' : 'bar';
                }

                const isCircular = ['pie', 'doughnut'].includes(targetType);
                const isLine = targetType === 'line';
                const numElementos = desglose.length;

                const $contenedor = $('#contenedor_grafica_principal');

                // Ajuste de altura dinámica
                const alturaBase = !isCircular && indexAxis === 'y'
                    ? Math.max(600, (numElementos * 50) + 100)
                    : 650;

                $contenedor.css('height', alturaBase + 'px');

                const totalPersonas = resumen.coincidencias ||
                    desglose.reduce((sum, d) => sum + parseInt(d.total), 0);

                // --- 1. LÓGICA DE COLORES CORREGIDA ---
                // Ahora usa barColorsMap y PALETA_PRO para sincronizarse con los inputs de color
                const rawColors = desglose.map((d, i) => {
                    const key = d.texto_completo || d.texto_opcion;

                    // Si ya existe un color seleccionado/guardado, úsalo
                    if (barColorsMap[key]) {
                        return barColorsMap[key];
                    } else {
                        // Si no, asigna uno de PALETA_PRO y guárdalo para que el input nazca con este color
                        const colorAsignado = PALETA_PRO[i % PALETA_PRO.length];
                        barColorsMap[key] = colorAsignado;
                        return colorAsignado;
                    }
                });

                // --- Patrones ---
                const createPattern = (color) => {
                    const pc = document.createElement('canvas');
                    pc.width = 14;
                    pc.height = 14;
                    const pctx = pc.getContext('2d');
                    pctx.fillStyle = color;
                    pctx.fillRect(0, 0, 14, 14);
                    pctx.strokeStyle = 'rgba(255,255,255,0.35)';
                    pctx.lineWidth = 2;
                    pctx.beginPath();
                    pctx.moveTo(0, 14);
                    pctx.lineTo(14, 0);
                    pctx.stroke();
                    return ctx.createPattern(pc, 'repeat');
                };

                // --- Estilos Visuales ---
                let finalBackground;
                if (isLine) {
                    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
                    gradient.addColorStop(0, 'rgba(220, 53, 69, 0.6)');
                    gradient.addColorStop(1, 'rgba(220, 53, 69, 0.05)');
                    finalBackground = gradient;
                } else {
                    finalBackground = rawColors.map(c => createPattern(c));
                }

                const borderColor = isLine ? '#dc3545' : '#ffffff';
                const pointBgColor = isLine ? '#ffffff' : undefined;
                const pointBorderColor = isLine ? '#dc3545' : undefined;

                const superDetailPlugin = {
                    id: 'superDetail',
                    beforeDatasetDraw(chart) {
                        const { ctx } = chart;
                        ctx.save();
                        ctx.shadowColor = 'rgba(0,0,0,0.25)';
                        ctx.shadowBlur = 10;
                        ctx.shadowOffsetX = 4;
                        ctx.shadowOffsetY = 4;
                    },
                    afterDatasetDraw(chart) {
                        chart.ctx.restore();
                    }
                };

                window.chartInstance = new Chart(ctx, {
                    type: targetType,
                    data: {
                        labels: desglose.map(d => d.perfil_corto),
                        datasets: [{
                            data: desglose.map(d => Math.round(d.total)),
                            backgroundColor: finalBackground,
                            borderColor: borderColor,
                            borderWidth: isCircular ? 6 : (isLine ? 3 : 4),
                            borderRadius: isCircular ? 0 : 22,
                            borderSkipped: false,
                            spacing: isCircular ? 8 : 0,

                            pointRadius: isLine ? 6 : 0,
                            pointHoverRadius: isLine ? 8 : 0,
                            pointBackgroundColor: pointBgColor,
                            pointBorderColor: pointBorderColor,
                            pointBorderWidth: 3,

                            tension: 0.4,
                            fill: isLine,
                            barThickness: isCircular ? null : (indexAxis === 'y' ? 25 : (numElementos > 15 ? 22 : 48)),
                            hoverOffset: 15
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        indexAxis: indexAxis,

                        layout: {
                            padding: {
                                top: 60,
                                bottom: isCircular ? 140 : 60,
                                left: 20,
                                right: 80
                            }
                        },

                        plugins: {
                            datalabels: {
                                color: '#000',
                                font: { weight: 'bold', size: 13 },
                                // Rotación: 0 si es horizontal, -90 si es vertical/circular
                                rotation: indexAxis === 'y' ? 0 : -90,
                                anchor: isCircular ? 'end' : 'end',
                                align: isCircular ? 'end' : (indexAxis === 'y' ? 'right' : 'end'),
                                offset: isCircular ? 4 : 8,
                                display: true,
                                formatter: (value) => {
                                    const pct = ((value / totalPersonas) * 100).toFixed(1);
                                    return `${pct}%`;
                                },
                                textStrokeColor: '#fff',
                                textStrokeWidth: 4
                            },
                            legend: {
                                display: isCircular,
                                position: 'bottom',
                                labels: { padding: 30, usePointStyle: true }
                            }
                        },

                        scales: {
                            x: {
                                display: !isCircular,
                                grid: { display: false, drawBorder: false },
                                grace: '15%',
                                ticks: {
                                    display: indexAxis === 'x',
                                    autoSkip: false,
                                    minRotation: 90,
                                    maxRotation: 90,
                                    font: { weight: 'bold' }
                                }
                            },
                            y: {
                                display: !isCircular,
                                grid: { display: false, drawBorder: false },
                                grace: '15%',
                                ticks: {
                                    display: indexAxis === 'y',
                                    autoSkip: false,
                                    minRotation: 0,
                                    maxRotation: 0,
                                    font: { weight: 'bold' },
                                    crossAlign: 'near'
                                },
                                afterFit: function (scaleInstance) {
                                    if (indexAxis === 'y') {
                                        scaleInstance.width = 160;
                                    }
                                }
                            }
                        },

                        cutout: targetType === 'doughnut' ? '50%' : 0
                    },
                    plugins: [ChartDataLabels, superDetailPlugin]
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
            function generarSelectoresDeColor(desglose) {
                const $container = $('#dynamic-legend-container').empty();

                desglose.forEach((item, index) => {
                    const key = item.texto_completo || item.texto_opcion;
                    if (!barColorsMap[key]) barColorsMap[key] = PALETA_PRO[index % PALETA_PRO.length];

                    $container.append(`
            <div class="d-flex align-items-center bg-dark p-1 rounded border border-secondary" style="gap: 5px; margin-bottom: 5px;">
                <input type="color" class="individual-picker" data-key="${key}" value="${barColorsMap[key]}" style="border:none; width:20px; height:20px; cursor:pointer; background:none;">
                <span class="text-white" style="font-size: 10px;">${item.total} pers.</span>
            </div>`);
                });

                $('.individual-picker').on('input change', function () {
                    const newColor = $(this).val();
                    barColorsMap[$(this).data('key')] = newColor;

                    // Redibujamos la gráfica con el nuevo color
                    if (lastChartData) {
                        actualizarGrafica(lastChartData.desglose, lastChartData.resumen);
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



            // ASISTENTE DE IMAGEN
            /**
 * PÁGINA 1: Genera el HTML para la Gráfica con tamaño controlado
 */
            function obtenerImagenGrafica(idCanvas) {
                const chart = window.chartInstance;
                if (!chart) return '';

                // 1. APLICAR ESTILO NEGRO CON BORDE BLANCO PARA EL PDF
                chart.options.plugins.datalabels.color = '#000000'; // Letra Negra
                chart.options.plugins.datalabels.textStrokeColor = '#ffffff'; // Borde Blanco
                chart.options.plugins.datalabels.textStrokeWidth = 3; // Grosor del borde

                // Cambiar también los ejes y leyenda a negro para el fondo blanco del PDF
                if (chart.options.scales.x) chart.options.scales.x.ticks.color = '#000000';
                if (chart.options.scales.y) chart.options.scales.y.ticks.color = '#000000';
                if (chart.options.plugins.legend) chart.options.plugins.legend.labels.color = '#000000';

                chart.update({ duration: 0 }); // Actualizar sin animaciones

                // 2. CAPTURAR EN EL LIENZO TEMPORAL
                const canvas = document.getElementById(idCanvas);
                const tempCanvas = document.createElement('canvas');
                tempCanvas.width = canvas.width;
                tempCanvas.height = canvas.height;
                const tempCtx = tempCanvas.getContext('2d');

                tempCtx.fillStyle = '#ffffff';
                tempCtx.fillRect(0, 0, tempCanvas.width, tempCanvas.height);
                tempCtx.drawImage(canvas, 0, 0);
                const imgData = tempCanvas.toDataURL('image/jpeg', 1.0);

                // 3. REGRESAR TODO A BLANCO PARA EL DASHBOARD OSCURO
                chart.options.plugins.datalabels.color = '#ffffff';
                chart.options.plugins.datalabels.textStrokeColor = 'transparent';
                chart.options.plugins.datalabels.textStrokeWidth = 0;

                if (chart.options.scales.x) chart.options.scales.x.ticks.color = '#ffffff';
                if (chart.options.scales.y) chart.options.scales.y.ticks.color = '#ffffff';
                if (chart.options.plugins.legend) chart.options.plugins.legend.labels.color = '#ffffff';

                chart.update({ duration: 0 });

                return imgData;
            }


            // Variable del logo (usamos Base64 si es posible para evitar errores de carga)
            const rutaLogo = "<?= base_url('/public/img/logo.png') ?>";

            function inyectarMarcaAgua() {
                // Agregamos crossorigin para evitar bloqueos de seguridad
                return `<img src="${rutaLogo}" class="marca-agua" crossorigin="anonymous">`;
            }


            /**
             * PÁGINA 1: Portada con Títulos, Filtros Geográficos y Barra de Resumen (Cápsula)
             */
            function obtenerHtmlPagina1() {
                const imgData = obtenerImagenGrafica('canvasUniones');

                // 1. Extraer los nombres de los filtros geográficos seleccionados
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

                // 2. Extraer datos de la encuesta y totales
                const nombreEncuesta = (lastChartData && lastChartData.resumen.encuesta_nombre)
                    ? lastChartData.resumen.encuesta_nombre
                    : "Análisis de Datos Vota y Opina";

                const totalRegistros = (lastChartData && lastChartData.resumen.coincidencias)
                    ? lastChartData.resumen.coincidencias
                    : 0;

                return `<div class="pagina-reporte">${inyectarMarcaAgua()}<div class="contenido-superior"><div style="text-align: center; width: 100%; margin-bottom: 5mm;"><h1 style="color: #003366; margin: 0; font-size: 30px; text-transform: uppercase;">Reporte de Uniones</h1><h2 style="color: #444; margin: 5px 0; font-size: 18px; font-weight: normal;">${nombreEncuesta}</h2><div style="margin-top: 5px; padding: 5px; background-color: rgba(0,0,0,0.03); border-radius: 5px; font-size: 13px; color: #333;">${filtrosGeo || "<i>Análisis Global (Sin filtros geográficos)</i>"}</div></div><div style="width: 100%; display: flex; align-items: center; justify-content: space-around; background-color: #f0f5f9; border: 1.5px solid #003366; border-radius: 15px; padding: 12px 0; margin-bottom: 15px;"><div style="text-align: center; flex: 1;"><span style="display: block; font-size: 11px; color: #003366; font-weight: bold; text-transform: uppercase;">TOTAL DE REGISTROS</span><span style="font-size: 22px; font-weight: bold; color: #000;">${totalRegistros}</span></div><div style="text-align: center; flex: 1; border-left: 1.5px solid #003366; border-right: 1.5px solid #003366;"><span style="display: block; font-size: 11px; color: #003366; font-weight: bold; text-transform: uppercase;">PUNTOS GEOGRÁFICOS</span><span style="font-size: 22px; font-weight: bold; color: #000;">${markers.length} Puntos</span></div><div style="text-align: center; flex: 1;"><span style="display: block; font-size: 11px; color: #003366; font-weight: bold; text-transform: uppercase;">FECHA</span><span style="font-size: 22px; font-weight: bold; color: #000;">${new Date().toLocaleDateString()}</span></div></div><div class="contenedor-grafica-full" style="width: 80%; display: flex; justify-content: center; align-items: center; flex-grow: 1;"><img src="${imgData}" class="grafica-img-full" style="width: 80%; max-height: 470px; object-fit: contain;"></div></div></div>`;
            }


            function obtenerHtmlPagina3() {
                const centro = map.getCenter();
                const zoom = map.getZoom();
                let staticUrl = `https://maps.googleapis.com/maps/api/staticmap?center=${centro.lat()},${centro.lng()}&zoom=${zoom}&size=1000x385&maptype=hybrid&key=<?= $google_maps_api_key ?>`;

                if (typeof markers !== 'undefined' && markers.length > 0) {
                    markers.slice(0, 50).forEach(marker => {
                        const pos = marker.getPosition();
                        staticUrl += `&markers=color:red%7C${pos.lat()},${pos.lng()}`;
                    });
                }

                return `<div class="pagina-reporte">${inyectarMarcaAgua()}<div class="contenido-superior"><h3 style="color: #003366; font-size: 24px; border-bottom: 3px solid #003366; padding-bottom: 10px; width: 100%; text-align: center;">3. Distribución Geográfica</h3><img src="${staticUrl}" class="mapa-img"></div></div>`;
            }

            // VINCULACIÓN AL BOTÓN
            $('#btn_imprimir_reporte').off('click').on('click', function () {
                if (!lastChartData) {
                    alert("Primero procese un análisis.");
                    return;
                }

                window.scrollTo(0, 0);

                const container = document.createElement('div');
                // Concatenamos y aplicamos .trim() para asegurar que no hay espacios al inicio
                container.innerHTML = (obtenerHtmlPagina1() + obtenerHtmlPagina3()).trim();

                const opt = {
                    margin: 0,
                    filename: 'Reporte_VotayOpina.pdf',
                    image: { type: 'jpeg', quality: 1 },
                    html2canvas: {
                        scale: 2,
                        useCORS: true,
                        letterRendering: true
                    },
                    jsPDF: { unit: 'mm', format: 'a4', orientation: 'landscape' },
                    // CAMBIO: Usamos modo 'css' para que respete el page-break-after de tu clase
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