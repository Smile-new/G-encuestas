<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comunidad</title>

    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,600,700,800,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Oswald:300,400,500,600,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


    <link rel="stylesheet" href="<?= base_url((defined('RECURSOS_PUBLICOS_CSS') ? RECURSOS_PUBLICOS_CSS : 'css') . '/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url((defined('RECURSOS_PUBLICOS_CSS') ? RECURSOS_PUBLICOS_CSS : 'css') . '/font-awesome.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url((defined('RECURSOS_PUBLICOS_CSS') ? RECURSOS_PUBLICOS_CSS : 'css') . '/style.css') ?>">
    <style>
        /* ==================================== */
        /* Estilos Generales           */
        /* ==================================== */
        body {
            font-family: 'Nunito Sans', sans-serif;
            background-color: #f4f6f8; /* Fondo general de la página */
            color: #333;
            margin: 0;
            padding: 0;
        }

        a {
            text-decoration: none;
            color: inherit; /* Hereda el color del padre por defecto */
        }

        a:hover {
            text-decoration: none;
        }

        .d-none {
            display: none !important;
        }

        /* ==================================== */
        /* Estilos de Header          */
        /* ==================================== */
        header {
            width: 100vw; /* Usar 100vw para asegurar que cubra todo el ancho */
            height: 35vh;
            background: #000000;
            background: -webkit-linear-gradient(to right, rgba(0, 0, 0, 0.6), rgba(255, 0, 0, 0.6));
            background: linear-gradient(to right, rgba(0, 0, 0, 0.6), rgba(255, 0, 0, 0.6)), url(<?= base_url('recursos_publicos/img/carrucel/3.png') ?>);
            background-size: cover;
            background-attachment: fixed;
            position: relative;
            overflow: hidden; /* Para que la onda no se desborde */
        }

        .header-section {
            padding: 15px 0;
            text-align: center;
            color: white;
            margin-bottom: 30px; /* Margen del header, pero la ola lo maneja mejor */
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
            flex-wrap: wrap; /* Para que los ítems se envuelvan en pantallas pequeñas */
        }

        .nav-menu ul li {
            margin: 0 15px; /* Espacio entre los ítems */
        }

        .nav-menu ul li a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            font-size: 1rem;
            transition: color 0.3s ease;
            padding: 5px 0; /* Padding para hacer el área clickeable más grande */
            display: block; /* Para que el padding afecte todo el enlace */
        }

        .nav-menu ul li a:hover {
            color: #f39c12; /* Naranja en hover */
        }

        .wive {
            position: absolute;
            bottom: 0;
            left: 0; /* Asegura que la ola esté en el borde izquierdo */
            width: 100%; /* Cubre todo el ancho */
            height: 150px;
            overflow: hidden;
        }

        .wive svg {
            display: block; /* Elimina espacio extra debajo del SVG */
        }

        /* ==================================== */
        /* Contenido Principal Foro     */
        /* ==================================== */
        .container.community-container-content {
            max-width: 900px;
            margin: 20px auto 40px auto;
            padding: 25px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .community-container-content h2.community-main-title {
            color: #e74c3c; /* Rojo primario */
            margin-bottom: 25px;
            font-family: 'Oswald', sans-serif;
            text-transform: uppercase;
            text-align: center;
            font-size: 2.2em;
            letter-spacing: 1px;
        }

        /* ==================================== */
        /* Formulario Nueva Publicación */
        /* ==================================== */
        /* --- Estilos Generales de la Comunidad --- */
/* Mantener si tienes un contenedor principal, pero ajusta paddings si es necesario */
.community-container-content {
    background-color: #fff;
    padding: 20px 30px; /* Suficiente padding para el contenido general */
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    margin-top: 30px;
}

.community-main-title {
    color: #333;
    font-weight: 600;
    margin-bottom: 25px;
    text-align: center; /* Centrar el título de la comunidad */
}

/* --- Formulario de Nueva Publicación Principal --- */
.new-post-form {
    background-color: #f0f2f5; /* Fondo más suave, similar a Facebook */
    padding: 16px; /* Padding ligeramente reducido para compacidad */
    border-radius: 8px; /* Bordes más redondeados */
    margin-bottom: 20px; /* Espacio reducido abajo */
    box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.05); /* Sombra interna sutil */
    border: none; /* Eliminar borde para un look más limpio */
}

.new-post-form h3 {
    font-size: 1.15rem; /* Tamaño de fuente más pequeño para el título del formulario */
    color: #555;
    margin-top: 0;
    margin-bottom: 12px; /* Espacio reducido */
    font-weight: 600; /* Un poco más de peso */
}

.new-post-form .form-control {
    border-radius: 20px; /* Bordes muy redondeados para el textarea */
    border: 1px solid #ccd0d5; /* Color de borde suave */
    padding: 10px 15px; /* Más padding horizontal */
    min-height: 60px; /* Altura mínima ajustada */
    resize: vertical;
    font-size: 0.95rem; /* Tamaño de fuente ligeramente más pequeño */
    line-height: 1.4; /* Interlineado para mejor lectura */
    box-shadow: none; /* Eliminar sombras por defecto si las hay */
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
}

.new-post-form .form-control:focus {
    border-color: #1877f2; /* Borde azul al enfocar, como Facebook */
    box-shadow: 0 0 0 1px #1877f2, 0 0 0 4px rgba(24, 119, 242, 0.2); /* Sombra de enfoque sutil */
}

.new-post-form .btn.btn-publish-main {
    background-color: #1877f2; /* Azul clásico de Facebook para el botón principal */
    color: white;
    border: none;
    padding: 8px 18px; /* Padding ajustado */
    border-radius: 6px; /* Bordes más redondeados */
    cursor: pointer;
    transition: background-color 0.2s ease, transform 0.1s ease;
    font-weight: bold;
    font-size: 1rem; /* Tamaño de fuente ligeramente más grande */
    margin-top: 15px; /* Espacio superior */
    width: 100%; /* Ocupa todo el ancho */
}

.new-post-form .btn.btn-publish-main:hover {
    background-color: #166fe5; /* Azul ligeramente más oscuro al pasar el ratón */
    transform: translateY(-1px); /* Efecto sutil al pasar el ratón */
}


/* ==================================== */
/* Lista de Publicaciones               */
/* ==================================== */

.posts-list {
    margin-top: 20px; /* Espacio superior para la lista de posts */
    display: flex;
    flex-direction: column;
    gap: 15px; /* Espacio entre cada publicación */
}

.post-card {
    background-color: #fff;
    border: none; /* Eliminar el borde principal */
    border-radius: 8px;
    padding: 12px; /* Padding ajustado para ser más compacto */
    margin-bottom: 0; /* Eliminar margen inferior ya que usamos gap en el padre */
    display: flex;
    align-items: flex-start; /* Asegurar que el avatar y el contenido se alineen arriba */
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1), 0 1px 2px rgba(0, 0, 0, 0.05); /* Sombra más sutil */
    transition: none; /* Eliminar la transición de transform en hover si no la quieres */
}

.post-card:hover {
    transform: none; /* Quitar el efecto de transform en hover */
}

.post-author-avatar {
    width: 40px; /* Tamaño del avatar más consistente con Facebook */
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    margin-right: 12px; /* Margen a la derecha ajustado */
    border: none; /* Eliminar el borde de color alrededor del avatar */
    flex-shrink: 0; /* Evitar que el avatar se encoja */
}

.post-content-wrapper {
    flex-grow: 1;
    min-width: 0; /* Esencial para prevenir desbordamientos */
}

.post-header {
    display: flex;
    flex-direction: row; /* Nombre y fecha en la misma línea */
    align-items: baseline; /* Alinear por la línea base del texto */
    margin-bottom: 2px; /* Espacio mínimo */
    gap: 8px; /* Espacio entre nombre y fecha */
}

.post-author-name {
    font-weight: 600; /* Peso de la fuente para el nombre */
    color: #050505; /* Color más oscuro para el nombre */
    font-size: 0.95rem; /* Tamaño de fuente ligeramente más pequeño */
}

.post-date {
    color: #65676b; /* Color gris para la fecha, similar a Facebook */
    font-size: 0.8rem; /* Tamaño de fuente más pequeño para la fecha */
    white-space: nowrap; /* Evitar que la fecha salte de línea */
}

.post-body {
    margin-bottom: 8px; /* Espacio reducido debajo del cuerpo del post */
    line-height: 1.35; /* Interlineado más compacto */
    color: #1c1e21; /* Color de texto principal */
    font-size: 0.9rem; /* Tamaño de fuente del contenido */
    white-space: pre-wrap;
    word-wrap: break-word;
}

/* Estilo para el contenido editable (modo edición) */
.post-content-editable[contenteditable="true"] {
    border: 1px solid #ced4da;
    padding: 8px 12px;
    border-radius: 5px;
    background-color: #fcfcfc;
    min-height: 80px; /* Para que sea más cómodo editar */
    outline: none; /* Quitar el borde de enfoque por defecto del navegador */
    box-shadow: inset 0 1px 2px rgba(0,0,0,.075);
    white-space: pre-wrap; /* Mantiene los saltos de línea y espacios en edición */
}


.post-actions {
    border-top: 1px solid #f0f2f5; /* Línea divisoria suave */
    padding-top: 6px; /* Padding superior reducido */
    margin-top: 6px; /* Margen superior reducido */
    display: flex;
    flex-wrap: wrap; /* Permitir que los botones salten de línea en pantallas pequeñas */
    gap: 12px; /* Espacio consistente entre los botones */
    justify-content: flex-start; /* Alinear los botones a la izquierda */
}

.post-actions .btn-action {
    background: none;
    border: none;
    color: #65676b; /* Color gris para los botones de acción */
    cursor: pointer;
    text-decoration: none;
    font-size: 0.85rem; /* Tamaño de fuente de los botones */
    padding: 4px 6px; /* Padding ajustado para botones compactos */
    border-radius: 4px;
    transition: background-color 0.2s ease, color 0.2s ease;
    font-weight: 600; /* Peso de fuente para los botones */
    display: flex; /* Para centrar íconos si los añades */
    align-items: center;
    gap: 4px; /* Espacio entre texto y posible ícono */
}

.post-actions .btn-action:hover {
    background-color: #f0f2f5; /* Fondo suave al pasar el ratón */
    color: #333; /* Texto más oscuro al pasar el ratón */
}

/* Estilos específicos para botones de edición/guardar/cancelar */
.btn-save-publicacion {
    color: #28a745; /* Verde para Guardar */
}
.btn-save-publicacion:hover {
    background-color: #e6ffed; /* Fondo verde claro en hover */
}

.btn-cancel-edit {
    color: #6c757d; /* Gris para Cancelar */
}
.btn-cancel-edit:hover {
    background-color: #e9ecef; /* Fondo gris claro en hover */
}

.btn-delete {
    color: #dc3545; /* Rojo para Eliminar */
}
.btn-delete:hover {
    background-color: #fcebeb; /* Fondo rojo claro en hover */
}


/* --- Estilos para Respuestas --- */

.replies-list {
    margin-top: 10px; /* Espacio reducido antes de la lista de respuestas */
    padding-left: 0;
    border-top: none; /* Eliminar esta línea, se maneja por indentación visualmente */
    padding-top: 0;
}

/* Aplicar la indentación a las respuestas */
.post-card.reply { /* Directamente la clase .reply en .post-card */
    margin-left: 45px; /* Indentación tipo Facebook */
    margin-top: 10px; /* Espacio entre respuesta y post padre/hermano */
    background-color: #f7f8fa; /* Fondo ligeramente diferente para respuestas */
    border-left: 2px solid #e0e0e0; /* Pequeña línea izquierda para anidar */
    padding-left: 10px; /* Ajustar padding por la línea */
    box-shadow: none; /* Eliminar sombras para respuestas, mantener la anidación limpia */
}

.post-card.reply .post-author-avatar {
    width: 32px; /* Avatar más pequeño para respuestas */
    height: 32px;
}

/* ==================================== */
/* Formulario de Respuesta Anidado      */
/* ==================================== */

.responder-form-container {
    margin-top: 10px; /* Espacio reducido */
}

.responder-form-container h6 {
    color: #65676b; /* Color similar a la fecha */
    font-size: 0.85rem; /* Tamaño de fuente más pequeño */
    margin-bottom: 6px; /* Espacio reducido */
}

.responder-form-container.new-post-form {
    padding: 12px; /* Padding más compacto */
    background-color: #f0f2f5; /* Fondo similar al formulario principal */
    border-radius: 8px; /* Bordes redondeados */
    margin-top: 8px; /* Espacio superior */
    border: none; /* Eliminar borde */
    box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.03); /* Sombra interna sutil */
}

.responder-form-container.new-post-form textarea {
    min-height: 50px; /* Altura mínima para el textarea de respuesta */
    font-size: 0.9rem; /* Tamaño de fuente ajustado */
    border-radius: 15px; /* Bordes redondeados */
    padding: 8px 12px; /* Padding ajustado */
    border-color: #ccd0d5; /* Color de borde */
}

.responder-form-container.new-post-form textarea:focus {
    border-color: #1877f2;
    box-shadow: 0 0 0 1px #1877f2, 0 0 0 4px rgba(24, 119, 242, 0.2);
}

.responder-form-container.new-post-form .btn {
    font-size: 0.8rem; /* Tamaño de fuente más pequeño para botones de respuesta */
    padding: 5px 10px; /* Padding más compacto */
    border-radius: 5px; /* Bordes redondeados */
    margin-top: 8px; /* Espacio superior */
}

.responder-form-container.new-post-form .btn-primary {
    background-color: #1877f2; /* Azul de Facebook */
    border-color: #1877f2;
}

.responder-form-container.new-post-form .btn-primary:hover {
    background-color: #166fe5;
    border-color: #166fe5;
}

.responder-form-container.new-post-form .btn-secondary {
    background-color: #e4e6eb; /* Gris claro para Cancelar */
    border-color: #e4e6eb;
    color: #4b4f56; /* Color de texto oscuro */
}

.responder-form-container.new-post-form .btn-secondary:hover {
    background-color: #d8dade;
    border-color: #d8dade;
}

/* --- Clases de Utilidad --- */
/* Mantener estas clases, asegúrate de que no haya overrides que las afecten */
.hidden {
    display: none !important;
}
.d-none { /* Otra opción para ocultar, si ya la usas */
    display: none !important;
}
.d-inline { /* Para hacer que un formulario se muestre en línea */
    display: inline-block;
}

        /* ==================================== */
        /* Estilos de Alertas        */
        /* ==================================== */
        #alert-messages {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
            max-width: 350px;
        }

        .alert-custom {
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            color: #fff;
            opacity: 0.95;
        }

        .alert-custom-success {
            background-color: #28a745;
        }

        .alert-custom-error,
        .alert-custom-danger {
            background-color: #dc3545;
        }

        .alert-custom-warning {
            background-color: #ffc107;
            color: #333; /* Texto oscuro para advertencias */
        }

        /* ==================================== */
        /* Estilos de Footer         */
        /* ==================================== */
        :root {
            --footer-bg-dark: #000000;
            --footer-text-light: #ecf0f1;
            --footer-heading-color: #e74c3c;
            --footer-link-hover: #ffffff;
            --social-icon-box-bg: #333333;
            --social-icon-color: #ecf0f1;
            --social-icon-hover-bg: #e74c3c;
            --transition-speed: 0.3s;
        }

        .main-footer {
            background-color: var(--footer-bg-dark);
            color: var(--footer-text-light);
            padding: 60px 20px;
            font-family: 'Nunito Sans', sans-serif;
            border-top: 5px solid var(--footer-heading-color);
            position: relative;
            z-index: 5;
        }

        .footer-content-wrapper {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 2fr;
            gap: 40px;
            text-align: left;
        }

        .footer-column {
            padding: 0 10px;
        }

        .footer-heading {
            font-family: 'Oswald', sans-serif;
            font-size: 1.6rem;
            color: var(--footer-text-light); /* Asegura que el título sea claro */
            margin-bottom: 25px;
            position: relative;
            padding-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: bold;
        }

        .footer-text {
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 15px;
            opacity: 0.9;
        }

        .copyright {
            margin-top: 30px;
            font-size: 0.85rem;
            opacity: 0.7;
            text-align: left;
        }

        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-links li {
            margin-bottom: 10px;
        }

        .footer-link {
            color: var(--footer-text-light);
            text-decoration: none;
            font-size: 1rem;
            transition: color var(--transition-speed) ease-in-out, transform var(--transition-speed) ease-in-out;
            display: inline-block;
        }

        .footer-link:hover {
            color: var(--footer-link-hover);
            transform: translateX(5px);
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

        .social-icons {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .social-icon {
            width: 45px;
            height: 45px;
            border-radius: 8px;
            background-color: var(--social-icon-box-bg);
            color: var(--social-icon-color);
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 1.2rem;
            text-decoration: none;
            transition: background-color var(--transition-speed) ease-in-out,
            transform var(--transition-speed) ease-in-out,
            box-shadow var(--transition-speed) ease-in-out;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .social-icon:hover {
            background-color: var(--social-icon-hover-bg);
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
        }

        .social-icon img {
            width: 100%; /* Asegura que la imagen ocupe todo el espacio del contenedor */
            height: 100%;
            object-fit: contain; /* Para que la imagen se ajuste dentro del círculo */
            border-radius: 8px; /* Mismo radio que el contenedor */
        }


        .contact-info .footer-text {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 12px;
        }

        .contact-info .footer-text i {
            font-size: 1.1rem;
            color: var(--footer-text-light);
            flex-shrink: 0;
            margin-top: 3px;
        }

        /* ==================================== */
        /* Media Queries (Responsividad) */
        /* ==================================== */
        @media (max-width: 992px) {
            .footer-content-wrapper {
                grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
                gap: 30px;
            }
        }

        @media (max-width: 768px) {
            .nav-menu ul li {
                margin: 0 10px;
            }
            .nav-menu ul li a {
                font-size: 0.9rem;
            }

            .footer-content-wrapper {
                grid-template-columns: 1fr;
                text-align: center;
                gap: 30px;
            }

            .footer-heading {
                margin-bottom: 20px;
                font-size: 1.5rem;
            }

            .social-icons {
                justify-content: center;
                margin-top: 15px;
            }

            .contact-info .footer-text {
                justify-content: center;
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
                width: 40px; /* Ajuste para móviles */
                height: 40px;
            }
            .copyright {
                margin-top: 20px;
                font-size: 0.8rem;
            }
        }

    </style>
</head>
<body>

<header>
    <div class="container-fluid header-section">
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
                    <?php if (isset($usuario_logueado) && $usuario_logueado): // Condicional para Perfil/Cerrar Sesión ?>
                        <li><a href="<?= base_url('perfilp') ?>">Perfil</a></li>
                        <li><a href="<?= base_url('logout') ?>">Cerrar Sesión</a></li>
                    <?php else: ?>
                        <li><a href="<?= base_url('login') ?>">Iniciar Sesión</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>
    <div class="wive">
        <svg viewBox="0 0 500 150" preserveAspectRatio="none" style="height: 100%; width: 100%;">
            <path d="M0.00,50.10 C150.00,150.33 349.20,-50.10 500.00,50.10 L500.00,150.33 L0.00,150.33 Z" style="stroke: none; fill: #f4f6f8;"></path>
        </svg>
    </div>
</header>
<div id="alert-messages"></div>
<div class="container community-container-content">
    <h2 class="text-center mb-4 community-main-title">Comunidad: Publicaciones Recientes</h2>

    <div id="flash-messages">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
    </div>

    <div class="new-post-form mb-5">
        <h3>Crea una nueva publicación</h3>
        <?php if (isset($usuario_logueado['id_usuario']) && !empty($usuario_logueado['id_usuario'])): ?>
            <form id="form-nueva-publicacion-principal" action="<?= base_url('comunidad/guardar') ?>" method="post">
                <?= csrf_field() ?>
                <div class="form-group mb-3">
                    <textarea name="contenido_publicacion" class="form-control" placeholder="¿Qué quieres compartir con la comunidad?" required></textarea>
                </div>
                <button type="submit" class="btn btn-publish-main">Publicar</button>
            </form>
        <?php else: ?>
            <div class="alert alert-warning text-center">
                Para poder publicar y comentar, debes <a href="<?= base_url('login') ?>">iniciar sesión</a>.
            </div>
        <?php endif; ?>
    </div>

    <div class="posts-list" id="lista-de-publicaciones-global">
        <?php if (!empty($publicaciones)): ?>
            <?php foreach ($publicaciones as $publicacion): ?>
                <?php
                // Prepara las variables para la publicación principal.
                // (Estas vienen ya procesadas del controlador)
                $defaultAvatarUrl = base_url('public/img_user/default-avatar.png');
                $avatarPath = esc($publicacion['foto_path'] ?? $defaultAvatarUrl);
                $nombreCompleto = esc($publicacion['nombre_completo_display'] ?? 'Usuario Desconocido');
                $fechaFormateada = esc($publicacion['fecha_creacion'] ?? 'Fecha desconocida'); // Ya viene formateada
                $esAdmin = $publicacion['usuario_logueado_es_admin'] ?? false;
                $esAutor = $publicacion['es_autor_logueado'] ?? false;
                $postId = esc($publicacion['id_publicacion']);

                // Contenido sin nl2br para el 'data-original-content', con nl2br para la visualización
                $postContentRaw = esc($publicacion['contenido_publicacion'] ?? '');
                $postContentDisplay = nl2br($postContentRaw);
                ?>
                <div class="post-card" id="post-<?= $postId ?>" data-id="<?= $postId ?>">
                    <img src="<?= $avatarPath ?>" alt="Avatar de <?= $nombreCompleto ?>" class="post-author-avatar" onerror="this.onerror=null;this.src='<?= $defaultAvatarUrl ?>';">
                    <div class="post-content-wrapper">
                        <div class="post-header">
                            <span class="post-author-name"><?= $nombreCompleto ?></span>
                            <span class="post-date"><?= $fechaFormateada ?></span>
                            </div>
                        <div class="post-body">
                            <div class="post-content-display">
                                <?= $postContentDisplay ?>
                            </div>
                            </div>
                        <div class="post-actions">
                            <?php if (isset($usuario_logueado['id_usuario'])): // Solo si hay un usuario logueado ?>
                                <button type="button" class="btn-action responder-btn" data-post-id="<?= $postId ?>">Responder</button>
                                <?php if ($esAutor || $esAdmin): // Solo si es autor o admin ?>
                                    <form action="<?= base_url('comunidad/eliminar/' . $postId) ?>" method="post" class="d-inline delete-post-form">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn-action btn-delete" onclick="return confirm('¿Estás seguro de que quieres eliminar esta publicación? Esta acción eliminará también todas sus respuestas.');">Eliminar</button>
                                    </form>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>

                        <?php if (isset($usuario_logueado['id_usuario'])): ?>
                            <div id="respuesta-form-<?= $postId ?>" class="responder-form-container new-post-form mt-3 d-none">
                                <h6>Responder a <?= $nombreCompleto ?>:</h6>
                                <form class="form-ajax-respuesta" action="<?= base_url('comunidad/guardar') ?>" method="post" data-parent-id="<?= $postId ?>">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="id_publicacion_padre" value="<?= $postId ?>">
                                    <div class="form-group mb-2">
                                        <textarea name="contenido_publicacion" class="form-control" placeholder="Tu respuesta..." required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-sm">Enviar Respuesta</button>
                                    <button type="button" class="btn btn-secondary btn-sm cancelar-respuesta-btn">Cancelar</button>
                                </form>
                            </div>
                        <?php endif; ?>

                        <div class="replies-list" id="replies-for-post-<?= $postId ?>">
                            <?php
                            // Llama a la función del helper para renderizar respuestas
                            renderizarRespuestas(
                                $publicacion['respuestas'] ?? [],
                                $usuario_logueado,
                                $esAdmin // Pasa la variable esAdmin de la publicación principal
                            );
                            ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center no-posts-message">Aún no hay publicaciones en la comunidad. ¡Sé el primero en publicar!</p>
        <?php endif; ?>
    </div>
</div>
<br><br><br>
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
                <li><a href="<?= base_url('home') ?>" class="footer-link">Inicio</a></li>
                <li><a href="<?= base_url('encuestasp') ?>" class="footer-link">Encuestas</a></li>
                <li><a href="<?= base_url('nosotrosp') ?>" class="footer-link">Nosotros</a></li>
            </ul>
        </div>

        <div class="footer-column social-media">
            <h3 class="footer-heading">Síguenos</h3>
            <div class="social-icons">
                <a href="https://www.instagram.com/grupomonitorcom/" class="social-icon">
                    <img src="<?= base_url('recursos_publicos/img/icon/4.png') ?>" alt="Instagram">
                </a>
                <a href="https://x.com/GrupoMonitorCom" class="social-icon">
                    <img src="<?= base_url('recursos_publicos/img/icon/3.png') ?>" alt="X">
                </a>
                <a href="https://www.facebook.com/GrupoMonitorCom" class="social-icon">
                    <img src="<?= base_url('recursos_publicos/img/icon/5.png') ?>" alt="Facebook">
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

<script src="<?= base_url((defined('RECURSOS_PUBLICOS_JS') ? RECURSOS_PUBLICOS_JS : 'js') . '/jquery-3.3.1.min.js') ?>"></script>
<script src="<?= base_url((defined('RECURSOS_PUBLICOS_JS') ? RECURSOS_PUBLICOS_JS : 'js') . '/bootstrap.min.js') ?>"></script>

<script>
    $(document).ready(function() {
        // Función para mostrar alertas flash
        function showAlert(message, type = 'info') {
            let alertContainer = $('#flash-messages');
            if (!alertContainer.length) {
                // Si el contenedor no existe, lo crea al principio del body
                $('body').prepend('<div id="flash-messages" class="fixed-top text-center" style="z-index: 1050; padding-top: 15px;"></div>');
                alertContainer = $('#flash-messages');
            }
            alertContainer.empty(); // Limpia mensajes anteriores
            const alertHtml = `<div class="alert alert-${type} alert-dismissible fade show" role="alert">
                                    ${message}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>`;
            alertContainer.append(alertHtml);
            setTimeout(() => {
                alertContainer.find('.alert').alert('close'); // Cierra la alerta automáticamente después de 5 segundos
            }, 5000);
        }

        // Obtiene el token CSRF
        function getCsrfToken() {
            return $('meta[name="csrf-token"]').attr('content') || $('input[name="csrf_test_name"]').first().val();
        }

        // Actualiza el token CSRF después de cada solicitud AJAX
        function updateCsrfToken(newToken) {
            if (newToken) { // Solo actualiza si hay un nuevo token
                $('meta[name="csrf-token"]').attr('content', newToken);
                $('input[name="csrf_test_name"]').val(newToken);
                console.log('CSRF Token Actualizado a:', newToken);
            } else {
                console.warn('Intento de actualizar CSRF Token con valor nulo o indefinido.');
            }
        }

        // Genera los botones de acción para una publicación/respuesta (AHORA SIN BOTONES DE EDICIÓN)
        function generarBotonesAccion(itemData) {
            let buttonsHtml = '';
            const currentUserId = itemData.usuario_logueado_id;
            const isAuthor = itemData.es_autor_logueado;
            const isAdmin = itemData.user_logged_in_is_admin; // Usar el nombre de la variable consistente
            const postId = itemData.id_publicacion;

            if (currentUserId) {
                // El botón "Responder" siempre se muestra si el usuario está logueado
                buttonsHtml += `<button type="button" class="btn-action responder-btn" data-post-id="${postId}">Responder</button>`;
                
                if (isAuthor || isAdmin) {
                    buttonsHtml += `
                        <form class="d-inline delete-post-form" action="${BASE_URL}comunidad/eliminar/${postId}" method="post">
                            <input type="hidden" name="csrf_test_name" value="${getCsrfToken()}">
                            <button type="submit" class="btn-action btn-delete" onclick="return confirm('¿Estás seguro de que quieres eliminar esta publicación/respuesta? Esta acción es irreversible.');">Eliminar</button>
                        </form>
                    `;
                }
            }
            return buttonsHtml;
        }

        // Genera el HTML completo para una nueva publicación o respuesta
        function generarPublicacionItemHTML(itemData, isReply = false) {
            const postId = itemData.id_publicacion;
            const avatarPath = itemData.foto_path || (BASE_URL + 'public/img_user/default-avatar.png');
            const nombreCompleto = itemData.nombre_completo_display || 'Usuario Desconocido';
            const fechaFormateada = itemData.fecha_creacion || 'Fecha desconocida';
            const postContentRaw = itemData.contenido_publicacion || '';
            // Reemplaza saltos de línea por <br> para visualización HTML
            const postContentDisplay = postContentRaw.replace(/(\r\n|\n|\r)/g, '<br>');

            let classType = isReply ? 'reply' : '';
            // Si es una respuesta y tiene un padre, es una respuesta anidada
            if (isReply && itemData.id_publicacion_padre) {
                classType += ' reply-to-reply';
            }

            const repliesContainerId = `replies-for-post-${postId}`;
            const responderFormContainerId = `respuesta-form-${postId}`;
            
            // Añade el atributo data-parent-id solo si es una respuesta y tiene un padre
            const dataParentAttr = isReply && itemData.id_publicacion_padre ? `data-parent-id="${itemData.id_publicacion_padre}"` : '';

            // Indicador de edición (lo mantenemos porque la fecha de edición puede venir de la DB)
            const editedIndicatorHtml = itemData.fecha_actualizacion_display 
                                        ? `<span class="post-edited-indicator">(editado ${itemData.fecha_actualizacion_display})</span>` 
                                        : '';

            let html = `
                <div class="post-card ${classType}" id="post-${postId}" data-id="${postId}" ${dataParentAttr}>
                    <img src="${avatarPath}" alt="Avatar de ${nombreCompleto}" class="post-author-avatar" onerror="this.onerror=null;this.src='${BASE_URL}public/img_user/default-avatar.png';">
                    <div class="post-content-wrapper">
                        <div class="post-header">
                            <span class="post-author-name">${nombreCompleto}</span>
                            <span class="post-date">${fechaFormateada}</span>
                            ${editedIndicatorHtml} 
                        </div>
                        <div class="post-body">
                            <div class="post-content-display">
                                ${postContentDisplay}
                            </div>
                            </div>
                        <div class="post-actions">
                            ${generarBotonesAccion(itemData)}
                        </div>
            `;

            // Si el usuario está logueado, cualquier post (principal o respuesta) puede tener un formulario de respuesta y una lista de respuestas
            if (itemData.usuario_logueado_id !== null) { 
                html += `
                    <div id="${responderFormContainerId}" class="responder-form-container new-post-form mt-3 d-none">
                        <h6>Responder a ${nombreCompleto}:</h6>
                        <form class="form-ajax-respuesta" action="${BASE_URL}comunidad/guardar" method="post" data-parent-id="${postId}">
                            <input type="hidden" name="csrf_test_name" value="${getCsrfToken()}">
                            <input type="hidden" name="id_publicacion_padre" value="${postId}">
                            <div class="form-group mb-2">
                                <textarea name="contenido_publicacion" class="form-control" placeholder="Tu respuesta..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">Enviar Respuesta</button>
                            <button type="button" class="btn btn-secondary btn-sm cancelar-respuesta-btn">Cancelar</button>
                        </form>
                    </div>
                    <div class="replies-list" id="${repliesContainerId}">
                    </div>
                `;
            }

            html += `
                        </div>
                    </div>
                `;
            return html;
        }

        // --- Manejo de la publicación principal ---
        $('#form-nueva-publicacion-principal').on('submit', function(e) {
            e.preventDefault();
            const form = $(this);
            const formData = form.serialize();
            const submitButton = form.find('button[type="submit"]');

            submitButton.prop('disabled', true).text('Publicando...');
            console.log('AJAX Nueva Publicación: Enviando petición.');

            $.ajax({
                url: form.attr('action'),
                method: form.attr('method'),
                data: formData,
                dataType: 'json',
                success: function(response) {
                    console.log('AJAX Nueva Publicación: Petición exitosa, respuesta del servidor:', response);
                    updateCsrfToken(response.token);

                    if (response.status === 'success') {
                        showAlert(response.message, 'success');
                        const newPublicacionData = response.data;
                        newPublicacionData.usuario_logueado_id = response.usuario_logueado_id;
                        newPublicacionData.es_autor_logueado = true; 
                        newPublicacionData.user_logged_in_is_admin = response.user_logged_in_is_admin; // Asegúrate de que este nombre sea consistente

                        const newPublicacionHtml = generarPublicacionItemHTML(newPublicacionData, false);
                        $('#lista-de-publicaciones-global').prepend(newPublicacionHtml);
                        form[0].reset(); 
                        $('.no-posts-message').remove(); 
                        console.log('AJAX Nueva Publicación: Publicación añadida y formulario reseteado.');
                    } else {
                        showAlert(response.message, 'danger');
                        if (response.errors) {
                            $.each(response.errors, function(field, message) {
                                console.error(`AJAX Nueva Publicación: Error de validación en ${field}: ${message}`);
                            });
                        }
                        console.warn('AJAX Nueva Publicación: Servidor reportó error lógico:', response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Nueva Publicación: Error en la petición AJAX:', status, error, xhr.responseText);
                    let errorMessage = 'Error al procesar la solicitud.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                        updateCsrfToken(xhr.responseJSON.token || getCsrfToken());
                    } else {
                        console.error("AJAX Nueva Publicación: Respuesta raw:", xhr.responseText);
                        errorMessage = 'Error inesperado al publicar. Consulta la consola del navegador para más detalles.';
                    }
                    showAlert(errorMessage, 'danger');
                },
                complete: function() {
                    submitButton.prop('disabled', false).text('Publicar');
                    console.log('AJAX Nueva Publicación: Petición completada, botón re-habilitado.');
                }
            });
        });

        // --- Manejo de la funcionalidad de "Responder" (mostrar/ocultar formulario) ---
        $(document).on('click', '.responder-btn', function() {
            const postId = $(this).data('post-id');
            // Cierra cualquier otro formulario de respuesta abierto antes de abrir uno nuevo
            $('.responder-form-container').not(`#respuesta-form-${postId}`).addClass('d-none').find('form')[0].reset();
            $(`#respuesta-form-${postId}`).toggleClass('d-none');
            console.log('Botón Responder clickeado para post:', postId);
        });

        $(document).on('click', '.cancelar-respuesta-btn', function() {
            $(this).closest('.responder-form-container').addClass('d-none');
            $(this).closest('form')[0].reset(); 
            console.log('Botón Cancelar Respuesta clickeado.');
        });

        // --- Manejo de la respuesta AJAX ---
        $(document).on('submit', '.form-ajax-respuesta', function(e) {
            e.preventDefault();
            const form = $(this);
            const parentId = form.data('parent-id');
            const formData = form.serialize();
            const submitButton = form.find('button[type="submit"]');

            submitButton.prop('disabled', true).text('Enviando...');
            console.log('AJAX Respuesta: Enviando petición para post:', parentId);

            $.ajax({
                url: form.attr('action'),
                method: form.attr('method'),
                data: formData,
                dataType: 'json',
                success: function(response) {
                    console.log('AJAX Respuesta: Petición exitosa, respuesta del servidor:', response);
                    updateCsrfToken(response.token);

                    if (response.status === 'success') {
                        showAlert(response.message, 'success');
                        const newReplyData = response.data;
                        newReplyData.usuario_logueado_id = response.usuario_logueado_id;
                        newReplyData.es_autor_logueado = true;
                        newReplyData.user_logged_in_is_admin = response.user_logged_in_is_admin; // Consistencia de nombre

                        const newReplyHtml = generarPublicacionItemHTML(newReplyData, true); 
                        $(`#replies-for-post-${parentId}`).append(newReplyHtml); 
                        form[0].reset(); 
                        form.closest('.responder-form-container').addClass('d-none'); 
                        console.log('AJAX Respuesta: Formulario reseteado y ocultado.');
                    } else {
                        showAlert(response.message, 'danger');
                        if (response.errors) {
                            $.each(response.errors, function(field, message) {
                                console.error(`AJAX Respuesta: Error de validación en ${field}: ${message}`);
                            });
                        }
                        console.warn('AJAX Respuesta: Servidor reportó error lógico:', response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Respuesta: Error en la petición AJAX:', status, error, xhr.responseText);
                    let errorMessage = 'Error al procesar la respuesta.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                        updateCsrfToken(xhr.responseJSON.token || getCsrfToken());
                    } else if (xhr.responseText) {
                        console.error("AJAX Respuesta: Respuesta raw:", xhr.responseText);
                        errorMessage = 'Error inesperado del servidor. Consulta la consola del navegador para más detalles.';
                    }
                    showAlert(errorMessage, 'danger');
                },
                complete: function() {
                    submitButton.prop('disabled', false).text('Enviar Respuesta');
                    console.log('AJAX Respuesta: Petición completada, botón re-habilitado.');
                }
            });
        });

        // --- Funcionalidad de eliminación ---
        $(document).on('submit', '.delete-post-form', function(e) {
            e.preventDefault();
            const form = $(this);
            const postCard = form.closest('.post-card');
            const postId = postCard.data('id');

            if (!confirm('¿Estás seguro de que quieres eliminar esta publicación/respuesta? Esta acción es irreversible.')) {
                return;
            }
            console.log('AJAX Eliminación: Enviando petición para eliminar post:', postId);
            const formData = form.serialize();

            $.ajax({
                url: form.attr('action'),
                method: form.attr('method'),
                data: formData,
                dataType: 'json',
                success: function(response) {
                    console.log('AJAX Eliminación: Petición exitosa, respuesta del servidor:', response);
                    updateCsrfToken(response.token);
                    if (response.status === 'success') {
                        showAlert(response.message, 'success');
                        postCard.fadeOut(300, function() {
                            $(this).remove(); 
                            // Verifica si no hay publicaciones principales después de eliminar
                            if ($('#lista-de-publicaciones-global').children('.post-card:not([data-parent-id])').length === 0) {
                                $('#lista-de-publicaciones-global').append('<p class="text-center no-posts-message">Aún no hay publicaciones en la comunidad. ¡Sé el primero en publicar!</p>');
                            }
                            console.log('AJAX Eliminación: Post eliminado del DOM.');
                        });
                    } else {
                        showAlert(response.message, 'danger');
                        console.warn('AJAX Eliminación: Servidor reportó error lógico:', response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Eliminación: Error en la petición AJAX:', status, error, xhr.responseText);
                    let errorMessage = 'Error inesperado al eliminar publicación/respuesta. Por favor, revisa la consola del navegador.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                        updateCsrfToken(xhr.responseJSON.token || getCsrfToken());
                    } else if (xhr.responseText) {
                        console.error("AJAX Eliminación: Respuesta raw:", xhr.responseText);
                        errorMessage = 'Error en el servidor al eliminar. Mensaje detallado en consola del navegador.';
                    }
                    showAlert(errorMessage, 'danger');
                }
            });
        });
    });
</script>
</body>
</html>