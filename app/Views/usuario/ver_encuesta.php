<?php
    // Asegurar que la variable siempre exista
    $yaRespondida = isset($yaRespondida) ? $yaRespondida : false;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  	<meta name="csrf-token" content="<?= csrf_hash() ?>">

    <title><?= esc($encuesta['titulo']) ?></title>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,600,700,800,900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Oswald:300,400,500,600,700&display=swap" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  
  <!-- Css Styles -->
  <link rel="stylesheet" href="<?= base_url(RECURSOS_PUBLICOS_CSS . '/bootstrap.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url(RECURSOS_PUBLICOS_CSS . '/font-awesome.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url(RECURSOS_PUBLICOS_CSS . '/style.css') ?>">

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }

        /************************************
         * HEADER
         ************************************/
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

/* Ajustes para iconos de redes sociales */
.top-social {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 10px;
}

.top-social a {
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 10px;
    text-decoration: none;
}

.top-social img {
    width: 30px;
    height: auto;
    transition: transform 0.3s ease;
}

.top-social img:hover {
    transform: scale(1.2);
}


        /************************************
         * CONTENEDOR PRINCIPAL
         ************************************/
        .container {
            max-width: 750px;
            margin: 50px auto;
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            border: 2px solidrgb(74, 75, 75);  /* Contorno verde para destacar el formulario */
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .header {
            margin-bottom: 20px;
        }
        .header h2 {
            font-weight: 700;
            color: #343a40;
        }

        /************************************
         * IMAGEN DE ENCUESTA
         ************************************/
        .encuesta-img-container {
            text-align: center;
            margin-bottom: 25px;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
        }
        .encuesta-img {
            width: 400%;
            height: 400%;
            border-radius: 12px;
        }

        /************************************
         * PREGUNTAS
         ************************************/
        .preguntas-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
            text-align: left;
        }
        .pregunta-card {
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0px 2px 5px rgb(255, 0, 0);
            border: 1px dashedrgb(106, 103, 103); /* Borde estilo ‘dashed’ para resaltar */
        }
        .pregunta-card h4 {
            font-weight: 700;
            color:rgb(255, 0, 0); /* Color verde para resaltar el título */
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }
        .pregunta-card h4 i {
            margin-right: 10px;
        }

        /* Radio Buttons Personalizados */
        .form-check-input {
            cursor: pointer;
            accent-color:rgb(27, 104, 218); /* Para navegadores que soportan accent-color */
        }
        /* En caso de navegadores sin accent-color, forzamos CSS extra: */
        .form-check-input:checked {
            background-color: #28a745;
            border-color: #28a745;
        }
        .form-check-label {
            font-size: 16px;
            cursor: pointer;
            color: #333;
        }

        /************************************
         * BOTÓN DE ENVÍO
         ************************************/
        .btn-enviar {
            width: 100%;
            background: -webkit-linear-gradient(to right, rgba(0, 0, 0, 0.7), rgba(255, 0, 0, 0.7));  /* For Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to right, rgba(0, 0, 0, 0.7), rgba(255, 0, 0, 0.7));  /* For modern browsers */
            border: none;
            padding: 14px;
            font-size: 18px;
            border-radius: 8px;
            transition: 0.3s;
            color: white;
            font-weight: bold;
            margin-top: 20px;
        }
        .btn-enviar:hover {
            background: -webkit-linear-gradient(to right, rgba(255, 0, 0, 0.7), rgba(0, 0, 0, 0.7));  /* For Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to right, rgba(255, 0, 0, 0.7), rgba(0, 0, 0, 0.7));  /* For modern browsers */
            color: white;
        }

       
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
      background: linear-gradient(to right, rgba(0, 0, 0, 0.6), rgba(255, 0, 0, 0.6)), url("<?= site_url('recursos_publicos/img/carrucel/3.png') ?>");  /* For modern browsers */
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
<div class="container">
    <div class="header">
        <h2><i class="fas fa-poll"></i> <?= esc($encuesta['titulo']) ?></h2>
        <p class="text-muted"><?= esc($encuesta['descripcion']) ?></p>
    </div>

    <div class="encuesta-img-container">
        <img src="<?= base_url('public/img/encuestas/' . $encuesta['foto']) ?>"
             onerror="this.src='<?= base_url('public/img/encuestas/default.jpg') ?>'"
             alt="Encuesta" class="encuesta-img">
    </div>

    <?php if ($yaRespondida): ?>
    <div class="alert alert-info">
        <strong>✅ Ya has respondido esta encuesta.</strong> ¡Gracias por tu participación!
    </div>
<?php else: ?>
    <form id="encuestaForm">
        <?= csrf_field() ?> <input type="hidden" name="id_encuesta" value="<?= $encuesta['id_encuesta'] ?>">

        <div class="preguntas-container">
            <?php foreach ($preguntas as $pregunta) : ?>
                <div class="pregunta-card">
                    <h4><i class="fas"></i> <?= esc($pregunta['pregunta_texto']) ?></h4>

                    <?php if ($pregunta['tipo_respuesta'] === 'opcion_multiple'): ?>
                        <?php foreach ($pregunta['opciones'] as $opcion) : ?>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio"
                                       name="respuestas[<?= $pregunta['id_pregunta'] ?>]"
                                       value="<?= $opcion['id_opcion'] ?>"
                                       id="opcion<?= $opcion['id_opcion'] ?>" required>
                                <label class="form-check-label" for="opcion<?= $opcion['id_opcion'] ?>">
                                    <?= esc($opcion['opcion_texto']) ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    <?php elseif ($pregunta['tipo_respuesta'] === 'texto_libre'): ?>
                        <div class="form-group">
                            <textarea class="form-control"
                                      name="respuestas[<?= $pregunta['id_pregunta'] ?>]"
                                      placeholder="Escribe tu respuesta aquí..." required></textarea>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <button type="button" class="btn btn-primary btn-lg mt-4" onclick="enviarEncuestaConUbicacion()">
            <i class="fas "></i> Enviar Respuestas
        </button>
    </form>
<?php endif; ?>
</div>


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


<script>
    // Configuración de BASE_URL
    window.BASE_URL = '<?= rtrim(base_url(), '/') ?>/';
    console.log('URL base configurada:', window.BASE_URL);

    // Función para obtener el token CSRF
    function getCsrfToken() {
        const token = document.querySelector('input[name="csrf_test_name"]')?.value;
        if (!token) console.error('Token CSRF no encontrado en el formulario');
        return token;
    }

    // Función para actualizar el token CSRF
    function updateCsrfToken(newToken) {
        const csrfInput = document.querySelector('input[name="csrf_test_name"]');
        if (csrfInput) csrfInput.value = newToken;
    }

    // Función principal para enviar encuesta con ubicación
    async function enviarEncuestaConUbicacion() {
        try {
            const form = document.getElementById('encuestaForm');
            if (!form?.checkValidity()) {
                form.reportValidity();
                return;
            }

            // Deshabilitar botón de envío
            const submitButton = document.querySelector('.btn-enviar');
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Enviando...';
            }

            // Recopilar datos del formulario
            const id_encuesta = document.querySelector('input[name="id_encuesta"]').value;
            const respuestasFormulario = {};
            
            document.querySelectorAll('[name^="respuestas["]').forEach(input => {
                const id_pregunta = input.name.match(/\[(\d+)\]/)[1];
                if ((input.type === 'radio' || input.type === 'checkbox') && input.checked) {
                    respuestasFormulario[id_pregunta] = input.value;
                } else if (input.type !== 'radio' && input.type !== 'checkbox') {
                    respuestasFormulario[id_pregunta] = input.value;
                }
            });

            // Obtener ubicación si está disponible
            const datosUbicacion = await obtenerDatosUbicacion();
            
            // Preparar datos para enviar
            const datosParaEnviar = {
                id_encuesta: id_encuesta,
                respuestas: respuestasFormulario,
                ...datosUbicacion,
                csrf_test_name: getCsrfToken()
            };

            // Enviar datos al servidor
            await enviarDatosAlServidor(datosParaEnviar);

        } catch (error) {
            console.error('Error en enviarEncuestaConUbicacion:', error);
            alert('Ocurrió un error al procesar la encuesta. Por favor, inténtalo de nuevo.');
            
            const submitButton = document.querySelector('.btn-enviar');
            if (submitButton) {
                submitButton.disabled = false;
                submitButton.innerHTML = '<i class="fas fa-paper-plane"></i> Enviar Respuestas';
            }
        }
    }

    // Función mejorada para obtener datos de geolocalización con mapeo correcto
    async function obtenerDatosUbicacion() {
        if (!navigator.geolocation) {
            alert("Tu navegador no soporta geolocalización. La encuesta se enviará sin ubicación.");
            return datosUbicacionVacios();
        }

        try {
            const position = await new Promise((resolve, reject) => {
                navigator.geolocation.getCurrentPosition(resolve, reject, {
                    enableHighAccuracy: false,
                    timeout: 5000,
                    maximumAge: 0
                });
            });

            const { latitude: lat, longitude: lon } = position.coords;
            const apiKey = 'AIzaSyBvsuyTPXuwzUmkHdjiXtl5Wd0CmDEE5tA';
            const response = await fetch(`https://maps.googleapis.com/maps/api/geocode/json?latlng=${lat},${lon}&key=${apiKey}&language=es`);
            const data = await response.json();

            console.log('Respuesta completa de Google Maps:', data);

            if (data.status !== 'OK' || !data.results.length) {
                console.warn('Geocodificación fallida');
                return datosUbicacionVacios();
            }

            // Procesamiento especial para direcciones en Tlaxcala
            const direccionCompleta = data.results[0]?.formatted_address || '';
            if (direccionCompleta.includes('Tlaxcala') || direccionCompleta.includes('Tlax')) {
                return procesarDireccionTlaxcala(direccionCompleta);
            }

            // Procesamiento estándar para otras ubicaciones
            return procesarDireccionStandard(data.results[0].address_components);

        } catch (error) {
            console.error('Error al obtener ubicación:', error);
            alert("No se pudo registrar la ubicación. La encuesta se enviará sin ella.");
            return datosUbicacionVacios();
        }
    }

    // Función especial para procesar direcciones en Tlaxcala
    function procesarDireccionTlaxcala(direccionCompleta) {
        console.log('Procesando dirección de Tlaxcala:', direccionCompleta);
        
        // Estructura esperada: "Cerca de [calle], [colonia], [municipio], [estado]"
        const partes = direccionCompleta.split(',').map(parte => parte.trim());
        
        // Asignación según el formato específico de Tlaxcala
        let calle = partes[0].replace('Cerca de ', '');
        let colonia = '';
        let municipio = '';
        let estado = 'Tlaxcala';
        
        if (partes.length >= 3) {
            // El formato típico es: Calle, Colonia, Municipio
            colonia = partes[1];
            municipio = partes[2].replace(/\d+/g, '').trim(); // Eliminar código postal si existe
            
            // Caso especial cuando la colonia y municipio están combinados
            if (partes.length === 3 && partes[2].includes('Tlaxcala')) {
                municipio = partes[1];
                colonia = 'No especificada';
            }
        }
        
        // Ajuste final para el caso específico mostrado en la imagen
        if (direccionCompleta.includes('Santa María Tlacatecpa') && 
            direccionCompleta.includes('San José Aztatla')) {
            calle = partes[0].replace('Cerca de ', '');
            colonia = 'San José Aztatla';
            municipio = 'Santa María Tlacatecpa';
        }
        
        console.log('Dirección procesada para Tlaxcala:', { calle, colonia, municipio, estado });
        
        return {
            calle: calle || null,
            colonia: colonia || null,
            municipio: municipio || null,
            estado: estado || null,
            fecha_ubicacion: new Date().toISOString().slice(0, 19).replace('T', ' ')
        };
    }

    // Función para procesamiento estándar de direcciones
    function procesarDireccionStandard(addressComponents) {
        let calle = '', colonia = '', municipio = '', estado = '';
        
        addressComponents.forEach(component => {
            if (component.types.includes('route')) {
                calle = component.long_name;
            } else if (component.types.includes('neighborhood') || 
                      component.types.includes('sublocality_level_1')) {
                colonia = component.long_name;
            } else if (component.types.includes('locality')) {
                municipio = component.long_name;
            } else if (component.types.includes('administrative_area_level_1')) {
                estado = component.long_name;
            }
        });
        
        return {
            calle: calle || null,
            colonia: colonia || null,
            municipio: municipio || null,
            estado: estado || null,
            fecha_ubicacion: new Date().toISOString().slice(0, 19).replace('T', ' ')
        };
    }

    function datosUbicacionVacios() {
        return {
            calle: null,
            colonia: null,
            municipio: null,
            estado: null,
            fecha_ubicacion: null
        };
    }

    // Función para enviar datos al servidor
    async function enviarDatosAlServidor(data) {
        const urlCompleta = window.BASE_URL + 'encuesta/guardar_respuesta';
        console.log('Enviando datos a:', urlCompleta, data);

        try {
            const response = await $.ajax({
                url: urlCompleta,
                method: 'POST',
                data: data,
                dataType: 'json',
                timeout: 10000
            });

            if (response.status === 'success') {
    updateCsrfToken(response.token);

    Swal.fire({
        icon: 'success',
        title: '¡Encuesta enviada!',
        text: 'Tus respuestas han sido registradas exitosamente.',
        confirmButtonText: 'Aceptar',
        confirmButtonColor: '#28a745'
    }).then(() => {
        window.location.href = window.BASE_URL + 'encuestas-contestadasp';
    });

} else {
    throw new Error(response.message || 'Error desconocido del servidor');
}


        } catch (error) {
            console.error('Error en enviarDatosAlServidor:', error);
            alert('Error al enviar la encuesta. Por favor, inténtalo de nuevo.');
            
            const submitButton = document.querySelector('.btn-enviar');
            if (submitButton) {
                submitButton.disabled = false;
                submitButton.innerHTML = '<i class="fas fa-paper-plane"></i> Enviar Respuestas';
            }
        }
    }
</script>

  <!-- Js Plugins -->
  <script src="<?= base_url(RECURSOS_PUBLICOS_JS . '/jquery-3.3.1.min.js') ?>"></script>
  <script src="<?= base_url(RECURSOS_PUBLICOS_JS . '/bootstrap.min.js') ?>"></script>
</body>
</html>
