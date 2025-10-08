<!DOCTYPE html>
<html class="loading" lang="es" data-textdirection="ltr">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Panel de Control - Vota y Opina</title>
    <link rel="apple-touch-icon" href="<?= base_url(RECURSOS_CONTROLADOR_IMAGES . 'ico/apple-icon-120.png') ?>">
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url(RECURSOS_CONTROLADOR_IMAGES . 'ico/favicon.ico') ?>">
    <link href="https://fonts.googleapis.com/css?family=Muli:300,300i,400,400i,600,600i,700,700i%7CComfortaa:300,400,700" rel="stylesheet">
    <link href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css" rel="stylesheet">
    
    <link rel="stylesheet" type="text/css" href="<?= base_url(RECURSOS_CONTROLADOR_CSS . 'vendors.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url(RECURSOS_CONTROLADOR_CSS . 'app-lite.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url(RECURSOS_CONTROLADOR_CSS . 'core/menu/menu-types/vertical-menu.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url(RECURSOS_CONTROLADOR_CSS . 'core/colors/palette-gradient.css') ?>">
    
    <style>
        .kpi-card .card-content { display: flex; flex-direction: column; height: 100%; }
        .kpi-card .kpi-header { display: flex; justify-content: space-between; align-items: flex-start; padding: 1.5rem 1.5rem 0 1.5rem; }
        .kpi-card .card-body { flex-grow: 1; display: flex; align-items: center; justify-content: center; padding: 1rem; }
        .kpi-card h5 { margin: 0; font-size: 1.1rem; }
        .kpi-card i { font-size: 2.5rem !important; opacity: 0.7; }
      .dropdown-menu-right .user-name {
    display: inline-block;
    max-width: 180px; /* ajusta según tu diseño */
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
    </style>
  </head>
  <body class="vertical-layout vertical-menu 2-columns menu-expanded fixed-navbar" data-open="click" data-menu="vertical-menu" data-color="bg-chartbg" data-col="2-columns">
<?php
// Preparar datos del usuario (debe pasarse desde el controlador preferiblemente)
$isLoggedIn = session()->get('isLoggedIn') ?? false;
$userData = session()->get('usuario') ?? null;

$nombreCompleto = "Invitado";
$rolTexto = "Rol Desconocido";
$rutaFotoPerfil = base_url('recursos_operador/images/layout_img/user_img.jpg');

if ($isLoggedIn && $userData) {
    $nombreCompleto = $userData['nombre'] . ' ' . $userData['apellido_paterno'] . ' ' . $userData['apellido_materno'];
$rolTexto = esc($userData['nombre_rol'] ?? 'Rol desconocido');
    if (!empty($userData['foto'])) {
        $rutaFotoPerfil = base_url('public/img_user/' . $userData['foto']);
    }
}
?>
    <nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-semi-light">
      <div class="navbar-wrapper">
        <div class="navbar-container content">
          <div class="collapse navbar-collapse show" id="navbar-mobile">
            <ul class="nav navbar-nav mr-auto float-left">
              <li class="nav-item d-block d-md-none"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu"></i></a></li>
              <li class="nav-item d-none d-md-block"><a class="nav-link nav-link-expand" href="#"><i class="ficon ft-maximize"></i></a></li>
            </ul>
            <ul class="nav navbar-nav float-right">
              <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown"> <span class="avatar avatar-online"><img src="<?= $rutaFotoPerfil ?>" alt="avatar"><i></i></span></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="arrow_box_right">
                      <a class="dropdown-item" href="#">
                        <span class="avatar avatar-online">
                          <img src="<?= $rutaFotoPerfil ?>" alt="avatar">
                        </span>
                        <span class="user-name text-bold-700 ml-1"><?= esc($nombreCompleto) ?></span>
                      </a>
                    </div>
                    <div class="dropdown-divider"></div><a class="dropdown-item" href="/controlador/perfil"><i class="ft-user"></i> Editar Perfil</a>
                    <div class="dropdown-divider"></div><a class="dropdown-item" href="/logout"><i class="ft-power"></i> Cerrar Sesión</a>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </nav>

    <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow " data-scroll-to-active="true" data-img="<?= base_url(RECURSOS_CONTROLADOR_IMAGES . 'backgrounds/02.jpg') ?>">
      <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
          <li class="nav-item mr-auto"><a class="navbar-brand" href="<?= base_url('controlador/panel') ?>">
              <h3 class="brand-text">Vota y Opina</h3></a></li>
          <li class="nav-item d-md-none"><a class="nav-link close-navbar"><i class="ft-x"></i></a></li>
        </ul>
      </div>
      <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
          <li class="nav-item"><a href="<?= base_url('controlador/panel') ?>"><i class="la la-home"></i><span class="menu-title">Panel</span></a></li>
          <li class=" active"><a href="<?= base_url('controlador/graficas') ?>"><i class="la la-pie-chart"></i><span class="menu-title">Gráficas</span></a></li>
          <li class=" nav-item"><a href="<?= base_url('controlador/usuarios') ?>"><i class="la la-users"></i><span class="menu-title">Usuarios</span></a></li>
          <li class=" nav-item"><a href="<?= base_url('controlador/encuestas') ?>"><i class="la la-list-alt"></i><span class="menu-title">Encuestas</span></a></li>
          <li class=" nav-item"><a href="<?= base_url('controlador/respuestas') ?>"><i class="la la-check-square"></i><span class="menu-title">Respuestas</span></a></li>
          <li class=" nav-item"><a href="<?= base_url('controlador/perfil') ?>"><i class="la la-user"></i><span class="menu-title">Perfil</span></a></li>
        </ul>
      </div>
      <div class="navigation-background"></div>
    </div>
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-wrapper-before"></div>
        <div class="content-header row">
           <div class="content-header-left col-md-4 col-12 mb-2">
            <h3 class="content-header-title">Dashboard</h3>
          </div>
        </div>
        <div class="content-body">
            
            <div class="row">
                <div class="col-12">
                    <div class="card" style="background-image: linear-gradient(to right, #6666ff, #7657f5); color: white;">
                        <div class="card-body">
                            <h4 class="card-title" style="color: white;">¡Bienvenido al Panel de Control!</h4>
                            <p class="card-text mb-0">Desde aquí puedes monitorear la actividad, gestionar usuarios y analizar los resultados de las encuestas.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-4 col-lg-6 col-md-12">
                    <div class="card pull-up ecom-card-1 kpi-card bg-white">
                        <div class="card-content ecom-card2 height-180">
                            <div class="kpi-header">
                                <h5 class="text-muted info">Usuarios Registrados</h5>
                                <i class="la la-users info"></i>
                            </div>
                            <div class="card-body"><h1 class="info text-center font-large-2 text-bold-700"><?= esc($totalUsuarios ?? 0) ?></h1></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-12">
                    <div class="card pull-up ecom-card-1 kpi-card bg-white">
                        <div class="card-content ecom-card2 height-180">
                            <div class="kpi-header">
                                <h5 class="text-muted warning">Encuestas Existentes</h5>
                                <i class="la la-list-alt warning"></i>
                            </div>
                            <div class="card-body"><h1 class="warning text-center font-large-2 text-bold-700"><?= esc($totalEncuestas ?? 0) ?></h1></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-12">
                    <div class="card pull-up ecom-card-1 kpi-card bg-white">
                        <div class="card-content ecom-card2 height-180">
                           <div class="kpi-header">
                                <h5 class="text-muted danger">Respuestas Recibidas</h5>
                                <i class="la la-check-square danger"></i>
                            </div>
                            <div class="card-body"><h1 class="danger text-center font-large-2 text-bold-700"><?= esc($totalRespuestas ?? 0) ?></h1></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row match-height">
                 <div class="col-lg-6 col-md-12"> <div class="card">
                        <div class="card-header"><h4 class="card-title">Distribución de Usuarios por Rol</h4></div>
                        <div class="card-content collapse show">
                            <div class="card-body"><div class="height-400"><canvas id="graficaUsuariosPorRol"></canvas></div></div>
                        </div>
                    </div>
                </div>
                 <div class="col-lg-6 col-md-12"> <div class="card">
                        <div class="card-header"><h4 class="card-title">Estado de Encuestas</h4></div>
                        <div class="card-content collapse show">
                            <div class="card-body"><div class="height-400"><canvas id="graficaEstadoEncuestas"></canvas></div></div>
                        </div>
                    </div>
                </div>
            </div>

             <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header"><h4 class="card-title">Actividad General de Respuestas (Últimos 30 Días)</h4></div>
                        <div class="card-content collapse show">
                            <div class="card-body"><div class="height-400"><canvas id="graficaActividadDiaria"></canvas></div></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
    
    <footer class="footer footer-static footer-light navbar-border navbar-shadow">
      <div class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2"><span class="float-md-left d-block d-md-inline-block"><?= date('Y') ?> &copy; Copyright <a class="text-bold-800 grey darken-2" href="#">Vota y Opina</a></span>
      </div>
    </footer>

    <script src="<?= base_url(RECURSOS_CONTROLADOR_VENDORS . 'js/vendors.min.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_CONTROLADOR_VENDORS . 'js/charts/chart.min.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_CONTROLADOR_JS . 'core/app-menu-lite.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_CONTROLADOR_JS . 'core/app-lite.js') ?>"></script>
    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const CHART_COLORS = ['#6666FF', '#FF9F40', '#FF6384', '#4BC0C0', '#9966FF', '#FFCD56'];
            
            // Gráfica 1: Barras Verticales (Usuarios por Rol)
            new Chart(document.getElementById('graficaUsuariosPorRol').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: <?= $graficaRolesLabels ?? '[]' ?>,
                    datasets: [{
                        label: 'Total de Usuarios',
                        data: <?= $graficaRolesData ?? '[]' ?>,
                        backgroundColor: CHART_COLORS,
                        borderWidth: 0
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false, legend: { display: false }, scales: { yAxes: [{ ticks: { beginAtZero: true, stepSize: 1 } }] } }
            });

            // Gráfica 2: Pastel (Estado de Encuestas)
            new Chart(document.getElementById('graficaEstadoEncuestas').getContext('2d'), {
                type: 'pie',
                data: {
                    labels: <?= $graficaEncuestasStatusLabels ?? '[]' ?>,
                    datasets: [{ 
                        data: <?= $graficaEncuestasStatusData ?? '[]' ?>, 
                        backgroundColor: ['#4BC0C0', '#FF6384'], // Verde-azulado para Activas, Rosa para Inactivas
                        borderColor: '#fff', 
                        borderWidth: 2 
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false, legend: { position: 'right' } }
            });

            // Gráfica 3: Línea de Picos (Actividad Diaria General)
            new Chart(document.getElementById('graficaActividadDiaria').getContext('2d'), {
                type: 'line',
                data: {
                    labels: <?= $graficaActividadLabels ?? '[]' ?>,
                    datasets: [{
                        label: 'Respuestas por Día',
                        data: <?= $graficaActividadData ?? '[]' ?>,
                        borderColor: '#FF6384',
                        borderWidth: 3,
                        backgroundColor: 'rgba(255, 99, 132, 0.1)',
                        pointBackgroundColor: '#FF6384',
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        lineTension: 0 // Esto crea los "picos"
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false, tooltips: { mode: 'index', intersect: false }, scales: { yAxes: [{ ticks: { beginAtZero: true } }], xAxes: [{ ticks: { autoSkip: true, maxTicksLimit: 15 } }] } }
            });
        });
    </script>
  </body>
</html>