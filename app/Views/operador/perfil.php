<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vota y Opina - Perfil</title>
    <link rel="icon" href="<?= base_url('recursos_operador/images/fevicon.png') ?>" type="image/png" />
    <link rel="stylesheet" href="<?= base_url('recursos_operador/css/bootstrap.min.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('recursos_operador/css/style.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('recursos_operador/css/responsive.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('recursos_operador/css/colors.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('recursos_operador/css/bootstrap-select.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('recursos_operador/css/perfect-scrollbar.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('recursos_operador/css/custom.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('recursos_operador/js/semantic.min.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('recursos_operador/css/jquery.fancybox.css') ?>" />
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

<?php
// Preparar datos del usuario (debe pasarse desde el controlador preferiblemente)
$isLoggedIn = session()->get('isLoggedIn') ?? false;
$userData = session()->get('usuario') ?? null;

$nombreCompleto = "Invitado";
$rolTexto = "Rol Desconocido";
$rutaFotoPerfil = base_url('recursos_operador/images/layout_img/user_img.jpg');

if ($isLoggedIn && $userData) {
    $nombreCompleto = $userData['nombre'] . ' ' . $userData['apellido_paterno'] . ' ' . $userData['apellido_materno'];
    $id_rol = $userData['id_rol'] ?? null;
    switch ($id_rol) {
        case 1: $rolTexto = 'Administrador'; break;
        case 2: $rolTexto = 'Operador'; break;
        case 3: $rolTexto = 'Encuestador'; break;
        default: $rolTexto = 'Miembro'; break;
    }
    if (!empty($userData['foto'])) {
        $rutaFotoPerfil = base_url('public/img_user/' . $userData['foto']);
    }
}
?>

<div class="full_container">
    <div class="inner_container">
        <!-- Sidebar -->
        <nav id="sidebar">
            <div class="sidebar_blog_1">
                <div class="sidebar-header">
                    <div class="logo_section">
                        <a href="<?= base_url('operador/dashboard') ?>">
                            <img class="logo_icon img-responsive" src="<?= base_url('recursos_operador/images/logo/logo_icon.png') ?>" alt="#" />
                        </a>
                    </div>
                </div>
                <div class="sidebar_user_info">
                    <div class="icon_setting"></div>
                    <div class="user_profle_side">
                        <div class="user_img">
                            <img class="img-responsive" src="<?= $rutaFotoPerfil ?>" alt="Foto de perfil" />
                        </div>
                        <div class="user_info">
                            <h6><?= $nombreCompleto ?></h6>
                            <p><span class="online_animation"></span> <?= $rolTexto ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sidebar_blog_2">
                <h4>General</h4>
                <ul class="list-unstyled components">
                    <li class="active"><a href="<?= base_url('dash') ?>"><i class="fa fa-dashboard yellow_color"></i> <span>Home</span></a></li>
                    <li><a href="<?= base_url('operador_user') ?>"><i class="fa fa-table purple_color2"></i> <span>Encuestadores</span></a></li>
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

        <!-- Contenido -->
        <div id="content">
            <div class="topbar">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <div class="full">
                        <button type="button" id="sidebarCollapse" class="sidebar_toggle"><i class="fa fa-bars"></i></button>
                        <div class="right_topbar">
                            <div class="icon_info">
                                <ul class="user_profile_dd">
                                    <li>
                                        <a class="dropdown-toggle" data-toggle="dropdown">
                                            <img class="img-responsive rounded-circle" src="<?= $rutaFotoPerfil ?>" alt="Foto de perfil" />
                                            <span class="name_user"><?= $nombreCompleto ?></span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>

            <div class="midde_cont">
                <div class="container-fluid">
                    <div class="row column_title">
                        <div class="col-md-12">
                            <div class="page_title">
                                <h2>Editar Encuestador</h2>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            <div class="white_shd full margin_bottom_30">
                                <div class="full graph_content">
                                    <div class="padding_infor_info">
                                        <?php if(session()->getFlashdata('errors')): ?>
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <ul>
                                                    <?php foreach(session()->getFlashdata('errors') as $error): ?>
                                                        <li><?= $error ?></li>
                                                    <?php endforeach; ?>
                                                </ul>
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        <?php endif; ?>

										<form action="<?= base_url('operador/perfil/update') ?>" method="post" enctype="multipart/form-data">
                                            <?= csrf_field() ?>

                                            <div class="form-group">
                                                <label for="usuario">Usuario</label>
                                                <input type="text" class="form-control" value="<?= $userData['usuario'] ?>" readonly>
                                            </div>

                                            <div class="form-group">
                                                <label for="usuario">Rol</label>
                                                <input type="text" class="form-control" value="<?= $rolTexto ?>" readonly>
                                            </div>
                                          
                                          <div class="form-group">
                                              <label for="nombre">Nombre</label>
                                              <input type="text" class="form-control" name="nombre" 
                                                     value="<?= esc($userData['nombre']) ?>">
                                          </div>

                                          <div class="form-group">
                                              <label for="apellido_paterno">Apellido Paterno</label>
                                              <input type="text" class="form-control" name="apellido_paterno" 
                                                     value="<?= esc($userData['apellido_paterno']) ?>">
                                          </div>

                                          <div class="form-group">
                                              <label for="apellido_materno">Apellido Materno</label>
                                              <input type="text" class="form-control" name="apellido_materno" 
                                                     value="<?= esc($userData['apellido_materno']) ?>">
                                          </div>

                                          <div class="form-group">
                                              <label for="telefono">Teléfono</label>
                                              <input type="text" class="form-control" name="telefono" 
                                                     value="<?= esc($userData['telefono']) ?>">
                                          </div>


                                            <div class="form-group">
                                                <label for="foto">Foto de Perfil Actual</label><br>
                                                <?php if(!empty($userData['foto'])): ?>
                                                    <img src="<?= base_url('public/img_user/' . $userData['foto']) ?>" 
                                                        alt="Foto actual" class="img-responsive rounded-circle mb-2" 
                                                        style="width: 100px; height: 100px; object-fit: cover;">
                                                <?php else: ?>
                                                    <p>No hay foto de perfil actual.</p>
                                                <?php endif; ?>

                                                <label for="foto">Cambiar Foto de Perfil</label>
                                                <input type="file" class="form-control-file" name="foto" id="foto">
                                            </div>

                                            <div class="text-right">
                                                <button type="submit" class="btn btn-primary">Actualizar</button>
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
                        <p>&copy; <?= date('Y') ?> <a href="javascript:void(0);">Vota y Opina</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('recursos_operador/js/jquery.min.js') ?>"></script>
<script src="<?= base_url('recursos_operador/js/popper.min.js') ?>"></script>
<script src="<?= base_url('recursos_operador/js/bootstrap.min.js') ?>"></script>

</body>
</html>