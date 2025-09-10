<?php
// --- Lógica de la sesión para la plantilla (copiada de tu vista de usuarios) ---
$session = session();
$isLoggedIn = $session->get('isLoggedIn');
$userData = $session->get('usuario'); 
$nombreCompleto = "Invitado";
$rolTexto = "Rol Desconocido";
$rutaFotoPerfil = base_url(RECURSOS_OPERADOR_IMAGES . '/layout_img/user_img.jpg'); 
if ($isLoggedIn && is_array($userData)) {
    $nombreCompleto = esc($userData['nombre']) . ' ' . esc($userData['apellido_paterno']) . ' ' . esc($userData['apellido_materno']);
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
// --- Fin de la lógica de sesión ---
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pluto - Mapa de Encuestas</title>
    <!-- Tus mismos estilos del panel de operador para consistencia -->
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
            <!-- Sidebar (Menú lateral) -->
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
            <!-- Fin del Sidebar -->

            <div id="content">
                <!-- Topbar (Barra superior) -->
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
                <!-- Fin del Topbar -->

                <!-- Contenido Principal -->
                <div class="midde_cont">
                    <div class="container-fluid">
                        <div class="row column_title">
                            <div class="col-md-12">
                                <div class="page_title">
                                    <h2>Mapa de Encuestas de: <?= esc($encuestador['nombre'] . ' ' . $encuestador['apellido_paterno']) ?></h2>
                                </div>
                            </div>
                        </div>

                        <!-- Fila para el mapa -->
                        <div class="row column1">
                            <div class="col-md-12">
                                <div class="white_shd full margin_bottom_30">
                                    <div class="full graph_head">
                                        <div class="heading1 margin_0">
                                            <h2>Ubicaciones Registradas</h2>
                                        </div>
                                    </div>
                                    <div class="full map_section">
                                        <!-- El mapa se renderizará aquí -->
                                        <div id="map" style="height: 600px; width: 100%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Footer -->
                    <div class="container-fluid">
                        <div class="footer">
                            <p>Copyright © 2025 Vota y Opina. All rights reserved.</p>
                        </div>
                    </div>
                </div>
                <!-- Fin del Contenido Principal -->
            </div>
        </div>
    </div>

    <!-- Scripts de tu plantilla -->
    <script src="<?= base_url(RECURSOS_OPERADOR_JS . '/jquery.min.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_OPERADOR_JS . '/popper.min.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_OPERADOR_JS . '/bootstrap.min.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_OPERADOR_JS . '/perfect-scrollbar.min.js') ?>"></script>
    <script>var ps = new PerfectScrollbar('#sidebar');</script>
    <script src="<?= base_url(RECURSOS_OPERADOR_JS . '/custom.js') ?>"></script>
    
    <!-- Script de Google Maps -->
    <script>
        // Pasamos las respuestas desde PHP a JavaScript de forma segura
        const respuestas = <?= json_encode($respuestas) ?>;

        function initMap() {
            // Centra el mapa en México
            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 5, 
                center: { lat: 23.6345, lng: -102.5528 },
            });

            const geocoder = new google.maps.Geocoder();
            const infowindow = new google.maps.InfoWindow();
            
            // Un pequeño retraso entre cada solicitud para evitar el error OVER_QUERY_LIMIT
            const delay = 100; 

            respuestas.forEach((respuesta, i) => {
                setTimeout(() => {
                    geocodeAddress(geocoder, map, infowindow, respuesta);
                }, i * delay);
            });
        }

        function geocodeAddress(geocoder, resultsMap, infowindow, respuesta) {
            const address = respuesta.direccion;
            geocoder.geocode({ address: address }, (results, status) => {
                if (status === "OK") {
                    const marker = new google.maps.Marker({
                        map: resultsMap,
                        position: results[0].geometry.location,
                        title: `Respuesta del: ${respuesta.fecha_respuesta}`
                    });

                    // Añadir un listener para mostrar información al hacer clic en el marcador
                    marker.addListener('click', () => {
                        const contentString = `<div><strong>Dirección:</strong> ${respuesta.direccion}<br><strong>Fecha:</strong> ${respuesta.fecha_respuesta}</div>`;
                        infowindow.setContent(contentString);
                        infowindow.open(resultsMap, marker);
                    });

                } else if (status === "OVER_QUERY_LIMIT") {
                    console.warn("Límite de geocodificación alcanzado. Reintentando para la dirección:", address);
                    setTimeout(() => { 
                        geocodeAddress(geocoder, resultsMap, infowindow, respuesta); 
                    }, 2000); // Esperar 2 segundos antes de reintentar
                } else {
                    console.error(`La geocodificación falló para la dirección "${address}" por la siguiente razón: ${status}`);
                }
            });
        }
    </script>
    <!-- El callback=initMap ejecuta la función initMap cuando la API de Google Maps está lista -->
    <!-- La clave de API se obtiene desde el controlador -->
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=<?= esc($googleApiKey) ?>&callback=initMap"></script>

</body>
</html>

