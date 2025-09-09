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

            // Asegúrate de que las URL estén correctamente configuradas en tu archivo de rutas de CodeIgniter.
            const baseUrl = '<?= base_url('estadisticascontroller') ?>';
            const colores = ['#007bff', '#28a745', '#dc3545', '#ffc107', '#17a2b8', '#6610f2', '#fd7e14', '#e83e8c'];
            const colorTextoSecundario = '#424242';

            Chart.register(ChartDataLabels);

            /**
             * Carga una única opción en un selector y lo deshabilita para que no se pueda cambiar.
             */
            function cargarSelectUnico(selectElement, data, idKey, textKey, placeholder) {
                selectElement.innerHTML = `<option value="${data[idKey]}">${data[textKey]}</option>`;
                selectElement.disabled = true;
            }

            /**
             * Carga opciones en un selector y lo habilita o deshabilita.
             */
            function cargarSelect(selectElement, data, idKey, textKey, placeholder, disabled = false) {
                selectElement.innerHTML = `<option value="">${placeholder}</option>`;
                data.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item[idKey];
                    option.textContent = item[textKey];
                    selectElement.appendChild(option);
                });
                selectElement.disabled = disabled;
            }

            /**
             * Carga checkboxes de preguntas en el contenedor.
             */
            function cargarPreguntasCheckboxes(preguntasData) {
                preguntaCheckboxContainer.innerHTML = '';
                if (preguntasData.length > 0) {
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

            /**
             * Crea un conjunto de datos para un gráfico a partir de una pregunta y filtros.
             */
            async function crearDatosGrafico(idPregunta, nombrePregunta) {
                const idEncuesta = encuestaSelect.value;
                const chartType = chartTypeSelect.value;
                const params = new URLSearchParams({
                    id_encuesta: idEncuesta,
                    id_pregunta: idPregunta,
                    id_municipio: municipioSelect.value,
                    id_seccion: seccionSelect.value,
                    id_comunidad: comunidadSelect.value,
                });

                try {
                    const opcionesResponse = await fetch(`${baseUrl}/getOpcionesPregunta/${idPregunta}`);
                    const opcionesData = await opcionesResponse.json();
                    const respuestasResponse = await fetch(`${baseUrl}/getRespuestas?${params.toString()}`);
                    const respuestasData = await respuestasResponse.json();

                    if (opcionesData && opcionesData.length > 0) {
                        const datosMapeados = {};
                        opcionesData.forEach(opcion => {
                            datosMapeados[opcion.texto_opcion] = 0;
                        });

                        respuestasData.forEach(respuesta => {
                            const opcionEncontrada = opcionesData.find(opcion => opcion.id_opcion == respuesta.id_opcion);
                            if (opcionEncontrada) {
                                datosMapeados[opcionEncontrada.texto_opcion] = parseInt(respuesta.total, 10);
                            }
                        });

                        const labels = Object.keys(datosMapeados);
                        const totals = Object.values(datosMapeados);

                        const chartData = {
                            id: idPregunta,
                            title: nombrePregunta,
                            labels: labels,
                            datasets: [{
                                label: 'Total de Respuestas',
                                data: totals,
                                backgroundColor: totals.map((_, index) => colores[index % colores.length]),
                                borderColor: totals.map((_, index) => colores[index % colores.length]),
                                borderWidth: 1,
                                pointRadius: chartType === 'line' || chartType === 'radar' ? 5 : 0,
                                fill: chartType === 'line' || chartType === 'radar' ? 'origin' : false,
                            }]
                        };
                        chartDataSets.push(chartData);
                    } else {
                        console.warn(`No hay opciones de respuesta para la pregunta: ${nombrePregunta}`);
                    }
                } catch (error) {
                    console.error('Error al obtener datos del gráfico para la pregunta ' + idPregunta + ':', error);
                }
            }

            /**
             * Renderiza un gráfico en el contenedor principal.
             */
            function renderizarGrafico(dataSet) {
                chartsContainer.innerHTML = '';
                if (chartInstance) {
                    chartInstance.destroy();
                    chartInstance = null;
                }

                if (!dataSet || dataSet.datasets[0].data.reduce((sum, current) => sum + current, 0) === 0) {
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
                            position: chartType === 'doughnut' || chartType === 'pie' ? 'bottom' : 'top',
                            labels: {
                                color: '#000000'
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const value = context.parsed.y !== undefined ? context.parsed.y : context.parsed;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                    return `${context.label}: ${value} (${percentage}%)`;
                                }
                            }
                        },
                        datalabels: {
                            color: colorTextoSecundario,
                            anchor: 'end',
                            align: 'start',
                            offset: -10,
                            font: {
                                weight: 'bold'
                            },
                            formatter: (value, context) => {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = total > 0 ? ((value / total) * 100).toFixed(1) + '%' : '0%';
                                return `${value} (${percentage})`;
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            suggestedMax: Math.max(...dataSet.datasets[0].data) > 5 ? Math.max(...dataSet.datasets[0].data) + 1 : 5,
                            ticks: {
                                precision: 0,
                                color: '#000000'
                            }
                        },
                        x: {
                            ticks: {
                                color: colorTextoSecundario,
                                autoSkip: false,
                                maxRotation: 45,
                                minRotation: 45
                            }
                        }
                    },
                    elements: {
                        bar: {
                            barPercentage: 0.8,
                            categoryPercentage: 0.9
                        }
                    }
                };

                if (chartType === 'doughnut' || chartType === 'pie') {
                    chartOptions.plugins.datalabels.offset = 0;
                    chartOptions.plugins.datalabels.align = 'center';
                    chartOptions.plugins.datalabels.formatter = (value, context) => {
                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                        const percentage = total > 0 ? ((value / total) * 100).toFixed(1) + '%' : '0%';
                        return percentage;
                    };
                    delete chartOptions.scales;
                } else if (chartType === 'radar') {
                    chartOptions.scales = {
                        r: {
                            angleLines: {
                                color: '#000000'
                            },
                            grid: {
                                color: '#000000'
                            },
                            pointLabels: {
                                color: '#000000'
                            },
                            ticks: {
                                color: '#000000',
                                backdropColor: 'rgba(255, 255, 255, 0.8)'
                            }
                        }
                    };
                    delete chartOptions.scales.y;
                    delete chartOptions.scales.x;
                }

                chartInstance = new Chart(ctx, {
                    type: chartType,
                    data: {
                        labels: dataSet.labels,
                        datasets: dataSet.datasets
                    },
                    options: chartOptions
                });
            }

            /**
             * Genera y muestra los gráficos para las preguntas seleccionadas.
             */
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

            /**
             * Actualiza los controles de navegación de los gráficos.
             */
            function actualizarControlesNavegacion() {
                chartCounter.textContent = `${currentChartIndex + 1} de ${chartDataSets.length}`;
                prevChartBtn.disabled = currentChartIndex === 0;
                nextChartBtn.disabled = currentChartIndex === chartDataSets.length - 1;
            }

            /**
             * Muestra el siguiente gráfico en la secuencia.
             */
            function mostrarSiguienteGrafico() {
                if (currentChartIndex < chartDataSets.length - 1) {
                    currentChartIndex++;
                    renderizarGrafico(chartDataSets[currentChartIndex]);
                    actualizarControlesNavegacion();
                }
            }

            /**
             * Muestra el gráfico anterior en la secuencia.
             */
            function mostrarGraficoAnterior() {
                if (currentChartIndex > 0) {
                    currentChartIndex--;
                    renderizarGrafico(chartDataSets[currentChartIndex]);
                    actualizarControlesNavegacion();
                }
            }

            /**
             * Genera un PDF con todas las gráficas en formato horizontal,
             * con un diseño profesional, fondos blancos y datos de filtro.
             */
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

    const colorPrimario = '#E53935';
    const colorTextoPrimario = '#ffffff';
    const colorTextoSecundario = '#424242';

    const encuestaTitle = encuestaSelect.options[encuestaSelect.selectedIndex].text;
    const estadoName = estadoSelect.value ? estadoSelect.options[estadoSelect.selectedIndex].text : 'Todos';
    const distritoFederalName = distritoFederalSelect.value ? distritoFederalSelect.options[distritoFederalSelect.selectedIndex].text : 'Todos';
    const distritoLocalName = distritoLocalSelect.value ? distritoLocalSelect.options[distritoLocalSelect.selectedIndex].text : 'Todos';
    const municipioName = municipioSelect.value ? municipioSelect.options[municipioSelect.selectedIndex].text : 'Todos';
    const seccionName = seccionSelect.value ? seccionSelect.options[seccionSelect.selectedIndex].text : 'Todas';
    const comunidadName = comunidadSelect.value ? comunidadSelect.options[comunidadSelect.selectedIndex].text : 'Todas';

    for (let index = 0; index < chartDataSets.length; index++) {
        if (index > 0) doc.addPage();

        const dataSet = chartDataSets[index];
        const yPosition = 30;

        // Cabecera roja
      
        doc.rect(0, 0, pageWidth, 20, 'F');

        // Título
        doc.setFont("helvetica", "bold");
        doc.setFontSize(16);
        doc.setTextColor(colorTextoPrimario);
        doc.text("Reporte de Resultados de Encuesta", pageWidth / 2, 13, { align: "center" });

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

        // Título pregunta
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



            // Eventos para los selectores
            encuestaSelect.addEventListener('change', async function() {
                const idEncuesta = this.value;
                preguntaCheckboxContainer.innerHTML = `<p class="text-white-50">Cargando preguntas...</p>`;
                generateChartsBtn.disabled = true;

                // Al cambiar la encuesta, limpiamos y deshabilitamos los selects de filtros geográficos
                municipioSelect.value = '';
                cargarSelect(seccionSelect, [], 'id_seccion', 'nombre_seccion', 'Selecciona una sección', true);
                cargarSelect(comunidadSelect, [], 'id_comunidad', 'nombre_comunidad', 'Selecciona una comunidad', true);
                
                // Limpiar y deshabilitar los selectores de jerarquía padre
                cargarSelect(estadoSelect, [], 'id_estado', 'nombre_estado', 'Estado', true);
                cargarSelect(distritoFederalSelect, [], 'id_distrito_federal', 'nombre_distrito_federal', 'Distrito Federal', true);
                cargarSelect(distritoLocalSelect, [], 'id_distrito_local', 'nombre_distrito_local', 'Distrito Local', true);


                if (idEncuesta) {
                    try {
                        const response = await fetch(`<?= base_url('estadisticascontroller/getPreguntas') ?>/${idEncuesta}`);
                        const data = await response.json();
                        cargarPreguntasCheckboxes(data);
                    } catch (error) {
                        console.error('Error al cargar preguntas:', error);
                        preguntaCheckboxContainer.innerHTML = `<p class="text-white-50">Error al cargar preguntas.</p>`;
                    }
                } else {
                    preguntaCheckboxContainer.innerHTML = `<p class="text-white-50">Selecciona una encuesta para cargar las preguntas.</p>`;
                }
                generarGraficos();
            });

            municipioSelect.addEventListener('change', async function() {
                const idMunicipio = this.value;

                // Limpiar y deshabilitar los selects de seccion y comunidad
                cargarSelect(seccionSelect, [], 'id_seccion', 'nombre_seccion', 'Cargando secciones...', !idMunicipio);
                cargarSelect(comunidadSelect, [], 'id_comunidad', 'nombre_comunidad', 'Selecciona una comunidad', true);

                // También limpiar y deshabilitar los selectores de jerarquía padre para reiniciarlos
                cargarSelect(estadoSelect, [], 'id_estado', 'nombre_estado', 'Cargando...', true);
                cargarSelect(distritoFederalSelect, [], 'id_distrito_federal', 'nombre_distrito_federal', 'Cargando...', true);
                cargarSelect(distritoLocalSelect, [], 'id_distrito_local', 'nombre_distrito_local', 'Cargando...', true);


                if (idMunicipio) {
                    try {
                        // Paso 1: Obtener la jerarquía de secciones del municipio
                        const seccionesResponse = await fetch(`<?= base_url('estadisticascontroller/getSecciones') ?>/${idMunicipio}`);
                        const seccionesData = await seccionesResponse.json();
                        cargarSelect(seccionSelect, seccionesData, 'id_seccion', 'nombre_seccion', 'Selecciona una sección', false);
                        
                        // Paso 2: Obtener la jerarquía padre del municipio
                        const parentResponse = await fetch(`<?= base_url('estadisticascontroller/getGeodataByMunicipio') ?>/${idMunicipio}`);
                        const parentData = await parentResponse.json();

                        // Llenar los selectores padre
                        cargarSelectUnico(estadoSelect, parentData.estado, 'id_estado', 'nombre_estado', 'Estado');
                        cargarSelectUnico(distritoFederalSelect, parentData.distrito_federal, 'id_distrito_federal', 'nombre_distrito_federal', 'Distrito Federal');
                        cargarSelectUnico(distritoLocalSelect, parentData.distrito_local, 'id_distrito_local', 'nombre_distrito_local', 'Distrito Local');


                    } catch (error) {
                        console.error('Error al cargar datos geográficos:', error);
                    }
                }
            });

            seccionSelect.addEventListener('change', async function() {
                const idSeccion = this.value;
                cargarSelect(comunidadSelect, [], 'id_comunidad', 'nombre_comunidad', 'Selecciona una comunidad', true);

                if (idSeccion) {
                    try {
                        const response = await fetch(`<?= base_url('estadisticascontroller/getComunidades') ?>/${idSeccion}`);
                        const data = await response.json();
                        cargarSelect(comunidadSelect, data, 'id_comunidad', 'nombre_comunidad', 'Selecciona una comunidad');
                    } catch (error) {
                        console.error('Error al cargar comunidades:', error);
                    }
                }
            });
            
            // Eventos de botones
            generateChartsBtn.addEventListener('click', generarGraficos);
            prevChartBtn.addEventListener('click', mostrarGraficoAnterior);
            nextChartBtn.addEventListener('click', mostrarSiguienteGrafico);
            downloadPdfBtn.addEventListener('click', generarPDF);
        });
    </script>
</body>

</html>
