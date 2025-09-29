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
            /* Estilo para el contenido del placeholder si no hay mapa */
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            background-color: #f8f9fa;
        }
    </style>
    <!-- [INICIO CORRECCIÓN] Definición global de initMap -->
    <script>
        let mapInstance;
        let mapMarker;
        
        // Función global requerida por Google Maps API: Se define antes del script de carga
        window.initMap = function() {
            // Inicializamos una instancia base del mapa que será actualizada después
            const defaultCoords = { lat: 19.35, lng: -99.05 }; // Coordenadas de México Central como default
            const mapDiv = document.getElementById('mapaUbicacion');
            
            // Verificamos si el div ya está en el DOM antes de inicializar
            if (mapDiv) {
                mapInstance = new google.maps.Map(mapDiv, {
                    center: defaultCoords,
                    zoom: 10,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                });
                
                mapMarker = new google.maps.Marker({
                    map: mapInstance,
                    position: defaultCoords,
                    title: 'Ubicación'
                });
                mapMarker.setMap(null); // Ocultar marcador por defecto
            }
        };
        
        /**
         * Inicializa o actualiza el mapa de Google Maps con datos dinámicos.
         * Esta función se llama al hacer clic en "Ver Detalle".
         */
        function initMapData(direccion, lat, lng) {
            const mapDiv = document.getElementById('mapaUbicacion');
            
            if (!window.google || !window.google.maps || !mapInstance) {
                 mapDiv.innerHTML = `<div class="map-placeholder-content"><p class="text-danger">
                    <i class="la la-close font-large-2 mb-2"></i><br>
                    Error: La API de Google Maps no se cargó o la clave no es válida.
                </p></div>`;
                return;
            }

            if (!lat || !lng) {
                 mapDiv.innerHTML = `<div class="map-placeholder-content"><p class="text-danger">
                    <i class="la la-close font-large-2 mb-2"></i><br>
                    Ubicación GPS de monitoreo no registrada para el encuestador.
                </p></div>`;
                mapMarker.setMap(null);
                return;
            }
            
            // Coordenadas válidas: Inicializar o actualizar
            const latFloat = parseFloat(lat);
            const lngFloat = parseFloat(lng);
            const coords = { lat: latFloat, lng: lngFloat };
            
            // Limpiamos el placeholder y aseguramos que el div esté listo para el mapa
            mapDiv.innerHTML = ''; 
            
            // Actualizar la posición y centrar el mapa
            mapInstance.setCenter(coords);
            mapInstance.setZoom(14); // Zoom detallado
            mapMarker.setPosition(coords);
            mapMarker.setTitle(direccion);
            mapMarker.setMap(mapInstance); // Mostrar el marcador
            
            // Forzamos el evento de redimensionar al abrir el modal (solución a mapa gris)
            google.maps.event.trigger(mapInstance, 'resize');

            // Mostrar info del marcador
            const infowindow = new google.maps.InfoWindow({
                content: `<b>Última Ubicación GPS:</b><br>Lat: ${lat}, Lng: ${lng}`
            });
            infowindow.open(mapInstance, mapMarker);
        }
    </script>
    <!-- [FIN CORRECCIÓN] -->
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
          <li class="nav-item"><a href="<?= base_url('controlador/graficas') ?>"><i class="la la-pie-chart"></i><span class="menu-title">Gráficas</span></a></li>
          <li class="nav-item"><a href="<?= base_url('controlador/usuarios') ?>"><i class="la la-users"></i><span class="menu-title">Usuarios</span></a></li>
          <li class="nav-item"><a href="<?= base_url('controlador/encuestas') ?>"><i class="la la-list-alt"></i><span class="menu-title">Encuestas</span></a></li>
          <li class="active"><a href="<?= base_url('controlador/respuestas') ?>"><i class="la la-check-square"></i><span class="menu-title">Respuestas</span></a></li>
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
            <!-- Tabla de Respuestas -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Respuestas Geocodificadas Recibidas</h4>
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
                                <p>Supervise las respuestas, incluyendo la ubicación de captura para control de calidad.</p>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>ID Resp.</th>
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
                                                        <th scope="row"><?= esc($respuesta['id_respuesta']) ?></th>
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
                                                                onclick="mostrarDetalleRespuesta(<?= esc($respuesta['id_respuesta']) ?>)">
                                                                <i class="la la-map"></i> Ver Detalle
                                                            </button>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <tr>
                                                    <td colspan="6" class="text-center">No se encontraron respuestas registradas.</td>
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

    <!-- Modal para el detalle de la respuesta -->
    <div class="modal fade text-left" id="modalDetalleRespuesta" tabindex="-1" role="dialog" aria-labelledby="detalleRespuestaLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary white">
                    <h4 class="modal-title white" id="detalleRespuestaLabel">Detalle y Auditoría de Respuesta #<span id="detalleIdRespuesta"></span></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="white">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Columna de Datos de la Respuesta -->
                        <div class="col-lg-6 col-md-12">
                            <h5 class="mb-3 text-bold-600 border-bottom pb-1">Datos de Trazabilidad</h5>
                            <p><strong>Encuesta:</strong> <span id="detalleTituloEncuesta"></span></p>
                            <p><strong>Encuestador:</strong> <span id="detalleNombreEncuestador"></span> (<span id="detalleAliasEncuestador"></span>)</p>
                            <p><strong>Fecha/Hora:</strong> <span id="detalleFechaRespuesta"></span></p>
                            <hr>
                            <h5 class="mb-3 text-bold-600 border-bottom pb-1">Contenido de la Respuesta</h5>
                            <p class="text-bold-600">Pregunta:</p>
                            <p class="text-primary font-large-1" id="detallePregunta"></p>
                            <p class="text-bold-600">Opción Seleccionada:</p>
                            <p class="font-large-1 text-color: red" id="detalleOpcion"></p>
                            <hr>
                            <p><strong>Referencias Adicionales:</strong> <span id="detalleReferencias"></span></p>
                        </div>

                        <!-- Columna de Geolocalización -->
                        <div class="col-lg-6 col-md-12">
                            <h5 class="mb-3 text-bold-600 border-bottom pb-1">Auditoría de Ubicación</h5>
                            <p><strong>Dirección Registrada (Respuesta):</strong> <span id="detalleDireccion"></span></p>
                            <div id="mapaUbicacion">
                                <div class="map-placeholder-content">Cargando mapa...</div>
                            </div>
                           
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- CARGA DE GOOGLE MAPS API -->
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=<?= $google_maps_api_key ?>&callback=initMap">
    </script>
    
    <script>
        let mapInstance;
        let mapMarker;
        
        // Función global requerida por Google Maps API
        window.initMap = function() {
            // Inicializamos una instancia base del mapa que será actualizada después
            const defaultCoords = { lat: 19.35, lng: -99.05 }; // Coordenadas de México Central como default
            const mapDiv = document.getElementById('mapaUbicacion');
            
            // Verificamos si el div ya está en el DOM antes de inicializar
            if (mapDiv) {
                mapInstance = new google.maps.Map(mapDiv, {
                    center: defaultCoords,
                    zoom: 10,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                });
                
                mapMarker = new google.maps.Marker({
                    map: mapInstance,
                    position: defaultCoords,
                    title: 'Ubicación'
                });
                mapMarker.setMap(null); // Ocultar marcador por defecto
            }
        };
        
       
        function initMapData(direccion, lat, lng) {
            const mapDiv = document.getElementById('mapaUbicacion');
            
            // 1. Verificar si la API y la instancia están disponibles
            if (!window.google || !window.google.maps || !mapInstance) {
                 mapDiv.innerHTML = `<div class="map-placeholder-content"><p class="text-danger">
                    <i class="la la-close font-large-2 mb-2"></i><br>
                    Error: La API de Google Maps no se cargó correctamente.
                </p></div>`;
                return;
            }

            // 2. Verificar coordenadas válidas
            if (!lat || !lng) {
                 mapDiv.innerHTML = `<div class="map-placeholder-content"><p class="text-danger">
                    <i class="la la-close font-large-2 mb-2"></i><br>
                    Ubicación GPS de monitoreo no registrada para el encuestador.
                </p></div>`;
                mapMarker.setMap(null); // Oculta el marcador si no hay datos
                return;
            }
            
            // 3. Coordenadas válidas: Inicializar o actualizar
            const latFloat = parseFloat(lat);
            const lngFloat = parseFloat(lng);
            const coords = { lat: latFloat, lng: lngFloat };
            
            // Revertir el div para el mapa si estaba en modo placeholder
            mapDiv.innerHTML = '';
            
            // Actualizar la posición y centrar el mapa
            mapInstance.setCenter(coords);
            mapInstance.setZoom(14); // Zoom detallado
            mapMarker.setPosition(coords);
            mapMarker.setTitle(direccion);
            mapMarker.setMap(mapInstance); // Mostrar el marcador

            // Forzamos el evento de redimensionar
            google.maps.event.trigger(mapInstance, 'resize');

            // Mostrar info del marcador
            const infowindow = new google.maps.InfoWindow({
                content: `<b>Última Ubicación GPS:</b><br>Lat: ${lat}, Lng: ${lng}`
            });
            infowindow.open(mapInstance, mapMarker);
        }
    </script>
    
    <footer class="footer footer-static footer-light navbar-border navbar-shadow">
      <div class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2"><span class="float-md-left d-block d-md-inline-block"><?= date('Y') ?> &copy; Copyright <a class="text-bold-800 grey darken-2" href="#">Vota y Opina</a></span>
      </div>
    </footer>

    <!-- BEGIN VENDOR JS-->
    <script src="<?= base_url(RECURSOS_CONTROLADOR_VENDORS . 'js/vendors.min.js') ?>" type="text/javascript"></script>
    <!-- END VENDOR JS-->
    
    <!-- BEGIN CHAMELEON JS-->
    <script src="<?= base_url(RECURSOS_CONTROLADOR_JS . 'core/app-menu-lite.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url(RECURSOS_CONTROLADOR_JS . 'core/app-lite.js') ?>" type="text/javascript"></script>
    <!-- END CHAMELEON JS-->
    
    <!-- Lógica de JavaScript para el Modal de Respuestas -->
    <script type="text/javascript">
        const detalleRespuestaUrl = "<?= site_url('controlador/detalleRespuesta') ?>";

        function mostrarDetalleRespuesta(idRespuesta) {
            fetch(`${detalleRespuestaUrl}?id=${idRespuesta}`)
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => { throw new Error(`Server Error: ${err.error || response.statusText}`); });
                    }
                    return response.json();
                })
                .then(data => {
                    const detalle = data.detalle;
                    const ubicacion = data.ubicacion_mapa;
                    
                    // Rellenar la sección de Trazabilidad
                    document.getElementById('detalleIdRespuesta').textContent = detalle.id_respuesta;
                    document.getElementById('detalleTituloEncuesta').textContent = detalle.titulo_encuesta;
                    document.getElementById('detalleNombreEncuestador').textContent = `${detalle.nombre_usuario} ${detalle.apellido_paterno}`;
                    document.getElementById('detalleAliasEncuestador').textContent = detalle.alias_usuario;
                    document.getElementById('detalleFechaRespuesta').textContent = detalle.fecha_respuesta;
                    document.getElementById('detalleReferencias').textContent = detalle.referencias || 'Ninguna';
                    
                    // Rellenar la sección de Contenido
                    document.getElementById('detallePregunta').textContent = detalle.texto_pregunta;
                    document.getElementById('detalleOpcion').textContent = detalle.texto_opcion || 'No aplica (Respuesta abierta, etc.)';

                    // Rellenar la sección de Ubicación
                    document.getElementById('detalleDireccion').textContent = ubicacion.direccion || 'No registrada';
                    
                    // Aseguramos que el div del mapa tenga contenido de placeholder mientras se espera el modal
                    document.getElementById('mapaUbicacion').innerHTML = `<div class="map-placeholder-content">Cargando mapa...</div>`;

                    // Mostrar el modal
                    $('#modalDetalleRespuesta').modal('show');
                    
                    // Listener para inicializar el mapa DESPUÉS de que el modal se muestre completamente
                    $('#modalDetalleRespuesta').one('shown.bs.modal', function () {
                         initMapData(ubicacion.direccion, ubicacion.latitud, ubicacion.longitud); 
                    });

                })
                .catch(error => {
                    console.error('Error al obtener detalles de la respuesta:', error);
                    alert(`Error al cargar la auditoría de respuesta. Detalle: ${error.message || 'Verifique la ruta del servidor y el ID.'}`);
                });
        }
    </script>
  </body>
</html>
