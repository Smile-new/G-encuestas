<!DOCTYPE html>
<html class="loading" lang="es" data-textdirection="ltr">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Gráficas - Vota y Opina</title>
    <link rel="apple-touch-icon" href="<?= base_url(RECURSOS_CONTROLADOR_IMAGES . 'ico/apple-icon-120.png') ?>">
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url(RECURSOS_CONTROLADOR_IMAGES . 'ico/favicon.ico') ?>">
    <link href="https://fonts.googleapis.com/css?family=Muli:300,300i,400,400i,600,600i,700,700i%7CComfortaa:300,400,700" rel="stylesheet">
    <link href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css" rel="stylesheet">
    
    <!-- BEGIN VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="<?= base_url(RECURSOS_CONTROLADOR_CSS . 'vendors.css') ?>">
    <!-- END VENDOR CSS-->

    <!-- BEGIN CHAMELEON CSS-->
    <link rel="stylesheet" type="text/css" href="<?= base_url(RECURSOS_CONTROLADOR_CSS . 'app-lite.css') ?>">
    <!-- END CHAMELEON CSS-->

    <!-- BEGIN Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="<?= base_url(RECURSOS_CONTROLADOR_CSS . 'core/menu/menu-types/vertical-menu.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url(RECURSOS_CONTROLADOR_CSS . 'core/colors/palette-gradient.css') ?>">
    <!-- END Page Level CSS-->
  </head>
  <body class="vertical-layout vertical-menu 2-columns menu-expanded fixed-navbar" data-open="click" data-menu="vertical-menu" data-color="bg-gradient-x-purple-blue" data-col="2-columns">

    <!-- fixed-top-->
    <nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-semi-light">
      <div class="navbar-wrapper">
        <div class="navbar-container content">
          <div class="collapse navbar-collapse show" id="navbar-mobile">
            <ul class="nav navbar-nav mr-auto float-left">
              <li class="nav-item d-block d-md-none"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu"></i></a></li>
              <li class="nav-item d-none d-md-block"><a class="nav-link nav-link-expand" href="#"><i class="ficon ft-maximize"></i></a></li>
            </ul>
            <ul class="nav navbar-nav float-right">
              <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown"> <span class="avatar avatar-online"><img src="<?= base_url(RECURSOS_CONTROLADOR_IMAGES . 'portrait/small/avatar-s-19.png') ?>" alt="avatar"><i></i></span></a>
                <div class="dropdown-menu dropdown-menu-right">
                  <div class="arrow_box_right"><a class="dropdown-item" href="#"><span class="avatar avatar-online"><img src="<?= base_url(RECURSOS_CONTROLADOR_IMAGES . 'portrait/small/avatar-s-19.png') ?>" alt="avatar"><span class="user-name text-bold-700 ml-1">John Doe</span></span></a>
                    <div class="dropdown-divider"></div><a class="dropdown-item" href="#"><i class="ft-user"></i> Editar Perfil</a>
                    <div class="dropdown-divider"></div><a class="dropdown-item" href="#"><i class="ft-power"></i> Cerrar Sesión</a>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </nav>

    <!--////////////////////////////////////////////////////////////////////////////-->

    <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true" data-img="<?= base_url(RECURSOS_CONTROLADOR_IMAGES . 'backgrounds/02.jpg') ?>">
      <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
          <li class="nav-item mr-auto"><a class="navbar-brand" href="<?= base_url('controlador/panel') ?>"><img class="brand-logo" alt="Chameleon admin logo" src="<?= base_url(RECURSOS_CONTROLADOR_IMAGES . 'logo/logo.png') ?>"/>
              <h3 class="brand-text">Vota y Opina</h3></a></li>
          <li class="nav-item d-md-none"><a class="nav-link close-navbar"><i class="ft-x"></i></a></li>
        </ul>
      </div>
      <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
          <li class="nav-item"><a href="<?= base_url('controlador/panel') ?>"><i class="la la-home"></i><span class="menu-title">Panel</span></a></li>
          <li class="active"><a href="<?= base_url('controlador/graficas') ?>"><i class="la la-pie-chart"></i><span class="menu-title">Gráficas</span></a></li>
          <li class="nav-item"><a href="<?= base_url('controlador/usuarios') ?>"><i class="la la-users"></i><span class="menu-title">Usuarios</span></a></li>
          <li class="nav-item"><a href="<?= base_url('controlador/encuestas') ?>"><i class="la la-list-alt"></i><span class="menu-title">Encuestas</span></a></li>
          <li class="nav-item"><a href="<?= base_url('controlador/respuestas') ?>"><i class="la la-check-square"></i><span class="menu-title">Respuestas</span></a></li>
        </ul>
      </div>
      <div class="navigation-background"></div>
    </div>

    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-wrapper-before"></div>
        <div class="content-header row">
          <div class="content-header-left col-md-4 col-12 mb-2">
            <h3 class="content-header-title">Gráficas y Estadísticas</h3>
          </div>
          <div class="content-header-right col-md-8 col-12">
            <div class="breadcrumbs-top float-md-right">
              <div class="breadcrumb-wrapper mr-1">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?= base_url('controlador/panel') ?>">Panel</a></li>
                  <li class="breadcrumb-item active">Gráficas</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <div class="content-body">
            <!-- Bar charts section start -->
            <section id="chartjs-bar-charts">
                <!-- Column Chart -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Resultados por Pregunta (Columnas)</h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <div class="height-400">
                                        <canvas id="column-chart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Bar Chart -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Resultados por Pregunta (Barras)</h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <div class="height-400">
                                        <canvas id="bar-chart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- // Bar charts section end -->

            <!-- Pie charts section start -->
            <section id="chartjs-pie-charts">
                <div class="row">
                    <!-- Simple Pie Chart -->
                    <div class="col-md-6 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Distribución de Respuestas (Pastel)</h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <div class="height-400">
                                        <canvas id="simple-pie-chart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Simple Doughnut Chart -->
                    <div class="col-md-6 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Distribución de Respuestas (Dona)</h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <div class="height-400">
                                        <canvas id="simple-doughnut-chart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>    
            </section>
            <!-- // Pie charts section end -->
        </div>
      </div>
    </div>
    <!-- ////////////////////////////////////////////////////////////////////////////-->


    <footer class="footer footer-static footer-light navbar-border navbar-shadow">
      <div class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2"><span class="float-md-left d-block d-md-inline-block"><?= date('Y') ?> &copy; Copyright <a class="text-bold-800 grey darken-2" href="#">Vota y Opina</a></span>
      </div>
    </footer>

    <!-- BEGIN VENDOR JS-->
    <script src="<?= base_url(RECURSOS_CONTROLADOR_VENDORS . 'js/vendors.min.js') ?>" type="text/javascript"></script>
    <!-- BEGIN VENDOR JS-->
    
    <!-- BEGIN PAGE VENDOR JS-->
    <script src="<?= base_url(RECURSOS_CONTROLADOR_VENDORS . 'js/charts/chart.min.js') ?>" type="text/javascript"></script>
    <!-- END PAGE VENDOR JS-->
    
    <!-- BEGIN CHAMELEON JS-->
    <script src="<?= base_url(RECURSOS_CONTROLADOR_JS . 'core/app-menu-lite.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url(RECURSOS_CONTROLADOR_JS . 'core/app-lite.js') ?>" type="text/javascript"></script>
    <!-- END CHAMELEON JS-->
    
    <!-- BEGIN PAGE LEVEL JS-->
    <script src="<?= base_url(RECURSOS_CONTROLADOR_JS . 'scripts/charts/chartjs/bar/column.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url(RECURSOS_CONTROLADOR_JS . 'scripts/charts/chartjs/bar/bar.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url(RECURSOS_CONTROLADOR_JS . 'scripts/charts/chartjs/pie-doughnut/pie-simple.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url(RECURSOS_CONTROLADOR_JS . 'scripts/charts/chartjs/pie-doughnut/doughnut-simple.js') ?>" type="text/javascript"></script>
    <!-- END PAGE LEVEL JS-->
  </body>
</html>
