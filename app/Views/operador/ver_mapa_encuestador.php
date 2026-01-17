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
$rolTexto = esc($userData['nombre_rol'] ?? 'Rol desconocido');
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
    <!-- Tus estilos del panel de operador -->
    <link rel="icon" href="<?= base_url(RECURSOS_OPERADOR_IMAGES . '/fevicon.png') ?>" type="image/png" />
    <link rel="stylesheet" href="<?= base_url(RECURSOS_OPERADOR_CSS . '/bootstrap.min.css') ?>" />
    <link rel="stylesheet" href="<?= base_url(RECURSOS_OPERADOR_CSS . '/style.css') ?>" />
    <link rel="stylesheet" href="<?= base_url(RECURSOS_OPERADOR_CSS . '/responsive.css') ?>" />
    <link rel="stylesheet" href="<?= base_url(RECURSOS_OPERADOR_CSS . '/colors.css') ?>" />
    <link rel="stylesheet" href="<?= base_url(RECURSOS_OPERADOR_CSS . '/perfect-scrollbar.css') ?>" />
    <link rel="stylesheet" href="<?= base_url(RECURSOS_OPERADOR_CSS . '/custom.css') ?>" />

      <style>
       .logout_sidebar {
    position: absolute;
    bottom: 20px; /* distancia desde abajo */
    width: 100%;
    text-align: center;
}

.logout_sidebar .btn_logout {
    display: inline-block;
    padding: 10px 15px;
    background-color: #f5f5f5; /* color de fondo opcional */
    border-radius: 5px;
    color: #333;
    text-decoration: none;
    font-weight: bold;
    transition: all 0.3s;
}

.logout_sidebar .btn_logout:hover {
    background-color: #e74c3c;
    color: #fff;
}

     </style>
</head>
<body class="inner_page">
    <div class="full_container">
        <div class="inner_container">
            <!-- Sidebar (Menú lateral) -->
            <nav id="sidebar">
               <div class="sidebar_blog_1">
                  <div class="sidebar-header">
                     <div class="logo_section">
                        <a href="<?= base_url('operador/dashboard') ?>"><img class="logo_icon img-responsive" src="<?= base_url(RECURSOS_OPERADOR_IMAGES . '/logo/logo_icon.png') ?>" alt="Logo" /></a>
                     </div>
                  </div>
                  <div class="sidebar_user_info">
                     <div class="icon_setting"></div>
                     <div class="user_profle_side">
                        <div class="user_img">
                           <!-- Foto de perfil dinámica en el sidebar -->
                           <img class="img-responsive" src="<?= $rutaFotoPerfil ?>" alt="Foto de perfil" />
                        </div>
                        <div class="user_info">
                           <!-- Nombre completo dinámico en el sidebar -->
                           <h6><?= $nombreCompleto ?></h6>
                           <!-- Rol dinámico en el sidebar -->
                           <p><span class="online_animation"></span> <?= $rolTexto ?></p>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="sidebar_blog_2">
                  <h4>General</h4>
                  <ul class="list-unstyled components">
                        <li class="active">
                            <a href="<?= base_url('operador/dashboard') ?>"><i class="fa fa-dashboard yellow_color"></i> <span>Home</span></a>
                        </li>
                        <li><a href="<?= base_url('operador_user') ?>"><i class="fa fa-table purple_color2"></i> <span>Encuestadores</span></a></li>
                    <li>
                        <a href="<?= base_url('operador/perfil') ?>">
                            <i class="fa fa-user purple_color2"></i> <span>Perfil</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="logout_sidebar">
                <a href="<?= base_url('logout') ?>" class="btn_logout">
                    <i class="fa fa-sign-out purple_color2"></i> Cerrar Sesión
                </a>
            </div>
        </nav>
            <!-- Fin del Sidebar -->

            <div id="content">

            <div class="topbar">
                  <nav class="navbar navbar-expand-lg navbar-light">
                     <div class="full">
                        <button type="button" id="sidebarCollapse" class="sidebar_toggle"><i class="fa fa-bars"></i></button>
                        <div class="right_topbar">
                           <div class="icon_info">
                              <ul class="user_profile_dd">
                                 <li>
                                    <!-- Foto de perfil dinámica en la navbar -->
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
                <!-- Topbar (Barra superior) -->
                <div class="topbar">
                    <!-- Tu código de topbar aquí... -->
                </div>
                <!-- Fin del Topbar -->

                <!-- Contenido Principal -->
                <div class="midde_cont">
                    <div class="container-fluid">
                        <div class="row column_title">
                            <div class="col-md-12">
                                <div class="page_title">
                                    <h2>Monitoreo en Vivo: <?= esc($encuestador['nombre'] . ' ' . $encuestador['apellido_paterno']) ?></h2>
                                </div>
                            </div>
                        </div>

                        <!-- Fila para el mapa -->
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
                    <!-- Footer -->
                    <div class="container-fluid">
                        <div class="footer">
                            <p>Copyright © 2025 Vota y Opina. All rights reserved.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts de tu plantilla -->
    <script src="<?= base_url(RECURSOS_OPERADOR_JS . '/jquery.min.js') ?>"></script>
    <!-- ... otros scripts de tu plantilla ... -->
    <script src="<?= base_url(RECURSOS_OPERADOR_JS . '/custom.js') ?>"></script>
    
    <!-- SCRIPT DE GOOGLE MAPS (VERSIÓN FINAL CON ÍCONO CORREGIDO) -->
<script>
        let map;
        let marker;
        let infoWindow;
        // ID específico del encuestador que queremos rastrear
        const idEncuestadorMonitoreado = <?= $encuestador['id_usuario'] ?>;

        function initMap() {
            // Inicializamos el mapa en una ubicación neutra, se centrará al recibir datos
            map = new google.maps.Map(document.getElementById("map"), {
                zoom: 17,
                center: { lat: 19.4326, lng: -99.1332 },
                mapTypeId: 'satellite',
                heading: 90,
                tilt: 45
            });
            infoWindow = new google.maps.InfoWindow();
            
            actualizarUbicacion();
            // Actualización constante cada 10 segundos
            setInterval(actualizarUbicacion, 5000);
        }

        async function actualizarUbicacion() {
    try {
        // 1. Romper el caché: Añadimos un timestamp (&_t=) para que el navegador no repita la respuesta vieja
        const timestamp = new Date().getTime();
        const url = `<?= base_url('operador_user/obtener_ubicaciones') ?>?id_usuario=${idEncuestadorMonitoreado}&_t=${timestamp}`;

        const response = await fetch(url);
        if (!response.ok) throw new Error("Error en la respuesta del servidor");
        
        const ubicaciones = await response.json();
        
        /**
         * 2. Selección del punto más reciente:
         * Como en el controlador corregimos la consulta con orderBy('id_monitoreo', 'DESC'),
         * el punto más nuevo siempre será el primero de la lista (índice 0).
         */
        const dataEncuestador = ubicaciones[0]; 

        if (dataEncuestador) {
            const latLng = { 
                lat: parseFloat(dataEncuestador.latitud), 
                lng: parseFloat(dataEncuestador.longitud) 
            };

            // Debug en consola para que veas las coordenadas moviéndose
            console.log(`Actualizando a: ${latLng.lat}, ${latLng.lng}`);

            // 3. Gestión dinámica del avatar
            const baseUrl = '<?= base_url() ?>';
            const fotoUrl = dataEncuestador.foto 
                ? `${baseUrl}/public/img_user/${dataEncuestador.foto}` 
                : `https://ui-avatars.com/api/?name=${encodeURIComponent(dataEncuestador.nombre)}+${encodeURIComponent(dataEncuestador.apellido_paterno)}&background=F44336&color=fff&rounded=true`;

            if (!marker) {
                // Crear el marcador por primera vez
                marker = new google.maps.Marker({
                    position: latLng,
                    map: map,
                    title: `${dataEncuestador.nombre}`,
                    icon: {
                        url: fotoUrl,
                        scaledSize: new google.maps.Size(60, 60),
                        anchor: new google.maps.Point(30, 30)
                    },
                    animation: google.maps.Animation.DROP
                });
                
                marker.addListener('click', () => infoWindow.open(map, marker));
                map.setCenter(latLng);
            } else {
                // ACTUALIZACIÓN DE MOVIMIENTO:
                // Movemos el marcador a la nueva posición
                marker.setPosition(latLng);
                
                // panTo hace que el mapa siga al encuestador con un deslizamiento suave
                map.panTo(latLng); 
            }
            
            // Actualizar el contenido de la ventana de información
            const fechaActualizacion = dataEncuestador.ultima_actualizacion 
                ? new Date(dataEncuestador.ultima_actualizacion).toLocaleTimeString()
                : "Recién capturado";

            const contenidoInfo = `
                <div style="color:#333; padding:5px; font-family: Arial, sans-serif;">
                    <b style="font-size:14px;">${dataEncuestador.nombre} ${dataEncuestador.apellido_paterno}</b><br>
                    <span style="color:#666;">Última señal: ${fechaActualizacion}</span>
                </div>`;
            
            infoWindow.setContent(contenidoInfo);
        } else {
            console.warn("No se encontraron coordenadas para el ID:", idEncuestadorMonitoreado);
        }

    } catch (error) {
        console.error("Fallo en la conexión de monitoreo:", error);
    }
}
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=<?= esc($google_maps_api_key) ?>&callback=initMap"></script>
</body>
</html>

