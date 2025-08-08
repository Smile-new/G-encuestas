<?php
// Obtener la instancia de la sesión al inicio del archivo
$session = session();

// Preparar los datos del usuario para mostrar en la plantilla
$isLoggedIn = $session->get('isLoggedIn');
$userData = $session->get('usuario'); // Obtener todo el array 'usuario' de la sesión

// Definir valores por defecto si el usuario no está logueado o los datos no existen
$nombreCompleto = "Invitado";
$nombreUsuario = "invitado"; // Se usará el campo 'usuario' (username)
$rolTexto = "Rol Desconocido";
$rutaFotoPerfil = base_url(RECURSOS_ADMIN_IMAGES . '/faces/face15.jpg'); // Imagen por defecto de la plantilla

if ($isLoggedIn && is_array($userData)) {
    $nombreCompleto = esc($userData['nombre']) . ' ' .
                      esc($userData['apellido_paterno']) . ' ' .
                      esc($userData['apellido_materno']);
    $nombreUsuario = esc($userData['usuario']); // Usamos el campo 'usuario' del array de sesión
    
    $id_rol = $userData['id_rol'] ?? null; // Usar id_rol para el rol
    switch ($id_rol) {
        case 1: $rolTexto = 'Administrador'; break;
        case 2: $rolTexto = 'Operador'; break;
        case 3: $rolTexto = 'Encuestador'; break;
        default: $rolTexto = 'Miembro'; break;
    }

    // Si hay una foto de usuario cargada en la sesión, usarla; de lo contrario, usar la por defecto
    if (!empty($userData['foto'])) {
        // Asegúrate de que 'public/img_user/' sea la ruta correcta donde guardas las fotos de usuario
        $rutaFotoPerfil = base_url('public/img_user/' . esc($userData['foto']));
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Estadísticas | Encuestas</title>
    <link rel="stylesheet" href="<?= base_url(RECURSOS_ADMIN_VENDORS . '/mdi/css/materialdesignicons.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url(RECURSOS_ADMIN_VENDORS . '/css/vendor.bundle.base.css') ?>">
    <link rel="stylesheet" href="<?= base_url(RECURSOS_ADMIN_CSS . '/style.css') ?>">
    <link rel="shortcut icon" href="<?= base_url(RECURSOS_ADMIN_IMAGES . '/favicon.png') ?>" />
    <style>
        /* Estilos personalizados para el tema oscuro */
        label {
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
        canvas#barChart {
            background-color: #ffffff;
        }
        .chart-container {
            position: relative;
            height: 400px;
        }
    </style>
</head>
<body>
    <div class="container-scroller">
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
                <a class="sidebar-brand brand-logo" href="<?= base_url('dashboard') ?>"><img src="<?= base_url(RECURSOS_ADMIN_IMAGES . '/logo.png') ?>" alt="logo" /></a>
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
                    <a class="sidebar-brand brand-logo" href="<?= base_url('dashboard') ?>"><img src="<?= base_url(RECURSOS_ADMIN_IMAGES . '/logo.png') ?>" alt="logo" /></a>
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
                                    <p class="mb-0 d-none d-sm-block navbar-profile-name"><?= esc($nombreCompleto) ?></p>
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
                                            <div class="form-group col-md-4">
                                                <label for="encuesta_select">Encuesta</label>
                                                <select class="form-control" id="encuesta_select">
                                                    <option value="">Selecciona una encuesta</option>
                                                    <?php foreach ($encuestas as $encuesta): ?>
                                                        <option value="<?= esc($encuesta['id_encuesta']) ?>"><?= esc($encuesta['titulo']) ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="pregunta_select">Pregunta</label>
                                                <select class="form-control" id="pregunta_select" disabled>
                                                    <option value="">Selecciona una pregunta</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-4">
                                                <label for="estado_select">Estado</label>
                                                <select class="form-control" id="estado_select">
                                                    <option value="">Selecciona un estado</option>
                                                    <?php foreach ($estados as $estado): ?>
                                                        <option value="<?= esc($estado['id_estado']) ?>"><?= esc($estado['nombre_estado']) ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="distrito_federal_select">Distrito Federal</label>
                                                <select class="form-control" id="distrito_federal_select" disabled>
                                                    <option value="">Selecciona un distrito federal</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="distrito_local_select">Distrito Local</label>
                                                <select class="form-control" id="distrito_local_select" disabled>
                                                    <option value="">Selecciona un distrito local</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-4">
                                                <label for="municipio_select">Municipio</label>
                                                <select class="form-control" id="municipio_select" disabled>
                                                    <option value="">Selecciona un municipio</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="seccion_select">Sección</label>
                                                <select class="form-control" id="seccion_select" disabled>
                                                    <option value="">Selecciona una sección</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="comunidad_select">Comunidad</label>
                                                <select class="form-control" id="comunidad_select" disabled>
                                                    <option value="">Selecciona una comunidad</option>
                                                </select>
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
                                <div class="card-body">
                                    <h4 class="card-title" id="titulo_grafico">Resultados de la pregunta</h4>
                                    <div id="no_data_message" class="text-center" style="display: block;">
                                        <p>Selecciona una encuesta y una pregunta para ver los resultados.</p>
                                    </div>
                                    <div class="chart-container">
                                        <canvas id="barChart" style="display: none;"></canvas>
                                    </div>
                                    <div id="chart-data-summary" class="mt-4" style="display: none;"></div>
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
    <script src="<?= base_url(RECURSOS_ADMIN_VENDORS . '/js/vendor.bundle.base.js') ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script src="<?= base_url(RECURSOS_ADMIN_JS . '/off-canvas.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_ADMIN_JS . '/hoverable-collapse.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_ADMIN_JS . '/misc.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_ADMIN_JS . '/settings.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_ADMIN_JS . '/todolist.js') ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
    
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const encuestaSelect = document.getElementById('encuesta_select');
        const preguntaSelect = document.getElementById('pregunta_select');
        const estadoSelect = document.getElementById('estado_select');
        const distritoFederalSelect = document.getElementById('distrito_federal_select');
        const distritoLocalSelect = document.getElementById('distrito_local_select');
        const municipioSelect = document.getElementById('municipio_select');
        const seccionSelect = document.getElementById('seccion_select');
        const comunidadSelect = document.getElementById('comunidad_select');
        const chartCanvas = document.getElementById('barChart');
        const noDataMessage = document.getElementById('no_data_message');
        const tituloGrafico = document.getElementById('titulo_grafico');
        const chartDataSummary = document.getElementById('chart-data-summary');

        let myChart = null;
        const baseUrl = '<?= base_url("estadistica") ?>';

        // Función genérica para limpiar y cargar selectores
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

        // Función principal para actualizar el gráfico y los filtros
        async function actualizarGrafico() {
            const idEncuesta = encuestaSelect.value;
            const idPregunta = preguntaSelect.value;

            if (!idEncuesta || !idPregunta) {
                if (myChart) { myChart.destroy(); }
                noDataMessage.style.display = 'block';
                noDataMessage.textContent = "Selecciona una encuesta y una pregunta para ver los resultados.";
                chartCanvas.style.display = 'none';
                chartDataSummary.style.display = 'none';
                return;
            }

            tituloGrafico.textContent = `Resultados: ${preguntaSelect.options[preguntaSelect.selectedIndex].text}`;

            const params = new URLSearchParams({
                id_encuesta: idEncuesta,
                id_pregunta: idPregunta,
                id_estado: estadoSelect.value,
                id_distrito_federal: distritoFederalSelect.value,
                id_distrito_local: distritoLocalSelect.value,
                id_municipio: municipioSelect.value,
                id_seccion: seccionSelect.value,
                id_comunidad: comunidadSelect.value,
            });

            try {
                // Obtener todas las opciones de respuesta para la pregunta
                const opcionesResponse = await fetch(`${baseUrl}/getOpcionesPregunta/${idPregunta}`);
                if (!opcionesResponse.ok) {
                    throw new Error(`Error HTTP! status: ${opcionesResponse.status}`);
                }
                const opcionesData = await opcionesResponse.json();

                // Obtener las respuestas con los filtros aplicados
                const respuestasResponse = await fetch(`${baseUrl}/getRespuestas?${params.toString()}`);
                if (!respuestasResponse.ok) {
                    throw new Error(`Error HTTP! status: ${respuestasResponse.status}`);
                }
                const respuestasData = await respuestasResponse.json();

                if (myChart) { myChart.destroy(); }

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
                    const totalRespuestas = totals.reduce((sum, current) => sum + current, 0);

                    const porcentajes = totals.map(total => totalRespuestas > 0 ? ((total / totalRespuestas) * 100).toFixed(1) : 0);

                    let summaryHtml = `<strong>Total de respuestas: ${totalRespuestas}</strong><br>`;
                    labels.forEach((label, index) => {
                        summaryHtml += `${label}: ${totals[index]} (${porcentajes[index]}%)<br>`;
                    });
                    chartDataSummary.innerHTML = summaryHtml;
                    chartDataSummary.style.display = 'block';

                    const colores = ['#FF1493', '#00FFFF', '#FFD700', '#32CD32', '#9400D3', '#FF4500'];

                    const chartData = {
                        labels: labels,
                        datasets: [{
                            label: 'Total de Respuestas',
                            data: totals,
                            backgroundColor: totals.map((_, index) => colores[index % colores.length]),
                            borderColor: totals.map((_, index) => colores[index % colores.length]),
                            borderWidth: 1
                        }]
                    };

                    const ctx = chartCanvas.getContext('2d');
                    myChart = new Chart(ctx, {
                        type: 'bar',
                        data: chartData,
                        options: {
                            maintainAspectRatio: false,
                            responsive: true,
                            plugins: {
                                legend: {
                                    labels: {
                                        color: '#000000' // Color del texto de la leyenda
                                    }
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            const value = context.parsed.y;
                                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                            const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                            return `${context.label}: ${value} (${percentage}%)`;
                                        }
                                    }
                                },
                                datalabels: {
                                    color: '#000000', // Color del texto de las etiquetas de datos
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
                                    suggestedMax: Math.max(...totals) > 5 ? Math.max(...totals) + 1 : 5,
                                    ticks: {
                                        precision: 0,
                                        color: '#000000' // Color del texto de los ticks del eje Y
                                    }
                                },
                                x: {
                                    ticks: {
                                        color: '#000000', // Color del texto de los ticks del eje X
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
                        },
                        plugins: [ChartDataLabels]
                    });

                    noDataMessage.style.display = 'none';
                    chartCanvas.style.display = 'block';
                    chartDataSummary.style.display = 'block';
                } else {
                    if (myChart) { myChart.destroy(); }
                    noDataMessage.textContent = "No hay opciones de respuesta para esta pregunta.";
                    noDataMessage.style.display = 'block';
                    chartCanvas.style.display = 'none';
                    chartDataSummary.style.display = 'none';
                }
            } catch (error) {
                console.error('Error al obtener datos del gráfico:', error);
                if (myChart) { myChart.destroy(); }
                noDataMessage.textContent = "Error al cargar los datos. Revisa la consola para más detalles.";
                noDataMessage.style.display = 'block';
                chartCanvas.style.display = 'none';
                chartDataSummary.style.display = 'none';
            }
        }

        // --- Eventos para los selectores ---
        // Aquí están las correcciones para encadenar las llamadas
        // a la API de forma correcta.

        // Evento para el selector de Encuesta
        encuestaSelect.addEventListener('change', async function() {
            const idEncuesta = this.value;
            // Reiniciar y deshabilitar los selectores de pregunta y geográficos
            cargarSelect(preguntaSelect, [], 'id_pregunta', 'texto_pregunta', 'Cargando preguntas...', !idEncuesta);
            
            // Reestablecer los selectores geográficos a su estado inicial
            cargarSelect(estadoSelect, <?= json_encode($estados) ?>, 'id_estado', 'nombre_estado', 'Selecciona un estado');
            cargarSelect(distritoFederalSelect, [], 'id_distrito_federal', 'nombre_distrito_federal', 'Selecciona un distrito federal', true);
            cargarSelect(distritoLocalSelect, [], 'id_distrito_local', 'nombre_distrito_local', 'Selecciona un distrito local', true);
            cargarSelect(municipioSelect, [], 'id_municipio', 'nombre_municipio', 'Selecciona un municipio', true);
            cargarSelect(seccionSelect, [], 'id_seccion', 'nombre_seccion', 'Selecciona una sección', true);
            cargarSelect(comunidadSelect, [], 'id_comunidad', 'nombre_comunidad', 'Selecciona una comunidad', true);

            if (idEncuesta) {
                try {
                    const response = await fetch(`${baseUrl}/getPreguntas/${idEncuesta}`);
                    const data = await response.json();
                    cargarSelect(preguntaSelect, data, 'id_pregunta', 'texto_pregunta', 'Selecciona una pregunta');
                } catch (error) {
                    console.error('Error al cargar preguntas:', error);
                }
            }
            actualizarGrafico();
        });

        // Evento para el selector de Pregunta
        preguntaSelect.addEventListener('change', actualizarGrafico);

        // Evento para el selector de Estado
        estadoSelect.addEventListener('change', async function() {
            const idEstado = this.value;
            // Limpiar y deshabilitar los siguientes selectores
            cargarSelect(distritoFederalSelect, [], 'id_distrito_federal', 'nombre_distrito_federal', 'Cargando distritos federales...', !idEstado);
            cargarSelect(distritoLocalSelect, [], 'id_distrito_local', 'nombre_distrito_local', 'Selecciona un distrito local', true);
            cargarSelect(municipioSelect, [], 'id_municipio', 'nombre_municipio', 'Selecciona un municipio', true);
            cargarSelect(seccionSelect, [], 'id_seccion', 'nombre_seccion', 'Selecciona una sección', true);
            cargarSelect(comunidadSelect, [], 'id_comunidad', 'nombre_comunidad', 'Selecciona una comunidad', true);
            
            if (idEstado) {
                try {
                    const response = await fetch(`${baseUrl}/getDistritosFederales/${idEstado}`);
                    const data = await response.json();
                    cargarSelect(distritoFederalSelect, data, 'id_distrito_federal', 'nombre_distrito_federal', 'Selecciona un distrito federal');
                } catch (error) {
                    console.error('Error al cargar distritos federales:', error);
                }
            }
            actualizarGrafico();
        });

        // Evento para el selector de Distrito Federal
        distritoFederalSelect.addEventListener('change', async function() {
            const idDistritoFederal = this.value;
            // Limpiar y deshabilitar los siguientes selectores
            cargarSelect(distritoLocalSelect, [], 'id_distrito_local', 'nombre_distrito_local', 'Cargando distritos locales...', !idDistritoFederal);
            cargarSelect(municipioSelect, [], 'id_municipio', 'nombre_municipio', 'Selecciona un municipio', true);
            cargarSelect(seccionSelect, [], 'id_seccion', 'nombre_seccion', 'Selecciona una sección', true);
            cargarSelect(comunidadSelect, [], 'id_comunidad', 'nombre_comunidad', 'Selecciona una comunidad', true);

            if (idDistritoFederal) {
                try {
                    const response = await fetch(`${baseUrl}/getDistritosLocales/${idDistritoFederal}`);
                    const data = await response.json();
                    cargarSelect(distritoLocalSelect, data, 'id_distrito_local', 'nombre_distrito_local', 'Selecciona un distrito local');
                } catch (error) {
                    console.error('Error al cargar distritos locales:', error);
                }
            }
            actualizarGrafico();
        });

        // Evento para el selector de Distrito Local
        distritoLocalSelect.addEventListener('change', async function() {
            const idDistritoLocal = this.value;
            // Limpiar y deshabilitar los siguientes selectores
            cargarSelect(municipioSelect, [], 'id_municipio', 'nombre_municipio', 'Cargando municipios...', !idDistritoLocal);
            cargarSelect(seccionSelect, [], 'id_seccion', 'nombre_seccion', 'Selecciona una sección', true);
            cargarSelect(comunidadSelect, [], 'id_comunidad', 'nombre_comunidad', 'Selecciona una comunidad', true);

            if (idDistritoLocal) {
                try {
                    const response = await fetch(`${baseUrl}/getMunicipios/${idDistritoLocal}`);
                    const data = await response.json();
                    cargarSelect(municipioSelect, data, 'id_municipio', 'nombre_municipio', 'Selecciona un municipio');
                } catch (error) {
                    console.error('Error al cargar municipios:', error);
                }
            }
            actualizarGrafico();
        });

        // Evento para el selector de Municipio
        municipioSelect.addEventListener('change', async function() {
            const idMunicipio = this.value;
            // Limpiar y deshabilitar los siguientes selectores
            cargarSelect(seccionSelect, [], 'id_seccion', 'nombre_seccion', 'Cargando secciones...', !idMunicipio);
            cargarSelect(comunidadSelect, [], 'id_comunidad', 'nombre_comunidad', 'Selecciona una comunidad', true);
            
            if (idMunicipio) {
                try {
                    const response = await fetch(`${baseUrl}/getSecciones/${idMunicipio}`);
                    const data = await response.json();
                    cargarSelect(seccionSelect, data, 'id_seccion', 'nombre_seccion', 'Selecciona una sección');
                } catch (error) {
                    console.error('Error al cargar secciones:', error);
                }
            }
            actualizarGrafico();
        });
        
        // Evento para el selector de Sección
        seccionSelect.addEventListener('change', async function() {
            const idSeccion = this.value;
            // Limpiar y deshabilitar el siguiente selector
            cargarSelect(comunidadSelect, [], 'id_comunidad', 'nombre_comunidad', 'Cargando comunidades...', !idSeccion);
            
            if (idSeccion) {
                try {
                    const response = await fetch(`${baseUrl}/getComunidades/${idSeccion}`);
                    const data = await response.json();
                    cargarSelect(comunidadSelect, data, 'id_comunidad', 'nombre_comunidad', 'Selecciona una comunidad');
                } catch (error) {
                    console.error('Error al cargar comunidades:', error);
                }
            }
            actualizarGrafico();
        });
        
        // Evento para el selector de Comunidad
        comunidadSelect.addEventListener('change', actualizarGrafico);
    });
    </script>
</body>
</html>
