<!DOCTYPE html>
<html class="loading" lang="es" data-textdirection="ltr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Respuestas - Vota y Opina</title>

    <!-- Iconos -->
    <link rel="apple-touch-icon" href="<?= base_url(RECURSOS_CONTROLADOR_IMAGES . 'ico/apple-icon-120.png') ?>">
    <link rel="shortcut icon" type="image/x-icon"
        href="<?= base_url(RECURSOS_CONTROLADOR_IMAGES . 'ico/favicon.ico') ?>">

    <!-- Fuentes -->
    <link href="https://fonts.googleapis.com/css?family=Muli:300,300i,400,400i,600,600i,700,700i|Comfortaa:300,400,700"
        rel="stylesheet">
    <link href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="<?= base_url(RECURSOS_CONTROLADOR_CSS . 'vendors.css') ?>">
    <link rel="stylesheet" href="<?= base_url(RECURSOS_CONTROLADOR_CSS . 'app-lite.css') ?>">
    <link rel="stylesheet" href="<?= base_url(RECURSOS_CONTROLADOR_CSS . 'core/menu/menu-types/vertical-menu.css') ?>">
    <link rel="stylesheet" href="<?= base_url(RECURSOS_CONTROLADOR_CSS . 'core/colors/palette-gradient.css') ?>">

    <style>
        /* Modales */
        .modal {
            z-index: 1051 !important;
        }

        .modal-backdrop {
            z-index: 1050 !important;
        }

        /* Mapa */
        #mapaUbicacion {
            height: 300px;
            width: 100%;
            border-radius: 8px;
            margin-top: 15px;
            border: 1px solid #ccc;
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

        /* Texto */
        .text-bold-600 {
            font-weight: 600 !important;
        }

        .font-large-1 {
            font-size: 1.25rem !important;
        }

        /* Paginación */
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
            background-color: #007bff;
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
            max-width: 180px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Lista de preguntas/respuestas */
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
    </style>
</head>

<body class="vertical-layout vertical-menu 2-columns menu-expanded fixed-navbar" data-open="click"
    data-menu="vertical-menu" data-color="bg-gradient-x-purple-blue" data-col="2-columns">

    <?php
    // Preparar datos del usuario
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

    <!-- NAVBAR -->
    <nav
        class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-semi-light">
        <div class="navbar-wrapper">
            <div class="navbar-container content">
                <div class="collapse navbar-collapse show" id="navbar-mobile">
                    <ul class="nav navbar-nav mr-auto float-left">
                        <li class="nav-item d-block d-md-none">
                            <a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu"></i></a>
                        </li>
                        <li class="nav-item d-none d-md-block">
                            <a class="nav-link nav-link-expand" href="#"><i class="ficon ft-maximize"></i></a>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav float-right">
                        <li class="dropdown dropdown-user nav-item">
                            <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                                <span class="avatar avatar-online">
                                    <img src="<?= $rutaFotoPerfil ?>" alt="avatar"><i></i>
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <div class="arrow_box_right">
                                    <a class="dropdown-item" href="#">
                                        <span class="avatar avatar-online">
                                            <img src="<?= $rutaFotoPerfil ?>" alt="avatar">
                                        </span>
                                        <span class="user-name text-bold-700 ml-1"><?= esc($nombreCompleto) ?></span>
                                    </a>
                                </div>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="/controlador/perfil"><i class="ft-user"></i> Editar
                                    Perfil</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="/logout"><i class="ft-power"></i> Cerrar Sesión</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- MENU LATERAL -->
    <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true"
        data-img="<?= base_url(RECURSOS_CONTROLADOR_IMAGES . 'backgrounds/02.jpg') ?>">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mr-auto">
                    <a class="navbar-brand" href="<?= base_url('controlador/panel') ?>">
                        <h3 class="brand-text">Vota y Opina</h3>
                    </a>
                </li>
                <li class="nav-item d-md-none">
                    <a class="nav-link close-navbar"><i class="ft-x"></i></a>
                </li>
            </ul>
        </div>
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                <li class="nav-item"><a href="<?= base_url('controlador/panel') ?>"><i class="la la-home"></i><span
                            class="menu-title">Panel</span></a></li>
                <li class="nav-item"><a href="<?= base_url('controlador/graficas') ?>"><i
                            class="la la-pie-chart"></i><span class="menu-title">Gráficas</span></a></li>
                <li class="nav-item"><a href="<?= base_url('controlador/usuarios') ?>"><i class="la la-users"></i><span
                            class="menu-title">Usuarios</span></a></li>
                <li class="nav-item"><a href="<?= base_url('controlador/encuestas') ?>"><i
                            class="la la-list-alt"></i><span class="menu-title">Encuestas</span></a></li>
                <li class="active"><a href="<?= base_url('controlador/respuestas') ?>"><i
                            class="la la-check-square"></i><span class="menu-title">Respuestas</span></a></li>
                <li class="nav-item"><a href="<?= base_url('controlador/perfil') ?>"><i class="la la-user"></i><span
                            class="menu-title">Perfil</span></a></li>
            </ul>
        </div>
        <div class="navigation-background"></div>
    </div>

    <!-- CONTENIDO PRINCIPAL -->
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
                                <li class="breadcrumb-item"><a href="<?= base_url('controlador/panel') ?>">Panel</a>
                                </li>
                                <li class="breadcrumb-item active">Respuestas</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TABLA DE RESPUESTAS -->
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
                                        <li><a data-action="reload" onclick="location.reload();"><i
                                                    class="ft-rotate-cw"></i></a></li>
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="card-content collapse show">
                                <div class="card-body">

                                    <form method="GET" action="<?= base_url('controlador/respuestas') ?>" class="mb-4">
                                        <div class="row items-align-end">
                                            <div class="col-md-4">
                                                <label for="f_encuesta" class="text-bold-600">Filtrar por
                                                    Encuesta:</label>
                                                <select name="f_encuesta" id="f_encuesta" class="form-control">
                                                    <option value="">-- Todas las Encuestas --</option>
                                                    <?php foreach ($listaEncuestas as $e): ?>
                                                        <option value="<?= $e['id_encuesta'] ?>"
                                                            <?= ($f_encuesta == $e['id_encuesta']) ? 'selected' : '' ?>>
                                                            <?= esc($e['titulo']) ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                            <div class="col-md-4">
                                                <label for="f_usuario" class="text-bold-600">Buscador de
                                                    Encuestador:</label>
                                                <input type="text" name="f_usuario" id="f_usuario" class="form-control"
                                                    placeholder="Nombre completo o usuario..."
                                                    value="<?= esc($f_usuario) ?>">
                                            </div>

                                            <div class="col-md-4" style="padding-top: 25px;">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="la la-search"></i> Filtrar
                                                </button>
                                                <a href="<?= base_url('controlador/respuestas') ?>"
                                                    class="btn btn-secondary">
                                                    <i class="la la-eraser"></i> Limpiar
                                                </a>
                                            </div>
                                        </div>
                                    </form>
                                    <p>
                                        Supervise las encuestas completadas, incluyendo la ubicación de captura para
                                        control de calidad.
                                        Mostrando <strong><?= count($listaRespuestas) ?> de
                                            <?= $totalRespuestas ?></strong> encuestas en total.
                                    </p>

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
                                                <?php if (!empty($listaRespuestas)): ?>
                                                    <?php foreach ($listaRespuestas as $respuesta): ?>
                                                        <tr>
                                                            <th scope="row"
                                                                title="ID de Instancia: <?= esc($respuesta['id_encuesta_realizada']) ?>">
                                                                <?= substr(esc($respuesta['id_encuesta_realizada']), 0, 8) ?>...
                                                            </th>
                                                            <td><?= esc($respuesta['nombre_encuesta']) ?></td>
                                                            <td><?= esc($respuesta['nombre_encuestador']) ?></td>
                                                            <td><?= esc($respuesta['fecha_respuesta']) ?></td>
                                                            <td>
                                                                <?php if (!empty($respuesta['direccion'])): ?>
                                                                    <span class="badge badge-success"><i
                                                                            class="la la-check-circle"></i> Registrada</span>
                                                                <?php else: ?>
                                                                    <span class="badge badge-warning"><i
                                                                            class="la la-times-circle"></i> No Registrada</span>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-primary btn-sm"
                                                                    onclick="mostrarDetalleRespuesta('<?= esc($respuesta['id_encuesta_realizada']) ?>')">
                                                                    <i class="la la-file-text"></i> Ver Detalle
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <tr>
                                                        <td colspan="6" class="text-center">No se encontraron encuestas
                                                            completadas.</td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="mt-3 pager"><?= $pager ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MODAL DE DETALLE -->
            <div class="modal fade text-left" id="modalDetalleRespuesta" tabindex="-1" role="dialog"
                aria-labelledby="detalleRespuestaLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-primary white">
                            <h4 class="modal-title white" id="detalleRespuestaLabel">Detalle y Auditoría de Encuesta
                                #<span id="detalleIdInstancia"></span></h4>
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
                                    <p><strong>Referencias Adicionales:</strong> <span id="detalleReferencias"></span>
                                    </p>
                                    <hr>
                                    <h5 class="mb-3 text-bold-600 border-bottom pb-1">Auditoría de Ubicación</h5>
                                    <p><strong>Dirección Registrada:</strong> <span id="detalleDireccion"></span></p>
                                    <div id="mapaUbicacion">
                                        <div class="map-placeholder-content">Cargando mapa...</div>
                                    </div>
                                    <p class="text-muted mt-2"><small>El mapa muestra la <strong>última
                                                ubicación</strong> registrada del encuestador (punto GPS) al momento de
                                            la captura.</small></p>
                                </div>
                                <div class="col-lg-7 col-md-12">
                                    <h5 class="mb-3 text-bold-600 border-bottom pb-1">Preguntas y Respuestas Registradas
                                    </h5>
                                    <div id="preguntasRespondidasContainer"></div>
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

        </div>
    </div>

    <!-- SCRIPTS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=<?= $google_maps_api_key ?>&callback=initMap"></script>

    <script>
        // Variables globales
        let mapInstance = null;
        let mapMarker = null;
        let currentInfoWindow = null;
        let currentMapData = { direccion: null, latitud: null, longitud: null };

        window.initMap = function () {
            console.log('Google Maps API cargada y lista.');
        };

        function updateMapUI(direccion, lat, lng) {
            const mapDiv = document.getElementById('mapaUbicacion');
            const geocoder = new google.maps.Geocoder(); // Instancia del buscador de Google

            // Intentar buscar por DIRECCIÓN primero para asegurar coincidencia con el texto
            geocoder.geocode({ 'address': direccion }, function (results, status) {
                if (status === 'OK') {
                    const coords = results[0].geometry.location;

                    if (!mapInstance) {
                        mapInstance = new google.maps.Map(mapDiv, {
                            center: coords,
                            zoom: 17, // Un poco más de zoom para ver la calle
                            mapTypeId: google.maps.MapTypeId.ROADMAP
                        });
                        mapMarker = new google.maps.Marker({
                            map: mapInstance,
                            position: coords,
                            animation: google.maps.Animation.DROP
                        });
                        currentInfoWindow = new google.maps.InfoWindow();
                    } else {
                        mapInstance.setCenter(coords);
                        mapMarker.setPosition(coords);
                    }

                    currentInfoWindow.setContent(`<strong>Dirección Confirmada:</strong><br>${direccion}`);
                    currentInfoWindow.open(mapInstance, mapMarker);
                } else {
                    // Si falla la dirección, usar las coordenadas como respaldo (lo que ya tenías)
                    console.warn('Geocode falló: ' + status);
                    const fallbackCoords = { lat: parseFloat(lat), lng: parseFloat(lng) };
                    // ... (aquí pones tu lógica anterior de centrar por coordenadas)
                }
            });
        }

        const detalleRespuestaUrl = "<?= site_url('controlador/detalleRespuesta') ?>";

        // Evento al abrir modal
        // Evento al abrir modal (Optimizado)
        $('#modalDetalleRespuesta').on('shown.bs.modal', function () {
            if (mapInstance && currentMapData.latitud && currentMapData.longitud) {
                const coords = {
                    lat: parseFloat(currentMapData.latitud),
                    lng: parseFloat(currentMapData.longitud)
                };

                // 1. Forzar el refresco de dimensiones
                google.maps.event.trigger(mapInstance, 'resize');

                // 2. Re-centrar con un pequeño delay para asegurar que el DOM se asentó
                setTimeout(() => {
                    mapInstance.setCenter(coords);
                    mapMarker.setPosition(coords);
                }, 100);
            } else {
                updateMapUI(currentMapData.direccion, currentMapData.latitud, currentMapData.longitud);
            }
        });

        // Evento al cerrar modal
        $('#modalDetalleRespuesta').on('hidden.bs.modal', function () {
            if (currentInfoWindow) currentInfoWindow.close();

            // Limpiar mapa (sin destruir el div)
            if (mapInstance) {
                google.maps.event.clearInstanceListeners(mapInstance);
                mapInstance = null;
                mapMarker = null;
            }

            $('#mapaUbicacion').html('<div class="map-placeholder-content">Cargando mapa...</div>');
        });

        // Mostrar detalle de respuesta
        function mostrarDetalleRespuesta(idInstancia) {
            $('#preguntasRespondidasContainer').html('<p class="text-muted">Cargando detalles...</p>');
            $('#errorPreguntas').text('');
            $('#detalleIdInstancia').text(idInstancia.substring(0, 8) + '...');
            $('#mapaUbicacion').html('<div class="map-placeholder-content">Cargando mapa...</div>');

            currentMapData = { direccion: null, latitud: null, longitud: null };

            fetch(`${detalleRespuestaUrl}?id_instancia=${idInstancia}`)
                .then(response => {
                    if (!response.ok) throw new Error('Error en la respuesta del servidor.');
                    return response.json();
                })
                .then(data => {
                    if (data.error) {
                        $('#errorPreguntas').text(`Error: ${data.error}`);
                        $('#preguntasRespondidasContainer').empty();
                        return;
                    }

                    const detalle = data.detalle;
                    const preguntas = data.preguntas_respondidas;

                    $('#detalleTituloEncuesta').text(detalle.titulo_encuesta || 'N/A');
                    $('#detalleAliasEncuestador').text(`${detalle.nombre_usuario || ''} ${detalle.apellido_paterno || ''} (${detalle.alias_usuario || 'N/A'})`);
                    $('#detalleFechaRespuesta').text(detalle.fecha_respuesta || 'N/A');
                    $('#detalleReferencias').text(detalle.referencias || 'Ninguna');
                    $('#detalleDireccion').text(detalle.direccion || 'No registrada');
                    $('#detalleIdInstancia').text(idInstancia.substring(0, 15) + '...');

                    currentMapData = {
                        direccion: detalle.direccion,
                        latitud: detalle.latitud,
                        longitud: detalle.longitud
                    };

                    // Renderizar preguntas
                    // Renderizar preguntas (Corregido para manejar opciones agrupadas)
                    const container = $('#preguntasRespondidasContainer');
                    container.empty();

                    if (preguntas && preguntas.length > 0) {
                        preguntas.forEach((item, index) => {
                            // 'item.respuestas' ahora es un array de strings gracias al controlador corregido
                            // Usamos .join(' / ') para separar las opciones marcadas de forma elegante
                            const opcionesTexto = item.respuestas.join(' <br> • ');

                            const html = `
            <div class="respuesta-item" style="margin-bottom: 20px; border-left: 4px solid #007bff; padding-left: 15px;">
                <h6 class="text-bold-700" style="color: #333; margin-bottom: 5px;">
                    ${index + 1}. ${item.texto_pregunta}
                </h6>
                <div class="text-primary" style="font-weight: 600; font-size: 1rem; line-height: 1.4;">
                    • ${opcionesTexto}
                </div>
            </div>`;
                            container.append(html);
                        });
                    } else {
                        container.html('<p class="text-muted">No se encontraron preguntas respondidas.</p>');
                    }

                    $('#modalDetalleRespuesta').modal('show');
                })
                .catch(error => {
                    console.error('Error en la petición fetch:', error);
                    $('#preguntasRespondidasContainer').empty();
                    $('#errorPreguntas').text('No se pudo cargar la información. Inténtelo de nuevo.');
                });
        }
    </script>

</body>

</html>