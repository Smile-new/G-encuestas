<!DOCTYPE html>
<html class="loading" lang="es" data-textdirection="ltr">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Usuarios - Vota y Opina</title>
    <link rel="apple-touch-icon" href="<?= base_url(RECURSOS_CONTROLADOR_IMAGES . 'ico/apple-icon-120.png') ?>">
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url(RECURSOS_CONTROLADOR_IMAGES . 'ico/favicon.ico') ?>">
    <link href="https://fonts.googleapis.com/css?family=Muli:300,300i,400,400i,600,600i,700,700i%7CComfortaa:300,400,700" rel="stylesheet">
    <link href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css" rel="stylesheet">
    
    <!-- BEGIN VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="<?= base_url(RECURSOS_CONTROLADOR_CSS . 'vendors.css') ?>">
    <!-- END VENDOR CSS-->

    <!-- BEGIN CHAMELEON CSS-->
    <link rel="stylesheet" type="text/css" href="<?= base_url(RECURSOS_CONTROLADOR_CSS . 'app-lite.css') ?>">
    <!-- END CHAMELEON CSS-->

    <!-- BEGIN Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="<?= base_url(RECURSOS_CONTROLADOR_CSS . 'core/menu/menu-types/vertical-menu.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url(RECURSOS_CONTROLADOR_CSS . 'core/colors/palette-gradient.css') ?>">
    <!-- END Page Level CSS-->
  </head>
  <style>
      .dropdown-menu-right .user-name {
        display: inline-block;
        max-width: 180px; /* ajusta según tu diseño */
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    </style>
  <body class="vertical-layout vertical-menu 2-columns menu-expanded fixed-navbar" data-open="click" data-menu="vertical-menu" data-color="bg-gradient-x-purple-blue" data-col="2-columns">
<?php
// Preparar datos del usuario (debe pasarse desde el controlador preferiblemente)
$isLoggedIn = session()->get('isLoggedIn') ?? false;
$userData = session()->get('usuario') ?? null;

$nombreCompleto = "Invitado";
$rolTexto = "Rol Desconocido";
$rutaFotoPerfil = base_url('recursos_operador/images/layout_img/user_img.jpg');

if ($isLoggedIn && $userData) {
    $nombreCompleto = $userData['nombre'] . ' ' . $userData['apellido_paterno'] . ' ' . $userData['apellido_materno'];
$rolTexto = esc($userData['nombre_rol'] ?? 'Rol desconocido');
    if (!empty($userData['foto'])) {
        $rutaFotoPerfil = base_url('public/img_user/' . $userData['foto']);
    }
}
?>

    <!-- fixed-top-->
    <nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-semi-light">
      <div class="navbar-wrapper">
        <div class="navbar-container content">
          <div class="collapse navbar-collapse show" id="navbar-mobile">
            <ul class="nav navbar-nav mr-auto float-left">
              <li class="nav-item d-block d-md-none"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu"></i></a></li>
              <li class="nav-item d-none d-md-block"><a class="nav-link nav-link-expand" href="#"><i class="ficon ft-maximize"></i></a></li>
            </ul>
            <ul class="nav navbar-nav float-right">
              <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown"> <span class="avatar avatar-online"><img src="<?= $rutaFotoPerfil ?>" alt="avatar"><i></i></span></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="arrow_box_right">
                        <a class="dropdown-item" href="#">
                            <span class="avatar avatar-online">
                                <img src="<?= $rutaFotoPerfil ?>" alt="avatar">
                            </span>
                            <span class="user-name text-bold-700 ml-1"><?= esc($nombreCompleto) ?></span>
                        </a>
                    </div>                   
                  <div class="dropdown-divider"></div><a class="dropdown-item" href="/controlador/perfil"><i class="ft-user"></i> Editar Perfil</a>
                  <div class="dropdown-divider"></div><a class="dropdown-item" href="/logout"><i class="ft-power"></i> Cerrar Sesión</a>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </nav>

    <!--////////////////////////////////////////////////////////////////////////////-->

    <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true" data-img="<?= base_url(RECURSOS_CONTROLADOR_IMAGES . 'backgrounds/02.jpg') ?>">
      <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
          <li class="nav-item mr-auto"><a class="navbar-brand" href="<?= base_url('controlador/panel') ?>">
              <h3 class="brand-text">Vota y Opina</h3></a></li>
          <li class="nav-item d-md-none"><a class="nav-link close-navbar"><i class="ft-x"></i></a></li>
        </ul>
      </div>
      <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
          <li class="nav-item"><a href="<?= base_url('controlador/panel') ?>"><i class="la la-home"></i><span class="menu-title">Panel</span></a></li>
          <li class="nav-item"><a href="<?= base_url('controlador/graficas') ?>"><i class="la la-pie-chart"></i><span class="menu-title">Gráficas</span></a></li>
          <li class="active"><a href="<?= base_url('controlador/usuarios') ?>"><i class="la la-users"></i><span class="menu-title">Usuarios</span></a></li>
          <li class="nav-item"><a href="<?= base_url('controlador/encuestas') ?>"><i class="la la-list-alt"></i><span class="menu-title">Encuestas</span></a></li>
          <li class="nav-item"><a href="<?= base_url('controlador/respuestas') ?>"><i class="la la-check-square"></i><span class="menu-title">Respuestas</span></a></li>
          <li class=" nav-item"><a href="<?= base_url('controlador/perfil') ?>"><i class="la la-user"></i><span class="menu-title">Perfil</span></a></li>        
        </ul>
      </div>
      <div class="navigation-background"></div>
    </div>

    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-wrapper-before"></div>
        <div class="content-header row">
          <div class="content-header-left col-md-4 col-12 mb-2">
            <h3 class="content-header-title">Supervisión de Usuarios</h3>
          </div>
          <div class="content-header-right col-md-8 col-12">
            <div class="breadcrumbs-top float-md-right">
              <div class="breadcrumb-wrapper mr-1">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?= base_url('controlador/panel') ?>">Panel</a></li>
                  <li class="breadcrumb-item active">Usuarios</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <div class="content-body">
            <!-- Tabla de Usuarios -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Todos los Usuarios del Sistema</h4>
                            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body">
                                <p>Revisa la trazabilidad de los usuarios, quién los creó y sus roles.</p>
                                
                                <!-- Filtros -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="filtroUsuario">Buscar por Nombre:</label> <!-- CAMBIO: Texto de la etiqueta -->
                                            <input type="text" id="filtroUsuario" class="form-control" placeholder="Escribe un nombre...">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="filtroRol">Filtrar por Rol:</label>
                                            <select id="filtroRol" class="form-control">
                                                <option value="">Todos los Roles</option>
                                                <?php foreach ($rolesDisponibles as $rol) : ?>
                                                    <option value="<?= esc($rol['nombre_rol']) ?>"><?= esc($rol['nombre_rol']) ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Imagen</th>
                                                <th>Nombre Completo</th>
                                                <th>Usuario</th>
                                                <th>Rol</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tablaUsuarios">
                                            <?php if (!empty($listaUsuarios)) : ?>
                                                <?php foreach ($listaUsuarios as $usuario) : ?>
                                                    <!-- CAMBIO 1: Añadir el atributo data-nombre-completo -->
                                                    <tr data-rol="<?= esc($usuario['nombre_rol']) ?>" 
                                                        data-usuario="<?= esc($usuario['usuario']) ?>" 
                                                        data-nombre-completo="<?= esc($usuario['nombre'] . ' ' . $usuario['apellido_paterno'] . ' ' . $usuario['apellido_materno']) ?>">
                                                        <td>
                                                            <?php 
                                                                $foto_url = $usuario['foto'] ? $img_path_user . $usuario['foto'] : base_url(RECURSOS_CONTROLADOR_IMAGES . 'portrait/small/avatar-s-19.png');
                                                            ?>
                                                            <img src="<?= $foto_url ?>" class="img-fluid rounded-circle" style="width: 50px; height: 50px;">
                                                        </td>
                                                        <td><?= esc($usuario['nombre'] . ' ' . $usuario['apellido_paterno'] . ' ' . $usuario['apellido_materno']) ?></td>
                                                        <td><?= esc($usuario['usuario']) ?></td>
                                                        <td><span class="badge badge-info"><?= esc($usuario['nombre_rol']) ?></span></td>
                                                        <td>
                                                            <button 
                                                                class="btn btn-primary btn-sm"
                                                                onclick="mostrarDetalle(<?= esc($usuario['id_usuario']) ?>)">
                                                                <i class="la la-eye"></i> Ver Perfil
                                                            </button>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <tr>
                                                    <td colspan="5" class="text-center">No se encontraron usuarios en el sistema.</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Fin de la tabla -->
        </div>
      </div>
    </div>
    <!-- ////////////////////////////////////////////////////////////////////////////-->

    <!-- Modal para el Detalle del Usuario -->
    <div class="modal fade text-left" id="modalDetalleUsuario" tabindex="-1" role="dialog" aria-labelledby="detalleUsuarioLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="detalleUsuarioLabel">Detalle del Usuario: <span id="detalleNombreCompleto"></span></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <img id="detalleFoto" src="" alt="Foto de perfil" class="img-fluid rounded-circle mb-2" style="max-width: 120px;">
                            <h5 id="detalleUsuario"></h5>
                            <span class="badge badge-info" id="detalleRol"></span>
                            <hr>
                        </div>
                        <div class="col-md-8">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong>Nombre:</strong> <span id="detalleNombre"></span></li>
                                <li class="list-group-item"><strong>Apellidos:</strong> <span id="detalleApellidos"></span></li>
                                <li class="list-group-item"><strong>Teléfono:</strong> <span id="detalleTelefono"></span></li>
                                <li class="list-group-item"><strong>Creado Por:</strong> <span id="detalleCreadoPor"></span></li>
                            </ul>
                            
                            <!-- Acordeón para usuarios creados -->
                            <div class="accordion mt-3" id="acordeonUsuariosCreados">
                                <div class="card">
                                    <div class="card-header" id="headingOne">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                Usuarios Creados por este Perfil
                                            </button>
                                        </h5>
                                    </div>
                                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#acordeonUsuariosCreados">
                                        <div class="card-body">
                                            <ul id="listaUsuariosCreados" class="list-group">
                                                <!-- La lista se llenará con JS -->
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal para el detalle de usuarios creados -->
    <div class="modal fade" id="modalCreadoPor" tabindex="-1" role="dialog" aria-labelledby="modalCreadoPorLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalCreadoPorLabel">Detalle de Usuario Creado</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
                <div class="col-12 text-center">
                    <img id="modalCreadoPorFoto" src="" alt="Foto de perfil" class="img-fluid rounded-circle mb-2" style="max-width: 100px;">
                    <h5 id="modalCreadoPorNombre"></h5>
                    <span class="badge badge-info" id="modalCreadoPorRol"></span>
                </div>
                <div class="col-12 mt-3">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Usuario:</strong> <span id="modalCreadoPorUsuario"></span></li>
                        <li class="list-group-item"><strong>Teléfono:</strong> <span id="modalCreadoPorTelefono"></span></li>
                        <li class="list-group-item"><strong>Creado Por:</strong> <span id="modalCreadoPorCreador"></span></li>
                    </ul>
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>


    <footer class="footer footer-static footer-light navbar-border navbar-shadow">
      <div class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2"><span class="float-md-left d-block d-md-inline-block"><?= date('Y') ?> &copy; Copyright <a class="text-bold-800 grey darken-2" href="#">Vota y Opina</a></span>
      </div>
    </footer>

    <!-- BEGIN VENDOR JS-->
    <script src="<?= base_url(RECURSOS_CONTROLADOR_VENDORS . 'js/vendors.min.js') ?>" type="text/javascript"></script>
    <!-- BEGIN VENDOR JS-->
    
    <!-- BEGIN CHAMELEON JS-->
    <script src="<?= base_url(RECURSOS_CONTROLADOR_JS . 'core/app-menu-lite.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url(RECURSOS_CONTROLADOR_JS . 'core/app-lite.js') ?>" type="text/javascript"></script>
    <!-- END CHAMELEON JS-->

    <!-- Lógica de JavaScript para el Modal -->
    <script type="text/javascript">
        // La ruta de las imágenes de usuario se recibe del controlador
        const userImgPath = '<?= $img_path_user ?>';

        // Lógica para filtrar la tabla
        document.getElementById('filtroUsuario').addEventListener('keyup', filtrarTabla);
        document.getElementById('filtroRol').addEventListener('change', filtrarTabla);

        function filtrarTabla() {
            const terminoBusqueda = document.getElementById('filtroUsuario').value.toLowerCase();
            const filtroRol = document.getElementById('filtroRol').value;
            const filas = document.getElementById('tablaUsuarios').getElementsByTagName('tr');

            for (let i = 0; i < filas.length; i++) {
                const fila = filas[i];
                
                // --- CAMBIO 2: Leer el atributo 'data-nombre-completo' en lugar de 'data-usuario' ---
                const nombreCompleto = fila.getAttribute('data-nombre-completo').toLowerCase();
                const rol = fila.getAttribute('data-rol');

                const coincideNombre = nombreCompleto.includes(terminoBusqueda);
                const coincideRol = (filtroRol === '' || rol === filtroRol);

                if (coincideNombre && coincideRol) {
                    fila.style.display = '';
                } else {
                    fila.style.display = 'none';
                }
            }
        }
        
        // Lógica para el modal principal de detalles de usuario
        function mostrarDetalle(idUsuario) {
            fetch(`<?= base_url('controlador/detalleUsuario') ?>?id=${idUsuario}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error en la respuesta del servidor');
                    }
                    return response.json();
                })
                .then(data => {
                    const perfil = data.perfil;
                    const creados = data.usuarios_creados;

                    // Rellenar la información del perfil
                    document.getElementById('detalleNombreCompleto').textContent = `${perfil.nombre} ${perfil.apellido_paterno}`;
                    document.getElementById('detalleUsuario').textContent = `@${perfil.usuario}`;
                    document.getElementById('detalleRol').textContent = perfil.nombre_rol;
                    document.getElementById('detalleNombre').textContent = perfil.nombre;
                    document.getElementById('detalleApellidos').textContent = `${perfil.apellido_paterno} ${perfil.apellido_materno}`;
                    document.getElementById('detalleTelefono').textContent = perfil.telefono;
                    document.getElementById('detalleCreadoPor').textContent = perfil.creado_por_nombre_completo || 'N/A';
                    
                    // Cargar la foto de perfil usando la variable del controlador
                    const fotoUrl = perfil.foto ? `${userImgPath}${perfil.foto}` : `<?= base_url(RECURSOS_CONTROLADOR_IMAGES . 'portrait/small/avatar-s-19.png') ?>`;
                    document.getElementById('detalleFoto').src = fotoUrl;

                    // Rellenar la lista de usuarios creados en el acordeón
                    let listaHTML = '';
                    if (creados.length > 0) {
                        creados.forEach(usuario => {
                            listaHTML += `<li class="list-group-item">
                                <a href="#" onclick="event.preventDefault(); mostrarDetalleCreadoPor(${usuario.id_usuario})">
                                    ${usuario.nombre} (${usuario.usuario})
                                </a>
                            </li>`;
                        });
                    } else {
                        listaHTML = '<li class="list-group-item text-muted">Este usuario no ha creado otras cuentas.</li>';
                    }
                    document.getElementById('listaUsuariosCreados').innerHTML = listaHTML;

                    // Mostrar el modal
                    $('#modalDetalleUsuario').modal('show');
                })
                .catch(error => {
                    console.error('Error al obtener detalles del usuario:', error);
                    alert('No se pudo cargar la información del usuario. Verifique su conexión o intente más tarde.');
                });
        }
        
        // Lógica para el modal de detalle de usuario creado (dentro del acordeón)
        function mostrarDetalleCreadoPor(idUsuario) {
            fetch(`<?= base_url('controlador/detalleUsuario') ?>?id=${idUsuario}`)
                .then(response => response.json())
                .then(data => {
                    const perfil = data.perfil;
                    
                    document.getElementById('modalCreadoPorNombre').textContent = `${perfil.nombre} ${perfil.apellido_paterno} ${perfil.apellido_materno}`;
                    document.getElementById('modalCreadoPorUsuario').textContent = `@${perfil.usuario}`;
                    document.getElementById('modalCreadoPorRol').textContent = perfil.nombre_rol;
                    document.getElementById('modalCreadoPorTelefono').textContent = perfil.telefono;
                    document.getElementById('modalCreadoPorCreador').textContent = perfil.creado_por_nombre_completo || 'N/A';
                    
                    const fotoUrl = perfil.foto ? `${userImgPath}${perfil.foto}` : `<?= base_url(RECURSOS_CONTROLADOR_IMAGES . 'portrait/small/avatar-s-19.png') ?>`;
                    document.getElementById('modalCreadoPorFoto').src = fotoUrl;
                    
                    $('#modalCreadoPor').modal('show');
                })
                .catch(error => {
                    console.error('Error al obtener detalles del usuario creado:', error);
                    alert('No se pudo cargar la información del usuario creado. Verifique su conexión o intente más tarde.');
                });
        }
    </script>
  </body>
</html>
