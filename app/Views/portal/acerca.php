<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Videograph Template">
    <meta name="keywords" content="Videograph, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Acerca de</title>

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

<style>

.opaco {
    height: 100%;
    width: 100%;
    background-color: rgba(46, 46, 46, 0.5);
    position: absolute;
    top: 0;
    left: 0;
    z-index: 1;
    display: flex;
    justify-content: center;
    align-items: center;
    opacity: 1;
    transition: opacity 0.3s ease;
}

.set-bg {
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center center;
}

.about__pic__item {
    position: relative;
    overflow: hidden;
    min-height: 250px;
    margin-bottom: 20px;
}

.about__pic__item--large {
    min-height: 500px;
}

.about__pic__item:hover .opaco {
    opacity: 0;
}

</style>

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
                                <li class="active"><a href="<?= base_url('acerca') ?>">Acerca de</a></li>
                                <li><a href="<?= base_url('servicios') ?>">Servicios</a></li>
                                <li><a href="<?= base_url('contacto') ?>">Contacto</a></li>
                               

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
                        <h2>Acerca de</h2>
                        <div class="breadcrumb__links">
                            <a href="<?= base_url('/') ?>">Inicio</a>
                            <span>Acerca de</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->
<section class="about spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="about__pic">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="about__pic__item about__pic__item--large set-bg"
                                data-setbg="<?= base_url(RECURSOS_USUARIO_IMG.'/about/tlax-1.jpg')?>">
                                <div class="opaco"></div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="about__pic__item set-bg" data-setbg="<?= base_url(RECURSOS_USUARIO_IMG.'/about/tlax-2.jpg')?>">
                                        <div class="opaco"></div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="about__pic__item set-bg" data-setbg="<?= base_url(RECURSOS_USUARIO_IMG.'/about/tlax-3.jpg')?>">
                                        <div class="opaco"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about__text">
                    <div class="section-title">
    <span>RANKER</span>
    <h2>Así Obtenemos tus Datos</h2>
</div>
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <div class="services__item">
            <div class="services__item__icon">
                <img src="<?= base_url(RECURSOS_USUARIO_IMG.'/icons/si-3.png')?>" alt="">
            </div>
            <h4>Nuestro Equipo en Campo</h4>
            <p>Contamos con encuestadores profesionales que recogen información esencial directamente donde ocurre, con gran precisión.</p>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6">
        <div class="services__item">
            <div class="services__item__icon">
                <img src="<?= base_url(RECURSOS_USUARIO_IMG.'/icons/si-chart.png')?>" alt="">
            </div>
            <h4>Información al Instante</h4>
            <p>Los datos recopilados están disponibles rápidamente, listos para que los analices y tomes decisiones informadas.</p>
        </div>
    </div>
</div>
<div class="about__text__desc">
    <p>Con RANKER, siempre tendrás acceso a información confiable y actualizada. Te ayudamos a entender mejor a tu audiencia y a impulsar tus proyectos con decisiones estratégicas.</p>
</div>
                </div>
            </div>
        </div>
    </div>
</section>

   <section class="testimonial spad set-bg" data-setbg="<?= base_url(RECURSOS_USUARIO_IMG.'/testimonial-bg.jpg')?>">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title center-title">
                    <span>Creamos información valiosa para ti</span>
                    <h2>Nuestros Beneficios</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="testimonial__slider owl-carousel">
                <div class="col-lg-4">
                    <div class="testimonial__item">
                        <div class="testimonial__text">
                            <p>Te damos datos claros para que tus planes funcionen mejor.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="testimonial__item">
                        <div class="testimonial__text">
                            <p>Obtén información real, siempre al día y ubicada en el mapa.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="testimonial__item">
                        <div class="testimonial__text">
                            <p>Toma las mejores decisiones justo cuando las necesitas.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="testimonial__item">
                        <div class="testimonial__text">
                            <p>Entiende a fondo a quién te diriges.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="testimonial__item">
                        <div class="testimonial__text">
                            <p>Descubre lo que la gente piensa y qué es importante para ellos.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
    <!-- Testimonial Section End -->


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