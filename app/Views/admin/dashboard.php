<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Corona Admin - Dashboard</title>
    <link rel="stylesheet" href="<?= base_url(RECURSOS_ADMIN_VENDORS . '/mdi/css/materialdesignicons.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url(RECURSOS_ADMIN_VENDORS . '/css/vendor.bundle.base.css') ?>">
    <link rel="stylesheet" href="<?= base_url(RECURSOS_ADMIN_VENDORS . '/jvectormap/jquery-jvectormap.css') ?>">
    <link rel="stylesheet" href="<?= base_url(RECURSOS_ADMIN_VENDORS . '/flag-icon-css/css/flag-icon.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url(RECURSOS_ADMIN_VENDORS . '/owl-carousel-2/owl.carousel.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url(RECURSOS_ADMIN_VENDORS . '/owl-carousel-2/owl.theme.default.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url(RECURSOS_ADMIN_CSS . '/style.css') ?>">
    
    <style>
      /* Gradient backgrounds for cards */
      .bg-gradient-danger {
        background: linear-gradient(to right,rgba(68, 147, 251, 0.78),rgb(231, 46, 14)) !important;
      }
      .bg-gradient-warning {
        background: linear-gradient(to right,rgb(251, 139, 3), #ffd200) !important;
      }
      .bg-gradient-success {
        background: linear-gradient(to right, #00b09b,rgb(158, 249, 0)) !important;
      }
      .bg-gradient-info {
        background: linear-gradient(to right,rgb(126, 213, 235),rgb(187, 103, 242)) !important;
      }

      /* General card styling (might be from your base style.css, but good to ensure here) */
      .card {
          border-radius: 8px;
          box-shadow: 0 2px 4px rgba(0,0,0,0.1);
          overflow: hidden; /* Ensures content stays within rounded corners */
      }
      .card-body {
          padding: 1.5rem;
      }

      /* Responsive adjustments */
      @media (max-width: 991px) {
          /* Ensure consistent spacing when cards stack on tablets/smaller desktops */
          .stretch-card, .grid-margin {
              margin-bottom: 20px;
          }
      }
      @media (max-width: 767px) {
          /* Hide sidebar and collapse profile name on very small screens */
          .sidebar {
              display: none; /* Hide the entire sidebar */
          }
          .navbar-profile-name {
              display: none !important; /* Hide profile name in navbar */
          }
          /* Adjust table action buttons for smaller screens if they become too cramped */
          .table td .btn {
              margin-bottom: 5px; /* Add some space between stacked buttons */
              width: 100%; /* Make buttons full width if they must stack */
              box-sizing: border-box; /* Include padding/border in width */
          }
      }

      /* Chart container styling for responsiveness */
      .chart-container {
        position: relative;
        height: 300px; /* Fixed height, but width will be fluid */
        width: 100%;
        margin-bottom: 20px; /* Space below the chart */
      }
    </style>
  </head>
  <body>
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
        </ul>
      </nav>
      <div class="container-fluid page-body-wrapper">
        <nav class="navbar p-0 fixed-top d-flex flex-row">
          <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
            <a class="navbar-brand brand-logo-mini" href="<?= base_url('dashboard') ?>"><img src="<?= base_url(RECURSOS_ADMIN_IMAGES . '/logo-mini.svg') ?>" alt="logo" /></a>
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
                  <a class="dropdown-item preview-item" href="<?= base_url('settings') ?>">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-settings text-success"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject mb-1">Configuración</p>
                    </div>
                  </a>
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
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
              <span class="mdi mdi-format-line-spacing"></span>
            </button>
          </div>
        </nav>
        <div class="main-panel">
            <div class="content-wrapper"> <div class="row">
                    <div class="col-sm-6 col-md-3 grid-margin stretch-card mb-4">
                        <div class="card bg-gradient-danger card-img-holder text-white">
                            <div class="card-body">
                                <h4 class="font-weight-normal mb-3">Total de Encuestas <i class="mdi mdi-chart-line mdi-24px float-right"></i></h4>
                                <h2 class="mb-5">
                                    <?= esc($totalEncuestas) ?>
                                    <span class="text-<?= ($percentageChangeTotalEncuestas >= 0) ? 'success' : 'danger' ?> small">
                                        <?= ($percentageChangeTotalEncuestas >= 0 ? '+' : '') . esc($percentageChangeTotalEncuestas) ?>%
                                    </span>
                                </h2>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3 grid-margin stretch-card mb-4">
                        <div class="card bg-gradient-warning card-img-holder text-white">
                            <div class="card-body">
                                <h4 class="font-weight-normal mb-3">Encuestas Activas <i class="mdi mdi-bookmark-outline mdi-24px float-right"></i></h4>
                                <h2 class="mb-5">
                                    <?= esc($encuestasActivas) ?>
                                    <span class="text-<?= ($percentageChangeEncuestasActivas >= 0) ? 'success' : 'danger' ?> small">
                                        <?= ($percentageChangeEncuestasActivas >= 0 ? '+' : '') . esc($percentageChangeEncuestasActivas) ?>%
                                    </span>
                                </h2>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3 grid-margin stretch-card mb-4">
                        <div class="card bg-gradient-success card-img-holder text-white">
                            <div class="card-body">
                                <h4 class="font-weight-normal mb-3">Total de Respuestas <i class="mdi mdi-diamond mdi-24px float-right"></i></h4>
                                <h2 class="mb-5">
                                    <?= esc($totalRespuestas) ?>
                                    <span class="text-<?= ($percentageChangeTotalRespuestas >= 0) ? 'success' : 'danger' ?> small">
                                        <?= ($percentageChangeTotalRespuestas >= 0 ? '+' : '') . esc($percentageChangeTotalRespuestas) ?>%
                                    </span>
                                </h2>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3 grid-margin stretch-card mb-4">
                        <div class="card bg-gradient-info card-img-holder text-white">
                            <div class="card-body">
                                <h4 class="font-weight-normal mb-3">Usuarios Registrados <i class="mdi mdi-account-multiple mdi-24px float-right"></i></h4>
                                <h2 class="mb-5">
                                    <?= esc($usuariosRegistrados) ?>
                                    <span class="text-<?= ($percentageChangeUsuariosRegistrados >= 0) ? 'success' : 'danger' ?> small">
                                        <?= ($percentageChangeUsuariosRegistrados >= 0 ? '+' : '') . esc($percentageChangeUsuariosRegistrados) ?>%
                                    </span>
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Distribución de Encuestas por Estado</h4>
                                <div class="chart-container">
                                    <canvas id="surveyStatusChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Usuarios por Rol</h4> <div class="chart-container">
                                    <canvas id="usersByRoleChart"></canvas> </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Últimas Encuestas Recientes</h4>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th> Título </th>
                                                <th> Fecha Creación </th>
                                                <th> Activa </th>
                                                <th> Acciones </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($ultimasEncuestas)): ?>
                                                <?php foreach ($ultimasEncuestas as $encuesta): ?>
                                                    <tr>
                                                        <td> <?= esc($encuesta['titulo'] ?? 'N/A') ?> </td>
                                                        <td> <?= esc($encuesta['fecha_creacion'] ?? 'N/A') ?> </td>
                                                        <td>
                                                            <div class="badge badge-outline-<?= ($encuesta['activa'] ?? false) ? 'success' : 'danger' ?>">
                                                                <?= ($encuesta['activa'] ?? false) ? 'Activa' : 'Inactiva' ?>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <?php 
                                                            $encuestaId = $encuesta['id'] ?? null; 
                                                            if ($encuestaId !== null): 
                                                            ?>
                                                                <a href="<?= base_url('encuestas/edit/' . $encuestaId) ?>" class="btn btn-info btn-sm">Editar</a>
                                                                <a href="<?= base_url('encuestas/view/' . $encuestaId) ?>" class="btn btn-primary btn-sm">Ver</a>
                                                            <?php else: ?>
                                                                <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="4" class="text-center">No hay encuestas recientes para mostrar.</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <footer class="footer">
                <div class="d-sm-flex justify-content-center justify-content-sm-between">
                    <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © bootstrapdash.com 2020</span>
                    <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> Free <a href="https://www.bootstrapdash.com/bootstrap-admin-template/" target="_blank">Bootstrap admin templates</a> from Bootstrapdash.com</span>
                </div>
            </footer>
            </div>
      </div>
    </div>

    <script src="<?= base_url(RECURSOS_ADMIN_VENDORS . '/js/vendor.bundle.base.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_ADMIN_VENDORS . '/progressbar.js/progressbar.min.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_ADMIN_VENDORS . '/jvectormap/jquery-jvectormap.min.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_ADMIN_VENDORS . '/jvectormap/jquery-jvectormap-world-mill-en.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_ADMIN_VENDORS . '/owl-carousel-2/owl.carousel.min.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_ADMIN_JS . '/off-canvas.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_ADMIN_JS . '/hoverable-collapse.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_ADMIN_JS . '/misc.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_ADMIN_JS . '/settings.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_ADMIN_JS . '/todolist.js') ?>"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 
<script>
  // JavaScript for Chart.js graphs
  document.addEventListener('DOMContentLoaded', function() {
    // --- Chart 1: Survey Status Distribution (Pie/Doughnut Chart) ---
    const surveyStatusCtx = document.getElementById('surveyStatusChart').getContext('2d');
    const surveyStatusChart = new Chart(surveyStatusCtx, {
        type: 'doughnut', // Or 'pie'
        data: {
            labels: ['Activas', 'Inactivas'], // Example labels
            datasets: [{
                label: 'Número de Encuestas',
                data: [
                    <?= esc($encuestasActivas) ?>, // Assuming this is "Activas"
                    <?= esc($totalEncuestas - $encuestasActivas) ?>, // Assuming Inactivas = Total - Activas
                    // You can add more data here if you have other statuses like 'Borrador'
                ], 
                backgroundColor: [
                    'rgba(26, 188, 156, 1)',  // Turquesa intenso (más verde)
                    'rgba(231, 76, 60, 1)',   // Rojo fuerte
                    // 'rgba(241, 196, 15, 1)'  // Amarillo brillante para borrador si lo añades
                ],
                borderColor: [
                    'rgba(26, 188, 156, 1)',
                    'rgba(231, 76, 60, 1)',
                    // 'rgba(241, 196, 15, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, // Allows chart to fill its container
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        color: '#ccc' // Adjust legend text color for dark theme
                    }
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                }
            }
        }
    });

    // --- Chart 2: Users by Role (Bar Chart) ---
    const usersByRoleCtx = document.getElementById('usersByRoleChart').getContext('2d');
    const usersByRoleChart = new Chart(usersByRoleCtx, {
        type: 'bar', // Using bar chart for user roles
        data: {
            labels: [<?= implode(', ', $labelsRoles); ?>], // Labels from controller (e.g., 'Administrador', 'Operador')
            datasets: [{
                label: 'Número de Usuarios',
                data: [<?= implode(', ', $dataRoles); ?>], // Data from controller (e.g., 5, 20, 15)
                backgroundColor: [
                    'rgba(52, 152, 219, 1)',  // Azul intenso
                    'rgba(243, 156, 18, 1)',  // Naranja quemado intenso
                    'rgba(142, 68, 173, 1)',  // Púrpura oscuro
                    'rgba(46, 204, 113, 1)',  // Verde esmeralda
                    'rgba(241, 196, 15, 1)',  // Amarillo brillante
                    'rgba(230, 126, 34, 1)',  // Naranja calabaza
                    'rgba(192, 57, 43, 1)'    // Rojo ladrillo
                ],
                borderColor: [
                    'rgba(52, 152, 219, 1)',
                    'rgba(243, 156, 18, 1)',
                    'rgba(142, 68, 173, 1)',
                    'rgba(46, 204, 113, 1)',
                    'rgba(241, 196, 15, 1)',
                    'rgba(230, 126, 34, 1)',
                    'rgba(192, 57, 43, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: '#ccc', // Adjust Y-axis label color for dark theme
                        precision: 0 // Ensure integer ticks for counts
                    },
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)' // Adjust grid line color
                    }
                },
                x: {
                    ticks: {
                        color: '#ccc' // Adjust X-axis label color for dark theme
                    },
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)'
                    }
                }
            },
            plugins: {
                legend: {
                    display: false // Hide legend if it's just one dataset
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                }
            }
        }
    });
  });
</script>
</body>
</html>