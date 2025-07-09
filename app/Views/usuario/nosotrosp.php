<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Activitar Template">
    <meta name="keywords" content="Activitar, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nosotros</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,600,700,800,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Oswald:300,400,500,600,700&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="<?= base_url(RECURSOS_PUBLICOS_CSS . '/bootstrap.min.css') ?>" type="text/css">
    <link rel="stylesheet" href="<?= base_url(RECURSOS_PUBLICOS_CSS . '/font-awesome.min.css') ?>" type="text/css">
    <link rel="stylesheet" href="<?= base_url(RECURSOS_PUBLICOS_CSS . '/elegant-icons.css') ?>" type="text/css">
    <link rel="stylesheet" href="<?= base_url(RECURSOS_PUBLICOS_CSS . '/nice-select.css') ?>" type="text/css">
    <link rel="stylesheet" href="<?= base_url(RECURSOS_PUBLICOS_CSS . '/owl.carousel.min.css') ?>" type="text/css">
    <link rel="stylesheet" href="<?= base_url(RECURSOS_PUBLICOS_CSS . '/magnific-popup.css') ?>" type="text/css">
    <link rel="stylesheet" href="<?= base_url(RECURSOS_PUBLICOS_CSS . '/slicknav.min.css') ?>" type="text/css">
    <link rel="stylesheet" href="<?= base_url(RECURSOS_PUBLICOS_CSS . '/style.css') ?>" type="text/css">

    <style>

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
      color: #FF0000;
    }
    .top-social a {
      color: white;
      font-size: 18px;
      margin-left: 15px;
    }

        /* Estilo del footer */
        
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

        .header {
            width: 100%;
            height: 400px; /* Ajusta la altura según lo necesites */
            background-size: cover;
            background-position: center;
            transition: background-image 1s ease-in-out;
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

        a{
            font-style: none;
            color: white;
        }

    </style>
</head>

<body>
    
	<!--Cabecera-->
	<header class="header-section">
  </br>
    <!--Menú-->	 
    <div class="container-fluid">
            <!-- Logo -->
            <div class="logo">
                <a href="<?= base_url('home') ?>">
                    <img src="<?= base_url('recursos_publicos/img/mon.png') ?>" alt="Logo">
                </a>
            </div>
            <!-- Menú de navegación -->
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
            <!-- Redes sociales -->
           
        </div>			
			<div class="wive" style="height: 150px; overflow: hidden;" ><svg viewBox="0 0 500 150" preserveAspectRatio="none" style="height: 100%; width: 100%;"><path d="M0.00,50.10 C150.00,150.33 349.20,-50.10 500.00,50.10 L500.00,150.33 L0.00,150.33 Z" style="stroke: none; fill: #fff;"></path></svg></div>
	</header>
  </br></br></br></br></br></br></br></br></br></br>
    <!-- Header End -->

    <div class="background"></div>
    <div class="sobre-grupo-monitor" style="padding: 40px; margin: 40px auto; color: black; max-width: 1200px; text-align: justify;">
  <h2 style="margin-bottom: 20px; color: black;">Grupo Monitor</h2>
  <p style="margin-bottom: 25px; line-height: 1.8; color: black;">
    Somos una empresa digital dedicada a la producción de contenidos multimedia e 
    informativos, con una visión crítica y analítica de la realidad social. Estudiamos 
    el comportamiento de las redes sociales y la mercadotecnia para conectar mejor con 
    nuestras audiencias, buscando siempre innovar en la forma de informar y entretener.
  </p>
  <p style="margin-bottom: 25px; line-height: 1.8; color: black;">
    En Grupo Monitor creemos que el conocimiento es un canal esencial de expresión 
    social y defendemos la idea de que la libertad solo se consigue al comprender lo 
    que sucede a nuestro alrededor. Por ello, nos enfocamos en la crítica, la 
    contextualización, el estudio de antecedentes y la proyección de los hechos, 
    brindando a la sociedad una lectura más amplia y profunda de los sucesos.
  </p>
</div>


    <!-- Gallery Section Begin -->
    <section class="gallery-section spad" style="background-color:#ffffff;">
        <div class="container">
            <div class="row gallery-filter">
                <div class="col-lg-4 col-sm-6 mix crossfit workout">
                    <div class="gallery-item">
                        <img style="box-shadow: 10px 10px 20px rgba(0, 0, 0, 0.3),
                        -10px -10px 20px rgba(255, 255, 255, 0.8);" src="recursos_publicos/img/gallery/8.png" alt="">
                        <div class="gi-hover-warp">
                            <div class="gi-hover">
                                <a href="recursos_publicos/img/gallery/8.png" class="image-popup"><i class="fa fa-search-plus"></i></a>
                                <a href="#"><i class="fa fa-chain"></i></a>
                                <h6>Responde en 1 Minuto<span>Tu participación puede cambiar el rumbo.</span></h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 mix workout gym">
                    <div class="gallery-item">
                        <img style="box-shadow: 10px 10px 20px rgba(0, 0, 0, 0.3),
                        -10px -10px 20px rgba(255, 255, 255, 0.8);" src="recursos_publicos/img/gallery/9.png" alt="">
                        <div class="gi-hover-warp">
                            <div class="gi-hover">
                                <a href="recursos_publicos/img/gallery/9.png" class="image-popup"><i class="fa fa-search-plus"></i></a>
                                <a href="#"><i class="fa fa-chain"></i></a>
                                <h6>Tu Opinión Cuenta <span>Participa y ayuda a mejorar decisiones.</span></h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 mix workout">
                    <div class="gallery-item">
                        <img style="box-shadow: 10px 10px 20px rgba(0, 0, 0, 0.3),
                        -10px -10px 20px rgba(255, 255, 255, 0.8);" src="recursos_publicos/img/gallery/10.png" alt="">
                        <div class="gi-hover-warp">
                            <div class="gi-hover">
                                <a href="recursos_publicos/img/gallery/10.png" class="image-popup"><i class="fa fa-search-plus"></i></a>
                                <a href="#"><i class="fa fa-chain"></i></a>
                                <h6>Encuestas Rápidas <span>Responde en minutos y marca la diferencia.</span></h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 mix gym">
                    <div class="gallery-item">
                        <img style="box-shadow: 10px 10px 20px rgba(0, 0, 0, 0.3),
                        -10px -10px 20px rgba(255, 255, 255, 0.8);" src="recursos_publicos/img/gallery/11.png" alt="">
                        <div class="gi-hover-warp">
                            <div class="gi-hover">
                                <a href="recursos_publicos/img/gallery/11.png" class="image-popup"><i
                                        class="fa fa-search-plus"></i></a>
                                <a href="#"><i class="fa fa-chain"></i></a>
                                <h6>Hazte Escuchar <span>Tu voz es clave para entender tendencias.</span></h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 mix crossfit">
                    <div class="gallery-item">
                        <img style="box-shadow: 10px 10px 20px rgba(0, 0, 0, 0.3),
                        -10px -10px 20px rgba(255, 255, 255, 0.8);" src="recursos_publicos/img/gallery/12.png" alt="">
                        <div class="gi-hover-warp">
                            <div class="gi-hover">
                                <a href="recursos_publicos/img/gallery/12.png" class="image-popup"><i class="fa fa-search-plus"></i></a>
                                <a href="#"><i class="fa fa-chain"></i></a>
                                <h6>Decisiones Inteligentes <span>Las encuestas nos guían hacia mejores opciones.</span></h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 mix gym crossfit">
                    <div class="gallery-item">
                        <img style="box-shadow: 10px 10px 20px rgba(0, 0, 0, 0.3),
                        -10px -10px 20px rgba(255, 255, 255, 0.8);" src="recursos_publicos/img/gallery/13.png" alt="">
                        <div class="gi-hover-warp">
                            <div class="gi-hover">
                                <a href="recursos_publicos/img/gallery/13.png" class="image-popup"><i
                                        class="fa fa-search-plus"></i></a>
                                <a href="#"><i class="fa fa-chain"></i></a>
                                <h6>Suma Tu Voto<span>Responde y comparte tu perspectiva.</span></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Gallery Section End -->
  



<div class="row" style="max-width: 1200px; margin: 0 auto; padding: 40px;">
    <!-- Información de contacto -->
    <div class="col-md-6 contact-info" style="color: black; padding: 20px;">
        <p style="margin-bottom: 25px; line-height: 1.8; color: black;"><strong>Dirección:</strong><br>
            Calle Allende 61, Centro, Ciudad de Tlaxcala, Tlax., México.
        </p>

        <p style="margin-bottom: 25px; line-height: 1.8; color: black;"><strong>Tels:</strong> 246 466 1050 / 246 113 6333</p>

        <p style="margin-bottom: 25px; line-height: 1.8; color: black;"><strong>Email:</strong> grupomonitornacional@gmail.com</p>

        <p style="margin-bottom: 25px; line-height: 1.8; color: black;"><strong>Horarios:</strong></p>
        <p style="margin-bottom: 25px; line-height: 1.8; color: black;">Lun-Vie: 10:00 – 18:00<br>
            Cerrado los días feriados
        </p>
    </div>

    <!-- Mapa -->
    <div class="col-md-6">
        <div class="map-area" style="width: 100%; height: 100%;">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7530.4523711112315!2d-98.241838!3d19.315989!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85cfd93e12d9cdeb%3A0x7107539d6899263b!2sGrupo%20Monitor!5e0!3m2!1ses-419!2sus!4v1741217713910!5m2!1ses-419!2sus" 
                style="width: 100%; height: 350px; border: 0; border-radius: 10px;" 
                allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </div>
</div>



    <!-- Footer Section Begin -->
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
    <div class="social-icons"> <a href="https://www.instagram.com/grupomonitorcom/">
            <img src="<?= base_url('recursos_publicos/img/icon/4.png') ?>" alt="Instagram" class="social-icon"> </a>
       
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Js Plugins -->
    <script src="<?= base_url(RECURSOS_PUBLICOS_JS . '/jquery-3.3.1.min.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_PUBLICOS_JS . '/bootstrap.min.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_PUBLICOS_JS . '/jquery.magnific-popup.min.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_PUBLICOS_JS . '/mixitup.min.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_PUBLICOS_JS . '/jquery.nice-select.min.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_PUBLICOS_JS . '/jquery.slicknav.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_PUBLICOS_JS . '/owl.carousel.min.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_PUBLICOS_JS . '/masonry.pkgd.min.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_PUBLICOS_JS . '/main.js') ?>"></script>
</body>

</html>
