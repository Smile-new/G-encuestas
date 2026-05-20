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
                        <h3 class="page-title">Reporte tecnico de filtrado</h3>
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
                                                    <option value="bar" selected>Lineas</option>
                                                    <option value="bar_v">Barras Verticales</option>
                                                    
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

                // 3. Petición POST
                $.post('<?= base_url('uniones/procesar') ?>', {
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

                const isLine = targetType === 'line';
                const isVertical = indexAxis === 'x';
                const isHorizontal = indexAxis === 'y' && !isLine;
                const numElementos = desglose.length;
                const $contenedor = $('#contenedor_grafica_principal');

                // Siempre limpiar scroll al cambiar gráfica
                $contenedor.css('min-width', '');
                $contenedor.css('width', '100%');
                $contenedor.parent().css('overflow-x', 'hidden');
                $contenedor.parent().css('overflow-y', 'hidden');

                const universoTotal = resumen.total_encuesta || 100;
                const maxDataValue = Math.max(...desglose.map(d => Math.round(d.total)));

                const rawColors = desglose.map((d, i) => {
                    const key = d.texto_completo || d.texto_opcion || d.perfil_corto;
                    if (barColorsMap[key]) return barColorsMap[key];
                    const colorAsignado = PALETA_PRO[i % PALETA_PRO.length];
                    barColorsMap[key] = colorAsignado;
                    return colorAsignado;
                });

                const createPattern = (color) => {
                    const pc = document.createElement('canvas');
                    pc.width = 12; pc.height = 12;
                    const pctx = pc.getContext('2d');
                    pctx.fillStyle = color;
                    pctx.fillRect(0, 0, 12, 12);
                    pctx.strokeStyle = 'rgba(255,255,255,0.2)';
                    pctx.lineWidth = 1;
                    pctx.beginPath();
                    pctx.moveTo(0, 12); pctx.lineTo(12, 0);
                    pctx.stroke();
                    return ctx.createPattern(pc, 'repeat');
                };

               

                // ── GRÁFICA DE LÍNEAS ─────────────────────────────────────────────────────
                if (isHorizontal) {

                    // ── Calculamos el ancho real máximo de las etiquetas ──
                    const tempCanvas = document.createElement('canvas');
                    const tempCtx = tempCanvas.getContext('2d');
                    tempCtx.font = 'bold 11px sans-serif';
                    const maxLabelPx = Math.max(
                        ...desglose.map(d => tempCtx.measureText(d.perfil_corto || d.texto_opcion || '').width)
                    );

                    // Con 45° la proyección vertical es width * sin(45°) ≈ width * 0.707
                    const espacioAbajo = Math.ceil(maxLabelPx * 0.707) + 40;
                    const alturaLinea = espacioAbajo + 340;

                    $contenedor.css('height', alturaLinea + 'px');

                    window.chartInstance = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: desglose.map(d => d.perfil_corto || d.texto_opcion),
                            datasets: [{
                                data: desglose.map(d => Math.round(d.total)),
                                borderColor: 'rgba(78,121,167,1)',
                                backgroundColor: (context) => {
                                    const chart = context.chart;
                                    const { ctx: c, chartArea } = chart;
                                    if (!chartArea) return 'transparent';
                                    const grad = c.createLinearGradient(0, chartArea.top, 0, chartArea.bottom);
                                    grad.addColorStop(0, 'rgba(78,121,167,0.55)');
                                    grad.addColorStop(0.6, 'rgba(78,121,167,0.15)');
                                    grad.addColorStop(1, 'rgba(78,121,167,0.02)');
                                    return grad;
                                },
                                borderWidth: 3,
                                pointRadius: 8,
                                pointBackgroundColor: rawColors,
                                pointBorderColor: '#fff',
                                pointBorderWidth: 3,
                                pointHoverRadius: 12,
                                pointHoverBorderWidth: 3,
                                pointStyle: 'circle',
                                tension: 0.4,
                                fill: true
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            layout: {
                                padding: { top: 70, bottom: espacioAbajo, left: 40, right: 40 }
                            },
                            plugins: {
                                legend: { display: false },
                                datalabels: { display: false }
                            },
                            scales: {
                                x: {
                                    grid: { display: false },
                                    border: { display: false },
                                    ticks: { display: false },
                                    offset: true
                                },
                                y: {
                                    display: false,
                                    beginAtZero: true,
                                    max: Math.ceil(maxDataValue * 1.35)
                                }
                            }
                        },
                        plugins: [ChartDataLabels, {
                            id: 'linea3DCustom',

                            afterDatasetsDraw(chart) {
                                const { ctx: c } = chart;
                                const meta = chart.getDatasetMeta(0);

                                desglose.forEach((d, i) => {
                                    const val = Math.round(d.total);
                                    const pct = ((val / universoTotal) * 100).toFixed(1);
                                    const punto = meta.data[i];
                                    const x = punto.x;
                                    const y = punto.y;
                                    const color = rawColors[i] || '#4e79a7';

                                    // ── Sombra del punto (efecto 3D) ──
                                    c.save();
                                    c.beginPath();
                                    c.arc(x + 3, y + 5, 10, 0, Math.PI * 2);
                                    c.fillStyle = 'rgba(0,0,0,0.15)';
                                    c.fill();
                                    c.restore();

                                    // ── Punto exterior con brillo ──
                                    c.save();
                                    const gradPunto = c.createRadialGradient(x - 3, y - 3, 1, x, y, 10);
                                    gradPunto.addColorStop(0, '#ffffff');
                                    gradPunto.addColorStop(0.4, color);
                                    gradPunto.addColorStop(1, shadeColor(color, -40));
                                    c.beginPath();
                                    c.arc(x, y, 10, 0, Math.PI * 2);
                                    c.fillStyle = gradPunto;
                                    c.fill();
                                    c.strokeStyle = '#fff';
                                    c.lineWidth = 2.5;
                                    c.stroke();
                                    c.restore();

                                    // ── Línea vertical desde el punto hacia arriba ──
                                    c.save();
                                    c.beginPath();
                                    c.setLineDash([4, 3]);
                                    c.moveTo(x, y - 12);
                                    c.lineTo(x, y - 52);
                                    c.strokeStyle = color;
                                    c.lineWidth = 1.5;
                                    c.globalAlpha = 0.5;
                                    c.stroke();
                                    c.restore();

                                    // ── Caja del porcentaje con fondo y borde de color ──
                                    c.save();
                                    c.translate(x, y - 55);
                                    c.rotate(-Math.PI / 2); // 90 grados

                                    const texto = `${val}  (${pct}%)`;
                                    c.font = 'bold 11px sans-serif';
                                    const tw = c.measureText(texto).width;
                                    const boxW = tw + 14;
                                    const boxH = 20;

                                    // Sombra de la caja
                                    c.shadowColor = 'rgba(0,0,0,0.2)';
                                    c.shadowBlur = 6;
                                    c.shadowOffsetX = 2;
                                    c.shadowOffsetY = 2;

                                    // Fondo de la caja
                                    c.fillStyle = color;
                                    roundRect(c, -boxW / 2, -boxH / 2, boxW, boxH, 5);
                                    c.fill();

                                    // Borde blanco
                                    c.shadowColor = 'transparent';
                                    c.strokeStyle = 'rgba(255,255,255,0.7)';
                                    c.lineWidth = 1.5;
                                    roundRect(c, -boxW / 2, -boxH / 2, boxW, boxH, 5);
                                    c.stroke();

                                    // Texto blanco
                                    c.fillStyle = '#ffffff';
                                    c.textAlign = 'center';
                                    c.textBaseline = 'middle';
                                    c.fillText(texto, 0, 0);
                                    c.restore();
                                });
                            },

                            afterDraw(chart) {
                                const { ctx: c, chartArea } = chart;
                                const meta = chart.getDatasetMeta(0);
                                const yBase = chartArea.bottom + 8;

                                desglose.forEach((d, i) => {
                                    const punto = meta.data[i];
                                    const x = punto.x;
                                    const label = d.perfil_corto || d.texto_opcion || '';
                                    const color = rawColors[i] || '#333';

                                    // ── Línea guía vertical al nombre ──
                                    c.save();
                                    c.beginPath();
                                    c.moveTo(x, yBase);
                                    c.lineTo(x, yBase + 10);
                                    c.strokeStyle = color;
                                    c.lineWidth = 1.5;
                                    c.globalAlpha = 0.4;
                                    c.stroke();
                                    c.restore();

                                    // ── Nombre en diagonal 45° con color ──
                                    c.save();
                                    c.translate(x, yBase + 14);
                                    c.rotate(-Math.PI / 4); // 45° diagonal
                                    c.textAlign = 'right';
                                    c.textBaseline = 'middle';
                                    c.font = 'bold 11px sans-serif';
                                    c.fillStyle = color;
                                    c.fillText(label, 0, 0);
                                    c.restore();
                                });
                            }
                        }]
                    });

                    return;
                }

                // ── Helpers ──────────────────────────────────────────────

                function roundRect(ctx, x, y, w, h, r) {
                    ctx.beginPath();
                    ctx.moveTo(x + r, y);
                    ctx.lineTo(x + w - r, y);
                    ctx.quadraticCurveTo(x + w, y, x + w, y + r);
                    ctx.lineTo(x + w, y + h - r);
                    ctx.quadraticCurveTo(x + w, y + h, x + w - r, y + h);
                    ctx.lineTo(x + r, y + h);
                    ctx.quadraticCurveTo(x, y + h, x, y + h - r);
                    ctx.lineTo(x, y + r);
                    ctx.quadraticCurveTo(x, y, x + r, y);
                    ctx.closePath();
                }

                function shadeColor(color, percent) {
                    if (!color.startsWith('#')) return color;
                    let r = parseInt(color.slice(1, 3), 16);
                    let g = parseInt(color.slice(3, 5), 16);
                    let b = parseInt(color.slice(5, 7), 16);
                    r = Math.min(255, Math.max(0, Math.round(r * (100 + percent) / 100)));
                    g = Math.min(255, Math.max(0, Math.round(g * (100 + percent) / 100)));
                    b = Math.min(255, Math.max(0, Math.round(b * (100 + percent) / 100)));
                    return `rgb(${r},${g},${b})`;
                }

                // ── BARRAS VERTICALES ─────────────────────────────────────────────────────
                const alturaBase = Math.max(500, (numElementos * 20) + 200);
                $contenedor.css('height', alturaBase + 'px');

                const datosOriginales3D = desglose.map(d => Math.round(d.total));

                window.chartInstance = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: desglose.map(d => d.perfil_corto || d.texto_opcion),
                        datasets: [{
                            data: datosOriginales3D,
                            backgroundColor: 'rgba(0,0,0,0)',
                            borderColor: 'rgba(0,0,0,0)',
                            borderWidth: 0,
                            barPercentage: 0.6,
                            maxBarThickness: 60
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        indexAxis: 'x',
                        layout: { padding: { top: 60, bottom: 20, left: 20, right: 20 } },
                        plugins: {
                            legend: { display: false },
                            datalabels: { display: false }
                        },
                        scales: {
                            x: {
                                beginAtZero: true,
                                grid: { display: false },
                                border: { display: false },
                                ticks: { color: '#444', font: { size: 11, weight: 'bold' } }
                            },
                            y: {
                                beginAtZero: true,
                                display: false,
                                grid: { display: false },
                                border: { display: false },
                                max: Math.ceil(maxDataValue * 1.45)
                            }
                        }
                    },
                    plugins: [ChartDataLabels, {
                        id: 'bar3DPlugin',
                        afterDatasetsDraw(chart) {
                            const { ctx, scales, chartArea } = chart;
                            const meta = chart.getDatasetMeta(0);
                            const yZero = scales.y.getPixelForValue(0);
                            const depth = 14;

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

                            meta.data.forEach((bar, i) => {
                                const color = rawColors[i % rawColors.length];
                                const x = bar.x;
                                const bw = bar.width;
                                const bx = x - bw / 2;
                                const yTop = bar.y;
                                const height = yZero - yTop;

                                if (height <= 0) return;

                                const fullTop = chartArea.top + 10;
                                const fullH = yZero - fullTop;

                                // ── 1. Contenedor gris 3D ────────────────────────────────────

                                ctx.save();

                                ctx.fillStyle = 'rgba(200,205,215,0.55)';
                                ctx.beginPath();
                                ctx.roundRect(bx, fullTop, bw, fullH, [4, 4, 0, 0]);
                                ctx.fill();

                                ctx.beginPath();
                                ctx.moveTo(bx, fullTop);
                                ctx.lineTo(bx + bw, fullTop);
                                ctx.lineTo(bx + bw + depth, fullTop - depth * 0.6);
                                ctx.lineTo(bx + depth, fullTop - depth * 0.6);
                                ctx.closePath();
                                ctx.fillStyle = 'rgba(180,185,195,0.55)';
                                ctx.fill();

                                ctx.beginPath();
                                ctx.moveTo(bx + bw, fullTop);
                                ctx.lineTo(bx + bw + depth, fullTop - depth * 0.6);
                                ctx.lineTo(bx + bw + depth, yZero - depth * 0.6);
                                ctx.lineTo(bx + bw, yZero);
                                ctx.closePath();
                                ctx.fillStyle = 'rgba(160,165,175,0.55)';
                                ctx.fill();

                                ctx.restore();

                                // ── 2. Barra de color 3D ─────────────────────────────────────

                                ctx.save();

                                const gradFront = ctx.createLinearGradient(bx, yTop, bx + bw, yTop);
                                gradFront.addColorStop(0, lighten(color, 30));
                                gradFront.addColorStop(0.5, color);
                                gradFront.addColorStop(1, darken(color, 20));

                                ctx.beginPath();
                                ctx.roundRect(bx, yTop, bw, height, [4, 4, 0, 0]);
                                ctx.fillStyle = gradFront;
                                ctx.fill();
                                ctx.strokeStyle = darken(color, 30);
                                ctx.lineWidth = 1;
                                ctx.stroke();

                                // Cara superior
                                ctx.beginPath();
                                ctx.moveTo(bx, yTop);
                                ctx.lineTo(bx + bw, yTop);
                                ctx.lineTo(bx + bw + depth, yTop - depth * 0.6);
                                ctx.lineTo(bx + depth, yTop - depth * 0.6);
                                ctx.closePath();
                                ctx.fillStyle = lighten(color, 50);
                                ctx.fill();
                                ctx.strokeStyle = darken(color, 10);
                                ctx.lineWidth = 0.5;
                                ctx.stroke();

                                // Cara lateral derecha
                                ctx.beginPath();
                                ctx.moveTo(bx + bw, yTop);
                                ctx.lineTo(bx + bw + depth, yTop - depth * 0.6);
                                ctx.lineTo(bx + bw + depth, yZero - depth * 0.6);
                                ctx.lineTo(bx + bw, yZero);
                                ctx.closePath();
                                ctx.fillStyle = darken(color, 25);
                                ctx.fill();
                                ctx.strokeStyle = darken(color, 35);
                                ctx.lineWidth = 0.5;
                                ctx.stroke();

                                // Brillo interior
                                const shine = ctx.createLinearGradient(bx, 0, bx + bw * 0.35, 0);
                                shine.addColorStop(0, 'rgba(255,255,255,0.25)');
                                shine.addColorStop(1, 'rgba(255,255,255,0)');
                                ctx.beginPath();
                                ctx.roundRect(bx, yTop, bw, height, [4, 4, 0, 0]);
                                ctx.fillStyle = shine;
                                ctx.fill();

                                ctx.restore();

                                // ── 3. Etiqueta encima de la barra en negro ──────────────────

                                // ── 3. Etiqueta encima de la barra en negro, rotada 90° ──────────

                                const valor = datosOriginales3D[i];
                                const pct = ((valor / universoTotal) * 100).toFixed(1);
                                const labelTxt = `${valor} (${pct}%)`;

                                ctx.save();

                                const maxFontSize = 16;
                                const minFontSize = 9;
                                let fontSize = maxFontSize;
                                ctx.font = `bold ${fontSize}px sans-serif`;

                                // Con rotación 90°, el texto ocupa 'height' vertical → ajustar al espacio encima
                                while (fontSize > minFontSize && ctx.measureText(labelTxt).width > (chartArea.top - (yTop - depth * 0.6) - 6)) {
                                    fontSize -= 0.5;
                                    ctx.font = `bold ${fontSize}px sans-serif`;
                                }

                                // Posición: encima de la cara superior 3D
                                const labelY = yTop - depth * 0.6 - 6;

                                ctx.translate(x, labelY);
                                ctx.rotate(-Math.PI / 2);        // 90° hacia arriba
                                ctx.textAlign = 'left';       // 'left' porque el texto crece hacia arriba tras rotar
                                ctx.textBaseline = 'middle';
                                ctx.fillStyle = '#222222';
                                ctx.shadowColor = 'rgba(255,255,255,0.8)';
                                ctx.shadowBlur = 3;
                                ctx.fillText(labelTxt, 4, 0);

                                ctx.restore();
                            });
                        }
                    }]
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
                    // La clave DEBE ser la misma que en actualizarGrafica
                    const key = item.texto_completo || item.texto_opcion || item.perfil_corto;

                    if (!barColorsMap[key]) {
                        barColorsMap[key] = PALETA_PRO[index % PALETA_PRO.length];
                    }

                    $container.append(`
            <div class="d-flex align-items-center bg-dark p-1 rounded border border-secondary" style="gap: 5px; margin-bottom: 5px;">
                <input type="color" class="individual-picker" data-key="${key}" value="${barColorsMap[key]}" 
                       style="border:none; width:20px; height:20px; cursor:pointer; background:none;">
                <span class="text-white" style="font-size: 10px;">${item.total} pers.</span>
            </div>
        `);
                });

                // Evento vinculado: Al cambiar el color, redibuja con los datos guardados
                $('.individual-picker').off('input change').on('input change', function () {
                    const newColor = $(this).val();
                    const key = $(this).data('key');
                    barColorsMap[key] = newColor;

                    if (lastChartData) {
                        // Llama a la función de arriba con el universo total original
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

            function obtenerImagenGrafica(idCanvas) {
                const chart = window.chartInstance;
                if (!chart) return '';

                const canvas = document.getElementById(idCanvas);

                const escala = 2;
                const tempCanvas = document.createElement('canvas');
                tempCanvas.width = canvas.width * escala;
                tempCanvas.height = canvas.height * escala;
                const tempCtx = tempCanvas.getContext('2d');

                // SIN fondo — transparente para que se vea la marca de agua
                // tempCtx.fillStyle = '#ffffff';
                // tempCtx.fillRect(0, 0, tempCanvas.width, tempCanvas.height);

                tempCtx.scale(escala, escala);

                // Guardar estilos originales
                const originalDatalabelsColor = chart.options.plugins.datalabels?.color;
                const originalDatalabelsStrokeColor = chart.options.plugins.datalabels?.textStrokeColor;
                const originalDatalabelsStrokeWidth = chart.options.plugins.datalabels?.textStrokeWidth;
                const originalXColor = chart.options.scales?.x?.ticks?.color;
                const originalYColor = chart.options.scales?.y?.ticks?.color;

                // Estilos para PDF — letras negras
                if (chart.options.plugins.datalabels) {
                    chart.options.plugins.datalabels.color = '#000000';
                    chart.options.plugins.datalabels.textStrokeColor = '#ffffff';
                    chart.options.plugins.datalabels.textStrokeWidth = 3;
                }
                if (chart.options.scales?.x?.ticks) chart.options.scales.x.ticks.color = '#000000';
                if (chart.options.scales?.y?.ticks) chart.options.scales.y.ticks.color = '#000000';
                if (chart.options.plugins?.legend?.labels) chart.options.plugins.legend.labels.color = '#000000';

                window._graficaParaPDF = true;
                chart.update({ duration: 0 });

                tempCtx.drawImage(canvas, 0, 0);

                // PNG mantiene transparencia
                const imgData = tempCanvas.toDataURL('image/png');

                // Restaurar estilos originales
                if (chart.options.plugins.datalabels) {
                    chart.options.plugins.datalabels.color = originalDatalabelsColor ?? '#ffffff';
                    chart.options.plugins.datalabels.textStrokeColor = originalDatalabelsStrokeColor ?? 'transparent';
                    chart.options.plugins.datalabels.textStrokeWidth = originalDatalabelsStrokeWidth ?? 0;
                }
                if (chart.options.scales?.x?.ticks) chart.options.scales.x.ticks.color = originalXColor ?? '#ffffff';
                if (chart.options.scales?.y?.ticks) chart.options.scales.y.ticks.color = originalYColor ?? '#ffffff';
                if (chart.options.plugins?.legend?.labels) chart.options.plugins.legend.labels.color = '#ffffff';

                window._graficaParaPDF = false;
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

                // Leer la variable guardada al momento de PROCESAR
                const subencabezadoDinamico =
                    (window._ultimaOpcionReporte && window._ultimaOpcionReporte !== '')
                        ? window._ultimaOpcionReporte
                        : (lastChartData && lastChartData.resumen.encuesta_nombre
                            ? lastChartData.resumen.encuesta_nombre
                            : "Análisis de Datos Vota y Opina");

                return `
<div class="pagina-reporte">
    ${inyectarMarcaAgua()}
    <div class="contenido-superior" style="display: flex; flex-direction: column; height: 100%; padding: 4mm 6mm;">

        <div style="text-align: center; width: 100%; margin-bottom: 2mm;">
            <h1 style="color: #003366; margin: 0; font-size: 28px; text-transform: uppercase; letter-spacing: 1px;">
                Intención de Voto
            </h1>
            <h2 style="color: #444; margin: 3px 0; font-size: 16px; font-weight: normal; text-transform: uppercase; letter-spacing: 0.5px;">
                ${subencabezadoDinamico}
            </h2>
            <div style="margin-top: 3px; padding: 3px 8px; background-color: rgba(0,0,0,0.03); border-radius: 5px; font-size: 12px; color: #555; display: inline-block;">
                ${filtrosGeo || "<i>Análisis Global (Sin filtros geográficos)</i>"}
            </div>
        </div>

        <div style="width: 100%; flex-grow: 1; display: flex; justify-content: center; align-items: center;">
            <img
                src="${imgData}"
                style="
                    width: 85%;
                    max-height: 700px;
                    object-fit: contain;
                    image-rendering: -webkit-optimize-contrast;
                    image-rendering: crisp-edges;
                    -ms-interpolation-mode: nearest-neighbor;
                "
            >
        </div>

    </div>
</div>`;
            }



            // VINCULACIÓN AL BOTÓN
            $('#btn_imprimir_reporte').off('click').on('click', function () {
                if (!lastChartData) {
                    alert("Primero procese un análisis.");
                    return;
                }

                window.scrollTo(0, 0);

                const container = document.createElement('div');

                // Solo se usa la página 1
                container.innerHTML = obtenerHtmlPagina1().trim();

                const opt = {
                    margin: 0,
                    filename: 'IntencionDeVoto.pdf',
                    image: { type: 'jpeg', quality: 1 },
                    html2canvas: {
                        scale: 2,
                        useCORS: true,
                        letterRendering: true
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