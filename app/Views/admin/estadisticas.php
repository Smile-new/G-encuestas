<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Estadísticas | Encuestas</title>

    <link rel="stylesheet" href="<?= base_url('recursos_admin/vendors/mdi/css/materialdesignicons.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('recursos_admin/vendors/css/vendor.bundle.base.css') ?>">
    <link rel="stylesheet" href="<?= base_url('recursos_admin/css/style.css') ?>">


    <style>
        label {
            color: #ffffff;
        }

        .form-group.checkbox-group {
            max-height: 200px;
            overflow-y: auto;
            border: 1px solid #4a4a4a;
            border-radius: 4px;
            padding: 10px;
            background-color: #2a2c3d;
        }

        .form-check {
            padding-left: 0;
            margin-bottom: 5px;
        }

        .form-check-input {
            margin-left: 0;
            margin-right: 10px;
        }

        .form-check-label {
            color: #ffffff;
        }

        select.form-control {
            color: #ffffff;
            background-color: #2a2c3d;
            border-color: #4a4a4a;
        }

        select.form-control option {
            background-color: #2a2c3d;
            color: #ffffff;
        }

        /* Aplica el mismo estilo para los selectores deshabilitados */
        select.form-control:disabled {
            background-color: #2a2c3d;
            color: #ffffff;
            border-color: #4a4a4a;
            -webkit-text-fill-color: #ffffff;
            /* Para navegadores basados en WebKit */
            opacity: 1;
            /* Para Firefox */
        }

        .chart-container {
            position: relative;
            height: 400px;
            margin-bottom: 20px;
        }

        #charts_container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            min-height: 400px;
        }

        .chart-wrapper {
            width: 95%;
            /* Un poco más de ancho */
            max-width: 850px;
            /* Ancho máximo */
            background-color: #ffffff;
            padding: 20px;
            border-radius: 12px;
            /* Bordes un poco más redondeados */
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            height: 420px;
            /* Un poco más de altura */

            /* --- ESTO ES LO MÁS IMPORTANTE --- */
            display: flex;
            flex-direction: column;
            /* Organiza los elementos (título y canvas) en una columna */
        }

        .chart-wrapper h4 {
            color: #333333;
            /* Un gris oscuro para el título */
            text-align: center;
            margin-bottom: 15px;
            flex-shrink: 0;
            /* Evita que el título se encoja */
        }

        .chart-wrapper canvas {
            /* El canvas ahora tomará el 100% del espacio restante en el wrapper */
            flex-grow: 1;
            /* Permite que el canvas crezca y ocupe el espacio */
            min-height: 0;
            /* Soluciona un problema común de Flexbox con canvas */
            width: 100% !important;
            /* Asegura que ocupe todo el ancho */
        }

        .chart-navigation {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            max-width: 800px;
            margin-top: 20px;
        }

        .chart-navigation .btn {
            background-color: #007bff;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .chart-navigation .btn:disabled {
            background-color: #6c757d;
            cursor: not-allowed;
        }

        /* Logo mini más grande en el navbar */
        .navbar .navbar-brand-wrapper .navbar-brand.brand-logo-mini img {
            width: auto;
            /* que respete proporción */
            max-height: 90px;
            /* ajusta según lo que necesites */
            height: auto;
        }


        /* === Responsive mejorado === */

        /* Tablets y pantallas medianas */
        @media (max-width: 991px) {

            /* Ajusta espaciados entre tarjetas */
            .grid-margin,
            .stretch-card {
                margin-bottom: 20px;
            }
        }

        /* Móviles y pantallas pequeñas */
        @media (max-width: 767px) {

            /* Sidebar se colapsa, no desaparece */
            .sidebar {
                position: fixed;
                left: -250px;
                transition: all 0.3s ease;
                width: 250px;
                z-index: 999;
            }

            .sidebar.active {
                left: 0;
            }

            /* Navbar: ajusta contenido */
            .navbar .navbar-brand-wrapper {
                padding: 0;
            }

            /* Oculta solo el texto, no el perfil entero */
            .navbar-profile-name {
                display: none !important;
            }

            /* Botones en tablas: que ocupen ancho completo */
            .table td .btn {
                display: block;
                width: 100%;
                margin-bottom: 6px;
            }

            /* Mejora la experiencia del main-panel */
            .main-panel {
                padding: 10px;
            }

            /* Logo mini más centrado */
            .navbar .navbar-brand-wrapper .navbar-brand.brand-logo-mini img {
                max-height: 70px;
            }
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

        <div class="container-fluid page-body-wrapper">
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
                                        <div class="preview-icon bg-dark rounded-circle"><i
                                                class="mdi mdi-logout text-danger"></i></div>
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

            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">Estadísticas de Encuestas</h3>
                    </div>

                    <div class="row">
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Filtros de Datos</h4>
                                    <form class="forms-sample">
                                        <div class="row">
                                            <div class="form-group col-md-4">
                                                <label for="encuesta_select">Encuesta</label>
                                                <select class="form-control" id="encuesta_select">
                                                    <option value="">Selecciona una encuesta</option>
                                                    <?php foreach ($encuestas as $encuesta): ?>
                                                        <option value="<?= $encuesta['id_encuesta'] ?>">
                                                            <?= esc($encuesta['titulo']) ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label>Preguntas</label>
                                                <div id="pregunta_checkbox_container" class="form-group checkbox-group">
                                                    <p class="text-white-50">Selecciona una encuesta para cargar las
                                                        preguntas.</p>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="chart_type_select">Tipo de Gráfica</label>
                                                <select class="form-control" id="chart_type_select">
                                                    <option value="bar">Gráfica de Barras</option>
                                                    <option value="doughnut">Gráfica de Dona</option>
                                                    <option value="pie">Gráfica de Pastel</option>
                                                    <option value="line">Gráfica de Líneas</option>
                                                    <option value="radar">Gráfica de Radar</option>
                                                    <option value="polarArea">Gráfica de Área Polar</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-md-3">
                                                <label for="estado_select">Estado</label>
                                                <select class="form-control" id="estado_select">
                                                    <option value="">Selecciona un Estado</option>
                                                    <?php foreach ($estados as $est): ?>
                                                        <option value="<?= $est['id_estado'] ?>">
                                                            <?= esc($est['nombre_estado']) ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="distrito_federal_select">Distrito Federal</label>
                                                <select class="form-control" id="distrito_federal_select" disabled>
                                                    <option value="">Distrito Federal</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="distrito_local_select">Distrito Local</label>
                                                <select class="form-control" id="distrito_local_select" disabled>
                                                    <option value="">Distrito Local</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="municipio_select">Municipio</label>
                                                <select class="form-control" id="municipio_select" disabled>
                                                    <option value="">Municipio</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row align-items-end">
                                            <div class="form-group col-md-3">
                                                <label for="seccion_select">Sección</label>
                                                <select class="form-control" id="seccion_select" disabled>
                                                    <option value="">Sección</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="comunidad_select">Comunidad</label>
                                                <select class="form-control" id="comunidad_select" disabled>
                                                    <option value="">Comunidad</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-6 d-flex justify-content-end">
                                                <button type="button" class="btn btn-success btn-icon-text mr-2"
                                                    id="generate_charts_btn" disabled>
                                                    <i class="mdi mdi-chart-areaspline btn-icon-prepend"></i> Generar
                                                    Gráficos
                                                </button>
                                                <button type="button" class="btn btn-primary btn-icon-text mr-2"
                                                    id="download_pdf_btn" style="display: none;">
                                                    <i class="mdi mdi-file-pdf btn-icon-prepend"></i> PDF
                                                </button>
                                                <button type="button" class="btn btn-outline-success btn-icon-text"
                                                    id="downloadExcelBtn" style="display: none;">
                                                    <i class="mdi mdi-file-excel btn-icon-prepend"></i> Excel
                                                </button>
                                            </div>
                                        </div>

                                        <div id="custom_colors_container" class="row mt-4 pt-3 border-top"
                                            style="display:none;">
                                            <div class="col-12">
                                                <h6 class="text-white mb-3"><i class="mdi mdi-palette"></i> Personalizar
                                                    Colores de Barras</h6>
                                                <div id="color_pickers_wrapper"
                                                    class="d-flex flex-wrap shadow-sm p-3 rounded"
                                                    style="background: rgba(0,0,0,0.1);">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body" id="chart-card-body">
                                    <h4 class="card-title" id="main_chart_title">Resultados de las preguntas
                                        seleccionadas</h4>
                                    <div id="no_data_message" class="text-center" style="display: block;">
                                        <p>Selecciona una encuesta y al menos una pregunta para ver los resultados.</p>
                                    </div>
                                    <div id="charts_container">
                                    </div>
                                    <div id="chart_navigation_container" class="chart-navigation"
                                        style="display: none;">
                                        <button class="btn" id="prev_chart_btn" disabled>Anterior</button>
                                        <span id="chart_counter" class="text-white"></span>
                                        <button class="btn" id="next_chart_btn" disabled>Siguiente</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <script src="<?= base_url('recursos_admin/vendors/js/vendor.bundle.base.js') ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>


    <script>


        // Plugin para ajustar padding inferior dinámicamente según la altura de la leyenda
        const dynamicBottomPadding = {
            id: 'dynamicBottomPadding',
            beforeLayout: (chart) => {
                if (chart.options.plugins.legend && chart.options.plugins.legend.display) {
                    const legendHeight = chart.legend?.height || 0;
                    chart.options.layout.padding.bottom = legendHeight + 30; // 30px extra
                }
            }
        };
        document.addEventListener('DOMContentLoaded', function () {
            // Referencias a elementos del DOM
            Chart.register(ChartDataLabels);
            const encuestaSelect = document.getElementById('encuesta_select');
            const preguntaCheckboxContainer = document.getElementById('pregunta_checkbox_container');
            const chartTypeSelect = document.getElementById('chart_type_select');
            const municipioSelect = document.getElementById('municipio_select');
            const seccionSelect = document.getElementById('seccion_select');
            const comunidadSelect = document.getElementById('comunidad_select');
            const chartsContainer = document.getElementById('charts_container');
            const noDataMessage = document.getElementById('no_data_message');
            const downloadPdfBtn = document.getElementById('download_pdf_btn');
            const chartNavigationContainer = document.getElementById('chart_navigation_container');
            const prevChartBtn = document.getElementById('prev_chart_btn');
            const nextChartBtn = document.getElementById('next_chart_btn');
            const chartCounter = document.getElementById('chart_counter');
            const generateChartsBtn = document.getElementById('generate_charts_btn');
            const BASE_URL = "<?= base_url() ?>";

            // Cerca de donde definiste chartDataSets
            let customBarColors = {}; // Estructura: { "Etiqueta": "#HEX" }

            // Nuevos elementos para la jerarquía padre
            const estadoSelect = document.getElementById('estado_select');
            const distritoFederalSelect = document.getElementById('distrito_federal_select');
            const distritoLocalSelect = document.getElementById('distrito_local_select');

            let chartDataSets = [];
            let currentChartIndex = 0;
            let chartInstance = null;

            // URL base para el controlador. Usamos rtrim para asegurar que no haya doble slash.
            const baseUrl = '<?= rtrim(site_url('EstadisticasController'), '/') ?>';
            const colores = ['#007bff', '#28a745', '#dc3545', '#ffc107', '#17a2b8', '#6610f2', '#fd7e14', '#e83e8c'];
            const colorTextoSecundario = '#424242';

            Chart.register(ChartDataLabels);

            // --- FUNCIONES AUXILIARES (Sin cambios) ---
            function cargarSelectUnico(selectElement, data, idKey, textKey) {
                selectElement.innerHTML = `<option value="${data[idKey]}">${data[textKey]}</option>`;
                selectElement.disabled = true;
            }

            function cargarSelect(selectElement, data, idKey, textKey, placeholder, disabled = false) {
                selectElement.innerHTML = `<option value="">${placeholder}</option>`;
                if (data && Array.isArray(data)) {
                    data.forEach(item => {
                        const option = document.createElement('option');
                        option.value = item[idKey];
                        option.textContent = item[textKey];
                        selectElement.appendChild(option);
                    });
                }
                selectElement.disabled = disabled;
            }

            function cargarPreguntasCheckboxes(preguntasData) {
                preguntaCheckboxContainer.innerHTML = '';
                if (preguntasData && preguntasData.length > 0) {
                    preguntasData.forEach(pregunta => {
                        const div = document.createElement('div');
                        div.classList.add('form-check');
                        div.innerHTML = `
                        <input class="form-check-input" type="checkbox" value="${pregunta.id_pregunta}" id="pregunta-${pregunta.id_pregunta}">
                        <label class="form-check-label" for="pregunta-${pregunta.id_pregunta}">${pregunta.texto_pregunta}</label>
                    `;
                        preguntaCheckboxContainer.appendChild(div);
                    });
                    preguntaCheckboxContainer.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
                        checkbox.addEventListener('change', () => {
                            const anyChecked = Array.from(preguntaCheckboxContainer.querySelectorAll('input[type="checkbox"]:checked')).length > 0;
                            generateChartsBtn.disabled = !anyChecked;
                        });
                    });
                } else {
                    preguntaCheckboxContainer.innerHTML = `<p class="text-white-50">No hay preguntas disponibles para esta encuesta.</p>`;
                }
            }

            // --- LÓGICA DE GRÁFICOS (con manejo de errores mejorado) ---
            async function fetchJSON(url, options = {}) {
                try {
                    const response = await fetch(url, options);
                    if (!response.ok) {
                        const errorText = await response.text();
                        throw new Error(`Error HTTP ${response.status}: ${response.statusText}. Respuesta del servidor: ${errorText}`);
                    }
                    // Si la respuesta está vacía, devuelve un array vacío para evitar errores de JSON
                    const text = await response.text();
                    return text ? JSON.parse(text) : [];
                } catch (error) {
                    console.error(`Fallo la petición a ${url}:`, error);
                    throw error; // Re-lanza el error para que sea manejado por la función que lo llamó
                }
            }

            async function crearDatosGrafico(idPregunta, nombrePregunta) {
                const idEncuesta = encuestaSelect.value;
                const params = new URLSearchParams({
                    id_encuesta: idEncuesta,
                    id_pregunta: idPregunta,
                    id_estado: document.getElementById('estado_select').value,
                    id_distrito_federal: document.getElementById('distrito_federal_select').value,
                    id_distrito_local: document.getElementById('distrito_local_select').value,
                    id_municipio: document.getElementById('municipio_select').value,
                    id_seccion: document.getElementById('seccion_select').value,
                    id_comunidad: document.getElementById('comunidad_select').value,
                });

                try {
                    const opcionesData = await fetchJSON(`${baseUrl}/getOpcionesPregunta/${idPregunta}`);
                    const respuestasData = await fetchJSON(`${baseUrl}/getRespuestas?${params.toString()}`);

                    if (opcionesData && opcionesData.length > 0) {
                        const datosMapeados = {};
                        opcionesData.forEach(opcion => {
                            datosMapeados[opcion.texto_opcion] = 0;
                        });
                        respuestasData.forEach(respuesta => {
                            const opcionEncontrada = opcionesData.find(op => op.id_opcion == respuesta.id_opcion);
                            if (opcionEncontrada) {
                                datosMapeados[opcionEncontrada.texto_opcion] = parseInt(respuesta.total, 10);
                            }
                        });

                        const chartData = {
                            id: idPregunta,
                            title: nombrePregunta,
                            labels: Object.keys(datosMapeados),
                            datasets: [{
                                label: '',
                                data: Object.values(datosMapeados),
                                backgroundColor: Object.values(datosMapeados).map((_, i) => colores[i % colores.length]),
                                borderColor: Object.values(datosMapeados).map((_, i) => colores[i % colores.length]),
                                borderWidth: 1,
                            }]
                        };
                        chartDataSets.push(chartData);
                    } else {
                        console.warn(`No hay opciones de respuesta para la pregunta: ${nombrePregunta}`);
                    }
                } catch (error) {
                    console.error(`Error al crear datos del gráfico para la pregunta ${idPregunta}:`, error);
                }
            }

            // --- COPIA Y PEGA ESTA FUNCIÓN COMPLETA ---
            function renderizarGrafico(dataSet) {
                const chartsContainer = document.getElementById('charts_container');
                const wrapperPickers = document.getElementById('color_pickers_wrapper');
                const containerPickers = document.getElementById('custom_colors_container');
                const noDataMessage = document.getElementById('no_data_message');

                // 1. Limpieza de instancias y contenedores
                chartsContainer.innerHTML = '';
                if (wrapperPickers) wrapperPickers.innerHTML = '';
                if (window.chartInstance) { window.chartInstance.destroy(); }

                // 2. Validación de datos (Suma total de respuestas)
                const total = dataSet.datasets[0].data.reduce((a, b) => a + b, 0);
                if (total === 0) {
                    noDataMessage.style.display = 'block';
                    noDataMessage.textContent = "No hay datos de respuestas para la selección.";
                    if (containerPickers) containerPickers.style.display = 'none';
                    return;
                }

                noDataMessage.style.display = 'none';

                // 3. Creación del Canvas
                const chartWrapper = document.createElement('div');
                chartWrapper.classList.add('chart-wrapper');
                const chartTitle = document.createElement('h4');
                chartTitle.textContent = dataSet.title;
                const chartCanvas = document.createElement('canvas');

                chartWrapper.appendChild(chartTitle);
                chartWrapper.appendChild(chartCanvas);
                chartsContainer.appendChild(chartWrapper);

                // 4. Generar configuración y renderizar
                const ctx = chartCanvas.getContext('2d');
                const chartType = document.getElementById('chart_type_select').value;
                const config = crearConfiguracionGrafico(dataSet, chartType, ctx, total);

                window.chartInstance = new Chart(ctx, config);

                // 5. Mostrar selectores de color si el tipo de gráfica lo permite
                const tiposPermitidos = ['bar', 'doughnut', 'pie', 'polarArea'];
                if (tiposPermitidos.includes(chartType)) {
                    generarColorPickers(dataSet);
                } else if (containerPickers) {
                    containerPickers.style.display = 'none';
                }
            }
            // --- FUNCIONES PRINCIPALES (con manejo de errores mejorado) ---

            // --- FUNCION DE VALIDACIÓN CENTRALIZADA ---
            function validarBotonGenerar() {
                const encuestaSeleccionada = encuestaSelect.value !== "";
                const preguntasSeleccionadas = preguntaCheckboxContainer.querySelectorAll('input[type="checkbox"]:checked').length > 0;

                // El botón se habilita solo si hay encuesta Y al menos una pregunta
                generateChartsBtn.disabled = !(encuestaSeleccionada && preguntasSeleccionadas);
            }

            // --- EVENTO ENCUESTA (CORREGIDO) ---
            encuestaSelect.addEventListener('change', async function () {
                const idEncuesta = this.value;
                preguntaCheckboxContainer.innerHTML = `<p class="text-white-50">Cargando preguntas...</p>`;

                // ELIMINADO: Ya no limpiamos los selectores geográficos aquí para no romper el enlace

                if (idEncuesta) {
                    try {
                        const data = await fetchJSON(`${baseUrl}/getPreguntas/${idEncuesta}`);

                        // Renderizamos los checkboxes
                        preguntaCheckboxContainer.innerHTML = '';
                        if (data && data.length > 0) {
                            data.forEach(pregunta => {
                                const div = document.createElement('div');
                                div.classList.add('form-check');
                                div.innerHTML = `
                        <input class="form-check-input" type="checkbox" value="${pregunta.id_pregunta}" id="p-${pregunta.id_pregunta}">
                        <label class="form-check-label" for="p-${pregunta.id_pregunta}">${pregunta.texto_pregunta}</label>
                    `;
                                preguntaCheckboxContainer.appendChild(div);

                                // Cada vez que marquen una pregunta, validamos el botón
                                div.querySelector('input').addEventListener('change', validarBotonGenerar);
                            });
                        } else {
                            preguntaCheckboxContainer.innerHTML = `<p class="text-white-50">No hay preguntas.</p>`;
                        }
                    } catch (error) {
                        preguntaCheckboxContainer.innerHTML = `<p class="text-danger">Error al cargar preguntas.</p>`;
                    }
                } else {
                    preguntaCheckboxContainer.innerHTML = `<p class="text-white-50">Selecciona una encuesta para cargar las preguntas.</p>`;
                }
                validarBotonGenerar();
            });

            // --- EVENTOS GEOGRÁFICOS (MANTENIENDO LA CASCADA NATURAL) ---

            estadoSelect.addEventListener('change', async function () {
                const id = this.value;
                // Solo limpiamos los HIJOS geográficos, no la encuesta
                cargarSelect(distritoFederalSelect, [], '', '', 'Cargando...', true);
                cargarSelect(distritoLocalSelect, [], '', '', 'Distrito Local', true);
                cargarSelect(municipioSelect, [], '', '', 'Municipio', true);
                cargarSelect(seccionSelect, [], '', '', 'Sección', true);
                cargarSelect(comunidadSelect, [], '', '', 'Comunidad', true);

                if (id) {
                    const data = await fetchJSON(`${baseUrl}/getDistritosFederales/${id}`);
                    cargarSelect(distritoFederalSelect, data, 'id_distrito_federal', 'nombre_distrito_federal', 'Selecciona Distrito Federal', false);
                }
            });

            distritoFederalSelect.addEventListener('change', async function () {
                const id = this.value;
                cargarSelect(distritoLocalSelect, [], '', '', 'Cargando...', true);
                cargarSelect(municipioSelect, [], '', '', 'Municipio', true);
                cargarSelect(seccionSelect, [], '', '', 'Sección', true);
                cargarSelect(comunidadSelect, [], '', '', 'Comunidad', true);

                if (id) {
                    const data = await fetchJSON(`${baseUrl}/getDistritosLocales/${id}`);
                    cargarSelect(distritoLocalSelect, data, 'id_distrito_local', 'nombre_distrito_local', 'Selecciona Distrito Local', false);
                }
            });

            distritoLocalSelect.addEventListener('change', async function () {
                const id = this.value;
                cargarSelect(municipioSelect, [], '', '', 'Cargando...', true);
                cargarSelect(seccionSelect, [], '', '', 'Sección', true);
                cargarSelect(comunidadSelect, [], '', '', 'Comunidad', true);

                if (id) {
                    const data = await fetchJSON(`${baseUrl}/getMunicipios/${id}`);
                    cargarSelect(municipioSelect, data, 'id_municipio', 'nombre_municipio', 'Selecciona Municipio', false);
                }
            });

            municipioSelect.addEventListener('change', async function () {
                const id = this.value;
                cargarSelect(seccionSelect, [], '', '', 'Cargando...', true);
                cargarSelect(comunidadSelect, [], '', '', 'Comunidad', true);

                if (id) {
                    const data = await fetchJSON(`${baseUrl}/getSecciones/${id}`);
                    cargarSelect(seccionSelect, data, 'id_seccion', 'nombre_seccion', 'Selecciona Sección', false);
                }
            });

            seccionSelect.addEventListener('change', async function () {
                const id = this.value;
                cargarSelect(comunidadSelect, [], '', '', 'Cargando...', true);

                if (id) {
                    const data = await fetchJSON(`${baseUrl}/getComunidades/${id}`);
                    cargarSelect(comunidadSelect, data, 'id_comunidad', 'nombre_comunidad', 'Selecciona Comunidad', false);
                }
            });

            async function generarGraficos() { /* ... sin cambios ... */ }
            function actualizarControlesNavegacion() { /* ... sin cambios ... */ }
            function mostrarSiguienteGrafico() { /* ... sin cambios ... */ }
            function mostrarGraficoAnterior() { /* ... sin cambios ... */ }
            async function generarPDF() { /* ... sin cambios ... */ }

            // El resto de tus funciones sin cambios (copia y pega las que faltan aquí si es necesario)
            async function generarGraficos() {
                const selectedQuestions = Array.from(preguntaCheckboxContainer.querySelectorAll('input[type="checkbox"]:checked'));
                const idEncuesta = encuestaSelect.value;
                chartsContainer.innerHTML = '';
                chartDataSets = [];
                currentChartIndex = 0;
                if (chartInstance) {
                    chartInstance.destroy();
                    chartInstance = null;
                }
                chartNavigationContainer.style.display = 'none';
                downloadPdfBtn.style.display = 'none';
                downloadExcelBtn.style.display = 'none';
                if (!idEncuesta || selectedQuestions.length === 0) {
                    noDataMessage.style.display = 'block';
                    noDataMessage.textContent = "Selecciona una encuesta y al menos una pregunta para ver los resultados.";
                    return;
                }
                noDataMessage.style.display = 'none';
                for (const checkbox of selectedQuestions) {
                    const idPregunta = checkbox.value;
                    const nombrePregunta = checkbox.nextElementSibling.textContent;
                    await crearDatosGrafico(idPregunta, nombrePregunta);
                }
                if (chartDataSets.length > 0) {
                    renderizarGrafico(chartDataSets[currentChartIndex]);
                    if (chartDataSets.length > 1) {
                        chartNavigationContainer.style.display = 'flex';
                    }
                    actualizarControlesNavegacion();
                    downloadPdfBtn.style.display = 'block';
                    downloadExcelBtn.style.display = 'block';
                } else {
                    noDataMessage.style.display = 'block';
                    noDataMessage.textContent = "No hay datos de respuestas para las preguntas seleccionadas.";
                }
            }

            function actualizarControlesNavegacion() {
                chartCounter.textContent = `${currentChartIndex + 1} de ${chartDataSets.length}`;
                prevChartBtn.disabled = currentChartIndex === 0;
                nextChartBtn.disabled = currentChartIndex === chartDataSets.length - 1;
            }

            function mostrarSiguienteGrafico() {
                if (currentChartIndex < chartDataSets.length - 1) {
                    currentChartIndex++;
                    renderizarGrafico(chartDataSets[currentChartIndex]);
                    actualizarControlesNavegacion();
                }
            }

            function mostrarGraficoAnterior() {
                if (currentChartIndex > 0) {
                    currentChartIndex--;
                    renderizarGrafico(chartDataSets[currentChartIndex]);
                    actualizarControlesNavegacion();
                }
            }

            /**
      * Crea la configuración completa (datos y opciones de estilo) para un gráfico.
      * @param {object} dataSet - El conjunto de datos para la gráfica.
      * @param {string} chartType - El tipo de gráfica ('bar', 'doughnut', etc.).
      * @param {CanvasRenderingContext2D} ctx - El contexto 2D del canvas donde se dibujará.
      * @returns {object} - Un objeto con { type, data, options } para crear una instancia de Chart.js.
      */
            function crearConfiguracionGrafico(dataSet, chartType, ctx) {
                // --- FUNCIONES AUXILIARES DE COLOR ---
                function hexToRgba(hex, alpha = 1) {
                    const r = parseInt(hex.slice(1, 3), 16), g = parseInt(hex.slice(3, 5), 16), b = parseInt(hex.slice(5, 7), 16);
                    return `rgba(${r}, ${g}, ${b}, ${alpha})`;
                }
                // Función para aclarar (+) u oscurecer (-) un color
                function adjustColor(colorHex, percent) {
                    let r = parseInt(colorHex.slice(1, 3), 16), g = parseInt(colorHex.slice(3, 5), 16), b = parseInt(colorHex.slice(5, 7), 16);
                    r = parseInt(r * (100 + percent) / 100); g = parseInt(g * (100 + percent) / 100); b = parseInt(b * (100 + percent) / 100);
                    r = (r < 255) ? r : 255; g = (g < 255) ? g : 255; b = (b < 255) ? b : 255;
                    r = (r > 0) ? r : 0; g = (g > 0) ? g : 0; b = (b > 0) ? b : 0;
                    const rr = ((r.toString(16).length === 1) ? "0" + r.toString(16) : r.toString(16));
                    const gg = ((g.toString(16).length === 1) ? "0" + g.toString(16) : g.toString(16));
                    const bb = ((b.toString(16).length === 1) ? "0" + b.toString(16) : b.toString(16));
                    return `#${rr}${gg}${bb}`;
                }

                // --- PLUGINS VISUALES PERSONALIZADOS ---

                // 1. Sombra para Gráficos Circulares (Flotar)
                const circularShadowPlugin = {
                    id: 'circularShadow',
                    beforeDraw: (chart) => {
                        if (['doughnut', 'pie', 'polarArea'].includes(chart.config.type)) {
                            const { ctx } = chart;
                            ctx.save();
                            ctx.shadowColor = 'rgba(0, 0, 0, 0.4)'; // Sombra oscura
                            ctx.shadowBlur = 20; // Muy difusa
                            ctx.shadowOffsetX = 5;
                            ctx.shadowOffsetY = 10;
                        }
                    },
                    afterDraw: (chart) => {
                        if (['doughnut', 'pie', 'polarArea'].includes(chart.config.type)) {
                            chart.ctx.restore();
                        }
                    }
                };

                // 2. Sombra para Puntos (Línea/Scatter)
                const pointShadowPlugin = {
                    id: 'pointShadow',
                    beforeDatasetsDraw: (chart) => {
                        if (['line', 'scatter'].includes(chart.config.type)) {
                            const { ctx } = chart;
                            ctx.save();
                            ctx.shadowColor = 'rgba(0, 0, 0, 0.3)';
                            ctx.shadowBlur = 8;
                            ctx.shadowOffsetY = 4;
                        }
                    },
                    afterDatasetsDraw: (chart) => {
                        if (['line', 'scatter'].includes(chart.config.type)) {
                            chart.ctx.restore();
                        }
                    }
                };

                // Registro condicional de plugins (para no duplicar)
                if (!Chart.registry.plugins.get('circularShadow')) Chart.register(circularShadowPlugin);
                if (!Chart.registry.plugins.get('pointShadow')) Chart.register(pointShadowPlugin);


                // --- CONFIGURACIÓN BASE ---
                const colores = ['#1E88E5', '#43A047', '#FFB300', '#E53935', '#8E24AA', '#00ACC1', '#FDD835', '#6D4C41'];
                const colorTextoPrincipal = '#000000';
                const colorTextoSecundario = '#555555';
                const totalDatosGlobal = dataSet.datasets[0].data.reduce((a, b) => a + b, 0);

                let finalType = chartType;
                let finalData = JSON.parse(JSON.stringify(dataSet));

                // Asignación de Colores Base
                finalData.datasets[0].backgroundColor = finalData.labels.map((label, i) => {
                    if (typeof customBarColors !== 'undefined' && customBarColors[label]) {
                        return customBarColors[label];
                    }
                    return colores[i % colores.length];
                });

                // Opciones Globales de Diseño
                let chartOptions = {
                    maintainAspectRatio: false,
                    responsive: true,
                    animation: { duration: 1200, easing: 'easeOutQuart' }, // Animación más lujosa
                    layout: {
                        padding: { top: 30, bottom: 20, left: 30, right: 30 } // Padding para sombras y etiquetas
                    },
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: colorTextoSecundario,
                                font: { size: 13, weight: '600', family: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif" },
                                boxWidth: 18,
                                boxHeight: 18,
                                padding: 25,
                                usePointStyle: true, // Puntos en lugar de cuadrados en la leyenda
                                pointStyle: 'circle'
                            }
                        },
                        // Configuración base DataLabels (se sobrescribe según el tipo)
                        datalabels: {
                            color: colorTextoPrincipal,
                            font: { weight: 'bold', size: 13 },
                            clamp: false,
                            clip: false,
                            // --- CAMBIOS: Eliminar sombras y efectos ---
                            textShadowBlur: 0,              // Desenfoque a 0
                            textShadowColor: 'transparent', // Color transparente
                            textStrokeWidth: 0              // Sin borde alrededor de la letra
                        },
                        // Tooltip Premium (Glassmorphism)
                        tooltip: {
                            enabled: true,
                            backgroundColor: 'rgba(40, 44, 52, 0.9)', // Fondo oscuro semitransparente
                            titleColor: '#ffffff',
                            bodyColor: '#dee2e6',
                            titleFont: { size: 14, weight: 'bold' },
                            bodyFont: { size: 13 },
                            padding: 16,
                            cornerRadius: 12, // Bordes muy redondeados
                            boxPadding: 8,
                            borderColor: 'rgba(255,255,255,0.1)', // Borde sutil
                            borderWidth: 1,
                            displayColors: true,
                            usePointStyle: true,
                            callbacks: {
                                labelColor: function (context) {
                                    return {
                                        borderColor: 'transparent',
                                        backgroundColor: context.dataset.backgroundColor[context.dataIndex] || context.dataset.backgroundColor,
                                        borderWidth: 0,
                                        borderRadius: 6
                                    };
                                }
                            }
                        }
                    },
                    scales: {
                        y: { display: false }, // Ocultar Eje Y por defecto
                        x: { display: false }  // Ocultar Eje X por defecto
                    }
                };

                // --- ESTILOS ESPECÍFICOS POR TIPO ---

                // 1. BARRAS (Con Gradientes, Bordes Redondeados y Sombra 3D)
                if (chartType === 'bar') {
                    chartOptions.scales.x = {
                        display: true,
                        ticks: { color: colorTextoSecundario, font: { weight: 'bold' } },
                        grid: { display: false }
                    };

                    const originalColors = finalData.datasets[0].backgroundColor;
                    // Crear Gradientes Lujosos
                    finalData.datasets[0].backgroundColor = originalColors.map(color => {
                        const gradient = ctx.createLinearGradient(0, 0, 0, 500);
                        gradient.addColorStop(0, adjustColor(color, 30));  // Luz arriba
                        gradient.addColorStop(1, adjustColor(color, -20)); // Sombra abajo
                        return gradient;
                    });

                    finalData.datasets[0].borderColor = originalColors.map(color => adjustColor(color, -10));
                    finalData.datasets[0].borderWidth = 2;
                    finalData.datasets[0].borderRadius = 20; // ¡Esquinas muy redondeadas!
                    finalData.datasets[0].borderSkipped = false; // Redondear también la base
                    finalData.datasets[0].barPercentage = 0.65;
                    finalData.datasets[0].hoverBackgroundColor = originalColors.map(color => adjustColor(color, 50)); // Brillar al pasar el mouse

                    // DataLabels Barras
                    chartOptions.plugins.datalabels = {
                        ...chartOptions.plugins.datalabels, // Heredar base
                        anchor: 'end',
                        align: 'end',
                        offset: -2,
                        formatter: (value) => totalDatosGlobal > 0 ? `${((value / totalDatosGlobal) * 100).toFixed(1)}%` : '0%'
                    };

                    // Plugin Sombra 3D para Barras
                    const bar3DShadowPlugin = {
                        id: 'bar3DShadow',
                        beforeDatasetsDraw: (chart) => {
                            const { ctx } = chart;
                            chart.getDatasetMeta(0).data.forEach(bar => {
                                ctx.save();
                                // Sombra suave y desplazada
                                ctx.shadowColor = 'rgba(0, 0, 0, 0.25)';
                                ctx.shadowBlur = 12;
                                ctx.shadowOffsetX = 4;
                                ctx.shadowOffsetY = 6;
                                // Dibujar una "falsa barra" detrás para proyectar la sombra
                                ctx.fillStyle = '#ffffff'; // Color irrelevante, solo importa la sombra
                                // Ajustamos un poco la posición y tamaño para que la sombra se vea realista
                                const x = bar.x - bar.width / 2 + 2;
                                const y = bar.y + 2;
                                const w = bar.width - 4;
                                const h = bar.height - 2;
                                if (h > 0 && w > 0) { // Evitar errores con barras de valor 0
                                    ctx.roundRect(x, y, w, h, 15); // Usar roundRect si el navegador lo soporta para coincidir con borderRadius
                                    ctx.fill();
                                }
                                ctx.restore();
                            });
                        }
                    };
                    // Registrar este plugin localmente solo para esta instancia si es barras
                    chartOptions.plugins.bar3DShadow = bar3DShadowPlugin;

                }


                // 2. CIRCULARES (Dona, Pastel) - Efecto Flotante y Separadores
                if (['doughnut', 'pie', 'polarArea'].includes(chartType)) {
                    finalData.datasets[0].borderColor = '#ffffff'; // Separador blanco
                    finalData.datasets[0].borderWidth = 4;         // Separador grueso
                    finalData.datasets[0].hoverBorderColor = '#ffffff';
                    finalData.datasets[0].hoverBorderWidth = 5;

                    // DataLabels Circulares (Afuera)
                    chartOptions.plugins.datalabels = {
                        ...chartOptions.plugins.datalabels, // Heredar base
                        anchor: 'end',
                        align: 'end',
                        offset: 15, // Más lejos del centro
                        formatter: (value) => totalDatosGlobal > 0 ? `${((value / totalDatosGlobal) * 100).toFixed(1)}%` : '0%'
                    };

                    if (chartType === 'doughnut') {
                        chartOptions.cutout = '60%'; // Grosor de la dona
                        chartOptions.hoverOffset = 15; // Las rebanadas "saltan" mucho al pasar el mouse
                    } else if (chartType === 'pie') {
                        chartOptions.hoverOffset = 15;
                    } else if (chartType === 'polarArea') {
                        chartOptions.scales.r = {
                            grid: { color: 'rgba(0,0,0,0.05)', circular: true }, // Rejilla circular muy sutil
                            ticks: { display: false, backdropColor: 'transparent' },
                            angleLines: { color: 'rgba(0,0,0,0.05)' }
                        };
                        chartOptions.hoverOffset = 10;
                        finalData.datasets[0].backgroundColor = finalData.datasets[0].backgroundColor.map(c => hexToRgba(c, 0.8)); // Un poco transparentes
                    }
                }


                // 3. LÍNEA Y DISPERSIÓN (Puntos Brillantes y Líneas Suaves)
                if (['line', 'scatter'].includes(chartType)) {
                    const isScatter = chartType === 'scatter';
                    chartOptions.scales.x.display = !isScatter; // Mostrar X solo si es línea
                    if (!isScatter) chartOptions.scales.x.grid = { display: false, drawBorder: false };
                    chartOptions.plugins.legend.display = false; // Ocultar leyenda (suele ser un solo color)

                    const baseColor = finalData.datasets[0].backgroundColor[0];
                    const lineColor = isScatter ? '#666' : adjustColor(baseColor, 10);

                    // Estilo de Línea
                    finalData.datasets[0].tension = 0.45; // Curva muy suave
                    finalData.datasets[0].borderColor = lineColor;
                    finalData.datasets[0].borderWidth = 4;

                    // Relleno (Solo para línea)
                    if (!isScatter) {
                        finalData.datasets[0].fill = true;
                        const gradient = ctx.createLinearGradient(0, 0, 0, 450);
                        gradient.addColorStop(0, hexToRgba(baseColor, 0.5)); // Semitransparente arriba
                        gradient.addColorStop(1, hexToRgba(baseColor, 0.0)); // Transparente abajo
                        finalData.datasets[0].backgroundColor = gradient;
                    }

                    // Estilo de Puntos Premium (Usan el plugin 'pointShadow' activado arriba)
                    finalData.datasets[0].pointRadius = 8;
                    finalData.datasets[0].pointBackgroundColor = isScatter ? originalColors : adjustColor(baseColor, 30); // Centro brillante
                    finalData.datasets[0].pointBorderColor = '#ffffff'; // Borde blanco grueso
                    finalData.datasets[0].pointBorderWidth = 3;
                    finalData.datasets[0].pointHoverRadius = 12; // Crecen mucho al pasar el mouse
                    finalData.datasets[0].pointHoverBorderWidth = 4;

                    // DataLabels Puntos
                    chartOptions.plugins.datalabels = {
                        ...chartOptions.plugins.datalabels, // Heredar base
                        display: true,
                        align: 'top',
                        offset: 12,
                        formatter: (value) => {
                            const val = (typeof value === 'object') ? value.y : value;
                            return totalDatosGlobal > 0 ? `${((val / totalDatosGlobal) * 100).toFixed(1)}%` : '0%';
                        }
                    };

                    if (isScatter) {
                        // Adaptar datos scatter
                        finalData.datasets[0].data = finalData.labels.map((label, i) => ({ x: label, y: finalData.datasets[0].data[i] }));
                        chartOptions.scales.x = { type: 'category', labels: finalData.labels, grid: { display: false } };
                        finalData.datasets[0].showLine = true;
                        finalData.datasets[0].pointBackgroundColor = finalData.datasets[0].backgroundColor; // Usar colores variados
                    }
                }


                // 4. RADAR (Estilo Telaraña Moderna)
                if (chartType === 'radar') {
                    const radarColor = finalData.datasets[0].backgroundColor[0];

                    // --- Estilos Visuales ---
                    finalData.datasets[0].fill = true;
                    finalData.datasets[0].backgroundColor = hexToRgba(radarColor, 0.2);
                    finalData.datasets[0].borderColor = adjustColor(radarColor, 10);
                    finalData.datasets[0].borderWidth = 3;
                    finalData.datasets[0].pointRadius = 6;
                    finalData.datasets[0].pointBackgroundColor = adjustColor(radarColor, 30);
                    finalData.datasets[0].pointBorderColor = '#fff';
                    finalData.datasets[0].pointBorderWidth = 2;
                    finalData.datasets[0].pointHoverRadius = 10;

                    // --- Configuración de Escala ---
                    chartOptions.scales.r = {
                        angleLines: { color: 'rgba(0,0,0,0.1)' },
                        grid: { color: 'rgba(0,0,0,0.1)', circular: true },

                        // Separación de los nombres (Morena, PAN, etc.) respecto a la gráfica
                        pointLabels: {
                            color: colorTextoPrincipal,
                            font: { size: 12, weight: 'bold' },
                            backdropColor: 'transparent',
                            padding: 25 // <--- MÁS SEPARACIÓN AQUÍ
                        },

                        // Sin números de escala (anillos limpios)
                        ticks: {
                            display: false,
                            beginAtZero: true
                        }
                    };

                    // --- DATALABELS EN EL PUNTO ---
                    chartOptions.plugins.datalabels = {
                        display: true,
                        color: colorTextoPrincipal, // Negro
                        font: { weight: 'bold', size: 11 },

                        // --- AQUÍ ESTÁ EL TRUCO PARA QUE NO SE PEGUEN ---
                        anchor: 'center', // El texto se ancla al CENTRO del punto
                        align: 'top',     // Se coloca justo ENCIMA del punto (como un sombrero)
                        offset: 0,        // Pegado al punto, sin empujarlo hacia afuera

                        // Sin sombras ni fondos (limpio)
                        textShadowBlur: 0,
                        textShadowColor: 'transparent',
                        backgroundColor: 'transparent',
                        borderWidth: 0,

                        formatter: (value) => {
                            const percentage = totalDatosGlobal > 0
                                ? `${((value / totalDatosGlobal) * 100).toFixed(1)}%`
                                : '0%';
                            return percentage;
                        }
                    };

                    chartOptions.plugins.legend.display = false;
                }
                return {
                    type: finalType,
                    data: finalData,
                    options: chartOptions
                };
            }

            function generarColorPickers(dataSet) {
                const wrapper = document.getElementById('color_pickers_wrapper');
                const container = document.getElementById('custom_colors_container');
                if (!wrapper || !container) return;

                container.style.display = 'block';
                wrapper.innerHTML = ''; // Se limpia para reconstruir según las etiquetas actuales

                dataSet.labels.forEach((label, index) => {
                    const colorDiv = document.createElement('div');
                    colorDiv.className = 'm-2 text-center';

                    const currentColor = customBarColors[label] || window.chartInstance.data.datasets[0].backgroundColor[index];

                    colorDiv.innerHTML = `
            <label class="d-block small text-white-50" style="font-size: 10px; margin-bottom: 2px;">${label}</label>
            <input type="color" value="${currentColor}" data-label="${label}" data-index="${index}" 
                   style="width: 42px; height: 28px; cursor: pointer; border: 2px solid #4a4a4a; border-radius: 4px; background: none; padding: 0;">
        `;

                    // Actualización "En Vivo"
                    colorDiv.querySelector('input').addEventListener('input', (e) => {
                        const nuevoColor = e.target.value;
                        const labelName = e.target.getAttribute('data-label');
                        const idx = e.target.getAttribute('data-index');

                        customBarColors[labelName] = nuevoColor;

                        if (window.chartInstance) {
                            // Actualiza solo el color de la barra/segmento en memoria
                            window.chartInstance.data.datasets[0].backgroundColor[idx] = nuevoColor;
                            window.chartInstance.update('none'); // 'none' evita animaciones que cierran el selector
                        }
                    });

                    wrapper.appendChild(colorDiv);
                });
            }

            async function generarPDF() {
                const { jsPDF } = window.jspdf;
                if (!encuestaSelect.value || chartDataSets.length === 0) {
                    // ... (código de alerta)
                    return;
                }

                const doc = new jsPDF({ orientation: "landscape", unit: "mm", format: "a4" });
                const pageWidth = doc.internal.pageSize.getWidth();
                const pageHeight = doc.internal.pageSize.getHeight();
                const margin = 15;

                // --- Cargar la imagen de la marca de agua ---
                let watermarkData = null;
                try {
                    const response = await fetch("<?= base_url('/public/img/logo.png') ?>");
                    if (response.ok) {
                        const blob = await response.blob();
                        watermarkData = await new Promise(resolve => {
                            const reader = new FileReader();
                            reader.onload = () => resolve(reader.result);
                            reader.readAsDataURL(blob);
                        });
                    }
                } catch (error) {
                    console.error("Error al cargar la imagen de marca de agua:", error);
                }

                // --- Generación de cada página del PDF ---
                for (let index = 0; index < chartDataSets.length; index++) {
                    if (index > 0) {
                        doc.addPage();
                    }

                    const dataSet = chartDataSets[index];
                    const totalRespuestas = dataSet.datasets[0].data.reduce((a, b) => a + b, 0);
                    if (totalRespuestas === 0) continue;

                    // --- DIBUJAR LA MARCA DE AGUA EN TODA LA PÁGINA ---
                    if (watermarkData) {
                        doc.addImage(watermarkData, 'PNG', 0, 0, pageWidth, pageHeight);
                    }

                    // --- ENCABEZADO ---
                    doc.setFont("helvetica", "bold");
                    doc.setFontSize(22);
                    doc.setTextColor('#000000'); // Asegurar que el título principal sea negro
                    doc.text("Resultados de Encuesta", pageWidth / 2, 20, { align: "center" });

                    doc.setDrawColor(180);
                    doc.setLineWidth(0.5);
                    doc.line(margin, 28, pageWidth - margin, 28);

                    // --- Información de filtros ---
                    const encuestaTitle = encuestaSelect.options[encuestaSelect.selectedIndex].text;
                    const municipioName = municipioSelect.value ? municipioSelect.options[municipioSelect.selectedIndex].text : 'Todos';
                    const seccionName = seccionSelect.value ? seccionSelect.options[seccionSelect.selectedIndex].text : 'Todas';
                    const comunidadName = comunidadSelect.value ? comunidadSelect.options[comunidadSelect.selectedIndex].text : 'Todas';

                    const textoEncuesta = `${encuestaTitle}`;
                    const textoUbicacion = `Municipio: ${municipioName}  |  Sección: ${seccionName}  |  Comunidad: ${comunidadName}`;

                    doc.setFont("helvetica", "normal");
                    doc.setFontSize(10);

                    // 1. Línea de Encuesta (Rojo)
                    doc.setTextColor('#FF0000');
                    doc.text(textoEncuesta, pageWidth / 2, 34, { align: "center" });

                    // 2. Línea de Municipio y demás (Gris fuerte)
                    doc.setTextColor('#4A4A4A'); // Tono gris oscuro (#4A4A4A)
                    doc.text(textoUbicacion, pageWidth / 2, 39, { align: "center" });

                    // Restaurar el color a negro para la pregunta
                    doc.setTextColor('#000000');

                    // --- Título de la Pregunta (Con ajuste de márgenes) ---
                    doc.setFont("helvetica", "bold");
                    doc.setFontSize(16);

                    // Definimos un ancho máximo permitido para el texto (ancho total menos un margen de 20 a cada lado)
                    const maxAnchoTexto = pageWidth - 40;

                    // splitTextToSize divide el texto en un arreglo de líneas si es muy largo
                    const lineasPregunta = doc.splitTextToSize(dataSet.title, maxAnchoTexto);

                    const yPosPregunta = 49;
                    // Al pasarle el arreglo de líneas, jsPDF las imprime una debajo de la otra centradas
                    doc.text(lineasPregunta, pageWidth / 2, yPosPregunta, { align: "center" });

                    // --- GENERACIÓN DE LA GRÁFICA ---
                    const tempCanvas = document.createElement('canvas');
                    tempCanvas.width = 1200;
                    tempCanvas.height = 600;
                    const tempCtx = tempCanvas.getContext('2d');
                    tempCtx.fillStyle = "#FFFFFF";
                    tempCtx.fillRect(0, 0, tempCanvas.width, tempCanvas.height);

                    const chartType = chartTypeSelect.value;
                    const config = crearConfiguracionGrafico(dataSet, chartType, tempCtx);
                    config.options.animation = false;
                    config.options.responsive = false;

                    config.plugins = [ChartDataLabels];
                    const dropShadowPlugin = {
                        id: 'dropShadow',
                        beforeDraw: (chart) => { if (['doughnut', 'pie', 'polarArea'].includes(chart.config.type)) { const { ctx } = chart; ctx.save(); ctx.shadowColor = 'rgba(0, 0, 0, 0.35)'; ctx.shadowBlur = 12; ctx.shadowOffsetX = 6; ctx.shadowOffsetY = 6; } },
                        afterDraw: (chart) => { if (['doughnut', 'pie', 'polarArea'].includes(chart.config.type)) { chart.ctx.restore(); } }
                    };
                    if (['doughnut', 'pie', 'polarArea'].includes(config.type)) {
                        config.plugins.push(dropShadowPlugin);
                    }

                    const tempChart = new Chart(tempCtx, config);
                    await new Promise(resolve => setTimeout(resolve, 500));
                    const chartImage = tempChart.toBase64Image("image/png", 1.0);
                    tempChart.destroy();

                    // --- COLOCACIÓN DE LA GRÁFICA EN EL PDF ---
                    const maxImgWidth = pageWidth - margin * 2;
                    const yPosGrafica = yPosPregunta + 10;
                    const maxImgHeight = pageHeight - yPosGrafica - margin;
                    let imgWidth = maxImgWidth;
                    let imgHeight = (tempCanvas.height / tempCanvas.width) * imgWidth;
                    if (imgHeight > maxImgHeight) {
                        imgHeight = maxImgHeight;
                        imgWidth = (tempCanvas.width / tempCanvas.height) * imgHeight;
                    }
                    const imgX = (pageWidth - imgWidth) / 2;
                    doc.addImage(chartImage, "PNG", imgX, yPosGrafica, imgWidth, imgHeight);
                }

                doc.save("reporte-resultados.pdf");
            }

            // Eventos de botones
            generateChartsBtn.addEventListener('click', generarGraficos);
            prevChartBtn.addEventListener('click', mostrarGraficoAnterior);
            nextChartBtn.addEventListener('click', mostrarSiguienteGrafico);
            downloadPdfBtn.addEventListener('click', generarPDF);

            downloadExcelBtn.addEventListener('click', function () {
                const idEncuesta = encuestaSelect.value;
                const idsPreguntas = Array.from(preguntaCheckboxContainer.querySelectorAll('input:checked')).map(cb => cb.value);

                if (!idEncuesta || idsPreguntas.length === 0) {
                    showTemporaryAlert('Por favor, selecciona una encuesta y al menos una pregunta para generar el reporte de Excel.');
                    return;
                }

                const params = new URLSearchParams();
                params.append('id_encuesta', idEncuesta);
                params.append('ids_preguntas', idsPreguntas.join(',')); // Unimos el array en un string

                if (municipioSelect.value) params.append('id_municipio', municipioSelect.value);
                if (seccionSelect.value) params.append('id_seccion', seccionSelect.value);
                if (comunidadSelect.value) params.append('id_comunidad', comunidadSelect.value);

                // Construimos la URL usando BASE_URL y la ruta definida en routes.php
                const urlFinal = `${BASE_URL}/estadisticas/descargarExcel?${params.toString()}`;

                // Redirigimos a la nueva URL para iniciar la descarga
                window.location.href = urlFinal;
            });

        });



    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const sidebar = document.querySelector(".sidebar");
            const toggleBtn = document.querySelector(".navbar-toggler-right[data-toggle='offcanvas']");
            const overlay = document.querySelector(".sidebar-overlay");

            if (toggleBtn && sidebar) {
                toggleBtn.addEventListener("click", function () {
                    sidebar.classList.toggle("active");
                    if (overlay) overlay.classList.toggle("active");
                });
            }

            if (overlay) {
                overlay.addEventListener("click", function () {
                    sidebar.classList.remove("active");
                    overlay.classList.remove("active");
                });
            }
        });
    </script>
</body>

</html>