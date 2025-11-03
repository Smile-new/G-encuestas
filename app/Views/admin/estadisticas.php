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
    width: 95%; /* Un poco más de ancho */
    max-width: 850px; /* Ancho máximo */
    background-color: #ffffff;
    padding: 20px;
    border-radius: 12px; /* Bordes un poco más redondeados */
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    height: 420px; /* Un poco más de altura */
    
    /* --- ESTO ES LO MÁS IMPORTANTE --- */
    display: flex;
    flex-direction: column; /* Organiza los elementos (título y canvas) en una columna */
}

.chart-wrapper h4 {
    color: #333333; /* Un gris oscuro para el título */
    text-align: center;
    margin-bottom: 15px;
    flex-shrink: 0; /* Evita que el título se encoja */
}

.chart-wrapper canvas {
    /* El canvas ahora tomará el 100% del espacio restante en el wrapper */
    flex-grow: 1; /* Permite que el canvas crezca y ocupe el espacio */
    min-height: 0; /* Soluciona un problema común de Flexbox con canvas */
    width: 100% !important; /* Asegura que ocupe todo el ancho */
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
        width: auto;       /* que respete proporción */
        max-height: 90px;  /* ajusta según lo que necesites */
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
          <a class="sidebar-brand brand-logo" href="<?= base_url('dashboard') ?>"><img src="<?= base_url(RECURSOS_ADMIN_IMAGES . '/logo.png') ?>" alt="logo" /> </a>
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
              <span class="menu-icon">
                <i class="mdi mdi-speedometer"></i>
              </span>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="<?= base_url('encuestas') ?>">
              <span class="menu-icon">
                <i class="mdi mdi-playlist-play"></i>
              </span>
              <span class="menu-title">Encuestas</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="<?= base_url('preguntas') ?>">
              <span class="menu-icon">
                <i class="mdi mdi-table-large"></i>
              </span>
              <span class="menu-title">Preguntas</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="<?= base_url('estadistica') ?>">
              <span class="menu-icon">
                <i class="mdi mdi-chart-bar"></i>
              </span>
              <span class="menu-title">Estadisticas</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="<?= base_url('usuarios') ?>">
              <span class="menu-icon">
                <i class="mdi mdi-contacts"></i>
              </span>
              <span class="menu-title">Usuarios</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="<?= base_url('admin/perfil') ?>">
              <span class="menu-icon">
                <i class="mdi mdi-account-circle"></i>
              </span>
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
    <option value="pie">Gráfica de Pastel</option>
    <option value="line">Gráfica de Líneas</option>
    <option value="radar">Gráfica de Radar</option>
    <option value="polarArea">Gráfica de Área Polar</option>
    <option value="scatter">Gráfica de Puntos</option>
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
                                            <div class="form-group col-md-6 d-flex align-items-end">
                                                <!-- Botones de PDF -->
                                                <button type="button" class="btn btn-primary" id="download_pdf_btn" style="display: none;">Descargar PDF</button>
                                                <!-- BOTÓN DE EXCEL -->
                                                <button type="button" class="btn btn-success ml-2" id="downloadExcelBtn" style="display: none;">
  Descargar Excel
</button>

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


    <script >


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
    document.addEventListener('DOMContentLoaded', function() {
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
        
        // --- COPIA Y PEGA ESTA FUNCIÓN COMPLETA ---
       function renderizarGrafico(dataSet) {
    chartsContainer.innerHTML = '';
    if (window.chartInstance) { window.chartInstance.destroy(); }

    const totalDatosGlobal = dataSet.datasets[0].data.reduce((a, b) => a + b, 0);
    if (!dataSet || totalDatosGlobal === 0) {
        noDataMessage.style.display = 'block';
        noDataMessage.textContent = "No hay datos de respuestas para la selección.";
        return;
    }

    noDataMessage.style.display = 'none';
    const chartWrapper = document.createElement('div');
    chartWrapper.classList.add('chart-wrapper');
    const chartTitle = document.createElement('h4');
    chartTitle.textContent = dataSet.title;
    const chartCanvas = document.createElement('canvas');
    chartWrapper.appendChild(chartTitle);
    chartWrapper.appendChild(chartCanvas);
    chartsContainer.appendChild(chartWrapper);

    const ctx = chartCanvas.getContext('2d');
    const chartType = chartTypeSelect.value;
    
    // Obtenemos la configuración completa de la nueva función
    const config = crearConfiguracionGrafico(dataSet, chartType, ctx);
    
    // Creamos la instancia de la gráfica en pantalla
    window.chartInstance = new Chart(ctx, config);
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
    // --- FUNCIONES Y VARIABLES DE DISEÑO INTERNAS ---
    function hexToRgba(hex, alpha = 1) { const r = parseInt(hex.slice(1, 3), 16), g = parseInt(hex.slice(3, 5), 16), b = parseInt(hex.slice(5, 7), 16); return `rgba(${r}, ${g}, ${b}, ${alpha})`; }
    function adjustColor(colorHex, percent) { let r = parseInt(colorHex.slice(1, 3), 16), g = parseInt(colorHex.slice(3, 5), 16), b = parseInt(colorHex.slice(5, 7), 16); r = parseInt(r * (100 + percent) / 100); g = parseInt(g * (100 + percent) / 100); b = parseInt(b * (100 + percent) / 100); r = (r < 255) ? r : 255; g = (g < 255) ? g : 255; b = (b < 255) ? b : 255; r = (r > 0) ? r : 0; g = (g > 0) ? g : 0; b = (b > 0) ? b : 0; const rr = ((r.toString(16).length === 1) ? "0" + r.toString(16) : r.toString(16)), gg = ((g.toString(16).length === 1) ? "0" + g.toString(16) : g.toString(16)), bb = ((b.toString(16).length === 1) ? "0" + b.toString(16) : b.toString(16)); return `#${rr}${gg}${bb}`; }

    // Paleta de colores más saturados
    const colores = ['#1E88E5', '#43A047', '#FFB300', '#E53935', '#8E24AA', '#00ACC1', '#FDD835', '#6D4C41'];
    const colorTextoGraficaPrincipal = '#000000';
    const colorTextoGraficaSecundario = '#333333'; // Gris más oscuro para mejor contraste
    const totalDatosGlobal = dataSet.datasets[0].data.reduce((a, b) => a + b, 0);

    let finalType = chartType;
    let finalData = JSON.parse(JSON.stringify(dataSet));

    finalData.datasets[0].backgroundColor = finalData.labels.map((_, i) => colores[i % colores.length]);
    finalData.datasets[0].borderColor = finalData.datasets[0].backgroundColor.map(color => adjustColor(color, -25)); // Borde más oscuro
    finalData.datasets[0].borderWidth = 1.5; // Borde ligeramente más grueso

    let chartOptions = {
        maintainAspectRatio: false,
        responsive: true,
        animation: { duration: 1000, easing: 'easeOutCubic' }, // Animación más rápida y suave
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    color: colorTextoGraficaSecundario,
                    font: { size: 14, weight: 'bold' }, // Leyenda más grande
                    boxWidth: 25,
                    padding: 30 // Más espacio para la leyenda
                }
            },
            datalabels: {
                color: colorTextoGraficaPrincipal,
                font: { weight: 'bold', size: 14 },
                formatter: (value, context) => { // Formatter base, se ajusta por tipo
                    const val = typeof value === 'object' ? value.y : value; // Manejar scatter
                    const total = totalDatosGlobal; // Usar total global por defecto
                    const percentage = total > 0 ? `${((val / total) * 100).toFixed(1)}%` : '0%';
                    return `${val}\n(${percentage})`; // Mostrar valor y porcentaje
                }
            },
            tooltip: {
                backgroundColor: 'rgba(0,0,0,0.85)',
                titleColor: '#fff',
                bodyColor: '#fff',
                bodyFont: { size: 14 },
                padding: 12,
                cornerRadius: 8,
                displayColors: true,
                boxPadding: 6,
                borderColor: 'rgba(255,255,255,0.2)',
                borderWidth: 1
            }
        },
        scales: {
            y: { beginAtZero: true, ticks: { precision: 0, color: colorTextoGraficaSecundario, font: { size: 12 } }, grid: { color: 'rgba(0, 0, 0, 0.12)', borderWidth: 1 } },
            x: { ticks: { color: colorTextoGraficaSecundario, maxRotation: 45, minRotation: 0, font: { size: 12 } }, grid: { color: 'rgba(0, 0, 0, 0.12)', borderWidth: 1 } }
        }
    };

    // --- LÓGICA DE ESTILOS DETALLADA POR TIPO ---

    if (chartType === 'bar') {
        const originalColors = finalData.datasets[0].backgroundColor;
        finalData.datasets[0].backgroundColor = originalColors.map(color => {
            const gradient = ctx.createLinearGradient(0, 0, 0, 400); // 400 es un valor de altura aprox.
            gradient.addColorStop(0, adjustColor(color, 25)); // Más claro arriba
            gradient.addColorStop(0.5, color);                 // Color original en el medio
            gradient.addColorStop(1, adjustColor(color, -25)); // Más oscuro abajo
            return gradient;
        });
        finalData.datasets[0].borderColor = originalColors.map(color => adjustColor(color, -50)); // Borde muy oscuro
        finalData.datasets[0].hoverBackgroundColor = originalColors.map(color => adjustColor(color, 40));
        finalData.datasets[0].hoverBorderColor = originalColors.map(color => adjustColor(color, -60));
        finalData.datasets[0].borderWidth = 2;
        finalData.datasets[0].borderRadius = 10; // Bordes más redondeados
        finalData.datasets[0].barPercentage = 0.75; // Barras un poco más anchas
        finalData.datasets[0].categoryPercentage = 0.7;

        // Añadir una sombra sutil debajo de la barra
        const barShadowPlugin = {
            id: 'barShadow',
            // --- CAMBIO AQUÍ: Usar beforeDatasetsDraw en lugar de afterDraw ---
            beforeDatasetsDraw: (chart) => {
                if (chart.config.type === 'bar') {
                    const { ctx } = chart;
                    // Aplicar sombra solo al dataset principal (índice 0 o el que tenga tus barras)
                    chart.getDatasetMeta(0).data.forEach(bar => {
                        ctx.save();
                        ctx.shadowColor = 'rgba(0, 0, 0, 0.25)'; // Sombra un poco más oscura
                        ctx.shadowBlur = 10;                     // Más difusa
                        ctx.shadowOffsetX = 3;                   // Mayor desplazamiento X
                        ctx.shadowOffsetY = 5;                   // Mayor desplazamiento Y
                        // Dibujar un rectángulo simple donde irá la barra, esto será la sombra
                        // Usamos el color de fondo como base, pero podría ser un gris oscuro
                        ctx.fillStyle = 'rgba(0,0,0,0.1)'; // Sombra grisácea
                        ctx.fillRect(bar.x - bar.width / 2, bar.y, bar.width, bar.height);
                        ctx.restore();
                    });
                }
            }
        };

        chartOptions.scales.y.grid = { display: false };
        chartOptions.scales.x.grid = { display: false };
        chartOptions.plugins.legend.display = false;
        chartOptions.plugins.datalabels = {
    color: '#0f0f0fff', // White text
    anchor: 'center',
    align: 'center',
    font: {
        weight: 'bold',
        size: 16 // Slightly larger font
    },
    // Add a subtle shadow for better readability on different segment colors
    textShadowColor: 'rgba(255, 255, 255, 1)', 
    textShadowBlur: 4,
    formatter: (value, context) => {
        // Get the specific dataset's data
        const dataset = context.chart.data.datasets[context.datasetIndex];
        // Calculate the total SUM for THIS dataset (crucial for accurate percentages in Pie/Doughnut/Polar)
        const total = dataset.data.reduce((sum, dataValue) => sum + dataValue, 0);
        // Calculate the percentage based on the dataset's total
        const percentage = total > 0 ? `${((value / total) * 100).toFixed(1)}%` : '0%';
        
        // Return only the percentage for cleaner look on circular charts
        return percentage; 
        // Or, if you still want value AND percentage:
        // return `${value}\n(${percentage})`; 
    }
};
    } else {
         // Desregistrar sombra de barras si no es tipo bar
        if (Chart.registry.plugins.get('barShadow')) {
            Chart.unregister(Chart.registry.plugins.get('barShadow'));
        }
    }

    // Plugin para sombra en gráficos circulares (ya estaba bien)
    const dropShadowPlugin = { id: 'dropShadow', beforeDraw: (chart) => { if (['doughnut', 'pie', 'polarArea'].includes(chart.config.type)) { const { ctx } = chart; ctx.save(); ctx.shadowColor = 'rgba(0, 0, 0, 0.35)'; ctx.shadowBlur = 12; ctx.shadowOffsetX = 6; ctx.shadowOffsetY = 6; } }, afterDraw: (chart) => { if (['doughnut', 'pie', 'polarArea'].includes(chart.config.type)) { chart.ctx.restore(); } } };
    if (!Chart.registry.plugins.get('dropShadow')) Chart.register(dropShadowPlugin);


    if (['doughnut', 'pie', 'polarArea'].includes(chartType)) {
        delete chartOptions.scales;
        chartOptions.plugins.datalabels = {
            color: '#fff', // Blanco
            textShadowColor: 'rgba(0,0,0,0.8)',
            textShadowBlur: 5,
            font: { weight: 'bold', size: 16 },
            formatter: (value, context) => { // Corrección aquí también
                const total = context.chart.data.datasets[0].data.reduce((a,b) => a+b, 0);
                const percentage = total > 0 ? `${((value / total) * 100).toFixed(1)}%` : '0%';
                return percentage;
            }
        };
        finalData.datasets[0].borderColor = '#ffffff';
        finalData.datasets[0].borderWidth = 5; // Borde más grueso
        if (chartType === 'doughnut') {
            chartOptions.cutout = '65%'; // Ligeramente más grueso
            chartOptions.plugins.datalabels.display = true;
            chartOptions.plugins.legend.display = true;
        }
        if (chartType === 'polarArea') {
            chartOptions.scales = { r: { grid: { color: 'rgba(0,0,0,0.1)' }, ticks: { color: colorTextoGraficaSecundario, backdropColor: 'transparent', font: { size: 12 } } } };
            chartOptions.plugins.legend.display = true;
            // --- CORRECCIÓN POLAR AREA DATALABELS ---
            // Usar el formatter específico que ya solo muestra porcentaje
             chartOptions.plugins.datalabels.color = '#111111ff'; // Mantener blanco
             chartOptions.plugins.datalabels.textShadowColor = 'rgba(255, 244, 244, 0)'; // Mantener sombra
             chartOptions.plugins.datalabels.textShadowBlur = 5;

        }
    }

    if (chartType === 'line') {
        const firstColor = finalData.datasets[0].backgroundColor[0];
        const gradient = ctx.createLinearGradient(0, 0, 0, 400); // Usar altura fija para consistencia
        gradient.addColorStop(0, hexToRgba(firstColor, 0.7)); // Más opaco arriba
        gradient.addColorStop(1, hexToRgba(firstColor, 0.1)); // Más transparente abajo
        finalData.datasets[0].fill = true;
        finalData.datasets[0].backgroundColor = gradient;
        finalData.datasets[0].borderColor = adjustColor(firstColor, -15); // Borde más oscuro
        finalData.datasets[0].borderWidth = 4; // Línea más gruesa
        finalData.datasets[0].tension = 0.4;
        finalData.datasets[0].pointRadius = 7; // Puntos más grandes
        finalData.datasets[0].pointBackgroundColor = adjustColor(firstColor, 35); // Puntos más brillantes
        finalData.datasets[0].pointBorderColor = '#fff';
        finalData.datasets[0].pointBorderWidth = 2;
        finalData.datasets[0].hoverRadius = 9;
        finalData.datasets[0].hoverBorderWidth = 3;
        chartOptions.plugins.datalabels.display = false;
        chartOptions.scales.y.grid.borderDash = [4, 4]; // Punteado más fino
        chartOptions.scales.x.grid.display = false; // Ocultar rejilla vertical
        chartOptions.plugins.tooltip.mode = 'index';
        chartOptions.plugins.tooltip.intersect = false;
    }

    if (chartType === 'scatter') {
        const originalScatterColors = finalData.datasets[0].backgroundColor;
        finalData.datasets[0].data = finalData.labels.map((label, i) => ({ x: label, y: finalData.datasets[0].data[i] }));
        chartOptions.scales.x = { type: 'category', labels: finalData.labels, ticks: { color: colorTextoGraficaSecundario }, grid: { color: 'rgba(0, 0, 0, 0.1)' } };
        chartOptions.scales.y.grid = { color: 'rgba(0, 0, 0, 0.1)' };
        
        // --- CAMBIO: CONECTAR LOS PUNTOS ---
        finalData.datasets[0].showLine = true; // ¡Conectar los puntos!
        finalData.datasets[0].tension = 0.4; // Curva suave
        finalData.datasets[0].borderColor = originalScatterColors[0] ? adjustColor(originalScatterColors[0], -10) : '#888'; // Usar el primer color para la línea
        finalData.datasets[0].borderWidth = 3; // Grosor de la línea
        
        finalData.datasets[0].pointRadius = 10; // Puntos grandes
        finalData.datasets[0].pointBorderWidth = 3;
        finalData.datasets[0].pointBackgroundColor = originalScatterColors.map(color => adjustColor(color, 25)); // Puntos más brillantes
        finalData.datasets[0].pointBorderColor = originalScatterColors.map(color => adjustColor(color, -25)); // Borde más oscuro
        finalData.datasets[0].hoverRadius = 12;

        // Datalabels encima de los puntos
        chartOptions.plugins.datalabels = {
    color: colorTextoGraficaPrincipal,
    anchor: 'end',         // etiqueta encima del punto
    align: 'bottom-right',
    offset: 20,             // separación
    clamp: true,           // evita que se salga del área visible
    clip: false,           // evita recorte fuera del canvas
    font: { weight: 'bold', size: 13 },
    formatter: (value) => {
        const percentage = totalDatosGlobal > 0
            ? `${((value.y / totalDatosGlobal) * 100).toFixed(1)}%`
            : '0%';
        return `${value.y} (${percentage})`;
    }
};

        chartOptions.plugins.tooltip.callbacks = { label: function(context) { let label = context.dataset.label || ''; if (label) { label += ': '; } if (context.parsed.y !== null) { label += `${context.label}: ${context.parsed.y}`; } return label; } };
        chartOptions.plugins.legend.display = false; // La línea usa un solo color, leyenda no necesaria
    }

    if (chartType === 'radar') {
        delete chartOptions.scales;
        const radarColor = finalData.datasets[0].backgroundColor[0];
        chartOptions.elements = {
            line: { borderWidth: 4, borderColor: adjustColor(radarColor, -10), tension: 0.3 }, // Línea más gruesa
            point: { radius: 6, backgroundColor: adjustColor(radarColor, 20), borderWidth: 2, borderColor: '#fff' }
        };
        finalData.datasets[0].fill = true;
        finalData.datasets[0].backgroundColor = hexToRgba(radarColor, 0.5); // Relleno más saturado
        chartOptions.scales = {
            r: {
                angleLines: { color: 'rgba(0, 0, 0, 0.25)' }, // Líneas más visibles
                grid: { color: 'rgba(0, 0, 0, 0.25)' },       // Rejilla más visible
                pointLabels: { color: colorTextoGraficaPrincipal, font: { size: 13, weight: 'bold' } }, // Etiquetas más grandes
                ticks: { backdropColor: 'transparent', color: colorTextoGraficaSecundario, showLabelBackdrop: false, font: {size: 11} }
            }
        };
        chartOptions.plugins.datalabels.display = false;
        chartOptions.plugins.legend.display = false; // Leyenda usualmente no necesaria en radar de un solo dataset
    }

   
    // --- RETORNO DE LA CONFIGURACIÓN ---
    return {
        type: finalType,
        data: finalData,
        options: chartOptions
    };
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
        doc.text("Reporte de Resultados de Encuesta", pageWidth / 2, 20, { align: "center" });
        
        doc.setDrawColor(180);
        doc.setLineWidth(0.5);
        doc.line(margin, 28, pageWidth - margin, 28);

        // --- Información de filtros ---
        const encuestaTitle = encuestaSelect.options[encuestaSelect.selectedIndex].text;
        const municipioName = municipioSelect.value ? municipioSelect.options[municipioSelect.selectedIndex].text : 'Todos';
        const seccionName = seccionSelect.value ? seccionSelect.options[seccionSelect.selectedIndex].text : 'Todas';
        const comunidadName = comunidadSelect.value ? comunidadSelect.options[comunidadSelect.selectedIndex].text : 'Todas';
        const filtroText = `Encuesta: ${encuestaTitle}  |  Municipio: ${municipioName}  |  Sección: ${seccionName}  |  Comunidad: ${comunidadName}`;
        
        doc.setFont("helvetica", "normal");
        doc.setFontSize(10);
        
        // ¡CAMBIO AQUÍ! Se establece el color del texto a un rojo intenso
        doc.setTextColor('#FF0000'); // Rojo Intenso 🔴
        
        doc.text(filtroText, pageWidth / 2, 35, { align: "center" });

        // ¡CAMBIO AQUÍ! Se restaura el color del texto a negro para el resto del documento
        doc.setTextColor('#000000'); 
        
        // --- Título de la Pregunta ---
        doc.setFont("helvetica", "bold");
        doc.setFontSize(16);
        const yPosPregunta = 48;
        doc.text(dataSet.title, pageWidth / 2, yPosPregunta, { align: "center" });

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

        downloadExcelBtn.addEventListener('click', function() {
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