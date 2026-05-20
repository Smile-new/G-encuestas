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
                                                    <option value="doughnut">Velocímetros</option>
                                                    <option value="pie">Gráfica de Esferas (Burbujas)</option>
                                                    <option value="line">Línea 3D</option>
                                                    <option value="anillo_3d">Anillo Moderno 3D</option>
                                                    <option value="tarta_premium">Tarta Premium Explodida</option>
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
            // --- COPIA Y PEGA ESTA FUNCIÓN COMPLETA ---
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

                // --- MAGIA AQUÍ: Memoria Individual ---
                // Si esta pregunta no tiene un tipo asignado, usa el del selector global de arriba por defecto.
                if (!dataSet.tipoElegido) {
                    dataSet.tipoElegido = document.getElementById('chart_type_select').value || 'bar';
                }
                const currentChartType = dataSet.tipoElegido;
                const totalItems = dataSet.labels.length;

                // Cálculo de altura dinámica según el tipo elegido
                let canvasHeight = 380;
                if (currentChartType === 'doughnut') {
                    const avgLabelLen = dataSet.labels.reduce((s, l) => s + l.length, 0) / dataSet.labels.length;
                    const maxCols = avgLabelLen > 25 ? 3 : 4;
                    const rows = Math.ceil(totalItems / maxCols);
                    canvasHeight = Math.max(350, rows * 180);
                } else if (currentChartType === 'pie') {
                    canvasHeight = 450;
                } else if (currentChartType === 'line' || currentChartType === 'scatter') {
                    const maxLabelLen = Math.max(...dataSet.labels.map(l => l.length));
                    const espacioAbajo = Math.max(100, maxLabelLen * 7 + 40);
                    canvasHeight = espacioAbajo + 250;
                }

                // 3. Creación del Wrapper Principal
                const chartWrapper = document.createElement('div');
                chartWrapper.classList.add('chart-wrapper');
                chartWrapper.style.height = 'auto';
                chartWrapper.style.minHeight = '420px';

                // --- NUEVO: Encabezado con Título y Selector Individual ---
                const headerDiv = document.createElement('div');
                headerDiv.style.display = 'flex';
                headerDiv.style.justifyContent = 'space-between';
                headerDiv.style.alignItems = 'center'; // Mejor alineación vertical
                headerDiv.style.marginBottom = '20px';
                headerDiv.style.gap = '15px';
                headerDiv.style.width = '100%'; // Asegura que no se desborde

                const chartTitle = document.createElement('h4');
                chartTitle.textContent = dataSet.title;
                chartTitle.style.margin = '0';

                // --- LA MAGIA PARA QUE EL TEXTO LARGO BAJE DE LÍNEA ---
                chartTitle.style.flex = '1 1 0%';
                chartTitle.style.minWidth = '0';
                chartTitle.style.wordWrap = 'break-word';
                chartTitle.style.lineHeight = '1.4'; // Da un poco de respiro entre las líneas de texto

                chartTitle.style.textAlign = 'left'; // Alineado a la izquierda para mejor balance con el select
                chartTitle.style.color = '#333333';

                // Selector individual para esta gráfica
                const selectorIndividual = document.createElement('select');
                selectorIndividual.className = 'form-control form-control-sm';
                selectorIndividual.style.width = '160px'; // Un poquito más compacto para dar más espacio al título
                selectorIndividual.style.flexShrink = '0'; // Evita que el selector se aplaste
                selectorIndividual.style.backgroundColor = '#2a2c3d';
                selectorIndividual.style.color = '#ffffff';
                selectorIndividual.style.borderColor = '#4a4a4a';

                selectorIndividual.innerHTML = `
                    <option value="bar" ${currentChartType === 'bar' ? 'selected' : ''}>Gráfica de Barras</option>
                    <option value="doughnut" ${currentChartType === 'doughnut' ? 'selected' : ''}>Velocímetros</option>
                    <option value="pie" ${currentChartType === 'pie' ? 'selected' : ''}>Esferas Líquidas</option>
                    <option value="line" ${currentChartType === 'line' ? 'selected' : ''}>Línea 3D</option>
                    <option value="anillo_3d" ${currentChartType === 'anillo_3d' ? 'selected' : ''}>Anillo Moderno 3D</option>
                    <option value="tarta_premium" ${currentChartType === 'tarta_premium' ? 'selected' : ''}>Tarta Premium Explodida</option>
                `;

                // Si el usuario cambia el tipo, se guarda en su memoria y se repinta
                selectorIndividual.addEventListener('change', function () {
                    dataSet.tipoElegido = this.value;
                    renderizarGrafico(dataSet);
                });

                headerDiv.appendChild(chartTitle);
                headerDiv.appendChild(selectorIndividual);

                // Contenedor del Canvas
                const canvasContainer = document.createElement('div');
                canvasContainer.style.position = 'relative';
                canvasContainer.style.width = '100%';
                canvasContainer.style.height = canvasHeight + 'px';

                const chartCanvas = document.createElement('canvas');

                canvasContainer.appendChild(chartCanvas);
                chartWrapper.appendChild(headerDiv);
                chartWrapper.appendChild(canvasContainer);
                chartsContainer.appendChild(chartWrapper);

                // 4. Generar configuración y renderizar usando el tipo individual
                const ctx = chartCanvas.getContext('2d');
                const config = crearConfiguracionGrafico(dataSet, currentChartType, ctx, total);

                window.chartInstance = new Chart(ctx, config);

                // 5. Mostrar selectores de color
                const tiposPermitidos = ['bar', 'doughnut', 'pie', 'polarArea', 'line', 'scatter', 'anillo_3d', 'tarta_premium'];
                if (tiposPermitidos.includes(currentChartType)) {
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

                function hexToRgba(hex, alpha = 1) {
                    const r = parseInt(hex.slice(1, 3), 16), g = parseInt(hex.slice(3, 5), 16), b = parseInt(hex.slice(5, 7), 16);
                    return `rgba(${r},${g},${b},${alpha})`;
                }

                function adjustColor(colorHex, percent) {
                    let r = parseInt(colorHex.slice(1, 3), 16), g = parseInt(colorHex.slice(3, 5), 16), b = parseInt(colorHex.slice(5, 7), 16);
                    r = parseInt(r * (100 + percent) / 100); g = parseInt(g * (100 + percent) / 100); b = parseInt(b * (100 + percent) / 100);
                    r = r < 255 ? r : 255; g = g < 255 ? g : 255; b = b < 255 ? b : 255;
                    r = r > 0 ? r : 0; g = g > 0 ? g : 0; b = b > 0 ? b : 0;
                    return `#${r.toString(16).padStart(2, '0')}${g.toString(16).padStart(2, '0')}${b.toString(16).padStart(2, '0')}`;
                }

                // Sombra para puntos línea
                const pointShadowPlugin = {
                    id: 'pointShadow',
                    beforeDatasetsDraw: (chart) => {
                        if (['line', 'scatter'].includes(chart.config.type)) {
                            chart.ctx.save();
                            chart.ctx.shadowColor = 'rgba(0,0,0,0.3)';
                            chart.ctx.shadowBlur = 10;
                            chart.ctx.shadowOffsetY = 5;
                        }
                    },
                    afterDatasetsDraw: (chart) => {
                        if (['line', 'scatter'].includes(chart.config.type)) chart.ctx.restore();
                    }
                };

                if (!Chart.registry.plugins.get('pointShadow')) Chart.register(pointShadowPlugin);

                const colores = ['#1E88E5', '#43A047', '#FFB300', '#E53935', '#8E24AA', '#00ACC1', '#FDD835', '#6D4C41'];
                const colorTextoPrincipal = '#000000';
                const colorTextoSecundario = '#555555';
                const totalDatosGlobal = dataSet.datasets[0].data.reduce((a, b) => a + b, 0);

                let finalType = chartType;
                let finalData = JSON.parse(JSON.stringify(dataSet));

                finalData.datasets[0].backgroundColor = finalData.labels.map((label, i) => {
                    if (typeof customBarColors !== 'undefined' && customBarColors[label]) return customBarColors[label];
                    return colores[i % colores.length];
                });

                let chartOptions = {
                    maintainAspectRatio: false,
                    responsive: true,
                    animation: { duration: 1200, easing: 'easeOutQuart' },
                    layout: { padding: { top: 40, bottom: 20, left: 30, right: 30 } },
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: colorTextoSecundario,
                                font: { size: 13, weight: '600' },
                                boxWidth: 18, boxHeight: 18, padding: 25,
                                usePointStyle: true, pointStyle: 'circle'
                            }
                        },
                        datalabels: {
                            color: colorTextoPrincipal,
                            font: { weight: 'bold', size: 13 },
                            clamp: false, clip: false,
                            textShadowBlur: 0, textShadowColor: 'transparent', textStrokeWidth: 0,
                            // Solo porcentajes
                            formatter: (value) => totalDatosGlobal > 0
                                ? `${((value / totalDatosGlobal) * 100).toFixed(1)}%`
                                : '0%'
                        },
                        tooltip: {
                            enabled: true,
                            backgroundColor: 'rgba(40,44,52,0.9)',
                            titleColor: '#ffffff', bodyColor: '#dee2e6',
                            titleFont: { size: 14, weight: 'bold' },
                            bodyFont: { size: 13 },
                            padding: 16, cornerRadius: 12, boxPadding: 8,
                            borderColor: 'rgba(255,255,255,0.1)', borderWidth: 1,
                            displayColors: true, usePointStyle: true,
                            callbacks: {
                                label: (context) => {
                                    const value = context.raw;
                                    const pct = totalDatosGlobal > 0
                                        ? ((value / totalDatosGlobal) * 100).toFixed(1)
                                        : '0';
                                    return ` ${pct}%`;
                                }
                            }
                        }
                    },
                    scales: { y: { display: false }, x: { display: false } }
                };

                // ── 1. BARRAS ─────────────────────────────────────────────────────────────────
                if (chartType === 'bar') {
                    const originalColors = finalData.labels.map((label, i) => {
                        if (typeof customBarColors !== 'undefined' && customBarColors[label]) return customBarColors[label];
                        return finalData.datasets[0].backgroundColor[i] || colores[i % colores.length];
                    });

                    const datosOriginales = [...finalData.datasets[0].data];

                    chartOptions.scales.x = {
                        display: true,
                        ticks: { color: colorTextoSecundario, font: { weight: 'bold', size: 11 } },
                        grid: { display: false }, border: { display: false }
                    };
                    chartOptions.scales.y = {
                        display: false, grid: { display: false }, beginAtZero: true,
                        max: Math.ceil(Math.max(...finalData.datasets[0].data) * 1.45)
                    };

                    finalData.datasets[0].backgroundColor = originalColors.map(() => 'rgba(0,0,0,0)');
                    finalData.datasets[0].borderColor = 'rgba(0,0,0,0)';
                    finalData.datasets[0].borderWidth = 0;
                    finalData.datasets[0].borderSkipped = false;
                    finalData.datasets[0].barPercentage = 0.65;
                    chartOptions.plugins.datalabels = { display: false };

                    function drawCapsule(ctx, x, y, w, h, r) {
                        ctx.beginPath();
                        ctx.moveTo(x + r, y); ctx.lineTo(x + w - r, y);
                        ctx.arcTo(x + w, y, x + w, y + r, r); ctx.lineTo(x + w, y + h - r);
                        ctx.arcTo(x + w, y + h, x + w - r, y + h, r); ctx.lineTo(x + r, y + h);
                        ctx.arcTo(x, y + h, x, y + h - r, r); ctx.lineTo(x, y + r);
                        ctx.arcTo(x, y, x + r, y, r); ctx.closePath();
                    }

                    const liquidBarPlugin = {
                        id: 'liquidBar',
                        afterDatasetsDraw(chart) {
                            const { ctx, scales, chartArea } = chart;
                            const meta = chart.getDatasetMeta(0);
                            const yZero = scales.y.getPixelForValue(0);

                            meta.data.forEach((bar, i) => {
                                const label = finalData.labels[i];
                                const color = (typeof customBarColors !== 'undefined' && customBarColors[label])
                                    ? customBarColors[label] : originalColors[i];
                                const x = bar.x;
                                const bw = bar.width * 0.9;
                                const bx = x - bw / 2;
                                const yTop = bar.y;
                                const radius = 12;
                                const fullH = yZero - chartArea.top - 10;
                                const fullY = chartArea.top + 10;

                                // Cápsula fondo
                                ctx.save();
                                drawCapsule(ctx, bx, fullY, bw, fullH, radius);
                                ctx.fillStyle = adjustColor(color, 75); ctx.fill();
                                drawCapsule(ctx, bx, fullY, bw, fullH, radius);
                                ctx.strokeStyle = adjustColor(color, 20); ctx.lineWidth = 2.5; ctx.stroke();
                                ctx.restore();

                                // Líquido con ola
                                ctx.save();
                                drawCapsule(ctx, bx, fullY, bw, fullH, radius); ctx.clip();
                                const grad = ctx.createLinearGradient(bx, yTop, bx + bw, yTop);
                                grad.addColorStop(0, adjustColor(color, 35));
                                grad.addColorStop(0.5, color);
                                grad.addColorStop(1, adjustColor(color, -25));
                                ctx.beginPath(); ctx.moveTo(bx, yZero); ctx.lineTo(bx, yTop + 8);
                                for (let wx = 0; wx <= bw; wx += 2) {
                                    ctx.lineTo(bx + wx, yTop + Math.sin((wx / bw) * Math.PI * 2) * 8);
                                }
                                ctx.lineTo(bx + bw, yZero); ctx.closePath();
                                ctx.fillStyle = grad; ctx.fill();
                                const shine = ctx.createLinearGradient(bx, 0, bx + bw * 0.45, 0);
                                shine.addColorStop(0, 'rgba(255,255,255,0.30)');
                                shine.addColorStop(1, 'rgba(255,255,255,0)');
                                ctx.fillStyle = shine; ctx.fill();
                                ctx.restore();

                                // Etiqueta solo porcentaje
                                const valor = datosOriginales[i];
                                const pct = totalDatosGlobal > 0
                                    ? `${((valor / totalDatosGlobal) * 100).toFixed(1)}%` : '0%';
                                ctx.save();
                                ctx.textAlign = 'center'; ctx.textBaseline = 'bottom';
                                ctx.font = 'bold 13px sans-serif';
                                ctx.fillStyle = adjustColor(color, -30);
                                ctx.fillText(pct, x, yTop - 8);
                                ctx.restore();
                            });
                        }
                    };

                    chartOptions.layout.padding = { top: 40, bottom: 20, left: 20, right: 20 };
                    finalType = 'bar';
                    chartOptions._liquidBarPlugin = liquidBarPlugin;

                    return {
                        type: finalType, data: finalData, options: chartOptions,
                        plugins: [ChartDataLabels, liquidBarPlugin]
                    };
                }

                if (chartType === 'doughnut') {
                    finalData.datasets[0].backgroundColor = 'transparent';
                    finalData.datasets[0].borderColor = 'transparent';
                    finalData.datasets[0].borderWidth = 0;

                    chartOptions.plugins.legend = { display: false };
                    chartOptions.plugins.datalabels = { display: false };
                    chartOptions.plugins.tooltip = { enabled: false };
                    chartOptions.layout.padding = { top: 40, bottom: 40, left: 20, right: 20 };

                    const velocimetroGridPlugin = {
                        id: 'velocimetroGrid',
                        afterDraw(chart) {
                            const { ctx, chartArea } = chart;
                            const labels = finalData.labels;
                            const data = finalData.datasets[0].data;
                            const totalItems = labels.length;

                            if (totalItems === 0) return;

                            // 🔥 CORRECCIÓN 1: Limitar cols según longitud de etiquetas
                            const avgLabelLen = labels.reduce((s, l) => s + l.length, 0) / labels.length;
                            const maxCols = avgLabelLen > 25 ? 3 : 4;
                            const cols = Math.min(maxCols, totalItems);
                            const rows = Math.ceil(totalItems / cols);

                            const cellW = chartArea.width / cols;
                            const cellH = chartArea.height / rows;

                            // 🔥 CORRECCIÓN 2: Radio más pequeño para que quepan las etiquetas
                            const radius = Math.min(cellW, cellH) * 0.22;

                            data.forEach((val, i) => {
                                const label = labels[i];

                                const color = (typeof customBarColors !== 'undefined' && customBarColors[label])
                                    ? customBarColors[label]
                                    : colores[i % colores.length];

                                const col = i % cols;
                                const row = Math.floor(i / cols);

                                // 🔥 CORRECCIÓN 3: Calcular espacio real que ocupa la etiqueta
                                ctx.font = 'bold 11px Arial';
                                const maxWidth = cellW - 20;
                                const words = label.split(' ');
                                let line = '';
                                let labelLines = [];
                                words.forEach(word => {
                                    const testLine = line + word + ' ';
                                    if (ctx.measureText(testLine).width > maxWidth) {
                                        labelLines.push(line);
                                        line = word + ' ';
                                    } else {
                                        line = testLine;
                                    }
                                });
                                labelLines.push(line);
                                labelLines = labelLines.slice(0, 2);

                                const labelHeight = labelLines.length * 14 + 28;

                                // 🔥 CORRECCIÓN 4: cy desplazado hacia arriba según el espacio de etiqueta
                                const cx = chartArea.left + (col * cellW) + (cellW / 2);
                                const cy = chartArea.top + (row * cellH) + (cellH / 2) - (labelHeight / 2) + 10;

                                const pct = totalDatosGlobal > 0 ? val / totalDatosGlobal : 0;
                                const pctText = (pct * 100).toFixed(1) + '%';

                                // =========================
                                // TICKS GRISES
                                // =========================
                                ctx.save();
                                ctx.translate(cx, cy);

                                const numTicks = 36;

                                for (let t = 0; t < numTicks; t++) {
                                    const angle = (t / numTicks) * Math.PI * 2;
                                    const innerTick = radius + 8;
                                    const outerTick = t % 4 === 0 ? radius + 16 : radius + 12;

                                    ctx.strokeStyle = 'rgba(210,215,220,0.6)';
                                    ctx.lineWidth = t % 4 === 0 ? 2 : 1;

                                    ctx.beginPath();
                                    ctx.moveTo(Math.cos(angle) * innerTick, Math.sin(angle) * innerTick);
                                    ctx.lineTo(Math.cos(angle) * outerTick, Math.sin(angle) * outerTick);
                                    ctx.stroke();
                                }
                                ctx.restore();

                                // =========================
                                // TICKS ACTIVOS
                                // =========================
                                ctx.save();
                                ctx.translate(cx, cy);
                                ctx.rotate(-Math.PI / 2);

                                const activeTicks = Math.round(pct * numTicks);

                                for (let t = 0; t <= activeTicks && t < numTicks && pct > 0; t++) {
                                    const angle = (t / numTicks) * Math.PI * 2;
                                    const innerTick = radius + 8;
                                    const outerTick = t % 4 === 0 ? radius + 16 : radius + 12;

                                    ctx.strokeStyle = color;
                                    ctx.lineWidth = t % 4 === 0 ? 2.5 : 1.5;

                                    ctx.beginPath();
                                    ctx.moveTo(Math.cos(angle) * innerTick, Math.sin(angle) * innerTick);
                                    ctx.lineTo(Math.cos(angle) * outerTick, Math.sin(angle) * outerTick);
                                    ctx.stroke();
                                }
                                ctx.restore();

                                // =========================
                                // ANILLO BASE
                                // =========================
                                ctx.beginPath();
                                ctx.arc(cx, cy, radius, 0, Math.PI * 2);
                                ctx.strokeStyle = 'rgba(235,240,245,0.8)';
                                ctx.lineWidth = 10;
                                ctx.stroke();

                                // =========================
                                // PROGRESO
                                // =========================
                                if (pct > 0) {
                                    ctx.beginPath();
                                    const startAngle = -Math.PI / 2;
                                    const endAngle = startAngle + (pct * Math.PI * 2);

                                    ctx.arc(cx, cy, radius, startAngle, endAngle);
                                    ctx.strokeStyle = color;
                                    ctx.lineWidth = 10;
                                    ctx.lineCap = 'round';
                                    ctx.stroke();
                                }

                                // =========================
                                // TEXTOS
                                // =========================
                                ctx.save();
                                ctx.textAlign = 'center';
                                ctx.textBaseline = 'middle';

                                // % principal
                                ctx.font = 'bold 18px Arial';
                                ctx.fillStyle = color;
                                ctx.fillText(pctText, cx, cy - 6);

                                // valor
                                ctx.font = '12px Arial';
                                ctx.fillStyle = '#777';
                                ctx.fillText(val, cx, cy + 12);

                                // 🔥 CORRECCIÓN 5: Label multilínea con más separación del anillo
                                ctx.font = 'bold 11px Arial';
                                ctx.fillStyle = '#222';

                                // 🔥 CORRECCIÓN 6: Mayor distancia entre la dona y la etiqueta
                                const startY = cy + radius + 28;

                                labelLines.forEach((l, index) => {
                                    ctx.fillText(l.trim(), cx, startY + (index * 14));
                                });

                                ctx.restore();
                            });
                        }
                    };

                    return {
                        type: 'doughnut',
                        data: finalData,
                        options: chartOptions,
                        plugins: [velocimetroGridPlugin]
                    };
                }

                // ── 4. ANILLO MODERNO 3D ──────────────────────────────────────────────────────
    
                if (chartType === 'anillo_3d') {
                    const originalColors = [...finalData.datasets[0].backgroundColor];
                    chartOptions.cutout = '60%';
                    chartOptions.layout.padding = { top: 50, bottom: 100, left: 80, right: 80 };
                    
                    chartOptions.animation = {
                        animateRotate: true,
                        animateScale: true,
                        duration: 1600,
                        easing: 'easeOutExpo'
                    };

                    chartOptions.plugins.legend = {
                        display: true,
                        position: 'bottom',
                        labels: {
                            color: '#333',
                            font: { size: 12, weight: '600' },
                            // --- CORRECCIÓN 2: Padding de leyenda ampliado ---
                            padding: 30, // Empuja las cajas de leyenda lejos del lienzo
                            usePointStyle: true,
                            pointStyle: 'circle',
                            boxWidth: 10,
                            boxHeight: 10
                        }
                    };

                    chartOptions.plugins.tooltip = {
                        backgroundColor: 'rgba(15,20,40,0.92)',
                        titleColor: '#fff',
                        bodyColor: '#ccc',
                        padding: 14,
                        cornerRadius: 10,
                        borderColor: 'rgba(255,255,255,0.12)',
                        borderWidth: 1,
                        callbacks: {
                            label: (ctx) => {
                                const pct = ((ctx.raw / totalDatosGlobal) * 100).toFixed(1);
                                return `  ${pct}%`;
                            }
                        }
                    };

                    // Dataset base
                    finalData.datasets[0].borderRadius = 12;
                    finalData.datasets[0].spacing = 4;
                    finalData.datasets[0].borderWidth = 3;
                    finalData.datasets[0].borderColor = '#ffffff';
                    finalData.datasets[0].hoverOffset = 20;
                    finalData.datasets[0].hoverBorderColor = '#ffffff';
                    finalData.datasets[0].hoverBorderWidth = 4;

                    // Datalabels — banderilla sin duplicado
                    chartOptions.plugins.datalabels = {
                        display: false // Lo maneja el plugin custom
                    };

                    // Plugin gradiente metálico
                    const gradientPlugin = {
                        id: 'gradientFill',
                        beforeDatasetsDraw(chart) {
                            const { ctx, chartArea } = chart;
                            if (!chartArea) return;
                            chart.data.datasets[0].backgroundColor = chart.data.labels.map((label, idx) => {
                                const base = (typeof customBarColors !== 'undefined' && customBarColors[label])
                                    ? customBarColors[label]
                                    : originalColors[idx % originalColors.length];
                                const grad = ctx.createLinearGradient(
                                    chartArea.left, chartArea.top, chartArea.right, chartArea.bottom
                                );
                                grad.addColorStop(0, adjustColor(base, 65));
                                grad.addColorStop(0.35, base);
                                grad.addColorStop(0.75, adjustColor(base, -20));
                                grad.addColorStop(1, adjustColor(base, -50));
                                return grad;
                            });
                        }
                    };

                    // Plugin sombra 3D
                    const shadow3DPlugin = {
                        id: 'shadow3D',
                        beforeDatasetsDraw(chart) {
                            const { ctx } = chart;
                            ctx.save();
                            ctx.shadowColor = 'rgba(0,0,0,0.3)';
                            ctx.shadowBlur = 20;
                            ctx.shadowOffsetX = 4;
                            ctx.shadowOffsetY = 12;
                        },
                        afterDatasetsDraw(chart) { chart.ctx.restore(); }
                    };

                    // Plugin brillo interior del anillo
                    const brilloPlugin = {
                        id: 'brilloAnillo',
                        afterDatasetsDraw(chart) {
                            const { ctx, chartArea } = chart;
                            const meta = chart.getDatasetMeta(0);
                            const cx = (chartArea.left + chartArea.right) / 2;
                            const cy = (chartArea.top + chartArea.bottom) / 2;

                            meta.data.forEach((arc) => {
                                const innerR = arc.innerRadius;
                                const outerR = arc.outerRadius;
                                const start = arc.startAngle;
                                const end = arc.endAngle;

                                // Brillo superior
                                ctx.save();
                                ctx.beginPath();
                                ctx.arc(cx, cy, outerR, start, end);
                                ctx.arc(cx, cy, outerR - (outerR - innerR) * 0.3, end, start, true);
                                ctx.closePath();
                                ctx.fillStyle = 'rgba(255,255,255,0.18)';
                                ctx.fill();
                                ctx.restore();

                                // Borde interior luminoso
                                ctx.save();
                                ctx.beginPath();
                                ctx.arc(cx, cy, innerR + 1, start, end);
                                ctx.strokeStyle = 'rgba(255,255,255,0.35)';
                                ctx.lineWidth = 2;
                                ctx.stroke();
                                ctx.restore();
                            });
                        }
                    };

                    // Plugin banderillas sin duplicado
                    const banderillaPlugin = {
                        id: 'banderillaAnillo3D',
                        afterDatasetsDraw(chart) {
                            const { ctx, chartArea } = chart;
                            const meta = chart.getDatasetMeta(0);
                            const cx = (chartArea.left + chartArea.right) / 2;
                            const cy = (chartArea.top + chartArea.bottom) / 2;
                            const MIN_SEP = 20;

                            const labels = [];
                            meta.data.forEach((arc, i) => {
                                const value = chart.data.datasets[0].data[i];
                                const pct = totalDatosGlobal > 0 ? ((value / totalDatosGlobal) * 100) : 0;
                                if (pct < 2) return;

                                const labelKey = finalData.labels[i];
                                const color = (typeof customBarColors !== 'undefined' && customBarColors[labelKey])
                                    ? customBarColors[labelKey]
                                    : originalColors[i % originalColors.length];

                                const midAngle = (arc.startAngle + arc.endAngle) / 2;
                                const outerR = arc.outerRadius;
                                const isRight = Math.cos(midAngle) >= 0;
                                const lineLen = pct < 5 ? 42 : 28;
                                const p2x = cx + Math.cos(midAngle) * (outerR + lineLen);
                                const p2y = cy + Math.sin(midAngle) * (outerR + lineLen);
                                const horizLen = isRight ? 20 : -20;

                                labels.push({
                                    color, isRight,
                                    p1x: cx + Math.cos(midAngle) * (outerR + 4),
                                    p1y: cy + Math.sin(midAngle) * (outerR + 4),
                                    p2x, p2y,
                                    p3x: p2x + horizLen,
                                    p3y: p2y,
                                    label: `${pct.toFixed(1)}%`
                                });
                            });

                            // Resolver colisiones
                            const resolver = (grupo) => {
                                for (let iter = 0; iter < 15; iter++) {
                                    for (let i = 1; i < grupo.length; i++) {
                                        const prev = grupo[i - 1], curr = grupo[i];
                                        const diff = curr.p3y - prev.p3y;
                                        if (diff < MIN_SEP) {
                                            const adj = (MIN_SEP - diff) / 2;
                                            prev.p3y -= adj; prev.p2y -= adj;
                                            curr.p3y += adj; curr.p2y += adj;
                                        }
                                    }
                                }
                            };

                            const left = labels.filter(l => !l.isRight).sort((a, b) => a.p3y - b.p3y);
                            const right = labels.filter(l => l.isRight).sort((a, b) => a.p3y - b.p3y);
                            resolver(left);
                            resolver(right);

                            [...left, ...right].forEach(({ color, isRight, p1x, p1y, p2x, p2y, p3x, p3y, label }) => {
                                const textX = isRight ? p3x + 5 : p3x - 5;
                                const textAlign = isRight ? 'left' : 'right';

                                // Línea conectora
                                ctx.save();
                                ctx.beginPath();
                                ctx.moveTo(p1x, p1y);
                                ctx.lineTo(p2x, p2y);
                                ctx.lineTo(p3x, p3y);
                                ctx.strokeStyle = color;
                                ctx.lineWidth = 1.5;
                                ctx.stroke();

                                // Badge
                                ctx.font = 'bold 11px sans-serif';
                                const tw = ctx.measureText(label).width + 10;
                                const th = 18;
                                const bgX = textAlign === 'left' ? textX - 2 : textX - tw + 2;

                                ctx.fillStyle = 'rgba(255,255,255,0.96)';
                                ctx.beginPath();
                                ctx.roundRect(bgX, p3y - th / 2, tw, th, 4);
                                ctx.fill();

                                ctx.strokeStyle = color;
                                ctx.lineWidth = 1;
                                ctx.stroke();

                                ctx.fillStyle = adjustColor(color, -30);
                                ctx.textAlign = textAlign;
                                ctx.textBaseline = 'middle';
                                ctx.fillText(label, textX, p3y);
                                ctx.restore();
                            });
                        }
                    };

                    return {
                        type: 'doughnut',
                        data: finalData,
                        options: chartOptions,
                        plugins: [ChartDataLabels, shadow3DPlugin, gradientPlugin, brilloPlugin, banderillaPlugin]
                    };
                }

                // ── 5. TARTA PREMIUM EXPLODIDA ────────────────────────────────────────────────
                // ── 6. TARTA PREMIUM EXPLODIDA (CON BANDERILLAS Y ZONA SEGURA) ───────────────
                if (chartType === 'tarta_premium') {
                    const originalColors = [...finalData.datasets[0].backgroundColor];

                    // --- 1. ZONA SEGURA: Mucho padding inferior para las banderillas ---
                    chartOptions.layout.padding = { top: 50, bottom: 100, left: 80, right: 80 };

                    chartOptions.animation = {
                        animateRotate: true,
                        animateScale: true,
                        duration: 1500,
                        easing: 'easeOutExpo'
                    };

                    chartOptions.plugins.legend = {
                        display: true,
                        position: 'bottom',
                        labels: {
                            color: '#333',
                            font: { size: 12, weight: '600' },
                            padding: 30, // Empuja las opciones lejos de las líneas
                            usePointStyle: true,
                            pointStyle: 'circle',
                            boxWidth: 10,
                            boxHeight: 10
                        }
                    };

                    chartOptions.plugins.tooltip = {
                        backgroundColor: 'rgba(15,20,40,0.92)',
                        titleColor: '#fff',
                        bodyColor: '#ccc',
                        padding: 14,
                        cornerRadius: 10,
                        borderColor: 'rgba(255,255,255,0.12)',
                        borderWidth: 1,
                        callbacks: {
                            label: (ctx) => {
                                const pct = ((ctx.raw / totalDatosGlobal) * 100).toFixed(1);
                                return `  ${pct}%`;
                            }
                        }
                    };

                    // ✨ Estilo del Dataset (Piezas de la tarta)
                    finalData.datasets[0].borderRadius = 6; // Bordes ligeramente suaves
                    finalData.datasets[0].spacing = 8;      // Piezas separadas (efecto explosión)
                    finalData.datasets[0].borderWidth = 2;
                    finalData.datasets[0].borderColor = '#ffffff';
                    finalData.datasets[0].hoverOffset = 25; // Salta mucho al pasar el mouse
                    finalData.datasets[0].hoverBorderColor = '#ffffff';
                    finalData.datasets[0].hoverBorderWidth = 3;

                    // Desactivamos los números internos porque usaremos las banderillas
                    chartOptions.plugins.datalabels = {
                        display: false 
                    };

                    // 🎨 Plugin: Gradiente Metálico para cada rebanada
                    const gradientTartaPlugin = {
                        id: 'gradientTarta',
                        beforeDatasetsDraw(chart) {
                            const { ctx, chartArea } = chart;
                            if (!chartArea) return;
                            chart.data.datasets[0].backgroundColor = chart.data.labels.map((label, idx) => {
                                const base = (typeof customBarColors !== 'undefined' && customBarColors[label])
                                    ? customBarColors[label]
                                    : originalColors[idx % originalColors.length];
                                const grad = ctx.createLinearGradient(
                                    chartArea.left, chartArea.top, chartArea.right, chartArea.bottom
                                );
                                grad.addColorStop(0, adjustColor(base, 50));   // Luz superior
                                grad.addColorStop(0.4, base);                  // Color base
                                grad.addColorStop(0.8, adjustColor(base, -20));
                                grad.addColorStop(1, adjustColor(base, -40));  // Sombra inferior
                                return grad;
                            });
                        }
                    };

                    // 🕳️ Plugin: Sombra 3D profunda
                    const shadowTartaPlugin = {
                        id: 'shadowTarta',
                        beforeDatasetsDraw(chart) {
                            const { ctx } = chart;
                            ctx.save();
                            ctx.shadowColor = 'rgba(0,0,0,0.35)';
                            ctx.shadowBlur = 18;
                            ctx.shadowOffsetX = 6;
                            ctx.shadowOffsetY = 12;
                        },
                        afterDatasetsDraw(chart) { chart.ctx.restore(); }
                    };

                    // 🚩 Plugin: Banderillas inteligentes (evitan superponerse)
                    const banderillaTartaPlugin = {
                        id: 'banderillaTarta',
                        afterDatasetsDraw(chart) {
                            const { ctx, chartArea } = chart;
                            const meta = chart.getDatasetMeta(0);
                            const cx = (chartArea.left + chartArea.right) / 2;
                            const cy = (chartArea.top + chartArea.bottom) / 2;
                            const MIN_SEP = 20; // Separación mínima entre banderillas

                            const labels = [];
                            meta.data.forEach((arc, i) => {
                                const value = chart.data.datasets[0].data[i];
                                const pct = totalDatosGlobal > 0 ? ((value / totalDatosGlobal) * 100) : 0;
                                if (pct < 2) return; // No muestra línea si es muy pequeño

                                const labelKey = finalData.labels[i];
                                const color = (typeof customBarColors !== 'undefined' && customBarColors[labelKey])
                                    ? customBarColors[labelKey]
                                    : originalColors[i % originalColors.length];

                                const midAngle = (arc.startAngle + arc.endAngle) / 2;
                                const outerR = arc.outerRadius;
                                const isRight = Math.cos(midAngle) >= 0;
                                
                                // Línea un poco más larga si el porcentaje es pequeño
                                const lineLen = pct < 5 ? 45 : 30; 
                                const p2x = cx + Math.cos(midAngle) * (outerR + lineLen);
                                const p2y = cy + Math.sin(midAngle) * (outerR + lineLen);
                                const horizLen = isRight ? 20 : -20;

                                labels.push({
                                    color, isRight,
                                    p1x: cx + Math.cos(midAngle) * (outerR + 2), // Nace justito en el borde
                                    p1y: cy + Math.sin(midAngle) * (outerR + 2),
                                    p2x, p2y,
                                    p3x: p2x + horizLen,
                                    p3y: p2y,
                                    label: `${pct.toFixed(1)}%`
                                });
                            });

                            // Resolver choques entre líneas
                            const resolver = (grupo) => {
                                for (let iter = 0; iter < 15; iter++) {
                                    for (let i = 1; i < grupo.length; i++) {
                                        const prev = grupo[i - 1], curr = grupo[i];
                                        const diff = curr.p3y - prev.p3y;
                                        if (diff < MIN_SEP) {
                                            const adj = (MIN_SEP - diff) / 2;
                                            prev.p3y -= adj; prev.p2y -= adj;
                                            curr.p3y += adj; curr.p2y += adj;
                                        }
                                    }
                                }
                            };

                            const left = labels.filter(l => !l.isRight).sort((a, b) => a.p3y - b.p3y);
                            const right = labels.filter(l => l.isRight).sort((a, b) => a.p3y - b.p3y);
                            resolver(left);
                            resolver(right);

                            // Dibujar las líneas y los cuadros de texto
                            [...left, ...right].forEach(({ color, isRight, p1x, p1y, p2x, p2y, p3x, p3y, label }) => {
                                const textX = isRight ? p3x + 5 : p3x - 5;
                                const textAlign = isRight ? 'left' : 'right';

                                // Trazo de la línea
                                ctx.save();
                                ctx.beginPath();
                                ctx.moveTo(p1x, p1y);
                                ctx.lineTo(p2x, p2y);
                                ctx.lineTo(p3x, p3y);
                                ctx.strokeStyle = color;
                                ctx.lineWidth = 1.5;
                                ctx.stroke();

                                // Fondo del porcentaje (Badge)
                                ctx.font = 'bold 11px sans-serif';
                                const tw = ctx.measureText(label).width + 10;
                                const th = 18;
                                const bgX = textAlign === 'left' ? textX - 2 : textX - tw + 2;

                                ctx.fillStyle = 'rgba(255,255,255,0.96)';
                                ctx.beginPath();
                                ctx.roundRect(bgX, p3y - th / 2, tw, th, 4);
                                ctx.fill();

                                ctx.strokeStyle = color;
                                ctx.lineWidth = 1;
                                ctx.stroke();

                                // Texto del porcentaje
                                ctx.fillStyle = adjustColor(color, -30); // Texto un poco más oscuro que la línea
                                ctx.textAlign = textAlign;
                                ctx.textBaseline = 'middle';
                                ctx.fillText(label, textX, p3y);
                                ctx.restore();
                            });
                        }
                    };

                    return {
                        type: 'pie',
                        data: finalData,
                        options: chartOptions,
                        plugins: [ChartDataLabels, shadowTartaPlugin, gradientTartaPlugin, banderillaTartaPlugin]
                    };
                }

                
                if (chartType === 'pie') {
                    const originalColors = [...finalData.datasets[0].backgroundColor];

                    chartOptions.plugins.datalabels = { display: false };
                    chartOptions.plugins.legend = { display: false };
                    chartOptions.plugins.tooltip = { enabled: false };
                    chartOptions.layout.padding = { top: 20, bottom: 20, left: 20, right: 20 };

                    finalData.datasets[0].backgroundColor = 'transparent';
                    finalData.datasets[0].borderColor = 'transparent';
                    finalData.datasets[0].borderWidth = 0;

                    const esferaPlugin = {
                        id: 'esferaLiquida',
                        afterDraw(chart) {
                            const { ctx, chartArea } = chart;
                            const labels = finalData.labels;
                            const data = finalData.datasets[0].data;
                            const totalItems = labels.length;

                            if (totalItems === 0) return;

                            const cols = Math.min(4, totalItems);
                            const rows = Math.ceil(totalItems / cols);
                            const cellW = chartArea.width / cols;
                            const cellH = chartArea.height / rows;

                            const LABEL_RESERVE = 28;
                            const radius = Math.min(cellW, cellH - LABEL_RESERVE) * 0.38;

                            data.forEach((val, i) => {
                                const labelKey = labels[i];
                                const color = (typeof customBarColors !== 'undefined' && customBarColors[labelKey])
                                    ? customBarColors[labelKey]
                                    : originalColors[i] || colores[i % colores.length];

                                const col = i % cols;
                                const row = Math.floor(i / cols);

                                const cx = chartArea.left + col * cellW + cellW / 2;
                                const cy = chartArea.top + row * cellH + (cellH - LABEL_RESERVE) / 2;

                                const pct = totalDatosGlobal > 0 ? val / totalDatosGlobal : 0;
                                const pctText = (pct * 100).toFixed(1) + '%';

                                // Helper: parsear color a rgba
                                const parseColor = (c) => {
                                    const tmp = document.createElement('canvas');
                                    tmp.width = tmp.height = 1;
                                    const tctx = tmp.getContext('2d');
                                    tctx.fillStyle = c;
                                    tctx.fillRect(0, 0, 1, 1);
                                    const d = tctx.getImageData(0, 0, 1, 1).data;
                                    return { r: d[0], g: d[1], b: d[2] };
                                };

                                const rgb = parseColor(color);
                                const colorRgb = `${rgb.r},${rgb.g},${rgb.b}`;

                                // =====================
                                // CLIP A LA ESFERA
                                // =====================
                                ctx.save();
                                ctx.beginPath();
                                ctx.arc(cx, cy, radius, 0, Math.PI * 2);
                                ctx.clip();

                                // Fondo muy claro (interior vacío)
                                ctx.fillStyle = `rgba(${colorRgb}, 0.08)`;
                                ctx.fillRect(cx - radius, cy - radius, radius * 2, radius * 2);

                                // Nivel del líquido: de abajo hacia arriba según pct
                                const liquidTop = cy + radius - (pct * radius * 2);

                                // Ola: curva senoidal suave
                                const waveAmp = radius * 0.06;
                                const waveFreq = (Math.PI * 2) / (radius * 2);

                                // Relleno del líquido con ola
                                ctx.beginPath();
                                ctx.moveTo(cx - radius, cy + radius); // esquina inferior izq
                                // ola superior
                                for (let x = cx - radius; x <= cx + radius; x += 1) {
                                    const y = liquidTop + Math.sin((x - cx) * waveFreq * 2) * waveAmp;
                                    ctx.lineTo(x, y);
                                }
                                ctx.lineTo(cx + radius, cy + radius); // esquina inferior der
                                ctx.closePath();

                                // Gradiente vertical del líquido
                                const gradLiq = ctx.createLinearGradient(cx, liquidTop, cx, cy + radius);
                                gradLiq.addColorStop(0, `rgba(${colorRgb}, 0.55)`);
                                gradLiq.addColorStop(1, `rgba(${colorRgb}, 0.85)`);
                                ctx.fillStyle = gradLiq;
                                ctx.fill();

                                // Segunda ola (más transparente, desplazada) para efecto profundidad
                                ctx.beginPath();
                                ctx.moveTo(cx - radius, cy + radius);
                                for (let x = cx - radius; x <= cx + radius; x += 1) {
                                    const y = liquidTop + radius * 0.04 + Math.sin((x - cx) * waveFreq * 2 + 1.2) * waveAmp * 0.7;
                                    ctx.lineTo(x, y);
                                }
                                ctx.lineTo(cx + radius, cy + radius);
                                ctx.closePath();
                                ctx.fillStyle = `rgba(${colorRgb}, 0.25)`;
                                ctx.fill();

                                // Brillo superior (reflejo de esfera)
                                const gradBrillo = ctx.createRadialGradient(
                                    cx - radius * 0.3, cy - radius * 0.35, radius * 0.05,
                                    cx, cy, radius
                                );
                                gradBrillo.addColorStop(0, 'rgba(255,255,255,0.45)');
                                gradBrillo.addColorStop(0.4, 'rgba(255,255,255,0.10)');
                                gradBrillo.addColorStop(1, 'rgba(255,255,255,0)');
                                ctx.fillStyle = gradBrillo;
                                ctx.fillRect(cx - radius, cy - radius, radius * 2, radius * 2);

                                ctx.restore(); // fin del clip

                                // =====================
                                // BORDE EXTERIOR DE LA ESFERA
                                // =====================
                                ctx.beginPath();
                                ctx.arc(cx, cy, radius, 0, Math.PI * 2);
                                ctx.strokeStyle = color;
                                ctx.lineWidth = 3;
                                ctx.stroke();

                                // =====================
                                // TEXTO % CENTRADO
                                // =====================
                                ctx.save();
                                ctx.textAlign = 'center';
                                ctx.textBaseline = 'middle';

                                const fontSize = Math.max(12, radius * 0.32);
                                ctx.font = `bold ${fontSize}px Arial`;

                                // Sombra suave para legibilidad
                                ctx.shadowColor = 'rgba(255,255,255,0.8)';
                                ctx.shadowBlur = 6;
                                ctx.fillStyle = color;
                                ctx.fillText(pctText, cx, cy);
                                ctx.restore();

                                // =====================
                                // LABEL NOMBRE ABAJO
                                // =====================
                                ctx.save();
                                ctx.textAlign = 'center';
                                ctx.textBaseline = 'top';
                                ctx.font = `bold 11px Arial`;
                                ctx.fillStyle = '#333';

                                const maxW = cellW - 10;
                                const words = labelKey.split(' ');
                                let line = '';
                                let lLines = [];
                                words.forEach(w => {
                                    const test = line + w + ' ';
                                    if (ctx.measureText(test).width > maxW) {
                                        lLines.push(line.trim());
                                        line = w + ' ';
                                    } else {
                                        line = test;
                                    }
                                });
                                lLines.push(line.trim());
                                lLines = lLines.slice(0, 2);

                                const labelStartY = cy + radius + 10;
                                lLines.forEach((l, li) => {
                                    ctx.fillText(l, cx, labelStartY + li * 14);
                                });
                                ctx.restore();
                            });
                        }
                    };

                    return {
                        type: 'pie',
                        data: finalData,
                        options: chartOptions,
                        plugins: [esferaPlugin]
                    };
                }
                // ── 3. LÍNEA 3D PREMIUM ───────────────────────────────────────────────────────
                if (['line', 'scatter'].includes(chartType)) {
                    const isScatter = chartType === 'scatter';

                    // Color fijo — azul marino para la línea, rojo para los puntos
                    const lineColor = '#1a3a6b';
                    const pointColor = '#e53935';
                    const fillColor = '#1a3a6b';

                    chartOptions.plugins.legend.display = false;
                    chartOptions.scales.x = {
                        display: !isScatter,
                        grid: { display: false, drawBorder: false },
                        ticks: { color: colorTextoSecundario, font: { weight: 'bold' } }
                    };
                    chartOptions.scales.y = {
                        display: false, beginAtZero: true,
                        max: Math.ceil(Math.max(...finalData.datasets[0].data) * 1.3)
                    };

                    // Fondo gris suave
                    const gradient = ctx.createLinearGradient(0, 0, 0, 500);
                    gradient.addColorStop(0, 'rgba(200,205,215,0.45)');
                    gradient.addColorStop(0.6, 'rgba(200,205,215,0.15)');
                    gradient.addColorStop(1, 'rgba(200,205,215,0.0)');

                    finalData.datasets[0].tension = 0.45;
                    finalData.datasets[0].borderColor = lineColor;
                    finalData.datasets[0].borderWidth = 3;
                    finalData.datasets[0].fill = !isScatter;
                    finalData.datasets[0].backgroundColor = gradient;

                    // Todos los puntos rojos
                    finalData.datasets[0].pointRadius = 9;
                    finalData.datasets[0].pointBackgroundColor = pointColor;
                    finalData.datasets[0].pointBorderColor = '#ffffff';
                    finalData.datasets[0].pointBorderWidth = 3;
                    finalData.datasets[0].pointHoverRadius = 13;
                    finalData.datasets[0].pointHoverBorderWidth = 4;
                    finalData.datasets[0].pointHoverBorderColor = '#ffffff';

                    const lineShadowPlugin = {
                        id: 'lineShadow',
                        beforeDatasetsDraw(chart) {
                            const { ctx } = chart;
                            ctx.save();
                            ctx.shadowColor = 'rgba(26,58,107,0.3)';
                            ctx.shadowBlur = 10;
                            ctx.shadowOffsetY = 5;
                        },
                        afterDatasetsDraw(chart) { chart.ctx.restore(); }
                    };

                    chartOptions.plugins.datalabels = {
                        ...chartOptions.plugins.datalabels,
                        display: true,
                        align: 'top',
                        anchor: 'end',
                        offset: 10,
                        color: lineColor,
                        font: { weight: 'bold', size: 12 },
                        backgroundColor: 'rgba(255,255,255,0.88)',
                        borderRadius: 6,
                        padding: { top: 3, bottom: 3, left: 6, right: 6 },
                        textShadowBlur: 0,
                        textShadowColor: 'transparent',
                        textStrokeWidth: 0,
                        formatter: (value) => totalDatosGlobal > 0
                            ? `${((value / totalDatosGlobal) * 100).toFixed(1)}%` : '0%'
                    };

                    if (isScatter) {
                        finalData.datasets[0].data = finalData.labels.map((label, i) => ({
                            x: label, y: finalData.datasets[0].data[i]
                        }));
                        chartOptions.scales.x = {
                            type: 'category', labels: finalData.labels, grid: { display: false }
                        };
                        finalData.datasets[0].showLine = true;
                        finalData.datasets[0].pointBackgroundColor = pointColor;
                    }

                    return {
                        type: finalType,
                        data: finalData,
                        options: chartOptions,
                        plugins: [ChartDataLabels, lineShadowPlugin, pointShadowPlugin]
                    };
                }

                // Return base por si no coincide ningún tipo
                return { type: finalType, data: finalData, options: chartOptions };
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
                    return;
                }

                const doc = new jsPDF({ orientation: "landscape", unit: "mm", format: "a4" });
                const pageWidth = doc.internal.pageSize.getWidth();
                const pageHeight = doc.internal.pageSize.getHeight();
                const margin = 15;

                // Cargar marca de agua
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
                    console.error("Error al cargar marca de agua:", error);
                }

                for (let index = 0; index < chartDataSets.length; index++) {
                    if (index > 0) doc.addPage();

                    const dataSet = chartDataSets[index];
                    const totalRespuestas = dataSet.datasets[0].data.reduce((a, b) => a + b, 0);
                    if (totalRespuestas === 0) continue;

                    // Marca de agua
                    if (watermarkData) {
                        doc.addImage(watermarkData, 'PNG', 0, 0, pageWidth, pageHeight);
                    }

                    // Encabezado
                    doc.setFont("helvetica", "bold");
                    doc.setFontSize(22);
                    doc.setTextColor('#000000');
                    doc.text("Resultados de Encuesta", pageWidth / 2, 20, { align: "center" });

                    doc.setDrawColor(180);
                    doc.setLineWidth(0.5);
                    doc.line(margin, 28, pageWidth - margin, 28);

                    const encuestaTitle = encuestaSelect.options[encuestaSelect.selectedIndex].text;
                    const municipioName = municipioSelect.value ? municipioSelect.options[municipioSelect.selectedIndex].text : 'Todos';
                    const seccionName = seccionSelect.value ? seccionSelect.options[seccionSelect.selectedIndex].text : 'Todas';
                    const comunidadName = comunidadSelect.value ? comunidadSelect.options[comunidadSelect.selectedIndex].text : 'Todas';

                    doc.setFont("helvetica", "normal");
                    doc.setFontSize(10);
                    doc.setTextColor('#FF0000');
                    doc.text(encuestaTitle, pageWidth / 2, 34, { align: "center" });
                    doc.setTextColor('#4A4A4A');
                    doc.text(`Municipio: ${municipioName}  |  Sección: ${seccionName}  |  Comunidad: ${comunidadName}`, pageWidth / 2, 39, { align: "center" });
                    doc.setTextColor('#000000');

                    doc.setFont("helvetica", "bold");
                    doc.setFontSize(16);
                    const maxAnchoTexto = pageWidth - 40;
                    const lineasPregunta = doc.splitTextToSize(dataSet.title, maxAnchoTexto);
                    const yPosPregunta = 49;
                    doc.text(lineasPregunta, pageWidth / 2, yPosPregunta, { align: "center" });

                    // ── Canvas temporal para la gráfica ──────────────────────────
                    const tempCanvas = document.createElement('canvas');
                    tempCanvas.width = 1200;
                    tempCanvas.height = 600;
                    const tempCtx = tempCanvas.getContext('2d');
                    tempCtx.fillStyle = "#FFFFFF";
                    tempCtx.fillRect(0, 0, tempCanvas.width, tempCanvas.height);

                    const chartType = dataSet.tipoElegido || document.getElementById('chart_type_select').value;
                    const config = crearConfiguracionGrafico(dataSet, chartType, tempCtx);
                    config.options.animation = false;
                    config.options.responsive = false;

                    // ── CLAVE: respetar plugins del config (liquidBarPlugin, etc.) ──
                    const pluginsBase = [ChartDataLabels];

                    // Agregar liquidBarPlugin si existe (barras)
                    if (config.plugins && Array.isArray(config.plugins)) {
                        config.plugins.forEach(p => {
                            if (p && p.id && p.id !== 'ChartDataLabels') {
                                pluginsBase.push(p);
                            }
                        });
                    }

                    // Plugin sombra para circulares
                    const dropShadowPlugin = {
                        id: 'dropShadow',
                        beforeDraw: (chart) => {
                            if (['doughnut', 'pie', 'polarArea'].includes(chart.config.type)) {
                                const { ctx } = chart;
                                ctx.save();
                                ctx.shadowColor = 'rgba(0,0,0,0.35)';
                                ctx.shadowBlur = 12;
                                ctx.shadowOffsetX = 6;
                                ctx.shadowOffsetY = 6;
                            }
                        },
                        afterDraw: (chart) => {
                            if (['doughnut', 'pie', 'polarArea'].includes(chart.config.type)) {
                                chart.ctx.restore();
                            }
                        }
                    };

                    if (['doughnut', 'pie', 'polarArea'].includes(config.type)) {
                        pluginsBase.push(dropShadowPlugin);
                    }

                    config.plugins = pluginsBase;

                    // Esperar a que el canvas esté listo antes de capturar
                    const tempChart = new Chart(tempCtx, config);
                    await new Promise(resolve => setTimeout(resolve, 800)); // Más tiempo para plugins custom
                    const chartImage = tempChart.toBase64Image("image/png", 1.0);
                    tempChart.destroy();

                    // Colocar imagen en el PDF
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