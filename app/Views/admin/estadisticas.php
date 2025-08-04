<?php 
// Obtener la instancia de la sesión
$session = session();

// Preparar los datos del usuario para mostrar en la plantilla
$isLoggedIn = $session->get('isLoggedIn');
$userData = $session->get('usuario');
$nombreCompleto = "Invitado";
$nombreUsuario = "invitado";
$rolTexto = "Rol Desconocido";
$rutaFotoPerfil = base_url('public/img_user/user.png'); 

if ($isLoggedIn && is_array($userData)) {
    $nombreCompleto = esc($userData['nombre'] ?? '') . ' ' . esc($userData['apellido_paterno'] ?? '');
    $nombreUsuario = esc($userData['usuario'] ?? '');
    $id_rol = $userData['id_rol'] ?? null;
    switch ($id_rol) {
        case 1: $rolTexto = 'Administrador'; break;
        case 2: $rolTexto = 'Operador'; break;
        case 3: $rolTexto = 'Encuestador'; break;
        default: $rolTexto = 'Miembro'; break;
    }
    if (!empty($userData['foto'])) {
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
                                <h5 class="mb-0 font-weight-normal"><?= $nombreCompleto ?></h5>
                                <span><?= $rolTexto ?></span>
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
                                            <div class="form-group col-md-4">
                                                <label for="encuesta_select">Encuesta</label>
                                                <select class="form-control" id="encuesta_select">
                                                    <option value="">Selecciona una encuesta</option>
                                                    <?php foreach ($encuestas as $encuesta): ?>
                                                        <option value="<?= $encuesta['id_encuesta'] ?>"><?= esc($encuesta['titulo']) ?></option>
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
                                                        <option value="<?= $estado['id_estado'] ?>"><?= esc($estado['nombre_estado']) ?></option>
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
                                    <canvas id="barChart" style="height:230px; display: none;"></canvas>
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
    <script src="<?= base_url(RECURSOS_ADMIN_VENDORS . '/chart.js/Chart.min.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_ADMIN_JS . '/off-canvas.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_ADMIN_JS . '/hoverable-collapse.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_ADMIN_JS . '/misc.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_ADMIN_JS . '/settings.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_ADMIN_JS . '/todolist.js') ?>"></script>
    
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
            let myChart = null;

            const baseUrl = '<?= base_url("estadistica") ?>';

            function limpiarSelect(selectElement, disabled = true, placeholder = 'Selecciona...') {
                selectElement.innerHTML = `<option value="">${placeholder}</option>`;
                selectElement.disabled = disabled;
            }

            function cargarSelect(selectElement, data, idKey, textKey, placeholder) {
                limpiarSelect(selectElement, false, placeholder);
                data.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item[idKey];
                    option.textContent = item[textKey];
                    selectElement.appendChild(option);
                });
            }
            
            function actualizarGrafico() {
                const idEncuesta = encuestaSelect.value;
                const idPregunta = preguntaSelect.value;

                if (!idEncuesta || !idPregunta) {
                    if (myChart) { myChart.destroy(); }
                    noDataMessage.style.display = 'block';
                    chartCanvas.style.display = 'none';
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

                fetch(`${baseUrl}/getRespuestas?${params.toString()}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (myChart) { myChart.destroy(); }

                        if (data && data.length > 0) {
                            const labels = data.map(item => item.opcion);
                            const totals = data.map(item => item.total);

                            const chartData = {
                                labels: labels,
                                datasets: [{
                                    label: 'Total de Respuestas',
                                    data: totals,
                                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                                    borderColor: 'rgba(54, 162, 235, 1)',
                                    borderWidth: 1
                                }]
                            };

                            const ctx = chartCanvas.getContext('2d');
                            myChart = new Chart(ctx, {
                                type: 'bar',
                                data: chartData,
                                options: {
                                    scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
                                }
                            });
                            
                            noDataMessage.style.display = 'none';
                            chartCanvas.style.display = 'block';
                        } else {
                            noDataMessage.textContent = "No hay datos para los filtros seleccionados.";
                            noDataMessage.style.display = 'block';
                            chartCanvas.style.display = 'none';
                        }
                    })
                    .catch(error => {
                        console.error('Error al obtener datos del gráfico:', error);
                        if (myChart) { myChart.destroy(); }
                        noDataMessage.textContent = "Error al cargar los datos. Revisa la consola para más detalles.";
                        noDataMessage.style.display = 'block';
                        chartCanvas.style.display = 'none';
                    });
            }

            // Eventos para los selectores
            encuestaSelect.addEventListener('change', function() {
                const idEncuesta = this.value;
                limpiarSelect(preguntaSelect, !idEncuesta, 'Cargando preguntas...');
                if (idEncuesta) {
                    fetch(`${baseUrl}/getPreguntas/${idEncuesta}`)
                        .then(response => response.json())
                        .then(data => {
                            cargarSelect(preguntaSelect, data, 'id_pregunta', 'texto_pregunta', 'Selecciona una pregunta');
                        })
                        .catch(error => console.error('Error al cargar preguntas:', error));
                } else {
                     limpiarSelect(preguntaSelect);
                }
                actualizarGrafico();
            });

            preguntaSelect.addEventListener('change', actualizarGrafico);
            
            estadoSelect.addEventListener('change', function() {
                const idEstado = this.value;
                limpiarSelect(distritoFederalSelect, !idEstado, 'Cargando distritos federales...');
                limpiarSelect(distritoLocalSelect);
                limpiarSelect(municipioSelect);
                limpiarSelect(seccionSelect);
                limpiarSelect(comunidadSelect);
                if (idEstado) {
                    fetch(`${baseUrl}/getDistritosFederales/${idEstado}`)
                        .then(response => response.json())
                        .then(data => {
                            cargarSelect(distritoFederalSelect, data, 'id_distrito_federal', 'nombre_distrito_federal', 'Selecciona un distrito federal');
                        })
                        .catch(error => console.error('Error al cargar distritos federales:', error));
                } else {
                    limpiarSelect(distritoFederalSelect);
                }
                actualizarGrafico();
            });

            distritoFederalSelect.addEventListener('change', function() {
                const idDistritoFederal = this.value;
                limpiarSelect(distritoLocalSelect, !idDistritoFederal, 'Cargando distritos locales...');
                limpiarSelect(municipioSelect);
                limpiarSelect(seccionSelect);
                limpiarSelect(comunidadSelect);
                if (idDistritoFederal) {
                    fetch(`${baseUrl}/getDistritosLocales/${idDistritoFederal}`)
                        .then(response => response.json())
                        .then(data => {
                            cargarSelect(distritoLocalSelect, data, 'id_distrito_local', 'nombre_distrito_local', 'Selecciona un distrito local');
                        })
                        .catch(error => console.error('Error al cargar distritos locales:', error));
                } else {
                    limpiarSelect(distritoLocalSelect);
                }
                actualizarGrafico();
            });

            distritoLocalSelect.addEventListener('change', function() {
                const idDistritoLocal = this.value;
                limpiarSelect(municipioSelect, !idDistritoLocal, 'Cargando municipios...');
                limpiarSelect(seccionSelect);
                limpiarSelect(comunidadSelect);
                if (idDistritoLocal) {
                    fetch(`${baseUrl}/getMunicipios/${idDistritoLocal}`)
                        .then(response => response.json())
                        .then(data => {
                            cargarSelect(municipioSelect, data, 'id_municipio', 'nombre_municipio', 'Selecciona un municipio');
                        })
                        .catch(error => console.error('Error al cargar municipios:', error));
                } else {
                    limpiarSelect(municipioSelect);
                }
                actualizarGrafico();
            });
            
            municipioSelect.addEventListener('change', function() {
                const idMunicipio = this.value;
                limpiarSelect(seccionSelect, !idMunicipio, 'Cargando secciones...');
                limpiarSelect(comunidadSelect);
                if (idMunicipio) {
                    fetch(`${baseUrl}/getSecciones/${idMunicipio}`)
                        .then(response => response.json())
                        .then(data => {
                            cargarSelect(seccionSelect, data, 'id_seccion', 'nombre_seccion', 'Selecciona una sección');
                        })
                        .catch(error => console.error('Error al cargar secciones:', error));
                } else {
                    limpiarSelect(seccionSelect);
                }
                actualizarGrafico();
            });

            seccionSelect.addEventListener('change', function() {
                const idSeccion = this.value;
                limpiarSelect(comunidadSelect, !idSeccion, 'Cargando comunidades...');
                if (idSeccion) {
                    fetch(`${baseUrl}/getComunidades/${idSeccion}`)
                        .then(response => response.json())
                        .then(data => {
                            cargarSelect(comunidadSelect, data, 'id_comunidad', 'nombre_comunidad', 'Selecciona una comunidad');
                        })
                        .catch(error => console.error('Error al cargar comunidades:', error));
                } else {
                    limpiarSelect(comunidadSelect);
                }
                actualizarGrafico();
            });

            comunidadSelect.addEventListener('change', actualizarGrafico);
        });
    </script>
</body>
</html>
