<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>

    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,600,700,800,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Oswald:300,400,500,600,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?= base_url(RECURSOS_PUBLICOS_CSS . '/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40NZjgDOxwxtcOpC+LsECAzXv6dAyj+kss6FzT0L+rW4R8K9Y32/hA/C6c9t5J5sE/2x/c9c9cQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?= base_url(RECURSOS_PUBLICOS_CSS . '/style.css') ?>">
    <style>
        body {
            font-family: 'Nunito Sans', sans-serif;
        }

        /* ENCABEZADO */
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

        /* CONTENEDOR DEL PERFIL */
        .profile-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .profile-card {
            width: 700px;
            padding: 10px;
            background: white; /* Fondo blanco */
            border: none;
            border-radius: 15px;
            text-align: center;
        }

        /* Contenedor de la imagen */
        .profile-image-container {
            text-align: center;
            margin-bottom: 20px;
            position: relative;
            width: 250px; /* Asegura que el contenedor tenga el mismo tamaño que la imagen */
            height: 250px;
            margin: 0 auto 20px auto; /* Centra el contenedor */
        }

        /* Imagen de perfil */
        .profile-img {
            width: 100%;
            height: 100%;
            border-radius: 50%; /* Hace que la imagen sea circular */
            object-fit: cover;  /* Ajusta la imagen sin deformarla */
            transition: 0.3s ease-in-out;
            display: block; /* Elimina espacios extra debajo de la imagen */
        }

        /* Overlay para la imagen de perfil */
        .profile-image-container .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6); /* Fondo semi-transparente oscuro */
            border-radius: 50%; /* Igual que la imagen para que coincida */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            font-size: 1.2em;
            font-weight: bold;
            opacity: 0; /* Oculto por defecto */
            transition: opacity 0.3s ease-in-out;
            cursor: pointer;
            text-align: center;
        }

        .profile-image-container .overlay i {
            font-size: 2.5em; /* Tamaño del icono */
            margin-bottom: 10px;
        }

        /* Efecto al pasar el mouse en modo edición */
        .profile-image-container.editable-mode .overlay {
            opacity: 1; /* Siempre visible en modo edición */
        }

        .profile-image-container.editable-mode .profile-img:hover {
            opacity: 0.8; /* Se puede mantener un efecto sutil en la imagen si se desea */
        }

        /* Input file oculto (solo aparece en modo edición si se activa su visibilidad) */
        #fotoInput {
            display: none;
        }

        /* ENCABEZADO DEL PERFIL */
        .profile-header {
            background: linear-gradient(to right, rgb(199, 11, 11),rgb(43, 42, 42));
            padding: 15px;
            border-radius: 10px;
            font-size: 18px;
            font-weight: bold;
            color: white;
            margin-bottom: 15px;
            text-shadow: 0 0 8px rgba(255, 0, 0, 0.8);
        }

        /* FORMULARIO DE PERFIL */
        .profile-details {
            background: white; /* Fondo blanco */
            padding: 15px;
            border-radius: 10px;
            text-align: left;
        }

        /* NOMBRES DE LOS CAMPOS */
        .profile-details strong {
            color: red; /* Rojo brillante */
            font-weight: bold;
        }

        /* DATOS DEL USUARIO */
        .profile-details p {
            color: black; /* Texto en negro */
            font-size: 16px;
            margin: 5px 0;
        }

        /* CAMPOS DE ENTRADA */
        .editable {
            width: 100%;
            background: white; /* Fondo blanco */
            color: black;      /* Texto negro */
            border: none;
            padding: 5px;
            text-align: center;
            font-size: 16px;
            transition: all 0.3s ease-in-out;
            border-radius: 5px;
        }
        /* CUANDO SE ACTIVA LA EDICIÓN */
        .editable:enabled {
            background: white !important;
            color: black !important;
            border: 1px solid red;
            box-shadow: 0 0 8px red;
        }

        /* Estilo para los select que también son 'editable' */
        .editable.form-control-select {
            -webkit-appearance: none; /* Elimina estilos por defecto de navegador */
            -moz-appearance: none;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3E%3Cpath fill='none' stroke='%23333' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 16px 12px;
            padding-right: 2.5rem;
            line-height: 1.5;
            height: auto;
        }


        /* BOTONES */
        .btn-warning {
            background: red;
            color: black;
            font-weight: bold;
            width: 100%;
            margin-top: 10px;
        }

        .btn-success {
            background: green;
            color: white;
            font-weight: bold;
            width: 100%;
            margin-top: 10px;
        }

        /* --- Variables CSS (Asegúrate de que estas coincidan con tus variables globales) --- */
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
            background: #000000;  /* Fallback para navegadores antiguos */
            background: -webkit-linear-gradient(to right, rgba(0, 0, 0, 0.6), rgba(255, 0, 0, 0.6));  
            background: linear-gradient(to right, rgba(0, 0, 0, 0.6), rgba(255, 0, 0, 0.6)), 
                        url(recursos_publicos/img/carrucel/3.png);
            background-size: cover;
            background-attachment: fixed;
            position: relative;
        }

        .wive {
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
    <header class="header-section">
        </br>
        <div class="container-fluid">
            <div class="logo">
                <a href="<?= base_url('home') ?>">
                    <img src="<?= base_url('recursos_publicos/img/monitor.png') ?>" alt="Logo">
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
        <div class="wive" style="height: 150px; overflow: hidden;">
            <svg viewBox="0 0 500 150" preserveAspectRatio="none" 
                style="height: 100%; width: 100%;">
                <path d="M0.00,50.10 C150.00,150.33 349.20,-50.10 
                                500.00,50.10 L500.00,150.33 L0.00,150.33 Z" 
                                style="stroke: none; fill: #fff;">
                </path>
            </svg>
        </div>
    </header>
    </br></br></br></br></br></br></br></br><br><br><br><br><br><br><br><br><br><br>

    <div class="profile-container">
    <?php
        $nombre = $usuario['nombre'] ?? 'No disponible';
        $apellido_paterno = $usuario['apellido_paterno'] ?? 'No disponible';
        $apellido_materno = $usuario['apellido_materno'] ?? 'No disponible';
        $telefono = $usuario['telefono'] ?? 'No registrado';
        $fecha_nacimiento = $usuario['fecha_nacimiento'] ?? 'No registrada';
        $correo = $usuario['correo'] ?? 'No disponible';
        $foto = !empty($usuario['foto']) 
                                ? base_url('public/img_user/' . $usuario['foto']) 
                                : base_url('public/img_user/default.png');
        
        // Atributos de estado, municipio y SECCION pasados desde el controlador
        $id_estado_actual = $usuario['id_estado'] ?? '';
        $id_municipio_actual = $usuario['id_municipio'] ?? '';
        $id_seccion_actual = $usuario['id_seccion'] ?? ''; // <--- NUEVO: ID de la sección actual
        
        $nombre_estado_actual = $nombre_estado ?? 'No disponible';
        $nombre_municipio_actual = $nombre_municipio ?? 'No disponible';
        $nombre_seccion_actual = $nombre_seccion ?? 'No disponible'; // <--- NUEVO: Nombre de la sección actual
    ?>

    <div class="profile-card">
        <div class="profile-header">
            <h2 style="color:white;">
                <?= strtoupper($nombre . ' ' . $apellido_paterno . ' ' . $apellido_materno) ?>
            </h2>
            <p style="color:white;" class="email">
                <?= $correo ?>
            </p>
        </div>

        <form id="editProfileForm" enctype="multipart/form-data">
            <div class="profile-image-container">
                <label for="fotoInput">
                    <img class="profile-img" id="previewImage" 
                                src="<?= $foto ?>" alt="Foto de Perfil">
                    <div class="overlay" id="imageOverlay">
                        <i class="fas fa-camera"></i>
                        <span>Cambiar Foto</span>
                    </div>
                </label>
                <input type="file" id="fotoInput" name="foto" accept="image/*" style="display: none;">
            </div>

            <div class="profile-details">
                <p><strong>Nombre:</strong>
                    <input type="text" id="nombre" name="nombre" 
                                value="<?= esc($nombre) ?>" 
                                class="editable" disabled>
                </p>
                <p><strong>Apellido Paterno:</strong>
                    <input type="text" id="apellido_paterno" 
                                name="apellido_paterno" 
                                value="<?= esc($apellido_paterno) ?>" 
                                class="editable" disabled>
                </p>
                <p><strong>Apellido Materno:</strong>
                    <input type="text" id="apellido_materno" 
                                name="apellido_materno" 
                                value="<?= esc($apellido_materno) ?>" 
                                class="editable" disabled>
                </p>
                <p><strong>Teléfono:</strong>
                    <input type="text" id="telefono" 
                                name="telefono" 
                                value="<?= esc($telefono) ?>" 
                                class="editable" disabled>
                </p>
                <p><strong>Fecha de Nacimiento:</strong>
                    <input type="date" id="fecha_nacimiento" 
                                name="fecha_nacimiento" 
                                value="<?= esc($fecha_nacimiento) ?>" 
                                class="editable" disabled>
                </p>
                <p><strong>Correo:</strong>
                    <input type="text" id="correo" 
                                name="correo" 
                                value="<?= esc($correo) ?>" 
                                class="editable" disabled>
                </p>
                <p><strong>Contraseña:</strong>
                    <input type="password" id="new_password" 
                                name="new_password" 
                                class="editable" disabled 
                                placeholder="*******">
                </p>

                <p><strong>Estado:</strong>
                    <select class="editable form-control-select" id="id_estado" name="id_estado" disabled required>
                        <option value="">-- Selecciona un Estado --</option>
                        <?php if (isset($estados) && is_array($estados)): ?>
                            <?php foreach ($estados as $estado): ?>
                                <option value="<?= esc($estado['id_estado']) ?>"
                                    <?= ($id_estado_actual == $estado['id_estado']) ? 'selected' : '' ?>>
                                    <?= esc($estado['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </p>

                <p><strong>Municipio:</strong>
                    <select class="editable form-control-select" id="id_municipio" name="id_municipio" disabled required>
                        <option value="">-- Selecciona un Municipio --</option>
                        <?php if (!empty($id_estado_actual) && !empty($id_municipio_actual)): ?>
                            <option value="<?= esc($id_municipio_actual) ?>" selected><?= esc($nombre_municipio_actual) ?></option>
                        <?php endif; ?>
                    </select>
                </p>

                <p><strong>Sección:</strong>
                    <select class="editable form-control-select" id="id_seccion" name="id_seccion" disabled required>
                        <option value="">-- Selecciona una Sección --</option>
                        <?php if (!empty($id_municipio_actual) && !empty($id_seccion_actual)): ?>
                            <option value="<?= esc($id_seccion_actual) ?>" selected><?= esc($nombre_seccion_actual) ?></option>
                        <?php endif; ?>
                    </select>
                </p>
                </div>

            <button type="button" id="editButton" class="btn btn-warning">
                Editar Perfil
            </button>

            <button type="submit" id="saveButton" class="btn btn-success" style="display:none;">
                Guardar Cambios
            </button>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function(){
    // Al hacer clic en Editar Perfil
    $("#editButton").click(function(){
        $(".editable").prop("disabled", false);
        // Si el campo de contraseña es el que se usa para nueva contraseña, asegúrate de que no se auto-complete con la antigua
        $("#new_password").val(''); // Limpia el campo de contraseña al entrar en modo edición
        $("#editButton").hide();
        $("#saveButton").show();
        // Agrega la clase para el modo edición al contenedor de la imagen
        $(".profile-image-container").addClass("editable-mode"); 
    });

    // Mostrar explorador de archivos al hacer clic en el overlay o la imagen
    $("#imageOverlay, #previewImage").click(function(){
        // Solo permite el clic si estamos en modo edición (la clase está presente)
        if ($(".profile-image-container").hasClass("editable-mode")) { 
            $("#fotoInput").click();
        }
    });

    // Previsualizar la nueva imagen antes de enviarla
    $("#fotoInput").change(function(event){
        var reader = new FileReader();
        reader.onload = function(e) {
            $("#previewImage").attr("src", e.target.result);
        };
        reader.readAsDataURL(event.target.files[0]);
    });

    // Configuración para cargar estados, municipios y SECCIONES
    const baseUrl = "<?= base_url(); ?>";
    // Asegúrate de que apunte al controlador correcto. Si tienes un controlador dedicado para geolocalización, úsalo.
    // Si PerfilController maneja estos métodos, mantén "PerfilController".
    const geolocController = "PerfilController"; 

    const initialEstadoId = "<?= esc($id_estado_actual) ?>";
    const initialMunicipioId = "<?= esc($id_municipio_actual) ?>";
    const initialSeccionId = "<?= esc($id_seccion_actual) ?>"; // <--- NUEVO: ID de la sección inicial

    // Función para cargar municipios en el select de municipios
    function loadMunicipios(idEstado, selectedMunicipioId = null) {
        const $municipioSelect = $("#id_municipio");
        $municipioSelect.prop("disabled", true).html('<option value="">Cargando municipios...</option>');
        
        // También deshabilita y limpia el select de secciones cuando cambia el estado
        $("#id_seccion").html('<option value="">-- Selecciona una Sección --</option>').prop("disabled", true);

        if (!idEstado) {
            $municipioSelect.html('<option value="">-- Selecciona un Municipio --</option>').prop("disabled", true);
            return;
        }

        $.ajax({
            url: `${baseUrl}/${geolocController}/getMunicipiosPorEstado/${idEstado}`,
            type: "GET",
            dataType: "json",
            success: function(municipios) {
                let optionsHtml = '<option value="">-- Selecciona un Municipio --</option>';
                if (municipios.length > 0) {
                    municipios.forEach(municipio => {
                        optionsHtml += `<option value="${municipio.id_municipio}" ${selectedMunicipioId == municipio.id_municipio ? 'selected' : ''}>${municipio.nombre}</option>`;
                    });
                    $municipioSelect.html(optionsHtml).prop("disabled", false);
                    // Si se cargaron municipios y hay un municipio seleccionado, cargar secciones
                    if (selectedMunicipioId) {
                        loadSecciones(selectedMunicipioId, initialSeccionId);
                    }
                } else {
                    $municipioSelect.html('<option value="">No hay municipios para este estado</option>').prop("disabled", true);
                }
            },
            error: function(xhr, status, error) {
                console.error("Error al cargar municipios:", status, error);
                $municipioSelect.html('<option value="">Error al cargar municipios</option>').prop("disabled", true);
            }
        });
    }

    // NUEVA FUNCIÓN: Para cargar secciones en el select de secciones
    function loadSecciones(idMunicipio, selectedSeccionId = null) {
        const $seccionSelect = $("#id_seccion");
        $seccionSelect.prop("disabled", true).html('<option value="">Cargando secciones...</option>');

        if (!idMunicipio) {
            $seccionSelect.html('<option value="">-- Selecciona una Sección --</option>').prop("disabled", true);
            return;
        }

        $.ajax({
            url: `${baseUrl}/${geolocController}/getSeccionesPorMunicipio/${idMunicipio}`, // Asegúrate de que esta URL sea correcta en tu controlador
            type: "GET",
            dataType: "json",
            success: function(secciones) {
                let optionsHtml = '<option value="">-- Selecciona una Sección --</option>';
                if (secciones.length > 0) {
                    secciones.forEach(seccion => {
                        // ¡¡¡AQUÍ ESTÁ LA CORRECCIÓN CLAVE!!!
                        optionsHtml += `<option value="${seccion.id_seccion}" ${selectedSeccionId == seccion.id_seccion ? 'selected' : ''}>${seccion.nombre_seccion}</option>`;
                    });
                    $seccionSelect.html(optionsHtml).prop("disabled", false);
                } else {
                    $seccionSelect.html('<option value="">No hay secciones para este municipio</option>').prop("disabled", true);
                }
            },
            error: function(xhr, status, error) {
                console.error("Error al cargar secciones:", status, error);
                $seccionSelect.html('<option value="">Error al cargar secciones</option>').prop("disabled", true);
            }
        });
    }

    // Lógica de carga inicial de municipios y secciones si ya hay un estado y municipio seleccionado
    // Esta parte asegura que los selects se pre-carguen con los datos del usuario al cargar la página
    if (initialEstadoId) {
        loadMunicipios(initialEstadoId, initialMunicipioId);
    }

    // Evento change para el select de estados
    $("#id_estado").change(function() {
        const idEstado = $(this).val();
        loadMunicipios(idEstado); // Cuando el usuario cambia el estado, no queremos pre-seleccionar un municipio antiguo
    });

    // NUEVO: Evento change para el select de municipios
    $("#id_municipio").change(function() {
        const idMunicipio = $(this).val();
        loadSecciones(idMunicipio); // Cuando el usuario cambia el municipio, no queremos pre-seleccionar una sección antigua
    });

    // Manejo de envío del formulario con AJAX
    $("#editProfileForm").submit(function(e){
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: "<?= base_url('/perfil/actualizar') ?>",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function(response) {
                if(response.status == "success") {
                    Swal.fire({
                        title: "¡Perfil Actualizado!",
                        text: "Tus datos han sido guardados exitosamente.",
                        icon: "success",
                        confirmButtonColor: "#28a745",
                        confirmButtonText: "Aceptar"
                    }).then(() => {
                        // Deshabilita todos los campos editables
                        $(".editable").prop("disabled", true); 
                        // Oculta el botón de guardar
                        $("#saveButton").hide(); 
                        // Muestra el botón de editar
                        $("#editButton").show(); 
                        // Quita la clase para el modo edición del contenedor de la imagen
                        $(".profile-image-container").removeClass("editable-mode");
                        
                        // Recarga la página para reflejar los cambios en la sesión y la UI
                        location.reload(); 
                    });
                } else {
                    // Construir mensaje de error si hay errores de validación
                    let errorMessage = "Hubo un problema al actualizar tu perfil.";
                    if (response.message && typeof response.message === 'object') {
                        errorMessage += "<br><br>Errores:<br>";
                        for (const key in response.message) {
                            errorMessage += `- ${response.message[key]}<br>`;
                        }
                    } else if (response.message) {
                            errorMessage = response.message;
                    }

                    Swal.fire({
                        title: "¡Error!",
                        html: errorMessage, // Usar html para permitir <br>
                        icon: "error",
                        confirmButtonColor: "#d33",
                        confirmButtonText: "Intentar de nuevo"
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", status, error, xhr.responseText);
                Swal.fire({
                    title: "¡Error de conexión!",
                    text: "No se pudo conectar con el servidor. Intenta de nuevo. Detalles: " + xhr.status,
                    icon: "warning",
                    confirmButtonColor: "#f39c12",
                    confirmButtonText: "Aceptar"
                });
            }
        });
    });
});
</script>
    <br><br><br><br><br><br><br><br><br><br><br><br><br>
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
    document.getElementById('currentYear').textContent = new Date().getFullYear();
</script>

</body>
</html>