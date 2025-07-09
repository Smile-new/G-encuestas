<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Monitor | Encuestas">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitor | Encuestas</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,600,700,800,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Oswald:300,400,500,600,700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <!-- CSS Styles -->
    <link rel="stylesheet" href="<?= base_url(RECURSOS_PUBLICOS_CSS . '/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url(RECURSOS_PUBLICOS_CSS . '/font-awesome.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url(RECURSOS_PUBLICOS_CSS . '/nice-select.css') ?>">
    <link rel="stylesheet" href="<?= base_url(RECURSOS_PUBLICOS_CSS . '/owl.carousel.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url(RECURSOS_PUBLICOS_CSS . '/magnific-popup.css') ?>">
    <link rel="stylesheet" href="<?= base_url(RECURSOS_PUBLICOS_CSS . '/slicknav.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url(RECURSOS_PUBLICOS_CSS . '/style.css') ?>">

    <style>
        /* Ajustes generales */
        body {
            font-family: 'Nunito Sans', sans-serif;
        }
        

        /* Estilos del preloader */
        #preloder {
            position: fixed;
            width: 100%;
            height: 100vh;
            background: #000;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .loader {
            border: 5px solid #fff;
            border-top: 5px solid #ff5722;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Responsividad */
        @media (max-width: 768px) {
            .hero-text {
                text-align: center;
                padding: 20px;
            }

            .hero-text h1 {
                font-size: 24px;
            }

            .primary-btn {
                font-size: 16px;
                padding: 10px 20px;
            }
        }

        /* Iconos sociales */
        .social-icon {
            width: 25px;
            margin: 0 5px;
            transition: transform 0.3s ease;
        }

        .social-icon:hover {
            transform: scale(1.2);
        }

        /* Logo */
        .header-section .logo img {
            max-height: 80px;
        }

        /* Estilos para la sección hero */
.hero-section {
    position: relative;
    overflow: hidden;
}

.single-hero-item {
    height: 100vh; /* ✅ Pantalla completa adaptable */
    display: flex;
    align-items: center;
    justify-content: center;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}

.hero-text {
    text-align: center;
    color: #fff;
    padding: 20px;
}

.hero-text h1 {
    font-size: 3rem;
    font-weight: 800;
    text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.4);
    margin-bottom: 20px;
}

.primary-btn {
    display: inline-block;
    background-color: #ff3d00;
    color: white;
    padding: 14px 28px;
    font-weight: 700;
    text-transform: uppercase;
    border-radius: 4px;
    transition: background 0.3s ease;
    font-size: 1rem;
    border: none;
    text-decoration: none;
}

.primary-btn:hover {
    background-color: #d93000;
}

/* ✅ Responsividad para móviles */
@media (max-width: 768px) {
    .hero-text h1 {
        font-size: 1.8rem;
        line-height: 1.3;
    }

    .primary-btn {
        font-size: 0.9rem;
        padding: 10px 20px;
    }

    .single-hero-item {
        height: 100vh; /* aún se adapta */
        padding: 40px 20px;
    }
}

    </style>
</head>

<body>
    <!-- Page Preloader -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Header -->
    <header class="header-section">
        <div class="container-fluid">
            <div class="logo">
                <a href="<?= base_url('home') ?>">
                    <img src="<?= base_url('recursos_publicos/img/mon.png') ?>" alt="Monitor">
                </a>
            </div>
            <div class="top-social">
                <a href="https://www.youtube.com/@GrupoMonitorCom">
                    <img src="<?= base_url('recursos_publicos/img/icon/1.png') ?>" alt="YouTube" class="social-icon">
                </a>
                <a href="https://www.instagram.com/grupomonitorcom/">
                    <img src="<?= base_url('recursos_publicos/img/icon/4.png') ?>" alt="Instagram" class="social-icon">
                </a>
                <a href="https://www.facebook.com/GrupoMonitorCom">
                    <img src="<?= base_url('recursos_publicos/img/icon/5.png') ?>" alt="Facebook" class="social-icon">
                </a>
            </div>

            <div class="container">
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
            <div id="mobile-menu-wrap"></div>
        </div>
    </header>
    
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-items owl-carousel">
            <div class="single-hero-item set-bg" data-setbg="<?= base_url('recursos_publicos/img/hero-slider/hero-1.jpg') ?>">
                <div class="container">
                    <div class="hero-text">
                        <h1>Participa en nuestras Encuestas</h1>
                        <a href="<?= base_url('encuestasp') ?>" class="primary-btn">Contestar</a>
                    </div>
                </div>
            </div>
            <div class="single-hero-item set-bg" data-setbg="<?= base_url('recursos_publicos/img/hero-slider/hero-2.jpg') ?>">
                <div class="container">
                    <div class="hero-text">
                        <h1>Descubre cómo los datos pueden ayudarte</h1>
                        <a href="<?= base_url('encuestasp') ?>" class="primary-btn">Contestar</a>
                    </div>
                </div>
            </div>
            <div class="single-hero-item set-bg" data-setbg="<?= base_url('recursos_publicos/img/hero-slider/hero-3.jpg') ?>">
                <div class="container">
                    <div class="hero-text">
                        <h1>Analiza tendencias en tiempo real</h1>
                        <a href="<?= base_url('encuestasp') ?>" class="primary-btn">Contestar</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Scripts -->
    <script src="<?= base_url(RECURSOS_PUBLICOS_JS . '/jquery-3.3.1.min.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_PUBLICOS_JS . '/bootstrap.min.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_PUBLICOS_JS . '/jquery.slicknav.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_PUBLICOS_JS . '/owl.carousel.min.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_PUBLICOS_JS . '/main.js') ?>"></script>

    <script>
        $(document).ready(function(){
            $(".hero-items").owlCarousel({
                items: 1,
                loop: true,
                autoplay: true,
                autoplayTimeout: 5000,
                animateOut: 'fadeOut',
                animateIn: 'fadeIn',
                smartSpeed: 1000
            });

            // Esconder el preloader
            $(window).on('load', function () {
                $("#preloder").fadeOut();
            });
        });
    </script>
</body>
</html>
