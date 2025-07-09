<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Videograph Template">
    <meta name="keywords" content="Videograph, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Servicios</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Play:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="<?= base_url(RECURSOS_USUARIO_CSS.'/bootstrap.min.css')?>" type="text/css">
    <link rel="stylesheet" href="<?= base_url(RECURSOS_USUARIO_CSS.'/font-awesome.min.css')?>" type="text/css">
    <link rel="stylesheet" href="<?= base_url(RECURSOS_USUARIO_CSS.'/elegant-icons.css')?>" type="text/css">
    <link rel="stylesheet" href="<?= base_url(RECURSOS_USUARIO_CSS.'/owl.carousel.min.css')?>" type="text/css">
    <link rel="stylesheet" href="<?= base_url(RECURSOS_USUARIO_CSS.'/magnific-popup.css')?>" type="text/css">
    <link rel="stylesheet" href="<?= base_url(RECURSOS_USUARIO_CSS.'/slicknav.min.css')?>" type="text/css">
    <link rel="stylesheet" href="<?= base_url(RECURSOS_USUARIO_CSS.'/style.css')?>" type="text/css">

    <link rel="icon" type="image/png" href="<?= base_url(RECURSOS_USUARIO_IMG.'/logo/minilogo.png')?>">
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Header Section Begin -->
    <header class="header">
        <div class="container">
            <div class="row">
                <div class="col-lg-2">
                    <div class="header__logo">
                        <a href="<?= base_url('/') ?>"><img src="<?= base_url(RECURSOS_USUARIO_IMG.'/logo/logo.png')?>" alt=""></a>
                    </div>
                </div>
                <div class="col-lg-10">
                    <div class="header__nav__option">
                        <nav class="header__nav__menu mobile-menu">
                            <ul>
                                <li><a href="<?= base_url('/') ?>">Inicio</a></li>
                                <li><a href="<?= base_url('acerca') ?>">Acerca de</a></li>
                                <li class="active"><a href="<?= base_url('servicios') ?>">Servicios</a></li>
                                <li><a href="<?= base_url('contacto') ?>">Contacto</a></li>
                                <li><a href="<?= base_url('login') ?>">Inicio Sesion</a></li>

                            </ul>
                        </nav>
                        <div class="header__nav__social">
                            <a href="https://www.facebook.com/RankerMX" target="_blank"><i class="fa fa-facebook"></i></a>
                            <a href="https://twitter.com/Ranker_Mx" target="_blank"><i class="fa fa-twitter"></i></a>
                            <a href="https://www.instagram.com/Ranker.Mx" target="_blank"><i class="fa fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="mobile-menu-wrap"></div>
        </div>
    </header>
    <!-- Header End -->

    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option spad set-bg" data-setbg="<?= base_url(RECURSOS_USUARIO_IMG.'/breadcrumb-bg.jpg')?>">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Servicios</h2>
                        <div class="breadcrumb__links">
                            <a href="<?= base_url('/') ?>">Inicio</a>
                            <span>Servicios</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Services Section Begin -->
    <section class="services-page spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="services__item">
                        <div class="services__item__icon">
                            <img src="<?= base_url(RECURSOS_USUARIO_IMG.'/icons/tecnologia.png')?>" alt="">
                        </div>
                        <h4>Tecnología Propia</h4>
                        <p>Contamos con un sistema exclusivo desarrollado por nosotros, diseñado para ofrecer resultados precisos y eficientes. Esta herramienta tecnológica nos permite tener control total del proceso, garantizando calidad y rapidez en cada etapa.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="services__item">
                        <div class="services__item__icon">
                            <img src="<?= base_url(RECURSOS_USUARIO_IMG.'/icons/datos.png')?>" alt="">
                        </div>
                        <h4>Cruce Dinámico de Datos</h4>
                        <p>Nuestra base de datos dinámica permite cruzar resultados con múltiples variables, ofreciendo un análisis más profundo y segmentado. Esto brinda a nuestros clientes una perspectiva más detallada de los datos obtenidos.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="services__item">
                        <div class="services__item__icon">
                            <img src="<?= base_url(RECURSOS_USUARIO_IMG.'/icons/analisis.png')?>" alt="">
                        </div>
                        <h4>Análisis Personalizado</h4>
                        <p>La información recolectada está completamente disponible para nuestros clientes, quienes pueden solicitar análisis específicos según sus necesidades. Nos adaptamos a los objetivos de cada cliente para entregar soluciones accionables y claras.</p>
                    </div>
                </div>
                
            </div>
        </div>
    </section>
    <!-- Services Section End -->

    <!-- Call To Action Section Begin -->
    <section class="callto sp__callto">
        <div class="container">
            <div class="callto__services spad set-bg" data-setbg="<?= base_url(RECURSOS_USUARIO_IMG.'/calltos-bg.jpg')?>">
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-10 text-center">
                        <div class="callto__text">
                            <h2>GENERAMOS LOS DATOS DE MÁS FUERZA</h2>
                            <p>Obtenemos información precisa, actual y georreferenciada que impulsa estrategias sólidas y decisiones efectivas en
                                 el momento justo. Confía en datos que realmente marcan la diferencia.</p>
                            <a href="/contacto">Contactanos</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Call To Action Section End -->

    <!-- Logo Begin -->
    <div class="logo spad">
        <div class="container">
            <div class="logo__carousel owl-carousel">
                <a href="#" class="logo__item"><img src="img/logo/logo-1.png" alt=""></a>
                <a href="#" class="logo__item"><img src="img/logo/logo-2.png" alt=""></a>
                <a href="#" class="logo__item"><img src="img/logo/logo-3.png" alt=""></a>
                <a href="#" class="logo__item"><img src="img/logo/logo-4.png" alt=""></a>
                <a href="#" class="logo__item"><img src="img/logo/logo-5.png" alt=""></a>
                <a href="#" class="logo__item"><img src="img/logo/logo-6.png" alt=""></a>
            </div>
        </div>
    </div>
    <!-- Logo End -->

    <!-- Footer Section Begin -->
    <footer class="footer">
        <div class="container">
            <div class="footer__top">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="footer__top__logo">
                            <a href="#"><img src="img/logo.png" alt=""></a>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="footer__top__social">
                            <a href="https://www.facebook.com/RankerMX" target="_blank"><i class="fa fa-facebook"></i></a>
                            <a href="https://twitter.com/Ranker_Mx" target="_blank"><i class="fa fa-twitter"></i></a>
                            <a href="https://www.instagram.com/Ranker.Mx" target="_blank"><i class="fa fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer__option">
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <div class="footer__option__item">
                            <h5>Acerca de nosotros</h5>
                            <p>Recopilamos datos clave mediante censos y encuestas confiables para ayudarte a comprender mejor a tu comunidad y tomar decisiones informadas.</p>
                            <a href="/acerca" class="read__more">Leer más <span class="arrow_right"></span></a>
                        </div>
                    </div>
                    <!--
                    <div class="col-lg-2 col-md-3">
                        <div class="footer__option__item">
                            <h5>Who we are</h5>
                            <ul>
                                <li><a href="#">Team</a></li>
                                <li><a href="#">Carrers</a></li>
                                <li><a href="#">Contact us</a></li>
                                <li><a href="#">Locations</a></li>
                            </ul>
                        </div>
                    </div>
                    -->
                    <div class="col-lg-4 col-md-12">
                        <div class="footer__option__item">
                            <h5>Nosotros</h5>
                            <ul>
                                <li><a href="/inicio">Inicio</a></li>
                                <li><a href="/acerca">Acerca de Nosotros</a></li>
                                <li><a href="/servicios">Servicios</a></li>
                                <li><a href="/contacto">Contacto</a></li>
                            </ul>
                        </div>
                    </div>
                    <!--
                    <div class="col-lg-4 col-md-12">
                        <div class="footer__option__item">
                            <h5>Newsletter</h5>
                            <p>Videoprah is an award-winning, full-service production company specializing.</p>
                            <form action="#">
                                <input type="text" placeholder="Email">
                                <button type="submit"><i class="fa fa-send"></i></button>
                            </form>
                        </div>
                    </div>
                        -->
                </div>
            </div>
            <div class="footer__copyright">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        <p class="footer__copyright__text">Copyright &copy;
                            <script>
                                document.write(new Date().getFullYear());
                            </script>
                            Todos los derechos reservados
                        </p>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer Section End -->

    <!-- Js Plugins -->
    <script src="<?= base_url(RECURSOS_USUARIO_JS.'/jquery-3.3.1.min.js')?>"></script>
    <script src="<?= base_url(RECURSOS_USUARIO_JS.'/bootstrap.min.js')?>"></script>
    <script src="<?= base_url(RECURSOS_USUARIO_JS.'/jquery.magnific-popup.min.js')?>"></script>
    <script src="<?= base_url(RECURSOS_USUARIO_JS.'/mixitup.min.js')?>"></script>
    <script src="<?= base_url(RECURSOS_USUARIO_JS.'/masonry.pkgd.min.js')?>"j></script>
    <script src="<?= base_url(RECURSOS_USUARIO_JS.'/jquery.slicknav.js')?>"></script>
    <script src="<?= base_url(RECURSOS_USUARIO_JS.'/owl.carousel.min.js')?>"></script>
    <script src="<?= base_url(RECURSOS_USUARIO_JS.'/main.js')?>"></script>
</body>

</html>