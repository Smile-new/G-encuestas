<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Estadísticas | Encuestas</title>

    <link rel="stylesheet" href="<?= base_url('recursos_admin/vendors/mdi/css/materialdesignicons.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('recursos_admin/vendors/css/vendor.bundle.base.css') ?>">
    <link rel="stylesheet" href="<?= base_url('recursos_admin/css/style.css') ?>">
    <link rel="shortcut icon" href="<?= base_url('recursos_admin/images/favicon.png') ?>" />

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
            -webkit-text-fill-color: #ffffff; /* Para navegadores basados en WebKit */
            opacity: 1; /* Para Firefox */
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
            width: 100%;
            max-width: 900px;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            height: 400px;
            position: relative;
        }

        .chart-wrapper canvas {
            width: 100% !important;
            height: 100% !important;
        }

        .chart-wrapper h4 {
            color: #000000;
            text-align: center;
            margin-bottom: 10px;
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
        $id_rol = $userData['id_rol'] ?? null;
        switch ($id_rol) {
            case 1:
                $rolTexto = 'Administrador';
                break;
            case 2:
                $rolTexto = 'Operador';
                break;
            case 3:
                $rolTexto = 'Encuestador';
                break;
            default:
                $rolTexto = 'Miembro';
                break;
        }

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
                <a class="sidebar-brand brand-logo" href="<?= base_url('dashboard') ?>"><img src="<?= base_url('recursos_admin/images/logo.png') ?>" alt="logo" /></a>
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
                                <h5 class="mb-0 font-weight-normal"><?= $nombreCompleto ?></h5>
                                <span><?= $rolTexto ?></span>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="nav-item nav-category">
                    <span class="nav-link">Navegación</span>
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
                    <a class="nav-link" href="<?= base_url('estadisticas') ?>">
                        <span class="menu-icon"><i class="mdi mdi-chart-bar"></i></span>
                        <span class="menu-title">Estadísticas</span>
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
                    <a class="sidebar-brand brand-logo" href="<?= base_url('dashboard') ?>"><img src="<?= base_url('recursos_admin/images/logo.png') ?>" alt="logo" /></a>
                </div>
                <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
                    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                        <span class="mdi mdi-menu"></span>
                    </button>
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
                                <a class="dropdown-item preview-item" href="<?= base_url('logout') ?>">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-dark rounded-circle"><i class="mdi mdi-logout text-danger"></i></div>
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
                        <h3 class="page-title">Estadísticas de Encuestas</h3>
                    </div>

                    <div class="row">
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Filtros de Datos</h4>
                                    <form class="forms-sample">
                                        <div class="row">
                                            <div class="form-group col-md-3">
                                                <label for="encuesta_select">Encuesta</label>
                                                <select class="form-control" id="encuesta_select">
                                                    <option value="">Selecciona una encuesta</option>
                                                    <?php foreach ($encuestas as $encuesta) : ?>
                                                        <option value="<?= $encuesta['id_encuesta'] ?>"><?= $encuesta['titulo'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label>Pregunta</label>
                                                <div id="pregunta_checkbox_container" class="form-group checkbox-group">
                                                    <p class="text-white-50">Selecciona una encuesta para cargar las preguntas.</p>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="chart_type_select">Tipo de Gráfica</label>
                                                <select class="form-control" id="chart_type_select">
                                                    <option value="bar">Gráfica de Barras</option>
                                                    <option value="doughnut">Gráfica de Dona</option>
                                                    <option value="line">Gráfica de Líneas</option>
                                                    <option value="pie">Gráfica de Pastel</option>
                                                    <option value="radar">Gráfica de Radar</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="estado_select">Estado</label>
                                                <select class="form-control" id="estado_select" disabled>
                                                    <option value="">Estado</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
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
                                                <select class="form-control" id="municipio_select">
                                                    <option value="">Selecciona un municipio</option>
                                                    <?php foreach ($municipios as $municipio) : ?>
                                                        <option value="<?= $municipio['id_municipio'] ?>"><?= $municipio['nombre_municipio'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="seccion_select">Sección</label>
                                                <select class="form-control" id="seccion_select" disabled>
                                                    <option value="">Selecciona una sección</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-3">
                                                <label for="comunidad_select">Comunidad</label>
                                                <select class="form-control" id="comunidad_select" disabled>
                                                    <option value="">Selecciona una comunidad</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-3 d-flex align-items-end">
                                                <button type="button" class="btn btn-success" id="generate_charts_btn" disabled>Generar Gráficos</button>
                                            </div>
                                            <div class="form-group col-md-3 d-flex align-items-end">
                                                <button type="button" class="btn btn-primary" id="download_pdf_btn" style="display: none;">Descargar PDF</button>
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
                                    <h4 class="card-title" id="main_chart_title">Resultados de las preguntas seleccionadas</h4>
                                    <div id="no_data_message" class="text-center" style="display: block;">
                                        <p>Selecciona una encuesta y al menos una pregunta para ver los resultados.</p>
                                    </div>
                                    <div id="charts_container">
                                    </div>
                                    <div id="chart_navigation_container" class="chart-navigation" style="display: none;">
                                        <button class="btn" id="prev_chart_btn" disabled>Anterior</button>
                                        <span id="chart_counter" class="text-white"></span>
                                        <button class="btn" id="next_chart_btn" disabled>Siguiente</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <footer class="footer">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © bootstrapdash.com 2020</span>
                        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> Free <a href="https://www.bootstrapdash.com/bootstrap-admin-template/" target="_blank">Bootstrap admin templates</a> from Bootstrapdash.com</span>
                    </div>
                </footer>
            </div>
        </div>
    </div>

    <script src="<?= base_url('recursos_admin/vendors/js/vendor.bundle.base.js') ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Referencias a elementos del DOM
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
                id_municipio: municipioSelect.value,
                id_seccion: seccionSelect.value,
                id_comunidad: comunidadSelect.value,
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
                            label: 'Total de Respuestas',
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
        
        function renderizarGrafico(dataSet) {
            chartsContainer.innerHTML = '';
            if (chartInstance) {
                chartInstance.destroy();
                chartInstance = null;
            }

            if (!dataSet || dataSet.datasets[0].data.reduce((a, b) => a + b, 0) === 0) {
                noDataMessage.style.display = 'block';
                noDataMessage.textContent = "No hay datos de respuestas para la pregunta seleccionada.";
                chartNavigationContainer.style.display = 'none';
                downloadPdfBtn.style.display = 'none';
                return;
            }

            noDataMessage.style.display = 'none';
            const chartWrapper = document.createElement('div');
            chartWrapper.classList.add('chart-wrapper');
            const chartTitle = document.createElement('h4');
            chartTitle.textContent = dataSet.title;
            const chartCanvas = document.createElement('canvas');
            chartCanvas.id = `chart-${dataSet.id}`;
            chartWrapper.appendChild(chartTitle);
            chartWrapper.appendChild(chartCanvas);
            chartsContainer.appendChild(chartWrapper);

            const ctx = chartCanvas.getContext('2d');
            const chartType = chartTypeSelect.value;
            let chartOptions = {
                maintainAspectRatio: false,
                responsive: true,
                plugins: {
                    legend: {
                        position: ['doughnut', 'pie'].includes(chartType) ? 'bottom' : 'top',
                        labels: { color: '#000' }
                    },
                    datalabels: {
                        color: '#333',
                        anchor: 'end',
                        align: 'start',
                        offset: -10,
                        font: { weight: 'bold' },
                        formatter: (value, context) => {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = total > 0 ? `${((value / total) * 100).toFixed(1)}%` : '0%';
                            return `${value} (${percentage})`;
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { precision: 0, color: '#000' }
                    },
                    x: {
                        ticks: { color: colorTextoSecundario, maxRotation: 45, minRotation: 45 }
                    }
                }
            };
            
            if (['doughnut', 'pie'].includes(chartType)) {
                chartOptions.plugins.datalabels.align = 'center';
                chartOptions.plugins.datalabels.offset = 0;
                chartOptions.plugins.datalabels.formatter = (value, context) => {
                     const total = context.dataset.data.reduce((a, b) => a + b, 0);
                     return total > 0 ? `${((value / total) * 100).toFixed(1)}%` : '0%';
                };
                delete chartOptions.scales;
            }
             if (chartType === 'radar'){
                 delete chartOptions.scales;
             }

            chartInstance = new Chart(ctx, {
                type: chartType,
                data: dataSet,
                options: chartOptions
            });
        }


        // --- FUNCIONES PRINCIPALES (con manejo de errores mejorado) ---

        encuestaSelect.addEventListener('change', async function() {
            const idEncuesta = this.value;
            preguntaCheckboxContainer.innerHTML = `<p class="text-white-50">Cargando preguntas...</p>`;
            generateChartsBtn.disabled = true;
            
            // Limpiar todo
            ['municipio_select', 'seccion_select', 'comunidad_select', 'estado_select', 'distrito_federal_select', 'distrito_local_select'].forEach(id => {
                const el = document.getElementById(id);
                if (id === 'municipio_select') el.value = '';
                else cargarSelect(el, [], '', '', el.firstElementChild.textContent, true);
            });
            
            if (idEncuesta) {
                try {
                    const data = await fetchJSON(`${baseUrl}/getPreguntas/${idEncuesta}`);
                    cargarPreguntasCheckboxes(data);
                } catch (error) {
                    preguntaCheckboxContainer.innerHTML = `<p class="text-danger">Error al cargar preguntas. Revisa la consola.</p>`;
                }
            } else {
                preguntaCheckboxContainer.innerHTML = `<p class="text-white-50">Selecciona una encuesta para cargar las preguntas.</p>`;
            }
        });
        
        municipioSelect.addEventListener('change', async function() {
            const idMunicipio = this.value;
            cargarSelect(seccionSelect, [], 'id_seccion', 'nombre_seccion', 'Cargando...', true);
            cargarSelect(comunidadSelect, [], 'id_comunidad', 'nombre_comunidad', 'Selecciona una comunidad', true);

            if (idMunicipio) {
                try {
                    const [seccionesData, parentData] = await Promise.all([
                        fetchJSON(`${baseUrl}/getSecciones/${idMunicipio}`),
                        fetchJSON(`${baseUrl}/getGeodataByMunicipio/${idMunicipio}`)
                    ]);
                    
                    cargarSelect(seccionSelect, seccionesData, 'id_seccion', 'nombre_seccion', 'Selecciona una sección', false);
                    
                    if(parentData && parentData.estado) {
                        cargarSelectUnico(estadoSelect, parentData.estado, 'id_estado', 'nombre_estado');
                        cargarSelectUnico(distritoFederalSelect, parentData.distrito_federal, 'id_distrito_federal', 'nombre_distrito_federal');
                        cargarSelectUnico(distritoLocalSelect, parentData.distrito_local, 'id_distrito_local', 'nombre_distrito_local');
                    }
                } catch (error) {
                    console.error('Error al cargar datos geográficos:', error);
                }
            }
        });

        seccionSelect.addEventListener('change', async function() {
            const idSeccion = this.value;
            cargarSelect(comunidadSelect, [], 'id_comunidad', 'nombre_comunidad', 'Cargando...', true);

            if (idSeccion) {
                try {
                    const data = await fetchJSON(`${baseUrl}/getComunidades/${idSeccion}`);
                    cargarSelect(comunidadSelect, data, 'id_comunidad', 'nombre_comunidad', 'Selecciona una comunidad', false);
                } catch (error) {
                    console.error('Error al cargar comunidades:', error);
                }
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

        async function generarPDF() {
    const { jsPDF } = window.jspdf;

    if (!encuestaSelect.value || chartDataSets.length === 0) {
        const alertDiv = document.createElement('div');
        alertDiv.classList.add('alert', 'alert-danger');
        alertDiv.textContent = "Por favor, selecciona una encuesta y al menos una pregunta para generar el reporte.";
        alertDiv.style.position = 'fixed';
        alertDiv.style.bottom = '20px';
        alertDiv.style.left = '50%';
        alertDiv.style.transform = 'translateX(-50%)';
        alertDiv.style.zIndex = '1000';
        document.body.appendChild(alertDiv);
        setTimeout(() => alertDiv.remove(), 5000);
        return;
    }

    const doc = new jsPDF({
        orientation: "landscape",
        unit: "mm",
        format: "a4"
    });

    const pageWidth = doc.internal.pageSize.getWidth();
    const pageHeight = doc.internal.pageSize.getHeight();
    const margin = 15;

    const colorTextoPrimario = '#000000';
    const colorTextoSecundario = '#424242';

    const encuestaTitle = encuestaSelect.options[encuestaSelect.selectedIndex].text;
    const estadoName = estadoSelect.value ? estadoSelect.options[estadoSelect.selectedIndex].text : 'Todos';
    const distritoFederalName = distritoFederalSelect.value ? distritoFederalSelect.options[distritoFederalSelect.selectedIndex].text : 'Todos';
    const distritoLocalName = distritoLocalSelect.value ? distritoLocalSelect.options[distritoLocalSelect.selectedIndex].text : 'Todos';
    const municipioName = municipioSelect.value ? municipioSelect.options[municipioSelect.selectedIndex].text : 'Todos';
    const seccionName = seccionSelect.value ? seccionSelect.options[seccionSelect.selectedIndex].text : 'Todas';
    const comunidadName = comunidadSelect.value ? comunidadSelect.options[comunidadSelect.selectedIndex].text : 'Todas';

    // Marca de agua (logo)
    const watermarkImage = "/public/img/logo.png";
    let imgData = null;
    try {
        const response = await fetch(watermarkImage);
        if (response.ok) {
            const blob = await response.blob();
            const reader = new FileReader();
            await new Promise(resolve => {
                reader.onload = () => resolve();
                reader.readAsDataURL(blob);
            });
            imgData = reader.result;
        }
    } catch (error) {
        console.error("Error al cargar la imagen de marca de agua:", error);
    }

    for (let index = 0; index < chartDataSets.length; index++) {
        if (index > 0) doc.addPage();

        const dataSet = chartDataSets[index];
        const yPosition = 30;

        // Marca de agua ocupando toda la hoja (100% tamaño y 100% visibilidad)
        if (imgData) {
            doc.addImage(imgData, 'PNG', 0, 0, pageWidth, pageHeight);
        }

        // Título del reporte
        doc.setFont("helvetica", "bold");
        doc.setFontSize(16);
        doc.setTextColor(colorTextoPrimario);
        doc.text("Reporte de Resultados de Encuesta", pageWidth / 2, 15, { align: "center" });

        // Info filtros
        doc.setFont("helvetica", "normal");
        doc.setFontSize(10);
        doc.setTextColor(colorTextoSecundario);
        doc.text(`Encuesta: ${encuestaTitle}`, margin, yPosition);
        doc.text(`Estado: ${estadoName}`, margin, yPosition + 5);
        doc.text(`Distrito Federal: ${distritoFederalName}`, margin, yPosition + 10);
        doc.text(`Distrito Local: ${distritoLocalName}`, margin, yPosition + 15);
        doc.text(`Municipio: ${municipioName}`, margin, yPosition + 20);
        doc.text(`Sección: ${seccionName}`, margin, yPosition + 25);
        doc.text(`Comunidad: ${comunidadName}`, margin, yPosition + 30);

        // Título de la pregunta
        doc.setFont("helvetica", "bold");
        doc.setFontSize(14);
        doc.text(dataSet.title, pageWidth / 2, yPosition + 40, { align: "center" });

        // Crear canvas temporal
        const chartCanvas = document.createElement('canvas');
        chartCanvas.width = 800;
        chartCanvas.height = 400;
        const ctx = chartCanvas.getContext('2d');

        // Fondo blanco en el canvas
        ctx.fillStyle = "#FFFFFF";
        ctx.fillRect(0, 0, chartCanvas.width, chartCanvas.height);

        const chartType = chartTypeSelect.value;
        const totalRespuestas = dataSet.datasets[0].data.reduce((a, b) => a + b, 0);
        if (totalRespuestas === 0) continue;

        const tempChart = new Chart(ctx, {
            type: chartType,
            data: {
                labels: dataSet.labels,
                datasets: dataSet.datasets
            },
            options: {
                responsive: false,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: chartType === 'doughnut' || chartType === 'pie' ? 'bottom' : 'top',
                        labels: { color: colorTextoSecundario }
                    },
                    datalabels: {
                        color: "#000",
                        anchor: 'end',
                        align: 'top',
                        font: { weight: 'bold' },
                        formatter: (value, context) => {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = total > 0 ? ((value / total) * 100).toFixed(1) + '%' : '0%';
                            return `${value} (${percentage})`;
                        }
                    }
                },
                scales: chartType === 'pie' || chartType === 'doughnut' ? {} : {
                    y: { beginAtZero: true, ticks: { precision: 0, color: colorTextoSecundario } },
                    x: { ticks: { color: colorTextoSecundario, maxRotation: 45, minRotation: 45 } }
                }
            }
        });

        tempChart.update();
        await new Promise(resolve => setTimeout(resolve, 500));
        const chartImage = tempChart.toBase64Image("image/png", 1.0);
        tempChart.destroy();

        // Ajustar imagen dentro de la página
        const maxImgWidth = pageWidth - margin * 2;
        const maxImgHeight = pageHeight - (yPosition + 60) - margin;
        let imgWidth = maxImgWidth;
        let imgHeight = (chartCanvas.height / chartCanvas.width) * imgWidth;

        if (imgHeight > maxImgHeight) {
            imgHeight = maxImgHeight;
            imgWidth = (chartCanvas.width / chartCanvas.height) * imgHeight;
        }

        const imgX = (pageWidth - imgWidth) / 2;
        const imgY = yPosition + 50;

        doc.addImage(chartImage, "PNG", imgX, imgY, imgWidth, imgHeight);
    }

    doc.save("reporte-encuesta.pdf");
}



        // Eventos de botones
        generateChartsBtn.addEventListener('click', generarGraficos);
        prevChartBtn.addEventListener('click', mostrarGraficoAnterior);
        nextChartBtn.addEventListener('click', mostrarSiguienteGrafico);
        downloadPdfBtn.addEventListener('click', generarPDF);
    });
</script>
</body>

</html>
