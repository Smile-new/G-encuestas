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
    <!-- Tus estilos del panel de operador -->
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
                 <!-- Tu código de sidebar aquí... -->
            </nav>
            <!-- Fin del Sidebar -->

            <div id="content">
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
        const idEncuestadorMonitoreado = <?= $encuestador['id_usuario'] ?>;

        function initMap() {
            map = new google.maps.Map(document.getElementById("map"), {
                zoom: 16,
                center: { lat: 19.4326, lng: -99.1332 },
                mapTypeId: 'satellite'
            });
            infoWindow = new google.maps.InfoWindow();
            
            actualizarUbicacion();
            setInterval(actualizarUbicacion, 15000);
        }

        async function actualizarUbicacion() {
            try {
                const response = await fetch('<?= base_url('operador_user/obtener_ubicaciones') ?>');
                const ubicaciones = await response.json();
                const dataEncuestador = ubicaciones.find(u => u.id_usuario == idEncuestadorMonitoreado);

                if (dataEncuestador) {
                    const latLng = new google.maps.LatLng(dataEncuestador.latitud, dataEncuestador.longitud);

                    // --- CORRECCIÓN EN LA RUTA DE LA IMAGEN ---
                    const baseUrl = '<?= base_url() ?>';
                    const fotoUrl = dataEncuestador.foto 
                        ? `${baseUrl}/public/img_user/${dataEncuestador.foto}` 
                        : `https://ui-avatars.com/api/?name=${encodeURIComponent(dataEncuestador.nombre)}+${encodeURIComponent(dataEncuestador.apellido_paterno)}&background=random&color=fff&rounded=true`;
                    
                    // Línea de depuración: Abre la consola (F12) para ver la URL exacta de la foto
                    console.log("Intentando cargar ícono desde:", fotoUrl);

                    if (!marker) {
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
                        map.setCenter(latLng);
                    } else {
                        marker.setPosition(latLng);
                        marker.setIcon({
                            url: fotoUrl,
                            scaledSize: new google.maps.Size(50, 50),
                            anchor: new google.maps.Point(25, 25),
                        });
                        map.panTo(latLng);
                    }
                    
                    const contenidoInfo = `<b>${dataEncuestador.nombre} ${dataEncuestador.apellido_paterno}</b><br>Última actualización: ${new Date(dataEncuestador.ultima_actualizacion).toLocaleTimeString()}`;
                    infoWindow.setContent(contenidoInfo);
                }

            } catch (error) {
                console.error("Error al obtener la ubicación:", error);
            }
        }
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=<?= esc($google_maps_api_key) ?>&callback=initMap"></script>
</body>
</html>

