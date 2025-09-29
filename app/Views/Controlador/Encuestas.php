<!DOCTYPE html>
<html class="loading" lang="es" data-textdirection="ltr">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Encuestas - Vota y Opina</title>
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
    <style>
        .pregunta-card .card-header {
            background-color: #f5f7fa;
            border-bottom: 1px solid #e1e8ed;
        }
        .pregunta-card .card-header button {
            color: #34495e;
            font-weight: bold;
        }
        .opcion-item {
            background-color: #ffffff;
            border: 1px solid #e1e8ed;
            margin-bottom: 5px;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.2s ease-in-out;
            cursor: pointer;
        }
        .opcion-item:hover {
            background-color: #f0f2f5;
        }
        .acordeon-opciones .list-group-item {
            border: none;
            border-bottom: 1px solid #e1e8ed;
        }
        .acordeon-opciones .list-group-item:last-child {
            border-bottom: none;
        }
        .acordeon-opciones {
            border: 1px solid #e1e8ed;
            border-radius: 5px;
        }
        .pregunta-card {
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #e1e8ed;
        }
        .pregunta-card .card-body {
            background-color: #fdfdfd;
        }
        /* Nuevos estilos para los círculos de las opciones */
        .opcion-item {
            display: flex;
            align-items: center;
        }
        .opcion-simbolo {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-right: 15px;
        }
        .opcion-simbolo.rojo { background-color: #FF6384; }
        .opcion-simbolo.azul { background-color: #36A2EB; }
        .opcion-simbolo.verde { background-color: #4BC0C0; }
        .opcion-simbolo.amarillo { background-color: #FFCE56; }
        .opcion-simbolo.morado { background-color: #9966FF; }
        .opcion-simbolo.naranja { background-color: #FF9F40; }
    </style>
  </head>
  <body class="vertical-layout vertical-menu 2-columns menu-expanded fixed-navbar" data-open="click" data-menu="vertical-menu" data-color="bg-gradient-x-purple-blue" data-col="2-columns">

  <?php
// Preparar datos del usuario (debe pasarse desde el controlador preferiblemente)
$isLoggedIn = session()->get('isLoggedIn') ?? false;
$userData = session()->get('usuario') ?? null;

$nombreCompleto = "Invitado";
$rolTexto = "Rol Desconocido";
$rutaFotoPerfil = base_url('recursos_operador/images/layout_img/user_img.jpg');

if ($isLoggedIn && $userData) {
    $nombreCompleto = $userData['nombre'] . ' ' . $userData['apellido_paterno'] . ' ' . $userData['apellido_materno'];
    $id_rol = $userData['id_rol'] ?? null;
    switch ($id_rol) {
        case 1: $rolTexto = 'Administrador'; break;
        case 2: $rolTexto = 'Operador'; break;
        case 3: $rolTexto = 'Encuestador'; break;
        default: $rolTexto = 'Miembro'; break;
    }
    if (!empty($userData['foto'])) {
        $rutaFotoPerfil = base_url('public/img_user/' . $userData['foto']);
    }
}
?>
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
              <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown"> <span class="avatar avatar-online"><img src="<?= $rutaFotoPerfil ?>" alt="avatar"><i></i></span></a>
                <div class="dropdown-menu dropdown-menu-right">
                  <div class="arrow_box_right"><a class="dropdown-item" href="#"><span class="avatar avatar-online"><img src="<?= $rutaFotoPerfil ?>" alt="avatar"><span class="user-name text-bold-700 ml-1"><?= esc($nombreCompleto) ?></span></span></a>
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

    <!--////////////////////////////////////////////////////////////////////////////-->

    <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true" data-img="<?= base_url(RECURSOS_CONTROLADOR_IMAGES . 'backgrounds/02.jpg') ?>">
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
          <li class="nav-item"><a href="<?= base_url('controlador/graficas') ?>"><i class="la la-pie-chart"></i><span class="menu-title">Gráficas</span></a></li>
          <li class="nav-item"><a href="<?= base_url('controlador/usuarios') ?>"><i class="la la-users"></i><span class="menu-title">Usuarios</span></a></li>
          <li class="active"><a href="<?= base_url('controlador/encuestas') ?>"><i class="la la-list-alt"></i><span class="menu-title">Encuestas</span></a></li>
          <li class="nav-item"><a href="<?= base_url('controlador/respuestas') ?>"><i class="la la-check-square"></i><span class="menu-title">Respuestas</span></a></li>
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
            <h3 class="content-header-title">Gestión de Encuestas</h3>
          </div>
          <div class="content-header-right col-md-8 col-12">
            <div class="breadcrumbs-top float-md-right">
              <div class="breadcrumb-wrapper mr-1">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?= base_url('controlador/panel') ?>">Panel</a></li>
                  <li class="breadcrumb-item active">Encuestas</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <div class="content-body">
            <!-- Tabla de Encuestas -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Lista de Encuestas Disponibles</h4>
                            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                    <li><a data-action="reload" onclick="location.reload();"><i class="ft-rotate-cw"></i></a></li>
                                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body">
                                <p>Aquí se mostrarán todas las encuestas creadas. Podrás editarlas, eliminarlas o ver sus resultados.</p>
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col">ID</th>
                                                <th scope="col">Título de la Encuesta</th>
                                                <th scope="col">Descripción</th>
                                                <th scope="col">Fecha de Creación</th>
                                                <th scope="col">Estado</th>
                                                <th scope="col">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($listaEncuestas)) : ?>
                                                <?php foreach ($listaEncuestas as $encuesta) : ?>
                                                    <tr>
                                                        <th scope="row"><?= esc($encuesta['id_encuesta']) ?></th>
                                                        <td><?= esc($encuesta['titulo']) ?></td>
                                                        <td><?= esc($encuesta['descripcion_corta']) ?></td>
                                                        <td><?= esc($encuesta['fecha_creacion']) ?></td>
                                                        <td>
                                                            <?php if ($encuesta['activa'] == 1) : ?>
                                                                <span class="badge badge-success">Activa</span>
                                                            <?php else : ?>
                                                                <span class="badge badge-danger">Inactiva</span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <div class="btn-group" role="group">
                                                                <button class="btn btn-info btn-sm" onclick="mostrarDetalleEncuesta(<?= esc($encuesta['id_encuesta']) ?>)">
                                                                    <i class="la la-eye"></i> Detalles
                                                                </button>
                                                                <!-- Puedes añadir más botones para editar, eliminar, etc. -->
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <tr>
                                                    <td colspan="6" class="text-center">No se encontraron encuestas en el sistema.</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Fin de la tabla -->
        </div>
      </div>
    </div>
    <!-- ////////////////////////////////////////////////////////////////////////////-->

    <!-- Modal para el detalle de la encuesta -->
    <div class="modal fade text-left" id="modalDetalleEncuesta" tabindex="-1" role="dialog" aria-labelledby="detalleEncuestaLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary white">
                    <h4 class="modal-title white" id="detalleEncuestaLabel">Detalles de la Encuesta: <span id="detalleTitulo"></span></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="white">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>Descripción:</strong> <span id="detalleDescripcion"></span></p>
                    <p><strong>Fecha de Creación:</strong> <span id="detalleFechaCreacion"></span></p>
                    <p><strong>Estado:</strong> <span id="detalleEstado"></span></p>
                    
                    <hr>
                    
                    <!-- Acordeón de Preguntas y Opciones -->
                    <div class="accordion" id="acordeonPreguntas">
                        <!-- Las preguntas se cargarán aquí -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>


    <footer class="footer footer-static footer-light navbar-border navbar-shadow">
      <div class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2"><span class="float-md-left d-block d-md-inline-block"><?= date('Y') ?> &copy; Copyright <a class="text-bold-800 grey darken-2" href="#">Vota y Opina</a></span>
      </div>
    </footer>

    <!-- BEGIN VENDOR JS-->
    <script src="<?= base_url(RECURSOS_CONTROLADOR_VENDORS . 'js/vendors.min.js') ?>" type="text/javascript"></script>
    <!-- BEGIN VENDOR JS-->
    
    <!-- BEGIN CHAMELEON JS-->
    <script src="<?= base_url(RECURSOS_CONTROLADOR_JS . 'core/app-menu-lite.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url(RECURSOS_CONTROLADOR_JS . 'core/app-lite.js') ?>" type="text/javascript"></script>
    <!-- END CHAMELEON JS-->
    
    <!-- Lógica de JavaScript para el Modal -->
    <script type="text/javascript">
        // La ruta base para las llamadas AJAX
        const detalleEncuestaUrl = "<?= site_url('controlador/detalleEncuesta') ?>";

        function mostrarDetalleEncuesta(idEncuesta) {
            fetch(`${detalleEncuestaUrl}?id=${idEncuesta}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error en la respuesta del servidor');
                    }
                    return response.json();
                })
                .then(data => {
                    const encuesta = data.encuesta;
                    const preguntas = data.preguntas;
                    
                    // Rellenar los detalles de la encuesta
                    document.getElementById('detalleTitulo').textContent = encuesta.titulo;
                    document.getElementById('detalleDescripcion').textContent = encuesta.descripcion;
                    document.getElementById('detalleFechaCreacion').textContent = encuesta.fecha_creacion;
                    const estadoSpan = document.getElementById('detalleEstado');
                    estadoSpan.textContent = encuesta.activa == 1 ? 'Activa' : 'Inactiva';
                    estadoSpan.className = `badge badge-${encuesta.activa == 1 ? 'success' : 'danger'}`;
                    
                    // Rellenar el acordeón de preguntas
                    const acordeonPreguntas = document.getElementById('acordeonPreguntas');
                    acordeonPreguntas.innerHTML = '';
                    
                    const colores = ['rojo', 'azul', 'verde', 'amarillo', 'morado', 'naranja'];
                    let colorIndex = 0;

                    if (preguntas.length > 0) {
                        preguntas.forEach((pregunta, index) => {
                            const collapseId = `collapsePregunta${pregunta.id_pregunta}`;
                            const headingId = `headingPregunta${pregunta.id_pregunta}`;

                            let opcionesHtml = '';
                            if (pregunta.opciones.length > 0) {
                                opcionesHtml += '<div class="list-group acordeon-opciones">';
                                pregunta.opciones.forEach(opcion => {
                                    const colorClase = colores[colorIndex % colores.length];
                                    opcionesHtml += `<div class="list-group-item opcion-item"><span class="opcion-simbolo ${colorClase}"></span> ${opcion.texto_opcion}</div>`;
                                    colorIndex++;
                                });
                                opcionesHtml += '</div>';
                            } else {
                                opcionesHtml = '<p class="text-muted">Esta pregunta no tiene opciones asociadas.</p>';
                            }

                            const preguntaHtml = `
                                <div class="card mb-2 pregunta-card">
                                    <div class="card-header p-0" id="${headingId}">
                                        <h5 class="mb-0">
                                            <button class="btn btn-block btn-light text-left py-3 px-4" type="button" data-toggle="collapse" data-target="#${collapseId}" aria-expanded="false" aria-controls="${collapseId}">
                                                ${pregunta.texto_pregunta}
                                            </button>
                                        </h5>
                                    </div>
                                    <div id="${collapseId}" class="collapse" aria-labelledby="${headingId}" data-parent="#acordeonPreguntas">
                                        <div class="card-body">
                                            ${opcionesHtml}
                                        </div>
                                    </div>
                                </div>
                            `;
                            acordeonPreguntas.innerHTML += preguntaHtml;
                        });
                    } else {
                        acordeonPreguntas.innerHTML = '<p class="text-muted text-center">Esta encuesta no contiene preguntas.</p>';
                    }
                    
                    // Mostrar el modal de detalles
                    $('#modalDetalleEncuesta').modal('show');
                })
                .catch(error => {
                    console.error('Error al obtener detalles de la encuesta:', error);
                    alert('No se pudo cargar la información de la encuesta. Verifique su conexión o intente más tarde.');
                });
        }
    </script>
  </body>
</html>
