<!DOCTYPE html>
<html class="loading" lang="es" data-textdirection="ltr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Panel de Control - Vota y Opina</title>
    <link rel="apple-touch-icon" href="<?= base_url(RECURSOS_CONTROLADOR_IMAGES . 'ico/apple-icon-120.png') ?>">
   
    <link href="https://fonts.googleapis.com/css?family=Muli:300,300i,400,400i,600,600i,700,700i%7CComfortaa:300,400,700" rel="stylesheet">
    <link href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="<?= base_url(RECURSOS_CONTROLADOR_CSS . 'vendors.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url(RECURSOS_CONTROLADOR_CSS . 'app-lite.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url(RECURSOS_CONTROLADOR_CSS . 'core/menu/menu-types/vertical-menu.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url(RECURSOS_CONTROLADOR_CSS . 'core/colors/palette-gradient.css') ?>">
    
    <style>
        /* Animacion de tecleo y cursor */
        @keyframes typing { from { width: 0 } to { width: 100% } }
        @keyframes blink-caret { from, to { border-color: transparent } 50% { border-color: #4a90e2; } }

        .ai-message-container { min-height: 2.5em; }
        .ai-message {
            overflow: hidden;
            border-right: .15em solid #4a90e2;
            white-space: nowrap;
            margin: 0 auto;
            letter-spacing: .05em;
            display: inline-block;
        }
        .typing-animation {
            animation: typing 2.5s steps(40, end), blink-caret .75s step-end infinite;
        }

        /* Tarjeta principal del asistente */
        .ai-card {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            border-radius: 20px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
            min-height: 500px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        .ai-card:hover { transform: translateY(-5px); box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2); }

        /* Icono del asistente y su animacion */
        .assistant-avatar {
            font-size: 8rem;
            color: #626FE6;
            animation: floatAnimation 3s ease-in-out infinite;
        }
        @keyframes floatAnimation {
            0% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
            100% { transform: translateY(0); }
        }

        /* Estilos para los pasos de la guia */
        .guidance-step {
            margin-top: 15px;
            opacity: 0;
            transform: translateY(20px) scale(0.98);
            transition: all 0.6s cubic-bezier(0.25, 0.8, 0.25, 1);
            padding: 15px;
            border-radius: 10px;
            background-color: transparent;
        }
        .guidance-step.visible { opacity: 1; transform: translateY(0) scale(1); }
        .guidance-step.highlight {
            background-color: rgba(255, 255, 255, 0.7);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        .step-icon {
            font-size: 1.8em;
            color: #1EAE98;
            margin-right: 15px;
            vertical-align: middle;
        }
        .guidance-step h5 { display: inline-block; vertical-align: middle; }
    </style>
</head>

<body class="vertical-layout vertical-menu 2-columns menu-expanded fixed-navbar" data-open="click" data-menu="vertical-menu" data-color="bg-gradient-x-purple-blue" data-col="2-columns">

    <?php
    $userData = session()->get('usuario') ?? null;
    $nombreUsuario = ($userData && isset($userData['nombre'])) ? esc($userData['nombre']) : 'Propietario';
    $nombreCompleto = ($userData) ? esc($userData['nombre'] . ' ' . $userData['apellido_paterno']) : 'Invitado';
    $rutaFotoPerfil = ($userData && !empty($userData['foto'])) ? base_url('public/img_user/' . $userData['foto']) : base_url(RECURSOS_CONTROLADOR_IMAGES . 'portrait/small/avatar-s-19.png');
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
                  <div class="arrow_box_right"><a class="dropdown-item" href="#"><span class="avatar avatar-online"><img src="<?= $rutaFotoPerfil ?>" alt="avatar"><span class="user-name text-bold-700 ml-1"><?= $nombreCompleto ?></span></span></a>
                    <div class="dropdown-divider"></div><a class="dropdown-item" href="<?= base_url('controlador/perfil') ?>"><i class="ft-user"></i> Editar Perfil</a>
                    <div class="dropdown-divider"></div><a class="dropdown-item" href="/logout"><i class="ft-power"></i> Cerrar Sesion</a>
                  </div>
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
            <li class="active"><a href="<?= base_url('controlador/panel') ?>"><i class="la la-home"></i><span class="menu-title">Panel</span></a></li>
            <li class="nav-item"><a href="<?= base_url('controlador/graficas') ?>"><i class="la la-pie-chart"></i><span class="menu-title">Graficas</span></a></li>
            <li class="nav-item"><a href="<?= base_url('controlador/usuarios') ?>"><i class="la la-users"></i><span class="menu-title">Usuarios</span></a></li>
            <li class="nav-item"><a href="<?= base_url('controlador/encuestas') ?>"><i class="la la-list-alt"></i><span class="menu-title">Encuestas</span></a></li>
            <li class="nav-item"><a href="<?= base_url('controlador/respuestas') ?>"><i class="la la-check-square"></i><span class="menu-title">Respuestas</span></a></li>
            <li class="nav-item"><a href="<?= base_url('controlador/perfil') ?>"><i class="la la-user"></i><span class="menu-title">Perfil</span></a></li>
        </ul>
      </div>
      <div class="navigation-background"></div>
    </div>

    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-wrapper-before"></div>
            <div class="content-header row">
                <div class="content-header-left col-md-4 col-12 mb-2">
                    <h3 class="content-header-title">Panel de Control</h3>
                </div>
                <div class="content-header-right col-md-8 col-12">
                    <div class="breadcrumbs-top float-md-right">
                        <div class="breadcrumb-wrapper mr-1">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?= base_url('controlador/panel') ?>">Panel</a></li>
                                <li class="breadcrumb-item active">Inicio</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card ai-card">
                            <div class="card-body text-center">
                                <i class="la la-rocket assistant-avatar"></i>
                                <h2 class="mt-3 text-primary">Asistente de Supervision</h2>
                                <p class="text-muted">Tu guia para dominar el panel de Vota y Opina.</p>

                                <div class="ai-message-container mb-4">
                                    <p class="ai-message text-bold-600 h4" id="aiMessage"></p>
                                </div>

                                <div id="guidanceSteps" class="mt-4" style="max-width: 650px; margin: 0 auto; text-align: left;">
                                    
                                    <div id="step1" class="guidance-step">
                                        <i class="la la-bar-chart step-icon"></i>
                                        <h5 class="text-bold-600">Vista General en Graficas</h5>
                                        <p class="pl-5 ml-2">Aqui tienes el pulso de toda la operacion con datos y estadisticas al momento para tomar decisiones.</p>
                                    </div>

                                    <div id="step2" class="guidance-step">
                                        <i class="la la-users step-icon"></i>
                                        <h5 class="text-bold-600">Control de Usuarios</h5>
                                        <p class="pl-5 ml-2">Este es tu centro de equipo. Puedes ver quien es quien, administrar sus accesos y permisos.</p>
                                    </div>
                                    
                                    <div id="step3" class="guidance-step">
                                        <i class="la la-list-alt step-icon"></i>
                                        <h5 class="text-bold-600">Gestion de Encuestas</h5>
                                        <p class="pl-5 ml-2">Revisa todas las encuestas creadas, activalas o desactivalas, y mira a detalle sus preguntas y opciones.</p>
                                    </div>

                                    <div id="step4" class="guidance-step">
                                        <i class="la la-map-marker step-icon"></i>
                                        <h5 class="text-bold-600">Verificacion de Respuestas</h5>
                                        <p class="pl-5 ml-2">Para asegurar la calidad, aqui puedes ver en el mapa donde se capturo cada opinion. Transparencia total.</p>
                                    </div>

                                    <div id="step5" class="guidance-step">
                                        <i class="la la-user-circle step-icon"></i>
                                        <h5 class="text-bold-600">Tu Perfil Personal</h5>
                                        <p class="pl-5 ml-2">En esta seccion puedes actualizar tu informacion, tu nombre, contacto y cambiar tu foto cuando quieras.</p>
                                    </div>
                                </div>

                                <button id="startButton" class="btn btn-primary btn-lg mt-4"><i class="la la-play-circle"></i> Iniciar Recorrido</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <footer class="footer footer-static footer-light navbar-border navbar-shadow">
        <div class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2"><span class="float-md-left d-block d-md-inline-block"><?= date('Y') ?> &copy; Copyright <a class="text-bold-800 grey darken-2" href="#">Vota y Opina</a></span>
        </div>
    </footer>

    <script src="<?= base_url(RECURSOS_CONTROLADOR_VENDORS . 'js/vendors.min.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_CONTROLADOR_JS . 'core/app-menu-lite.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_CONTROLADOR_JS . 'core/app-lite.js') ?>"></script>

    <script type="text/javascript">
    $(document).ready(function() {
        const userName = '<?= $nombreUsuario ?>';
        const aiMessageElement = $('#aiMessage');
        const startButton = $('#startButton');
        
        // Mensajes del recorrido, incluyendo los nuevos apartados
        const messages = {
            welcome: `Hola ${userName}. Soy tu guia. Exploremos juntos tu panel.`,
            step1: "Primero, en Graficas tienes el panorama general de tu operacion.",
            step2: "Ahora, en Usuarios, puedes administrar a todo tu equipo.",
            step3: "En Encuestas, tienes el control total de tus cuestionarios.",
            step4: "Despues, en Respuestas, verificas el trabajo de campo con mapas.",
            step5: "Por ultimo, en Perfil, mantienes tus datos personales al dia.",
            end: "Excelente. Ya conoces lo principal. Tienes el control total."
        };

        const steps = [
            { text: messages.step1, element: '#step1' },
            { text: messages.step2, element: '#step2' },
            { text: messages.step3, element: '#step3' },
            { text: messages.step4, element: '#step4' },
            { text: messages.step5, element: '#step5' }
        ];
        
        let currentStep = 0;
        let isTourRunning = false;

        function typeWriter(text, callback) {
            aiMessageElement.text('');
            aiMessageElement.removeClass('typing-animation').width(); // Forzar reinicio de animacion
            aiMessageElement.addClass('typing-animation');

            let i = 0;
            const speed = 40;

            function type() {
                if (i < text.length) {
                    aiMessageElement.text(aiMessageElement.text() + text.charAt(i));
                    i++;
                    setTimeout(type, speed);
                } else {
                    aiMessageElement.removeClass('typing-animation');
                    if (callback) {
                        setTimeout(callback, 500);
                    }
                }
            }
            type();
        }

        function startTour() {
            if (isTourRunning) return;
            isTourRunning = true;
            currentStep = 0;
            
            startButton.prop('disabled', true).html('<i class="la la-spinner la-spin"></i> En recorrido...');
            $('.guidance-step').removeClass('visible highlight');

            typeWriter(messages.welcome, nextStep);
        }

        function nextStep() {
            if (currentStep < steps.length) {
                const step = steps[currentStep];
                typeWriter(step.text, () => {
                    $('.guidance-step.highlight').removeClass('highlight');
                    const stepElement = $(step.element);
                    stepElement.addClass('visible highlight');
                    
                    currentStep++;
                    setTimeout(nextStep, 3500);
                });
            } else {
                typeWriter(messages.end, () => {
                    isTourRunning = false;
                    startButton.prop('disabled', false).html('<i class="la la-refresh"></i> Iniciar de Nuevo');
                    setTimeout(() => $('.guidance-step.highlight').removeClass('highlight'), 2000);
                });
            }
        }

        startButton.on('click', startTour);
        
        // Iniciar con el mensaje de bienvenida al cargar la pagina
        setTimeout(() => typeWriter(messages.welcome), 500);
    });
    </script>
</body>
</html>