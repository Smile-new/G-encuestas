<?php
$session = session();
$isLoggedIn = $session->get('isLoggedIn');
$userData = $session->get('usuario');

$nombreCompleto = "Invitado";
$nombreUsuario = "invitado";
$rutaFotoPerfil = base_url(RECURSOS_ENCUESTADOR_IMAGES . '/user.png');

if ($isLoggedIn && is_array($userData)) {
    $nombreCompleto = esc($userData['nombre']) . ' ' .
        esc($userData['apellido_paterno']) . ' ' .
        esc($userData['apellido_materno']);
    $nombreUsuario = esc($userData['usuario']);
    if (!empty($userData['foto'])) {
        $rutaFotoPerfil = base_url('public/img_user/' . esc($userData['foto']));
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Vota y Opina | Formularios de Encuestas</title>
    <link rel="manifest" href="<?= base_url('manifest.json') ?>">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="theme-color" content="#f44336">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet"
        type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="<?= base_url(RECURSOS_ENCUESTADOR_PLUGINS . '/bootstrap/css/bootstrap.css') ?>" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="<?= base_url(RECURSOS_ENCUESTADOR_PLUGINS . '/node-waves/waves.css') ?>" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="<?= base_url(RECURSOS_ENCUESTADOR_PLUGINS . '/animate-css/animate.css') ?>" rel="stylesheet" />

    <!-- Morris Chart Css-->
    <link href="<?= base_url(RECURSOS_ENCUESTADOR_PLUGINS . '/morrisjs/morris.css') ?>" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="<?= base_url(RECURSOS_ENCUESTADOR_CSS . '/style.css') ?>" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="<?= base_url(RECURSOS_ENCUESTADOR_CSS . '/themes/all-themes.css') ?>" rel="stylesheet" />
    <style>
        :root {
            --primary-red: #F44336;
            --primary-red-dark: #C62828;
            --primary-red-light: #FFCDD2;
            --primary-accent: #FF3D00;
            /* Se usa para header y botón */
            --text-dark: #212121;
            --text-medium: #616161;
            --bg-page: #FAFAFA;
            --bg-card: #FFFFFF;
            --border-subtle: #E0E0E0;
            --shadow-subtle: rgba(0, 0, 0, 0.08);
            --shadow-hover: rgba(0, 0, 0, 0.18);
        }

        body {
            background-color: var(--bg-page);
            font-family: 'Roboto', sans-serif;
        }

        .survey-card {
            margin-bottom: 25px;
            border: none;
            border-radius: 10px;
            overflow: hidden;
            background-color: var(--bg-card);
            box-shadow: 0 6px 12px var(--shadow-subtle);
            transition: all 0.3s ease-in-out;
        }

        .survey-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 20px var(--shadow-hover);
        }

        .survey-card .header {
            background-color: var(--primary-accent);
            color: white;
            padding: 20px 25px;
        }

        .survey-card .header h2 {
            font-weight: bold;
            font-size: 1.4em;
            margin: 0 0 8px;
            color: white;
        }

        .survey-card .header .survey-date {
            font-size: 0.9em;
            color: rgba(255, 255, 255, 0.85);
        }

        .survey-card .body {
            padding: 25px;
            background-color: var(--bg-card);
            color: var(--text-dark);
        }

        .survey-card .survey-description {
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--border-subtle);
            font-size: 1em;
            line-height: 1.5;
        }

        /* Modificación para el botón (ahora un enlace con estilo de botón) */
        .survey-card .body .btn {
            background-color: var(--primary-accent) !important;
            color: #fff;
            border: none;
            padding: 14px 28px;
            border-radius: 6px;
            font-weight: bold;
            letter-spacing: 1px;
            text-transform: uppercase;
            transition: 0.3s ease-in-out;
            box-shadow: 0 4px 10px rgba(255, 61, 0, 0.4);
            cursor: pointer;
            /* Cambiado de not-allowed a pointer */
            text-decoration: none;
            /* Asegura que no tenga subrayado de enlace */
            display: inline-block;
            /* Para que padding y width funcionen como en un botón */
            text-align: center;
            /* Centrar texto si es necesario */
        }

        .survey-card .body .btn:hover {
            background-color: var(--primary-red-dark) !important;
            transform: translateY(-2px);
        }

        .no-surveys-message {
            padding: 60px 30px;
            text-align: center;
            background-color: var(--bg-card);
            border: 1px solid var(--border-subtle);
            border-radius: 8px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.08);
            color: var(--text-medium);
        }

        .no-surveys-message .material-icons {
            font-size: 80px;
            color: var(--primary-accent);
            opacity: 0.9;
            margin-bottom: 20px;
        }

        .no-surveys-message h2 {
            color: var(--text-dark);
            font-weight: 700;
            margin-bottom: 15px;
        }

        .no-surveys-message p {
            font-size: 1.1em;
            color: var(--text-medium);
        }

        /* RESPONSIVE DESIGN */
        @media screen and (max-width: 768px) {
            .survey-card {
                border-radius: 6px;
                margin-bottom: 20px;
            }

            .survey-card .header {
                padding: 15px 20px;
            }

            .survey-card .header h2 {
                font-size: 1.2em;
            }

            .survey-card .body {
                padding: 20px;
            }

            .survey-card .survey-description {
                font-size: 0.95em;
                padding-bottom: 12px;
            }

            .survey-card .body .btn {
                width: 100%;
                padding: 12px 0;
                font-size: 0.95em;
                box-shadow: none;
            }

            .no-surveys-message {
                padding: 40px 20px;
            }

            .no-surveys-message .material-icons {
                font-size: 60px;
            }

            .no-surveys-message h2 {
                font-size: 1.5em;
            }
        }

        @media screen and (max-width: 480px) {
            .survey-card .header h2 {
                font-size: 1.1em;
            }

            .survey-card .body .btn {
                font-size: 0.9em;
            }

            .no-surveys-message h2 {
                font-size: 1.3em;
            }

            .no-surveys-message p {
                font-size: 1em;
            }
        }

        .logout_sidebar {
            position: absolute;
            bottom: 80px;
            /* queda justo arriba del bloque .legal */
            width: 100%;
            text-align: center;
        }

        .logout_sidebar a {
            display: block;
            padding: 12px;
            color: #fff;
            /* texto blanco */
            background-color: #f44336;
            /* rojo estilo Material */
            text-decoration: none;
            font-weight: bold;
        }

        .logout_sidebar a:hover {
            background-color: #d32f2f;
        }
    </style>

</head>

<body class="theme-red">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Please wait...</p>
        </div>
    </div>
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Search Bar -->
    <!-- #END# Search Bar -->
    <!-- Top Bar -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>

                <a class="navbar-brand" href="<?= base_url('/') ?>"
                    style="display: flex; align-items: center; padding: 5px 15px;">
                    <img src="<?= base_url(RECURSOS_USUARIO_IMG . '/logo/logo.png') ?>" alt="Vota y Opina"
                        style="height: 35px; width: auto; max-width: 150px; object-fit: contain;">
                </a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <!-- Puedes añadir elementos de navegación aquí si es necesario -->
                    <li class="pull-right"><a href="javascript:void(0);" class="js-right-sidebar" data-close="true"><i
                                class="material-icons">more_vert</i></a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info">
                <div class="image">
                    <!-- Foto de perfil dinámica -->
                    <img src="<?= $rutaFotoPerfil ?>" width="48" height="48" alt="User" />
                </div>
                <div class="info-container">
                    <!-- Nombre completo dinámico -->
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?= $nombreCompleto ?>
                    </div>
                    <!-- Nombre de usuario dinámico -->
                    <div class="email"><?= $nombreUsuario ?></div> <!-- CAMBIADO: Muestra el nombre de usuario -->
                    <div class="btn-group user-helper-dropdown">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="true">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="javascript:void(0);"><i class="material-icons">person</i>Perfil</a></li>
                            <li role="seperator" class="divider"></li>
                            <!-- Enlace de cerrar sesión dinámico -->
                            <li><a href="<?= base_url('logout') ?>"><i class="material-icons">input</i>Cerrar Sesión</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="header">NAVEGACIÓN PRINCIPAL</li>
                    <li>
                        <a href="<?= base_url('home') ?>">
                            <i class="material-icons">home</i>
                            <span>Inicio</span>
                        </a>
                    </li>
                    <li class="active">
                        <a href="<?= base_url('formularios') ?>">
                            <i class="material-icons">assignment</i>
                            <span>Formularios</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= site_url('perfil') ?>">
                            <i class="material-icons">account_circle</i>
                            <span>Perfil</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Botón fijo abajo -->
            <div class="logout_sidebar">
                <a href="<?= site_url('logout') ?>">
                    <i class="material-icons">input</i>
                    <span>Cerrar Sesión</span>
                </a>
            </div>
            <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">
                <div class="copyright">
                    &copy; <?= date('Y') ?> <a href="javascript:void(0);">Vota y Opina</a>.
                </div>
                <div class="version">
                    <b>Version: </b> 1.0.0
                </div>
            </div>
            <!-- #Footer -->
        </aside>

    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="block-header" style="display: flex; justify-content: space-between; align-items: center;">
                <h2>ENCUESTAS DISPONIBLES</h2>
                <div>
                    <button id="btnSyncEncuestas"
                        class="btn btn-primary btn-circle-lg waves-effect waves-circle waves-float"
                        title="Sincronizar para modo offline">
                        <i class="material-icons">sync</i>
                    </button>
                    <div id="sync-status-msg" style="font-size: 11px; text-align: right; margin-top: 5px;"></div>
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-lg-12" id="survey-main-container">
                    <div id="online-survey-list">
                        <?php if (empty($encuestas)): ?>
                            <div class="card no-surveys-message">
                                <i class="material-icons">info_outline</i>
                                <h2>No hay encuestas activas disponibles.</h2>
                            </div>
                        <?php else: ?>
                            <?php foreach ($encuestas as $encuesta): ?>
                                <div class="card survey-card">
                                    <div class="header">
                                        <h2><?= esc($encuesta['titulo']) ?></h2>
                                    </div>
                                    <div class="body">
                                        <p class="survey-description"><?= esc($encuesta['descripcion']) ?></p>
                                        <a href="<?= base_url('encuestador/verEncuesta/' . esc($encuesta['id_encuesta'])) ?>"
                                            class="btn waves-effect m-t-15">Iniciar encuesta nueva</a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <div id="offline-survey-list" style="display: none;">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="<?= base_url(RECURSOS_ENCUESTADOR_PLUGINS . '/jquery/jquery.min.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_ENCUESTADOR_PLUGINS . '/bootstrap/js/bootstrap.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_ENCUESTADOR_PLUGINS . '/node-waves/waves.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_ENCUESTADOR_JS . '/admin.js') ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/dexie@latest/dist/dexie.js"></script>
    <script src="<?= base_url('js/offline_handler.js') ?>"></script>

    <script>
        $(function () {
            const $btnSync = $('#btnSyncEncuestas');
            const $status = $('#sync-status-msg');

            /**
             * 1. FUNCIÓN DE RENDERIZADO HÍBRIDO
             * Esta función asegura que, si no hay internet, la lista se construya 
             * usando los datos guardados en la base de datos local (Dexie).
             */
            async function renderizarEncuestasOffline() {
                if (!navigator.onLine) {
                    try {
                        if (!db.isOpen()) await db.open();

                        // Obtenemos las encuestas de la tabla lista_maestra (Versión 3)
                        const encuestasLocal = await db.lista_maestra.toArray();

                        if (encuestasLocal.length > 0) {
                            // Ocultamos la lista vacía de PHP y mostramos la de JS
                            $('#online-survey-list').hide();
                            const $offlineList = $('#offline-survey-list');
                            $offlineList.empty().show();

                            encuestasLocal.forEach(encuesta => {
                                const cardHtml = `
                                <div class="card survey-card">
                                    <div class="header" style="background-color: #FF3D00;">
                                        <h2 style="color:white;">${encuesta.titulo} (Modo Offline)</h2>
                                    </div>
                                    <div class="body">
                                        <p class="survey-description">${encuesta.descripcion}</p>
                                        <a href="<?= base_url('encuestador/verEncuesta/') ?>/${encuesta.id_encuesta}" 
                                           class="btn waves-effect m-t-15" 
                                           style="background-color: #FF3D00 !important; width:100%; color:white; display:block; text-align:center; padding:10px; border-radius:6px; text-decoration:none;">
                                           Iniciar encuesta nueva
                                        </a>
                                    </div>
                                </div>`;
                                $offlineList.append(cardHtml);
                            });
                        }
                    } catch (err) {
                        console.error("Error al renderizar offline:", err);
                    }
                }
            }

            // Ejecutar renderizado al cargar la página
            renderizarEncuestasOffline();

            /**
             * 2. AUTO-ACTUALIZACIÓN DEL SERVICE WORKER (v1.6)
             * Fuerza al navegador a buscar cambios en el sw.js cada vez que se abre la app.
             */
            if ('serviceWorker' in navigator) {
                navigator.serviceWorker.ready.then(reg => {
                    reg.update(); // Busca actualizaciones v1.6
                });
            }

            /**
             * 3. LÓGICA DEL BOTÓN DE SINCRONIZACIÓN
             * Descarga las encuestas actuales y las prepara para el uso sin internet.
             */
            $btnSync.on('click', async function () {
                // Validación de Conexión y Contexto Seguro (HTTPS)
                if (!navigator.onLine) {
                    alert("No tienes conexión a internet para sincronizar.");
                    return;
                }

                if (location.protocol !== 'https:' && location.hostname !== 'localhost') {
                    alert("Error: La sincronización requiere una conexión segura (HTTPS).");
                    return;
                }

                $btnSync.addClass('js-animating');
                $status.text('Sincronizando...').css('color', 'orange');

                try {
                    // Asegurarse de que la base de datos esté abierta
                    if (!db.isOpen()) await db.open();

                    // 1. Limpiar lista antigua para evitar encuestas "fantasmas"
                    await db.lista_maestra.clear();

                    // 2. Escaneo de encuestas actuales en la pantalla (renderizadas por PHP)
                    const encuestasParaDescargar = [];
                    $('.survey-card').each(function () {
                        const $card = $(this);
                        const url = $card.find('a').attr('href');
                        if (url) {
                            const id = url.split('/').pop();
                            encuestasParaDescargar.push({
                                url: url,
                                id: id,
                                titulo: $card.find('h2').text(),
                                desc: $card.find('.survey-description').text()
                            });
                        }
                    });

                    if (encuestasParaDescargar.length === 0) {
                        throw new Error("No se encontraron encuestas activas en la lista.");
                    }

                    // 3. Descarga y almacenamiento individual
                    for (let i = 0; i < encuestasParaDescargar.length; i++) {
                        const encuesta = encuestasParaDescargar[i];
                        $status.text(`Descargando ${i + 1} de ${encuestasParaDescargar.length}...`);

                        try {
                            // Forzamos la descarga real al caché dinámico (v1.6)
                            const res = await fetch(encuesta.url, { cache: 'reload' });
                            if (!res.ok) throw new Error(`Error al descargar encuesta ${encuesta.id}`);

                            // Guardamos en la tabla lista_maestra para el renderizado offline
                            await db.lista_maestra.put({
                                id_encuesta: encuesta.id,
                                titulo: encuesta.titulo,
                                descripcion: encuesta.desc,
                                activa: 1
                            });
                        } catch (e) {
                            console.warn(`Error individual en encuesta ${encuesta.id}: ${e.message}`);
                        }
                    }

                    // 4. Actualizar el caché de la lista de formularios
                    await fetch('<?= base_url('formularios') ?>', { cache: 'reload' });

                    // 5. Notificar al Service Worker (Background Sync API)
                    const reg = await navigator.serviceWorker.ready;
                    if (reg.sync) {
                        await reg.sync.register('sync-encuestas');
                    }

                    $status.text('¡Sincronización completa!').css('color', 'green');

                    setTimeout(() => {
                        $btnSync.removeClass('js-animating');
                        location.reload(); // Recargar para aplicar los datos frescos
                    }, 1000);

                } catch (error) {
                    console.error("Error de sincronización:", error);
                    $btnSync.removeClass('js-animating');
                    alert("Fallo la sincronización: " + error.message);
                    $status.text('Error al sincronizar.').css('color', 'red');
                }
            });
        });
    </script>

</body>



</html>