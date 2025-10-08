<?php
// Tus constantes de RECURSOS_OPERADOR_ se asumen definidas en app/Config/Constants.php.
// Son necesarias para que base_url() funcione correctamente con ellas.

// Obtener la instancia de la sesión al inicio del archivo
$session = session();

// Preparar los datos del usuario para mostrar en la plantilla
$isLoggedIn = $session->get('isLoggedIn');
$userData = $session->get('usuario'); // Obtener todo el array 'usuario' de la sesión

// Definir valores por defecto si el usuario no está logueado o los datos no existen
$nombreCompleto = "Invitado";
$rolTexto = "Rol Desconocido";
$rutaFotoPerfil = base_url(RECURSOS_OPERADOR_IMAGES . '/layout_img/user_img.jpg'); // Imagen por defecto de la plantilla

if ($isLoggedIn && is_array($userData)) {
    $nombreCompleto = esc($userData['nombre']) . ' ' .
                      esc($userData['apellido_paterno']) . ' ' .
                      esc($userData['apellido_materno']);
    
$rolTexto = esc($userData['nombre_rol'] ?? 'Rol desconocido');

    // Si hay una foto de usuario cargada en la sesión, usarla; de lo contrario, usar la por defecto
    if (!empty($userData['foto'])) {
        // Asegúrate de que 'public/img_user/' sea la ruta correcta donde guardas las fotos de usuario
        $rutaFotoPerfil = base_url('public/img_user/' . esc($userData['foto']));
    }
}
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <title>Vota y Opina - Estat</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <link rel="icon" href="<?= base_url(RECURSOS_OPERADOR_IMAGES . '/fevicon.png') ?>" type="image/png" />
      <link rel="stylesheet" href="<?= base_url(RECURSOS_OPERADOR_CSS . '/bootstrap.min.css') ?>" />
      <link rel="stylesheet" href="<?= base_url(RECURSOS_OPERADOR_CSS . '/style.css') ?>" />
      <link rel="stylesheet" href="<?= base_url(RECURSOS_OPERADOR_CSS . '/responsive.css') ?>" />
      <link rel="stylesheet" href="<?= base_url(RECURSOS_OPERADOR_CSS . '/colors.css') ?>" />
      <link rel="stylesheet" href="<?= base_url(RECURSOS_OPERADOR_CSS . '/bootstrap-select.css') ?>" />
      <link rel="stylesheet" href="<?= base_url(RECURSOS_OPERADOR_CSS . '/perfect-scrollbar.css') ?>" />
      <link rel="stylesheet" href="<?= base_url(RECURSOS_OPERADOR_CSS . '/custom.css') ?>" />
      <link rel="stylesheet" href="<?= base_url(RECURSOS_OPERADOR_JS . '/semantic.min.css') ?>" />

        <style>
       .logout_sidebar {
    position: absolute;
    bottom: 20px; /* distancia desde abajo */
    width: 100%;
    text-align: center;
}

.logout_sidebar .btn_logout {
    display: inline-block;
    padding: 10px 15px;
    background-color: #f5f5f5; /* color de fondo opcional */
    border-radius: 5px;
    color: #333;
    text-decoration: none;
    font-weight: bold;
    transition: all 0.3s;
}

.logout_sidebar .btn_logout:hover {
    background-color: #e74c3c;
    color: #fff;
}

     </style>
      </head>
   <body class="inner_page map">
      <div class="full_container">
         <div class="inner_container">
            <nav id="sidebar">
               <div class="sidebar_blog_1">
                  <div class="sidebar-header">
                     <div class="logo_section">
                        <a href="<?= base_url('operador/dashboard') ?>"><img class="logo_icon img-responsive" src="<?= base_url(RECURSOS_OPERADOR_IMAGES . '/logo/logo_icon.png') ?>" alt="#" /></a>
                     </div>
                  </div>
                  <div class="sidebar_user_info">
                     <div class="icon_setting"></div>
                     <div class="user_profle_side">
                        <div class="user_img">
                           <!-- Foto de perfil dinámica en el sidebar -->
                           <img class="img-responsive" src="<?= $rutaFotoPerfil ?>" alt="Foto de perfil" />
                        </div>
                        <div class="user_info">
                           <!-- Nombre completo dinámico en el sidebar -->
                           <h6><?= $nombreCompleto ?></h6>
                           <!-- Rol dinámico en el sidebar -->
                           <p><span class="online_animation"></span> <?= $rolTexto ?></p>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="sidebar_blog_2">
                  <h4>General</h4>
                  <ul class="list-unstyled components">
                     <li class="active">
                      <a href="<?= base_url('dash') ?>"><i class="fa fa-dashboard yellow_color"></i> <span>Dashboard</span></a>
                     </li>
                     <li><a href="<?= base_url('tab') ?>"><i class="fa fa-table purple_color2"></i> <span>Tables</span></a></li>
                     <li><a href="<?= base_url('estat') ?>"><i class="fa fa-bar-chart-o green_color"></i> <span>Charts</span></a></li>
                    <li>
                        <a href="<?= base_url('operador/perfil') ?>">
                            <i class="fa fa-user purple_color2"></i> <span>Perfil</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="logout_sidebar">
                <a href="<?= base_url('logout') ?>" class="btn_logout">
                    <i class="fa fa-sign-out purple_color2"></i> Cerrar Sesión
                </a>
            </div>
        </nav>
            <div id="content">
               <div class="topbar">
                  <nav class="navbar navbar-expand-lg navbar-light">
                     <div class="full">
                        <button type="button" id="sidebarCollapse" class="sidebar_toggle"><i class="fa fa-bars"></i></button>
                        <div class="right_topbar">
                           <div class="icon_info">
                              <ul class="user_profile_dd">
                                 <li>
                                    <!-- Foto de perfil dinámica en la navbar -->
                                    <a class="dropdown-toggle" data-toggle="dropdown"><img class="img-responsive rounded-circle" src="<?= $rutaFotoPerfil ?>" alt="Foto de perfil" /><span class="name_user"><?= $nombreCompleto ?></span></a>
                                    <div class="dropdown-menu">
                                       <a class="dropdown-item" href="<?= base_url('logout') ?>"><span>Log Out</span> <i class="fa fa-sign-out"></i></a>
                                    </div>
                                 </li>
                              </ul>
                           </div>
                        </div>
                     </div>
                  </nav>
               </div>
               <!-- Aquí iría el contenido principal de tu página de operador -->
               <div class="midde_cont">
                  <div class="container-fluid">
                     <div class="row column_title">
                        <div class="col-md-12">
                           <div class="page_title">
                              <h2>Panel de Operador</h2>
                           </div>
                        </div>
                     </div>
                     <!-- Aquí puedes agregar tus tarjetas, gráficos o tablas específicas del operador -->
                     <div class="row column1">
                        <div class="col-md-12">
                           <div class="white_shd full margin_bottom_30">
                              <div class="full graph_head">
                                 <div class="heading1 margin_0">
                                    <h2>Bienvenido, <?= esc($userData['nombre'] ?? 'Operador') ?>!</h2>
                                 </div>
                              </div>
                              <div class="full graph_content">
                                 <div class="row">
                                    <div class="col-md-12">
                                       <p>Este es tu panel de control como Operador. Aquí puedes gestionar las operaciones y ver estadísticas relevantes.</p>
                                       <p>Tu rol actual es: <strong><?= $rolTexto ?></strong></p>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- Fin del contenido principal del operador -->
                  </div>
                  <!-- footer -->
                  <div class="container-fluid">
                     <div class="footer">
                        <p>Copyright © 2025 Vota y Opina. All rights reserved.<br><br>
                           Distributed By: <a href="https://themewagon.com/">ThemeWagon</a>
                        </p>
                     </div>
                  </div>
               </div>
            </div> <!-- Cierre del div id="content" -->
         </div>
      </div>
      <script src="<?= base_url(RECURSOS_OPERADOR_JS . '/jquery.min.js') ?>"></script>
      <script src="<?= base_url(RECURSOS_OPERADOR_JS . '/popper.min.js') ?>"></script>
      <script src="<?= base_url(RECURSOS_OPERADOR_JS . '/bootstrap.min.js') ?>"></script>
      <script src="<?= base_url(RECURSOS_OPERADOR_JS . '/Chart.min.js') ?>"></script>
      <script src="<?= base_url(RECURSOS_OPERADOR_JS . '/Chart.bundle.min.js') ?>"></script>
      <script src="<?= base_url(RECURSOS_OPERADOR_JS . '/utils.js') ?>"></script>
      <script src="<?= base_url(RECURSOS_OPERADOR_JS . '/analyser.js') ?>"></script>
      <script src="<?= base_url(RECURSOS_OPERADOR_JS . '/animate.js') ?>"></script>
      <script src="<?= base_url(RECURSOS_OPERADOR_JS . '/bootstrap-select.js') ?>"></script>
      <script src="<?= base_url(RECURSOS_OPERADOR_JS . '/owl.carousel.js') ?>"></script> 
      <script src="<?= base_url(RECURSOS_OPERADOR_JS . '/perfect-scrollbar.min.js') ?>"></script>
      <script>
         var ps = new PerfectScrollbar('#sidebar');
      </script>
      <script src="<?= base_url(RECURSOS_OPERADOR_JS . '/custom.js') ?>"></script>
      <script src="<?= base_url(RECURSOS_OPERADOR_JS . '/semantic.min.js') ?>"></script>
   </body>
</html>
