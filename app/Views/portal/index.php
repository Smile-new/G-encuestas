<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Videograph Template">
    <meta name="keywords" content="Videograph, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inicio</title>

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

.work__item {
    position: relative;
    overflow: hidden;
    height: 300px;
    margin-bottom: 20px;
}

.work__item:hover .opaco {
    opacity: 0;
}

.set-bg {
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center center;
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
                                <li class="active"><a href="<?= base_url('/') ?>">Inicio</a></li>
                                <li><a href="<?= base_url('acerca') ?>">Acerca de</a></li>
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

    <!-- Hero Section Begin -->
    <section class="hero">
        <div class="hero__slider owl-carousel">
            <div class="hero__item set-bg" data-setbg="<?= base_url(RECURSOS_USUARIO_IMG.'/hero/hero-1.png')?>">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="hero__text">
                                <span>Sé parte del cambio</span>
                                <h2>Vota y Opina</h2>
                                <a href="/acerca" class="primary-btn">Saber más de nosotros</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hero__item set-bg" data-setbg="<?= base_url(RECURSOS_USUARIO_IMG.'/hero/hero-2.png')?>">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="hero__text">
                                <span>Sé parte del cambio</span>
                                <h2>Vota y Opina</h2>
                                <a href="/acerca" class="primary-btn">Saber más de nosotros</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hero__item set-bg" data-setbg="<?= base_url(RECURSOS_USUARIO_IMG.'/hero/hero-3.png')?>">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="hero__text">
                                <span>Sé parte del cambio</span>
                                <h2>Vota y Opina</h2>
                                <a href="/acerca" class="primary-btn">Saber más de nosotros</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- Services Section Begin -->
    <section class="services spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="services__title">
                        <div class="section-title">
                            <span>¿Qué ofrece Opina y Vota?</span>
                            <h2>Generales</h2>
                        </div>
                        <p>Te acompañamos en la obtención de información valiosa mediante censos y encuestas confiables, creados para identificar las necesidades y comportamientos de tu comunidad. Nuestro compromiso es ofrecerte datos precisos y oportunos que fortalezcan tus decisiones estratégicas.</p>
                        <a href="/servicios" class="primary-btn">Ver nuestros servicios</a>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="services__item">
                                <div class="services__item__icon">
                                    <img src="<?= base_url(RECURSOS_USUARIO_IMG.'/icons/app.png')?>" alt="">
                                </div>
                                <h4>Aplicaciones específicas para encuestadores</h4>
                                <p>Contamos con herramientas digitales diseñadas para facilitar el trabajo en campo, optimizando la captura de datos y reduciendo errores en el proceso.</p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="services__item">
                                <div class="services__item__icon">
                                    <img src="<?= base_url(RECURSOS_USUARIO_IMG.'/icons/medir.png')?>" alt="">
                                </div>
                                <h4>Medición de parámetros clave</h4>
                                <p>Evaluamos distintos indicadores fundamentales para el análisis electoral, incluyendo:</p>
                                <ul>
                                    <li><strong>Nivel de conocimiento</strong> sobre los candidatos o partidos políticos.</li>
                                    <li><strong>Intención de voto</strong> en distintas etapas del proceso electoral.</li>
                                    <li><strong>Demás parámetros electorales</strong> relevantes para construir estrategias efectivas.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Services Section End -->

    <!-- Work Section Begin -->
    <section class="work">
    <div class="work__gallery">
        <div class="grid-sizer"></div>

        <div class="work__item wide__item set-bg" data-setbg="<?= base_url(RECURSOS_USUARIO_IMG . '/work/Tlaxcala.jpg') ?>">
            <div class="opaco"></div>
        </div>

        <div class="work__item small__item set-bg" data-setbg="<?= base_url(RECURSOS_USUARIO_IMG . '/work/voto.jpg') ?>">
            <div class="opaco"></div>
        </div>

        <div class="work__item small__item set-bg" data-setbg="<?= base_url(RECURSOS_USUARIO_IMG . '/work/noche.jpg') ?>">
            <div class="opaco"></div>
        </div>

        <div class="work__item large__item set-bg" data-setbg="<?= base_url(RECURSOS_USUARIO_IMG . '/work/Encuestador.jpg') ?>">
            <div class="opaco"></div>
        </div>

        <div class="work__item small__item set-bg" data-setbg="<?= base_url(RECURSOS_USUARIO_IMG . '/work/electoral.jpg') ?>">
            <div class="opaco"></div>
        </div>

        <div class="work__item small__item set-bg" data-setbg="<?= base_url(RECURSOS_USUARIO_IMG . '/work/eleccion.jpg') ?>">
            <div class="opaco"></div>
        </div>

        <div class="work__item wide__item set-bg" data-setbg="<?= base_url(RECURSOS_USUARIO_IMG . '/work/beneficios.jpg') ?>">
            <div class="opaco"></div>
        </div>
    </div>
</section>
    <!-- Work Section End -->

    <!-- Counter Section Begin -->
    <section class="counter">
        <div class="container">
            <div class="counter__content">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="counter__item">
                            <div class="counter__item__text">
                                <img src="img/icons/ci-1.png" alt="">
                                <h2 class="counter_num">1</h2>
                                <p>Visión 360º del electorado</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="counter__item second__item">
                            <div class="counter__item__text">
                                <img src="img/icons/ci-2.png" alt="">
                                <h2 class="counter_num">2</h2>
                                <p>Útil para distintos sectores.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="counter__item third__item">
                            <div class="counter__item__text">
                                <img src="img/icons/ci-3.png" alt="">
                                <h2 class="counter_num">3</h2>
                                <p>Base para buenas decisiones.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="counter__item four__item">
                            <div class="counter__item__text">
                                <img src="img/icons/ci-4.png" alt="">
                                <h2 class="counter_num">4</h2>
                                <p>Datos clave en el momento.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Counter Section End -->

    <!-- Team Section Begin 
    <section class="team spad set-bg" data-setbg="img/team-bg.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title team__title">
                        <span>Nice to meet</span>
                        <h2>OUR Team</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 p-0">
                    <div class="team__item set-bg" data-setbg="img/team/team-1.jpg">
                        <div class="team__item__text">
                            <h4>AMANDA STONE</h4>
                            <p>Videographer</p>
                            <div class="team__item__social">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-dribbble"></i></a>
                                <a href="#"><i class="fa fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 p-0">
                    <div class="team__item team__item--second set-bg" data-setbg="img/team/team-2.jpg">
                        <div class="team__item__text">
                            <h4>AMANDA STONE</h4>
                            <p>Videographer</p>
                            <div class="team__item__social">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-dribbble"></i></a>
                                <a href="#"><i class="fa fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 p-0">
                    <div class="team__item team__item--third set-bg" data-setbg="img/team/team-3.jpg">
                        <div class="team__item__text">
                            <h4>AMANDA STONE</h4>
                            <p>Videographer</p>
                            <div class="team__item__social">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-dribbble"></i></a>
                                <a href="#"><i class="fa fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 p-0">
                    <div class="team__item team__item--four set-bg" data-setbg="img/team/team-4.jpg">
                        <div class="team__item__text">
                            <h4>AMANDA STONE</h4>
                            <p>Videographer</p>
                            <div class="team__item__social">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-dribbble"></i></a>
                                <a href="#"><i class="fa fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 p-0">
                    <div class="team__btn">
                        <a href="#" class="primary-btn">Meet Our Team</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
     Team Section End -->

    <!-- Latest Blog Section Begin
    <section class="latest spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title center-title">
                        <span>Our Blog</span>
                        <h2>Blog Update</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="latest__slider owl-carousel">
                    <div class="col-lg-4">
                        <div class="blog__item latest__item">
                            <h4>What Makes Users Want to Share a Video on Social Media?</h4>
                            <ul>
                                <li>Jan 03, 2020</li>
                                <li>05 Comment</li>
                            </ul>
                            <p>We recently launched a new website for a Vital client and wanted to share some of the
                                cool features we were able...</p>
                            <a href="#">Read more <span class="arrow_right"></span></a>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="blog__item latest__item">
                            <h4>Bumper Ads: How to Tell a Story in 6 Seconds</h4>
                            <ul>
                                <li>Jan 03, 2020</li>
                                <li>05 Comment</li>
                            </ul>
                            <p>We recently launched a new website for a Vital client and wanted to share some of the
                                cool features we were able...</p>
                            <a href="#">Read more <span class="arrow_right"></span></a>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="blog__item latest__item">
                            <h4>What Makes Users Want to Share a Video on Social Media?</h4>
                            <ul>
                                <li>Jan 03, 2020</li>
                                <li>05 Comment</li>
                            </ul>
                            <p>We recently launched a new website for a Vital client and wanted to share some of the
                                cool features we were able...</p>
                            <a href="#">Read more <span class="arrow_right"></span></a>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="blog__item latest__item">
                            <h4>Bumper Ads: How to Tell a Story in 6 Seconds</h4>
                            <ul>
                                <li>Jan 03, 2020</li>
                                <li>05 Comment</li>
                            </ul>
                            <p>We recently launched a new website for a Vital client and wanted to share some of the
                                cool features we were able...</p>
                            <a href="#">Read more <span class="arrow_right"></span></a>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="blog__item latest__item">
                            <h4>What Makes Users Want to Share a Video on Social Media?</h4>
                            <ul>
                                <li>Jan 03, 2020</li>
                                <li>05 Comment</li>
                            </ul>
                            <p>We recently launched a new website for a Vital client and wanted to share some of the
                                cool features we were able...</p>
                            <a href="#">Read more <span class="arrow_right"></span></a>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="blog__item latest__item">
                            <h4>What Makes Users Want to Share a Video on Social Media?</h4>
                            <ul>
                                <li>Jan 03, 2020</li>
                                <li>05 Comment</li>
                            </ul>
                            <p>We recently launched a new website for a Vital client and wanted to share some of the
                                cool features we were able...</p>
                            <a href="#">Read more <span class="arrow_right"></span></a>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="blog__item latest__item">
                            <h4>What Makes Users Want to Share a Video on Social Media?</h4>
                            <ul>
                                <li>Jan 03, 2020</li>
                                <li>05 Comment</li>
                            </ul>
                            <p>We recently launched a new website for a Vital client and wanted to share some of the
                                cool features we were able...</p>
                            <a href="#">Read more <span class="arrow_right"></span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    Latest Blog Section End -->

    <!-- Call To Action Section Begin -->
    <section class="callto spad set-bg" data-setbg="<?= base_url(RECURSOS_USUARIO_IMG.'/callto-bg.jpg')?>">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="callto__text">
                        <h2>Datos que inspiran decisiones, conocimiento que transforma comunidades.</h2>
                        <p>Confiabilidad, innovación y cercanía en cada encuesta.</p>
                        <a href="/contacto">Contáctanos</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Call To Action Section End -->

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