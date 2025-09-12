<?php
// --- Lógica de la sesión para la plantilla ---
$session = session();
$isLoggedIn = $session->get('isLoggedIn');
$userData = $session->get('usuario');
$nombreCompleto = "Invitado";
$rolTexto = "Rol Desconocido";
$rutaFotoPerfil = base_url(RECURSOS_OPERADOR_IMAGES . '/layout_img/user_img.jpg');
if ($isLoggedIn && is_array($userData)) {
    $nombreCompleto = esc($userData['nombre']) . ' ' . esc($userData['apellido_paterno']);
    $id_rol = $userData['id_rol'] ?? null;
    switch ($id_rol) {
        case 1: $rolTexto = 'Administrador'; break;
        case 2: $rolTexto = 'Operador'; break;
        case 3: $rolTexto = 'Encuestador'; break;
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Monitoreo en Tiempo Real</title>
    <link rel="icon" href="<?= base_url(RECURSOS_OPERADOR_IMAGES . '/fevicon.png') ?>" type="image/png" />
    <link rel="stylesheet" href="<?= base_url(RECURSOS_OPERADOR_CSS . '/bootstrap.min.css') ?>" />
    <link rel="stylesheet" href="<?= base_url(RECURSOS_OPERADOR_CSS . '/style.css') ?>" />
    <link rel="stylesheet" href="<?= base_url(RECURSOS_OPERADOR_CSS . '/responsive.css') ?>" />
    <link rel="stylesheet" href="<?= base_url(RECURSOS_OPERADOR_CSS . '/colors.css') ?>" />
    <link rel="stylesheet" href="<?= base_url(RECURSOS_OPERADOR_CSS . '/perfect-scrollbar.css') ?>" />
    <link rel="stylesheet" href="<?= base_url(RECURSOS_OPERADOR_CSS . '/custom.css') ?>" />
</head>
<body class="inner_page">
    <div class="full_container">
        <div class="inner_container">
            <nav id="sidebar">
                <div class="sidebar_blog_1">
                    <div class="sidebar-header">
                        <div class="logo_section">
                            <a href="<?= base_url('operador/dashboard') ?>"><img class="logo_icon img-responsive" src="<?= base_url(RECURSOS_OPERADOR_IMAGES . '/logo/logo_icon.png') ?>" alt="#" /></a>
                        </div>
                    </div>
                    <div class="sidebar_user_info">
                        <div class="user_profle_side">
                            <div class="user_img"><img class="img-responsive" src="<?= $rutaFotoPerfil ?>" alt="Foto de perfil" /></div>
                            <div class="user_info">
                                <h6><?= $nombreCompleto ?></h6>
                                <p><span class="online_animation"></span> <?= $rolTexto ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sidebar_blog_2">
                    <h4>General</h4>
                    <ul class="list-unstyled components">
                        <li><a href="<?= base_url('operador/dashboard') ?>"><i class="fa fa-dashboard yellow_color"></i> <span>Home</span></a></li>
                        <li class="active"><a href="<?= base_url('operador_user') ?>"><i class="fa fa-table purple_color2"></i> <span>Encuestadores</span></a></li>
                    </ul>
                </div>
            </nav>
            <div id="content">
                <div class="topbar">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <div class="full">
                            <button type="button" id="sidebarCollapse" class="sidebar_toggle"><i class="fa fa-bars"></i></button>
                            <div class="right_topbar">
                                <div class="icon_info">
                                    <ul class="user_profile_dd">
                                        <li>
                                            <a class="dropdown-toggle" data-toggle="dropdown"><img class="img-responsive rounded-circle" src="<?= $rutaFotoPerfil ?>" alt="Foto de perfil" /><span class="name_user"><?= $nombreCompleto ?></span></a>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="<?= base_url('logout') ?>"><span>Log Out</span> <i class="fa fa-sign-out"></i></a>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </nav>
                </div>
                <div class="midde_cont">
                    <div class="container-fluid">
                        <div class="row column_title">
                            <div class="col-md-12">
                                <div class="page_title">
                                    <h2>Monitoreo en Vivo: <?= esc($encuestador['nombre'] . ' ' . $encuestador['apellido_paterno']) ?></h2>
                                </div>
                            </div>
                        </div>

                        <div class="row column1">
                            <div class="col-md-12">
                                <div class="white_shd full margin_bottom_30">
                                    <div class="full graph_head">
                                        <div class="heading1 margin_0">
                                            <h2>Ubicación Actual (se actualiza cada 15 segundos)</h2>
                                        </div>
                                    </div>
                                    <div class="full map_section">
                                        <div id="map" style="height: 600px; width: 100%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container-fluid">
                        <div class="footer">
                            <p>Copyright © 2025 Vota y Opina. All rights reserved.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= base_url(RECURSOS_OPERADOR_JS . '/jquery.min.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_OPERADOR_JS . '/popper.min.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_OPERADOR_JS . '/bootstrap.min.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_OPERADOR_JS . '/perfect-scrollbar.min.js') ?>"></script>
    <script>var ps = new PerfectScrollbar('#sidebar');</script>
    <script src="<?= base_url(RECURSOS_OPERADOR_JS . '/custom.js') ?>"></script>
    
    <script>
        let map;
        let marker; // Solo necesitaremos un marcador para este encuestador
        let infoWindow;
        const idEncuestadorMonitoreado = <?= $encuestador['id_usuario'] ?>;

        function initMap() {
            map = new google.maps.Map(document.getElementById("map"), {
                zoom: 16,
                center: { lat: 19.4326, lng: -99.1332 }, // Centro inicial en CDMX
                mapTypeId: 'satellite'
            });
            infoWindow = new google.maps.InfoWindow();
            
            actualizarUbicacion();
            setInterval(actualizarUbicacion, 15000); // Actualizar cada 15 segundos
        }

        async function actualizarUbicacion() {
            try {
                const response = await fetch('<?= base_url('operador_user/obtener_ubicaciones') ?>');
                const ubicaciones = await response.json();

                const dataEncuestador = ubicaciones.find(u => u.id_usuario == idEncuestadorMonitoreado);

                if (dataEncuestador) {
                    const latLng = new google.maps.LatLng(dataEncuestador.latitud, dataEncuestador.longitud);

                    if (!marker) {
                        const fotoUrl = dataEncuestador.foto 
                            ? `<?= base_url('public/img_user/') ?>${dataEncuestador.foto}` 
                            : `https://ui-avatars.com/api/?name=${encodeURIComponent(dataEncuestador.nombre)}+${encodeURIComponent(dataEncuestador.apellido_paterno)}&background=random&color=fff&rounded=true`;

                        marker = new google.maps.Marker({
                            position: latLng,
                            map: map,
                            title: `${dataEncuestador.nombre} ${dataEncuestador.apellido_paterno}`,
                            icon: {
                                url: fotoUrl,
                                scaledSize: new google.maps.Size(50, 50),
                                anchor: new google.maps.Point(25, 25),
                            }
                        });
                        
                        marker.addListener('click', () => infoWindow.open(map, marker));
                        map.setCenter(latLng); // Centrar el mapa la primera vez
                    } else {
                        marker.setPosition(latLng); // Mover el marcador existente
                        map.panTo(latLng); // Mover suavemente el mapa al centro
                    }
                    
                    const contenidoInfo = `<b>${dataEncuestador.nombre} ${dataEncuestador.apellido_paterno}</b><br>Última actualización: ${new Date(dataEncuestador.ultima_actualizacion).toLocaleTimeString()}`;
                    infoWindow.setContent(contenidoInfo);

                } else {
                    console.log(`Esperando la ubicación del encuestador ID: ${idEncuestadorMonitoreado}... (Puede que esté inactivo)`);
                }

            } catch (error) {
                console.error("Error al obtener la ubicación:", error);
            }
        }
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=<?= esc($google_maps_api_key) ?>&callback=initMap"></script>
</body>
</html>