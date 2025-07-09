<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encuestas Disponibles</title>

    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,600,700,800,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Oswald:300,400,500,600,700&display=swap" rel="stylesheet">

    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="<?= base_url(RECURSOS_PUBLICOS_CSS . '/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url(RECURSOS_PUBLICOS_CSS . '/font-awesome.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url(RECURSOS_PUBLICOS_CSS . '/style.css') ?>">

    <style>
        /*************************************
        * Colores y Variables para el Menú Activo
        *************************************/
        :root {
            --menu-active-color: #FF0000; /* Color rojo para el menú activo */
            --menu-hover-color: #FF0000; /* Color rojo para hover, igual que el activo */
            --menu-text-color: white; /* Color del texto del menú */
        }

        /*************************************
        * Encabezado
        *************************************/
         .header-section {
      padding: 15px 0;
      text-align: center;
      color: white;
      margin-bottom: 30px;
    }
    .header-section .logo img {
      max-height: 80px;
      width: auto;
    }
    .nav-menu ul {
      list-style: none;
      padding: 0;
      margin: 0;
      display: flex;
      justify-content: center;
    }
    .nav-menu ul li {
      margin-right: 20px;
    }
    .nav-menu ul li a {
      color: white;
      text-decoration: none;
      font-weight: bold;
      font-size: 16px;
    }
    .nav-menu ul li a:hover {
      color: #f39c12;
    }
    

        /*************************************
        * Contenedor principal
        *************************************/
        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
        }

        /*************************************
        * Grid de encuestas
        *************************************/
        .encuestas-container {
            /* 3 columnas en pantallas grandes */
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            padding: 20px;
        }
        /* Responsivo: 2 columnas en pantallas medianas */
        @media (max-width: 992px) {
            .encuestas-container {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        /* Responsivo: 1 columna en pantallas pequeñas */
        @media (max-width: 576px) {
            .encuestas-container {
                grid-template-columns: 1fr;
            }
        }

        /*************************************
        * Tarjeta de encuesta
        *************************************/
        .encuesta-card {
            background: #fff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            box-shadow: 10px 10px 20px rgba(0, 0, 0, 0.3),
                                -10px -10px 20px rgba(255, 255, 255, 0.8);
            transition: transform 0.3s ease-in-out;
            position: relative;
        }
        .encuesta-card:hover {
            transform: translateY(-5px);
        }

        /*************************************
        * Imagen de la encuesta
        *************************************/
        .encuesta-img {
            width: 100%;
            height: 250px;       /* Mantén altura fija para uniformidad */
            object-fit: contain; /* Muestra la imagen completa sin recortar */
            border-bottom: 3px solid #FF0000;
            background: #fff;    /* Fondo blanco para que se vea relleno si sobra espacio */
        }

        /*************************************
        * Contenido de la encuesta
        *************************************/
        .encuesta-content {
            padding: 15px;
            text-align: center;
        }
        .encuesta-content h3 {
            margin: 10px 0;
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }
        .encuesta-content p {
            font-size: 14px;
            color: #666;
        }
        .btn-ver {
            display: inline-block;
            background: -webkit-linear-gradient(to right, rgba(0, 0, 0, 0.7), rgba(255, 0, 0, 0.7));  /* For Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to right, rgba(0, 0, 0, 0.7), rgba(255, 0, 0, 0.7));  /* For modern browsers */
            padding: 10px 15px;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 10px;
        }
        .btn-ver:hover {
            background: -webkit-linear-gradient(to right, rgba(255, 0, 0, 0.7), rgba(0, 0, 0, 0.7));  /* For Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to right, rgba(255, 0, 0, 0.7), rgba(0, 0, 0, 0.7));  /* For modern browsers */
        }

        /*************************************
        * Footer
        *************************************/
        :root {
            --footer-bg-dark: #000000; /* Fondo negro puro */
            --footer-text-light: #ecf0f1; /* Texto claro para contraste (gris muy claro) */
            --footer-heading-color: #e74c3c; /* Rojo primario para los encabezados */
            --footer-link-hover: #ffffff; /* Blanco puro para enlaces al pasar el ratón */
            --social-icon-box-bg: #333333; /* Fondo para el cuadrado de los iconos (gris oscuro) */
            --social-icon-color: #ecf0f1; /* Color del icono dentro del cuadrado */
            --social-icon-hover-bg: #e74c3c; /* Rojo primario para pasar el ratón por el cuadrado */
            --transition-speed: 0.3s; /* Velocidad de transición para efectos de pasar el ratón */
        }

        /* --- Sección Principal del Pie de Página (Footer) --- */
        .main-footer {
            background-color: var(--footer-bg-dark); /* Fondo negro */
            color: var(--footer-text-light); /* Texto claro */
            padding: 60px 20px; /* Relleno generoso arriba/abajo, y lateral */
            font-family: 'Nunito Sans', sans-serif; /* Consistencia con una fuente legible */
            /* La línea de acento roja superior si la quieres, de lo contrario, elimínala */
            border-top: 5px solid var(--footer-heading-color);
            position: relative;
            z-index: 5;
        }

        /* Contenedor de Contenido para Grid/Flex */
        .footer-content-wrapper {
            max-width: 1200px; /* Limita el ancho del contenido para mejor lectura */
            margin: 0 auto; /* Centra el contenedor */
            display: grid;
            /* Adapta el grid para 4 columnas en pantallas grandes. Ajustado para que la primera y última columna sean un poco más anchas. */
            grid-template-columns: 2fr 1fr 1fr 2fr;
            gap: 40px; /* Espacio entre las columnas */
            text-align: left; /* Alinea el texto a la izquierda dentro de cada columna */
        }

        /* --- Estilos de las Columnas del Pie de Página --- */
        .footer-column {
            padding: 0 10px; /* Pequeño relleno interno para las columnas */
        }

        .footer-heading {
            font-family: 'Oswald', sans-serif; /* Fuente llamativa para los títulos */
            font-size: 1.6rem; /* Tamaño de título adecuado */
            color: var(--footer-text-light); /* Color del título ahora es claro como en la imagen */
            margin-bottom: 25px; /* Espacio debajo del título */
            position: relative;
            padding-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: bold; /* Los títulos en la imagen se ven más gruesos */
        }

        .footer-text {
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 15px; /* Espacio entre párrafos */
            opacity: 0.9; /* Ligeramente transparente para suavidad */
        }

        .copyright {
            margin-top: 30px; /* Espacio generoso para el copyright */
            font-size: 0.85rem;
            opacity: 0.7;
            text-align: left; /* Asegura que el copyright se alinee a la izquierda con el texto "Sobre Nosotros" */
        }

        /* --- Enlaces Rápidos --- */
        .footer-links {
            list-style: none; /* Elimina los puntos de lista */
            padding: 0;
            margin: 0;
        }

        .footer-links li {
            margin-bottom: 10px; /* Espacio entre cada enlace */
        }

        .footer-link {
            color: var(--footer-text-light);
            text-decoration: none;
            font-size: 1rem;
            transition: color var(--transition-speed) ease-in-out, transform var(--transition-speed) ease-in-out;
            display: inline-block; /* Para que la transformación funcione */
        }

        .footer-link:hover {
            color: var(--footer-link-hover);
            transform: translateX(5px); /* Desliza el enlace un poco a la derecha */
        }

        .footer-link-email {
            color: var(--footer-text-light);
            text-decoration: none;
            transition: color var(--transition-speed) ease-in-out;
        }

        .footer-link-email:hover {
            color: var(--footer-link-hover);
            text-decoration: underline;
        }

        /* --- Iconos de Redes Sociales --- */
        .social-icons {
            display: flex;
            gap: 15px; /* Espacio entre los iconos */
            margin-top: 20px;
        }

        .social-icon {
            width: 45px; /* Tamaño fijo para los iconos */
            height: 45px;
            border-radius: 8px; /* Bordes ligeramente redondeados como en la imagen */
            background-color: var(--social-icon-box-bg); /* Fondo del cuadrado */
            color: var(--social-icon-color); /* Color del icono */
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 1.2rem; /* Tamaño del icono */
            text-decoration: none;
            transition: background-color var(--transition-speed) ease-in-out,
                            transform var(--transition-speed) ease-in-out,
                            box-shadow var(--transition-speed) ease-in-out;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Sombra sutil para profundidad */
        }

        .social-icon:hover {
            background-color: var(--social-icon-hover-bg); /* Cambia a rojo al pasar el ratón */
            transform: translateY(-3px) scale(1.05); /* Efecto de "flotar" y crecer */
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3); /* Sombra más pronunciada al pasar el ratón */
        }


        /* --- Información de Contacto --- */
        .contact-info .footer-text {
            display: flex; /* Para alinear el icono y el texto */
            align-items: flex-start; /* Alinea los ítems en la parte superior */
            gap: 10px; /* Espacio entre el icono y el texto */
            margin-bottom: 12px;
        }

        .contact-info .footer-text i {
            font-size: 1.1rem; /* Tamaño de los iconos de contacto */
            color: var(--footer-text-light); /* Color de los iconos de contacto como el texto general */
            flex-shrink: 0; /* Evita que el icono se encoja */
            margin-top: 3px; /* Pequeño ajuste para la alineación visual */
        }

        /* --- Media Queries para Responsividad --- */
        @media (max-width: 992px) { /* Ajustado para que en tabletas ya se apilen */
            .footer-content-wrapper {
                grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); /* 2 columnas o 1 */
                gap: 30px;
            }
        }

        @media (max-width: 768px) {
            .footer-content-wrapper {
                grid-template-columns: 1fr; /* Una sola columna en pantallas medianas y pequeñas */
                text-align: center; /* Centra el texto en móviles */
                gap: 30px; /* Menos espacio entre secciones */
            }

            .footer-heading {
                margin-bottom: 20px;
                font-size: 1.5rem;
            }

            /* El subrayado del título ahora está centrado si lo usas */
            .footer-heading::after {
                left: 50%;
                transform: translateX(-50%);
            }

            .social-icons {
                justify-content: center; /* Centra los iconos en móviles */
                margin-top: 15px;
            }

            .contact-info .footer-text {
                justify-content: center; /* Centra el contenido de contacto */
            }
        }

        @media (max-width: 480px) {
            .main-footer {
                padding: 40px 15px;
            }
            .footer-heading {
                font-size: 1.4rem;
            }
            .footer-text,
            .footer-link {
                font-size: 0.9rem;
            }
            .social-icon {
                width: 25px; /* Ajusta el tamaño según sea necesario */
                height: auto;
                margin: 0 2px;
                transition: transform 0.3s ease;
            }
            .copyright {
                margin-top: 20px;
                font-size: 0.8rem;
            }
        }

        header {
            width: 99vw;
            height: 35vh;
            background: #000000;  /* Fallback for old browsers */
            background: -webkit-linear-gradient(to right, rgba(0, 0, 0, 0.6), rgba(255, 0, 0, 0.6));  /* For Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to right, rgba(0, 0, 0, 0.6), rgba(255, 0, 0, 0.6)), url(recursos_publicos/img/carrucel/3.png);  /* For modern browsers */
            background-size: cover;
            background-attachment: fixed;
            position: relative;
        }

        .wive{
            position: absolute;
            bottom: 0;
            width: 99vw;
        }
        
        .header-section .logo img {
            max-height: 80px;
            width: auto;
        }

        a {
            font-style: none;
            color: white;
        }
    </style>
</head>

<body>

    <header class="header-section">
        <br>
        <div class="container-fluid">
            <div class="logo">
                <a href="<?= base_url('home') ?>">
                    <img src="<?= base_url('recursos_publicos/img/mon.png') ?>" alt="Logo">
                </a>
            </div>
            <div class="nav-menu">
                <nav class="mainmenu mobile-menu">
                    <ul>
                         <li><a href="<?= base_url('home') ?>">Home</a></li>
                            <li><a href="<?= base_url('encuestasp') ?>">Encuestas</a></li>
                            <li><a href="<?= base_url('encuestas-contestadasp') ?>">Encuestas Contestadas</a></li>
                            <li><a href="<?= base_url('comunidad') ?>">Comunidad</a></li>
                            <li><a href="<?= base_url('nosotrosp') ?>">Nosotros</a></li>
                            <li><a href="<?= base_url('perfilp') ?>">Perfil</a></li>
                            <li><a href="<?= base_url('login') ?>">Cerrar Sesión</a></li>
                    </ul>
                </nav>
            </div>
            </div>       
        <div class="wive" style="height: 150px; overflow: hidden;" ><svg viewBox="0 0 500 150" preserveAspectRatio="none" style="height: 100%; width: 100%;"><path d="M0.00,50.10 C150.00,150.33 349.20,-50.10 500.00,50.10 L500.00,150.33 L0.00,150.33 Z" style="stroke: none; fill: #fff;"></path></svg></div>
    </header>
    <br><br><br><br><br><br><br><br><br><br>
    <div class="container">
        <h2 style="text-align: center; color: #333;">Encuestas Disponibles</h2>

        <div class="encuestas-container">
            <?php if (!empty($encuestas)) : ?>
                <?php foreach ($encuestas as $encuesta) : ?>
                    <div class="encuesta-card">
                        <img 
                            src="<?= base_url('public/img/encuestas/' . $encuesta['foto']) ?>" 
                            onerror="this.src='<?= base_url('public/img/encuestas/default.jpg') ?>'"
                            alt="Encuesta"
                            class="encuesta-img"
                        >
                        <div class="encuesta-content">
                            <h3><?= esc($encuesta['titulo']) ?></h3>
                            <p><?= esc($encuesta['descripcion']) ?></p>
                            <a href="<?= base_url('encuesta/detalle/' . $encuesta['id_encuesta']) ?>" class="btn-ver">Ver Encuesta</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p style="text-align: center;">No hay encuestas disponibles en este momento.</p>
            <?php endif; ?>
        </div>
    </div>

    <br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <footer class="main-footer">
        <div class="footer-content-wrapper">
            <div class="footer-column about-us">
                <h3 class="footer-heading">Sobre Nosotros</h3>
                <p class="footer-text">Monitor Encuestal es tu fuente confiable para análisis profundos y datos precisos sobre encuestas y opinión pública. Nos dedicamos a ofrecer información clara y contextualizada para una comprensión informada de la sociedad.</p>
                <div class="copyright">
                    <p>&copy; <span id="currentYear"></span> Monitor Encuestal | Todos los derechos reservados</p>
                </div>
            </div>

            <div class="footer-column quick-links">
                <h3 class="footer-heading">Enlaces Rápidos</h3>
                <ul class="footer-links">
                    <li><a href="<?= base_url('home') ?>">Inicio</a></li>
                    <li><a href="<?= base_url('encuestasp') ?>">Encuestas</a></li>
                    <li><a href="<?= base_url('nosotrosp') ?>">Nosotros</a></li>
                </ul>
            </div>

            <div class="footer-column social-media">
                <h3 class="footer-heading">Síguenos</h3>
                <div class="social-icons">
                    <a href="https://www.instagram.com/grupomonitorcom/">
                        <img src="<?= base_url('recursos_publicos/img/icon/4.png') ?>" alt="Instagram" class="social-icon">
                    </a>
                    <a href="https://x.com/GrupoMonitorCom">
                        <img src="<?= base_url('recursos_publicos/img/icon/3.png') ?>" alt="X" class="social-icon">
                    </a>
                    <a href="https://www.facebook.com/GrupoMonitorCom">
                        <img src="<?= base_url('recursos_publicos/img/icon/5.png') ?>" alt="Facebook" class="social-icon">
                    </a>
                </div>
            </div>

            <div class="footer-column contact-info">
                <h3 class="footer-heading">Contáctanos</h3>
                <p class="footer-text"><i class="fas fa-map-marker-alt"></i> Calle Allende 61, Centro, Ciudad de Tlaxcala, Tlax. México.</p>
                <p class="footer-text"><i class="fas fa-phone-alt"></i> 246 466 1050 / 246 113 6333</p>
                <p class="footer-text"><a href="mailto:grupomonitornacional@gmail.com" class="footer-link-email">grupomonitornacional@gmail.com</a></p>
                <p class="footer-text"><i class="fas fa-clock"></i> Lun-Vie: 10:00 – 18:00</p>
                <p class="footer-text">Cerrado los días feriados</p>
            </div>
        </div>
    </footer>
    <script src="<?= base_url(RECURSOS_PUBLICOS_JS . '/jquery-3.3.1.min.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_PUBLICOS_JS . '/bootstrap.min.js') ?>"></script>
    <script>
        // Script para establecer el año actual en el copyright del footer
        document.getElementById('currentYear').textContent = new Date().getFullYear();
    </script>
</body>
</html>