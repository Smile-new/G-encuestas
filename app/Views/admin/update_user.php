<?php
// Obtener la instancia de la sesión
$session = session();
$userData = $session->get('usuario');
$isLoggedIn = $session->get('isLoggedIn');

// Definir valores por defecto
$nombreCompleto = "Invitado";
$rolTexto = "Rol Desconocido";
$rutaFotoPerfil = base_url(RECURSOS_ADMIN_IMAGES . '/faces/face15.jpg');

if ($isLoggedIn && is_array($userData)) {
    $nombreCompleto = esc($userData['nombre']) . ' ' . esc($userData['apellido_paterno']) . ' ' . esc($userData['apellido_materno']);
    $id_rol = $userData['id_rol'] ?? null;
    
    // Ajustar los roles a los de tu base de datos
    switch ($id_rol) {
        case 4: $rolTexto = 'Administrador'; break;
        case 3: $rolTexto = 'Encuestador'; break;
        case 2: $rolTexto = 'Supervisor'; break;
        case 1: $rolTexto = 'Operador'; break;
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
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Vota y Opina - Editar Usuario</title>
    <!-- CSS de la plantilla -->
    <link rel="stylesheet" href="<?= base_url(RECURSOS_ADMIN_VENDORS . '/mdi/css/materialdesignicons.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url(RECURSOS_ADMIN_VENDORS . '/css/vendor.bundle.base.css') ?>">
    <link rel="stylesheet" href="<?= base_url(RECURSOS_ADMIN_CSS . '/style.css') ?>">
</head>
<body>
    <div class="container-scroller">
        <!-- Barra lateral (Sidebar) -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
               <a class="sidebar-brand brand-logo" href="<?= base_url('administrador/dashboard') ?>"><img src="<?= base_url(RECURSOS_ADMIN_IMAGES . '/logo.png') ?>" alt="logo" /> </a>
            </div>
            <ul class="nav">
                <li class="nav-item profile">
                    <div class="profile-desc">
                        <div class="profile-pic">
                            <div class="count-indicator">
                                <img class="img-xs rounded-circle" src="<?= $rutaFotoPerfil ?>" alt="Foto de perfil">
                                <span class="count bg-success"></span>
                            </div>
                            <div class="profile-name">
                                <h5 class="mb-0 font-weight-normal"><?= $nombreCompleto ?></h5>
                                <span><?= $rolTexto ?></span>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="nav-item nav-category"><span class="nav-link">Navegación</span></li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="<?= base_url('administrador/dashboard') ?>">
                        <span class="menu-icon"><i class="mdi mdi-speedometer"></i></span>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="<?= base_url('administrador/usuarios') ?>">
                        <span class="menu-icon"><i class="mdi mdi-contacts"></i></span>
                        <span class="menu-title">Usuarios</span>
                    </a>
                </li>
                 <li class="nav-item menu-items">
                    <a class="nav-link" href="<?= base_url('administrador/encuestas') ?>">
                        <span class="menu-icon"><i class="mdi mdi-playlist-play"></i></span>
                        <span class="menu-title">Encuestas</span>
                    </a>
                </li>
                <li class="nav-item menu-items">
            <a class="nav-link" href="<?= base_url('admin/perfil') ?>">
              <span class="menu-icon">
                <i class="mdi mdi-account-circle"></i>
              </span>
              <span class="menu-title">Perfil</span>
            </a>
          </li>
            </ul>
        </nav>
        
        <div class="container-fluid page-body-wrapper">
            <!-- Barra de navegación superior (Navbar) -->
            <nav class="navbar p-0 fixed-top d-flex flex-row">
                 <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
                    <a class="navbar-brand brand-logo-mini" href="<?= base_url('administrador/dashboard') ?>"><img src="<?= base_url(RECURSOS_ADMIN_IMAGES . '/logo-mini.svg') ?>" alt="logo" /></a>
                </div>
                <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
                    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                        <span class="mdi mdi-menu"></span>
                    </button>
                    <ul class="navbar-nav navbar-nav-right">
                        <li class="nav-item dropdown">
                            <a class="nav-link" id="profileDropdown" href="#" data-toggle="dropdown">
                                <div class="navbar-profile">
                                    <img class="img-xs rounded-circle" src="<?= $rutaFotoPerfil ?>" alt="Foto de perfil">
                                    <p class="mb-0 d-none d-sm-block navbar-profile-name"><?= $nombreCompleto ?></p>
                                    <i class="mdi mdi-menu-down d-none d-sm-block"></i>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="profileDropdown">
                                <h6 class="p-3 mb-0">Perfil</h6>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item preview-item" href="<?= base_url('logout') ?>">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-dark rounded-circle"><i class="mdi mdi-logout text-danger"></i></div>
                                    </div>
                                    <div class="preview-item-content">
                                        <p class="preview-subject mb-1">Cerrar Sesión</p>
                                    </div>
                                </a>
                            </div>
                        </li>
                    </ul>
                    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                        <span class="mdi mdi-format-line-spacing"></span>
                    </button>
                </div>
            </nav>

            <!-- Contenido Principal -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title"> Editar Usuario </h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?= base_url('administrador/dashboard') ?>">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="<?= base_url('administrador/usuarios') ?>">Usuarios</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Editar</li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row">
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Formulario de Edición: <?= esc($usuario['nombre'] . ' ' . $usuario['apellido_paterno']); ?></h4>
                                    <p class="card-description"> Modifica los campos para actualizar el usuario. </p>

                                    <?php if (session()->getFlashdata('errors')): ?>
                                        <div class="alert alert-danger">
                                            <ul>
                                                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                                    <li><?= esc($error) ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <form class="forms-sample" action="<?= base_url('usuarios/update/' . $usuario['id_usuario']); ?>" method="post" enctype="multipart/form-data">
                                        <?= csrf_field() ?>
                                        
                                        <div class="form-group">
                                            <label for="nombre">Nombre</label>
                                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" value="<?= old('nombre', $usuario['nombre']); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="apellido_paterno">Apellido Paterno</label>
                                            <input type="text" class="form-control" id="apellido_paterno" name="apellido_paterno" placeholder="Apellido Paterno" value="<?= old('apellido_paterno', $usuario['apellido_paterno']); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="apellido_materno">Apellido Materno</label>
                                            <input type="text" class="form-control" id="apellido_materno" name="apellido_materno" placeholder="Apellido Materno" value="<?= old('apellido_materno', $usuario['apellido_materno']); ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="telefono">Teléfono</label>
                                            <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Ej. 1234567890" value="<?= old('telefono', $usuario['telefono']); ?>" pattern="[0-9]{10}" title="Por favor, ingresa 10 dígitos numéricos">
                                        </div>

                                        <!-- ✅ CAMPO DE USUARIO CON GENERADOR -->
                                        <div class="form-group">
                                            <label for="usuario">Usuario (Nombre de Login)</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Clic en 'Generar' para crear uno nuevo" value="<?= old('usuario', $usuario['usuario']); ?>" required minlength="15">
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary btn-inverse-primary" type="button" onclick="generateRandomUsername()">
                                                        <i class="mdi mdi-account-key"></i> Generar Nuevo
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- ✅ CAMPO DE CONTRASEÑA CON GENERADOR -->
                                        <div class="form-group">
                                            <label for="contrasena">Nueva Contraseña (Opcional)</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="contrasena" name="contrasena" placeholder="Dejar en blanco para no cambiar" minlength="15">
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary btn-inverse-primary" type="button" onclick="generateRandomPassword()">
                                                        <i class="mdi mdi-key-variant"></i> Generar Nueva
                                                    </button>
                                                </div>
                                            </div>
                                             <small class="form-text text-muted">Si generas o escribes una contraseña, la anterior será reemplazada.</small>
                                        </div>

                                        <div class="form-group">
                                            <label>Foto de Perfil Actual</label>
                                             <?php if (!empty($usuario['foto'])): ?>
                                                <div class="mb-2">
                                                    <img src="<?= base_url('public/img_user/' . $usuario['foto']); ?>" alt="Foto actual" class="img-fluid rounded" style="max-width: 100px; max-height: 100px; object-fit: cover;">
                                                </div>
                                            <?php else: ?>
                                                <p class="text-muted">No hay foto actual.</p>
                                            <?php endif; ?>
                                            <label for="foto" class="mt-2">Subir Nueva Foto (reemplaza la actual)</label>
                                            <input type="file" name="foto" class="file-upload-default" accept="image/*">
                                            <div class="input-group col-xs-12">
                                                <input type="text" class="form-control file-upload-info" disabled placeholder="Subir Nueva Foto">
                                                <span class="input-group-append">
                                                    <button class="file-upload-browse btn btn-primary" type="button">Subir</button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="id_rol">Rol</label>
                                            <select class="form-control" id="id_rol" name="id_rol" required>
                                                <option value="">Selecciona un Rol</option>
                                                <?php if (!empty($roles) && is_array($roles)): ?>
                                                    <?php foreach ($roles as $rol): ?>
                                                        <option value="<?= esc($rol['id_rol']) ?>" <?= old('id_rol', $usuario['id_rol']) == $rol['id_rol'] ? 'selected' : '' ?>>
                                                            <?= esc($rol['nombre_rol']) ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>

                                        <button type="submit" class="btn btn-primary mr-2">Actualizar Usuario</button>
                                        <a href="<?= base_url('usuarios'); ?>" class="btn btn-dark">Cancelar</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Pie de página (Footer) -->
                <footer class="footer">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © <?= date('Y') ?> Vota y Opina.</span>
                    </div>
                </footer>
            </div>
        </div>
    </div>
    <!-- JS de la plantilla -->
    <script src="<?= base_url(RECURSOS_ADMIN_VENDORS . '/js/vendor.bundle.base.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_ADMIN_JS . '/off-canvas.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_ADMIN_JS . '/hoverable-collapse.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_ADMIN_JS . '/misc.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_ADMIN_JS . '/settings.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_ADMIN_JS . '/todolist.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_ADMIN_JS . '/file-upload.js') ?>"></script>

    <!-- ✅ SCRIPTS PARA GENERAR CREDENCIALES -->
    <script>
        /**
         * Genera un nombre de usuario aleatorio y lo coloca en el campo de usuario.
         */
        function generateRandomUsername() {
            const prefix = "uservotayopina"; // 15 caracteres
            const randomLength = 6; // Añadimos 6 caracteres para un total de 21
            const charset = "abcdefghijklmnopqrstuvwxyz0123456789!@#$%&*";
            let randomPart = "";
            for (let i = 0; i < randomLength; i++) {
                randomPart += charset.charAt(Math.floor(Math.random() * charset.length));
            }
            document.getElementById("usuario").value = prefix + randomPart;
        }

        /**
         * Genera una contraseña aleatoria y la coloca en el campo de contraseña.
         */
        function generateRandomPassword() {
            const length = 16; // Longitud deseada de la contraseña (mayor a 15)
            const charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+~`|}{[]:;?><,./-=";
            let password = "";
            for (let i = 0, n = charset.length; i < length; ++i) {
                password += charset.charAt(Math.floor(Math.random() * n));
            }
            document.getElementById("contrasena").value = password;
        }
    </script>
</body>
</html>
