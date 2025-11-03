<!DOCTYPE html>
<html class="loading" lang="es" data-textdirection="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Respuestas - Vota y Opina</title>
    <link rel="apple-touch-icon" href="<?= base_url(RECURSOS_CONTROLADOR_IMAGES . 'ico/apple-icon-120.png') ?>">
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url(RECURSOS_CONTROLADOR_IMAGES . 'ico/favicon.ico') ?>">
    <link href="https://fonts.googleapis.com/css?family=Muli:300,300i,400,400i,600,600i,700,700i%7CComfortaa:300,400,700" rel="stylesheet">
    <link href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css" rel="stylesheet">
    
    <link rel="stylesheet" type="text/css" href="<?= base_url(RECURSOS_CONTROLADOR_CSS . 'vendors.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url(RECURSOS_CONTROLADOR_CSS . 'app-lite.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url(RECURSOS_CONTROLADOR_CSS . 'core/menu/menu-types/vertical-menu.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url(RECURSOS_CONTROLADOR_CSS . 'core/colors/palette-gradient.css') ?>">
    <style>
        /* CORRECCIÓN: Asegura que el modal esté por encima del menú lateral (z-index 999) */
        .modal {
            z-index: 1051 !important; 
        }
        .modal-backdrop {
            z-index: 1050 !important;
        }

        #mapaUbicacion {
            height: 300px;
            width: 100%;
            border-radius: 8px;
            margin-top: 15px;
            border: 1px solid #ccc;
        }
        .text-bold-600 {
            font-weight: 600 !important;
        }
        .font-large-1 {
            font-size: 1.25rem !important;
        }
        .map-placeholder-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            background-color: #f8f9fa;
            text-align: center;
        }

        /* INICIO: ESTILOS DE PAGINACIÓN MEJORADOS */
        .pager ul.pagination {
            display: flex;
            padding-left: 0;
            list-style: none;
            border-radius: .25rem;
            margin-top: 1rem;
        }
        .pager ul.pagination li {
            margin: 0 2px;
        }
        .pager ul.pagination li a,
        .pager ul.pagination li span {
            position: relative;
            display: block;
            padding: .5rem .75rem;
            line-height: 1.25;
            color: #555;
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: .25rem;
            text-decoration: none;
            transition: all .2s;
        }
        .pager ul.pagination li a:hover {
            z-index: 2;
            color: #333;
            background-color: #e9ecef;
            border-color: #dee2e6;
        }
        .pager ul.pagination li.active a,
        .pager ul.pagination li.active span {
            z-index: 3;
            color: #fff;
            background-color: #007bff; /* Color primario de Bootstrap */
            border-color: #007bff;
        }
        .pager ul.pagination li.disabled a,
        .pager ul.pagination li.disabled span {
            color: #6c757d;
            pointer-events: none;
            background-color: #fff;
            border-color: #dee2e6;
        }

        .dropdown-menu-right .user-name {
            display: inline-block;
            max-width: 180px; /* ajusta según tu diseño */
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        
        /* Estilos específicos para la lista de preguntas/respuestas en el modal */
        #preguntasRespondidasContainer h6 {
            font-weight: 700;
            margin-top: 15px;
            color: #333;
        }
        #preguntasRespondidasContainer .respuesta-item {
            border-left: 3px solid #007bff;
            padding-left: 10px;
            margin-bottom: 15px;
        }
        #preguntasRespondidasContainer .respuesta-item p {
            margin-bottom: 0;
            font-size: 0.95rem;
        }
        /* FIN: ESTILOS DE PAGINACIÓN MEJORADOS */
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
              </li>
            </ul>
          </div>
        </div>
      </div>
    </nav>

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
          <li class="nav-item"><a href="<?= base_url('controlador/encuestas') ?>"><i class="la la-list-alt"></i><span class="menu-title">Encuestas</span></a></li>
          <li class="active"><a href="<?= base_url('controlador/respuestas') ?>"><i class="la la-check-square"></i><span class="menu-title">Respuestas</span></a></li>
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
            <h3 class="content-header-title">Auditoría de Respuestas</h3>
          </div>
          <div class="content-header-right col-md-8 col-12">
            <div class="breadcrumbs-top float-md-right">
              <div class="breadcrumb-wrapper mr-1">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?= base_url('controlador/panel') ?>">Panel</a></li>
                  <li class="breadcrumb-item active">Respuestas</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <div class="content-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Encuestas Completadas Recibidas</h4>
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
                                <p>Supervise las encuestas completadas, incluyendo la ubicación de captura para control de calidad. Mostrando **<?= count($listaRespuestas) ?> de <?= $totalRespuestas ?>** encuestas en total.</p>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>ID Instancia</th>
                                                <th>Encuesta</th>
                                                <th>Encuestador</th>
                                                <th>Fecha de Captura</th>
                                                <th>Ubicación GPS</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($listaRespuestas)) : ?>
                                                <?php foreach ($listaRespuestas as $respuesta) : ?>
                                                    <tr>
                                                        <th scope="row" title="ID de Instancia: <?= esc($respuesta['id_encuesta_realizada']) ?>">
                                                            <?= substr(esc($respuesta['id_encuesta_realizada']), 0, 8) ?>...
                                                        </th>
                                                        <td><?= esc($respuesta['nombre_encuesta']) ?></td>
                                                        <td><?= esc($respuesta['nombre_encuestador']) ?></td>
                                                        <td><?= esc($respuesta['fecha_respuesta']) ?></td>
                                                        <td>
                                                            <?php if (!empty($respuesta['direccion'])) : ?>
                                                                <span class="badge badge-success"><i class="la la-check-circle"></i> Registrada</span>
                                                            <?php else : ?>
                                                                <span class="badge badge-warning"><i class="la la-times-circle"></i> No Registrada</span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <button 
                                                                class="btn btn-primary btn-sm"
                                                                onclick="mostrarDetalleRespuesta('<?= esc($respuesta['id_encuesta_realizada']) ?>')">
                                                                <i class="la la-file-text"></i> Ver Detalle
                                                            </button>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <tr>
                                                    <td colspan="6" class="text-center">No se encontraron encuestas completadas.</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-3 pager">
                                    <?= $pager ?>
                                </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
      </div>
    </div>
    <div class="modal fade text-left" id="modalDetalleRespuesta" tabindex="-1" role="dialog" aria-labelledby="detalleRespuestaLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary white">
                    <h4 class="modal-title white" id="detalleRespuestaLabel">Detalle y Auditoría de Encuesta #<span id="detalleIdInstancia"></span></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="white">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-5 col-md-12 border-right">
                            <h5 class="mb-3 text-bold-600 border-bottom pb-1">Resumen y Trazabilidad</h5>
                            <p><strong>Encuesta:</strong> <span id="detalleTituloEncuesta"></span></p>
                            <p><strong>Encuestador:</strong> <span id="detalleAliasEncuestador"></span></p>
                            <p><strong>Fecha/Hora:</strong> <span id="detalleFechaRespuesta"></span></p>
                            <p><strong>Referencias Adicionales:</strong> <span id="detalleReferencias"></span></p>
                            <hr>
                            <h5 class="mb-3 text-bold-600 border-bottom pb-1">Auditoría de Ubicación</h5>
                            <p><strong>Dirección Registrada:</strong> <span id="detalleDireccion"></span></p>
                            <div id="mapaUbicacion">
                                <div class="map-placeholder-content">Cargando mapa...</div>
                            </div>
                            <p class="text-muted mt-2"><small>El mapa muestra la **última ubicación** registrada del encuestador (punto GPS) al momento de la captura.</small></p>
                        </div>

                        <div class="col-lg-7 col-md-12">
                            <h5 class="mb-3 text-bold-600 border-bottom pb-1">Preguntas y Respuestas Registradas</h5>
                            <div id="preguntasRespondidasContainer">
                                </div>
                            <p class="text-danger mt-3" id="errorPreguntas"></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    const detalleRespuestaUrl = "<?= site_url('controlador/detalleRespuesta') ?>";
    
    // Variables globales para almacenar temporalmente los datos del mapa
    let currentMapData = { direccion: null, latitud: null, longitud: null };
    
    // --- EVENTOS GLOBALES DEL MODAL (Definidos una sola vez) ---

    // Evento que se dispara CADA VEZ que el modal se abre completamente
    $('#modalDetalleRespuesta').on('shown.bs.modal', function () {
        console.log('Modal abierto, actualizando mapa...');
        
        // Retraso para asegurar que el modal es visible ANTES de dibujar el mapa
        setTimeout(function() {
            updateMapUI(
                currentMapData.direccion, 
                currentMapData.latitud, 
                currentMapData.longitud
            ); 
        }, 250); 
    });

    // Evento que se dispara CADA VEZ que el modal se cierra completamente
    $('#modalDetalleRespuesta').on('hidden.bs.modal', function () {
        console.log('Modal cerrado, destruyendo instancias de mapa...');
        
        // 1. Cerrar el info window si existe
        if (window.currentInfoWindow) {
            window.currentInfoWindow.close();
        }
        
        // 2. ***** LA CORRECCIÓN CLAVE ESTÁ AQUÍ *****
        // Destruimos las instancias globales de Google Maps.
        // Al ponerlas en 'null', forzamos a updateMapUI a recrearlas
        // desde cero en el bloque 'if (!mapInstance)' la próxima vez.
        mapInstance = null;
        mapMarker = null;
        window.currentInfoWindow = null;

        // 3. Resetear el HTML del div para el placeholder
        $('#mapaUbicacion').html('<div class="map-placeholder-content">Cargando mapa...</div>');
    });


    // --- FUNCIÓN PRINCIPAL PARA MOSTRAR DETALLES ---

    function mostrarDetalleRespuesta(idInstancia) {
        // Limpiar contenido anterior
        $('#preguntasRespondidasContainer').html('<p class="text-muted">Cargando preguntas...</p>');
        $('#errorPreguntas').text('');
        $('#detalleIdInstancia').text(idInstancia.substring(0, 8) + '...');
        
        // Resetear placeholder del mapa (esto se hace en 'hidden.bs.modal',
        // pero lo ponemos aquí también por seguridad)
        $('#mapaUbicacion').html('<div class="map-placeholder-content">Cargando mapa...</div>');
        
        // Resetear datos del mapa globalmente
        currentMapData = { direccion: null, latitud: null, longitud: null };

        // Iniciar la petición de datos
        fetch(`${detalleRespuestaUrl}?id_instancia=${idInstancia}`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    $('#errorPreguntas').text(`Error: ${data.error}`);
                    $('#preguntasRespondidasContainer').empty();
                    return;
                }

                const detalle = data.detalle;
                const preguntas = data.preguntas_respondidas;

                // Rellenar datos de resumen en el modal
                $('#detalleTituloEncuesta').text(detalle.titulo_encuesta);
                $('#detalleAliasEncuestador').text(`${detalle.nombre_usuario} ${detalle.apellido_paterno} (${detalle.alias_usuario})`);
                $('#detalleFechaRespuesta').text(detalle.fecha_respuesta);
                $('#detalleReferencias').text(detalle.referencias || 'Ninguna');
                $('#detalleDireccion').text(detalle.direccion || 'No registrada');
                $('#detalleIdInstancia').text(idInstancia.substring(0, 15) + '...'); 
                
                // Almacenar datos del mapa para que el evento 'shown.bs.modal' los utilice
                currentMapData.direccion = detalle.direccion;
                currentMapData.latitud = detalle.latitud;
                currentMapData.longitud = detalle.longitud;

                // Rellenar las Preguntas y Respuestas
                const container = $('#preguntasRespondidasContainer');
                container.empty();

                if (preguntas && preguntas.length > 0) {
                    preguntas.forEach((item, index) => {
                        const html = `
                            <div class="respuesta-item">
                                <h6>${index + 1}. ${item.texto_pregunta}</h6>
                                <p class="text-success text-bold-600">Respuesta: ${item.respuesta_seleccionada || 'Sin respuesta seleccionada'}</p>
                            </div>
                        `;
                        container.append(html);
                    });
                } else {
                    container.html('<p class="text-muted">No se encontraron preguntas respondidas para esta instancia.</p>');
                }

                // Ahora que todos los datos están listos, mostramos el modal.
                $('#modalDetalleRespuesta').modal('show');

            })
            .catch(error => {
                console.error('Error en fetch:', error);
                $('#errorPreguntas').text(`Error de red o conexión: ${error.message}`);
                $('#preguntasRespondidasContainer').empty();
            });
    }
    </script>

    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=<?= $google_maps_api_key ?>&callback=initMap">
    </script>
</body>
</html>