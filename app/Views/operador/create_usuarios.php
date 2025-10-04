<?php
// Tus constantes de RECURSOS_OPERADOR_ se asumen definidas en app/Config/Constants.php.
$session = session();
$isLoggedIn = $session->get('isLoggedIn');
$userData = $session->get('usuario');
$nombreCompleto = "Invitado";
$rolTexto = "Rol Desconocido";
$rutaFotoPerfil = base_url('recursos_operador/images/layout_img/user_img.jpg'); // Ruta por defecto

if ($isLoggedIn && is_array($userData)) {
    $nombreCompleto = esc($userData['nombre']) . ' ' . esc($userData['apellido_paterno']) . ' ' . esc($userData['apellido_materno']);
    $id_rol = $userData['id_rol'] ?? null;
    switch ($id_rol) {
        case 1: $rolTexto = 'Administrador'; break;
        case 2: $rolTexto = 'Operador'; break;
        case 3: $rolTexto = 'Encuestador'; break;
        default: $rolTexto = 'Miembro'; break;
    }
    if (!empty($userData['foto'])) {
        $rutaFotoPerfil = base_url('public/img_user/' . esc($userData['foto']));
    }
}
?>
<!DOCTYPE html>
<html lang="es">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Vota y Opina - Crear Encuestador</title>
      <link rel="icon" href="<?= base_url('recursos_operador/images/fevicon.png') ?>" type="image/png" />
      <link rel="stylesheet" href="<?= base_url('recursos_operador/css/bootstrap.min.css') ?>" />
      <link rel="stylesheet" href="<?= base_url('recursos_operador/css/style.css') ?>" />
      <link rel="stylesheet" href="<?= base_url('recursos_operador/css/responsive.css') ?>" />
      <link rel="stylesheet" href="<?= base_url('recursos_operador/css/colors.css') ?>" />
      <link rel="stylesheet" href="<?= base_url('recursos_operador/css/bootstrap-select.css') ?>" />
      <link rel="stylesheet" href="<?= base_url('recursos_operador/css/perfect-scrollbar.css') ?>" />
      <link rel="stylesheet" href="<?= base_url('recursos_operador/css/custom.css') ?>" />
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
   <body class="inner_page forms_page">
      <div class="full_container">
         <div class="inner_container">
            <!-- Sidebar y Topbar (igual que en la vista principal) -->
            <nav id="sidebar">
               <div class="sidebar_blog_1">
                  <div class="sidebar-header">
                     <div class="logo_section">
                        <a href="<?= base_url('operador/dashboard') ?>"><img class="logo_icon img-responsive" src="<?= base_url(RECURSOS_OPERADOR_IMAGES . '/logo/logo_icon.png') ?>" alt="Logo" /></a>
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
                            <a href="<?= base_url('operador/dashboard') ?>"><i></i> <span>Home</span></a>
                        </li>
                        <li><a href="<?= base_url('operador_user') ?>"><i></i> <span>Encuestadores</span></a></li>
                    <li>
                        <a href="<?= base_url('operador/perfil') ?>">
                            <i></i> <span>Perfil</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="logout_sidebar">
                <a href="<?= base_url('logout') ?>" class="btn_logout">
                    <i></i> Cerrar Sesión
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
                                       <a class="dropdown-item" href="<?= base_url('logout') ?>"><span>Log Out</span> <i></i></a>
                                    </div>
                                 </li>
                              </ul>
                           </div>
                        </div>
                     </div>
                  </nav>
               </div>
               <!-- Contenido principal: Formulario de creación -->
               <div class="midde_cont">
                  <div class="container-fluid">
                     <div class="row column_title">
                        <div class="col-md-12">
                           <div class="page_title">
                              <h2>Crear Nuevo Encuestador</h2>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-8 offset-md-2">
                           <div class="white_shd full margin_bottom_30">
                              <div class="full graph_content">
                                 <div class="padding_infor_info">
                                    <?php if (session()->getFlashdata('errors')): ?>
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                           <ul>
                                              <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                                  <li><?= esc($error) ?></li>
                                              <?php endforeach; ?>
                                           </ul>
                                           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                               <span aria-hidden="true">&times;</span>
                                           </button>
                                        </div>
                                    <?php endif; ?>
                                    <form action="<?= base_url('operador_user/store') ?>" method="post" enctype="multipart/form-data">
                                       <?= csrf_field() ?>
                                       <div class="form-group">
                                          <label for="nombre">Nombre</label>
                                          <input type="text" class="form-control" name="nombre" id="nombre" value="<?= old('nombre') ?>" required>
                                       </div>
                                       <div class="form-group">
                                          <label for="apellido_paterno">Apellido Paterno</label>
                                          <input type="text" class="form-control" name="apellido_paterno" id="apellido_paterno" value="<?= old('apellido_paterno') ?>" required>
                                       </div>
                                       <div class="form-group">
                                          <label for="apellido_materno">Apellido Materno</label>
                                          <input type="text" class="form-control" name="apellido_materno" id="apellido_materno" value="<?= old('apellido_materno') ?>">
                                       </div>
                                       <div class="form-group">
                                          <label for="telefono">Teléfono</label>
                                          <input type="text" class="form-control" name="telefono" id="telefono" value="<?= old('telefono') ?>">
                                       </div>
                                      
                                       <!-- INICIO DE CAMPOS DE USUARIO Y CONTRASEÑA -->
                                       <div class="form-group">
                                          <label for="usuario">Usuario</label>
                                          <div class="input-group">
                                             <input type="text" class="form-control" name="usuario" id="usuario" value="<?= old('usuario') ?>" required>
                                             <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="button" id="generate-username">Generar</button>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="form-group">
                                          <label for="contrasena">Contraseña</label>
                                          <div class="input-group">
                                             <input type="text" class="form-control" name="contrasena" id="contrasena" value="<?= old('contrasena') ?>" required>
                                             <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="button" id="generate-password">Generar</button>
                                             </div>
                                          </div>
                                       </div>
                                       <!-- FIN DE CAMPOS DE USUARIO Y CONTRASEÑA -->

                                       <div class="form-group">
                                          <label for="foto">Foto de Perfil</label>
                                          <input type="file" class="form-control-file" name="foto" id="foto" accept="image/*">
                                          <img id="preview-foto" src="#" alt="Vista previa de la foto" class="img-responsive rounded-circle mt-2" style="width: 100px; height: 100px; object-fit: cover; display: none;">
                                       </div>
                                       <div class="text-right">
                                          <a href="<?= base_url('operador_user') ?>" class="btn btn-secondary">Cancelar</a>
                                          <button type="submit" class="btn btn-primary">Guardar Encuestador</button>
                                       </div>
                                    </form>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
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
            </div>
         </div>
      </div>
      <script src="<?= base_url('recursos_operador/js/jquery.min.js') ?>"></script>
      <script src="<?= base_url('recursos_operador/js/popper.min.js') ?>"></script>
      <script src="<?= base_url('recursos_operador/js/bootstrap.min.js') ?>"></script>
      <script>
        document.addEventListener('DOMContentLoaded', function() {
            const generateUsernameBtn = document.getElementById('generate-username');
            const usernameInput = document.getElementById('usuario');
            const generatePasswordBtn = document.getElementById('generate-password');
            const passwordInput = document.getElementById('contrasena');
            const fotoInput = document.getElementById('foto');
            const previewFoto = document.getElementById('preview-foto');

            /**
             * Genera una cadena de texto aleatoria.
             * @param {number} length - La longitud de la cadena a generar.
             * @param {string} chars - El conjunto de caracteres a utilizar.
             * @returns {string}
             */
            function generateRandomString(length, chars) {
                let result = '';
                for (let i = 0; i < length; i++) {
                    result += chars.charAt(Math.floor(Math.random() * chars.length));
                }
                return result;
            }

            // Función para generar y establecer el nombre de usuario
            function generateUsername() {
                const chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
                // El prefijo es 'votayopina' (10 chars), se necesitan 5 más para un total de 15
                const randomPart = generateRandomString(5, chars);
                usernameInput.value = 'votayopina' + randomPart;
            }

            // Función para generar y establecer la contraseña
            function generatePassword() {
                const chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+-=[]{}|';
                passwordInput.type = 'text'; // Asegurarse de que sea visible
                passwordInput.value = generateRandomString(15, chars);
            }
            
            // Event listeners para los botones de generar
            generateUsernameBtn.addEventListener('click', generateUsername);
            generatePasswordBtn.addEventListener('click', generatePassword);
            
            // Generar un usuario y contraseña al cargar la página si los campos están vacíos
            if (!usernameInput.value) {
                generateUsername();
            }
            if (!passwordInput.value) {
                generatePassword();
            }

            // Lógica para previsualizar la imagen (sin cambios)
            fotoInput.addEventListener('change', function(event) {
                const [file] = event.target.files;
                if (file) {
                    previewFoto.src = URL.createObjectURL(file);
                    previewFoto.style.display = 'block';
                }
            });
        });
      </script>
   </body>
</html>

