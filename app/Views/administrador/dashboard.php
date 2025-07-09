<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Administrador</title>

    <link rel="stylesheet" href="<?= base_url('css/bootstrap.min.css'); ?>">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600;700&display=swap" rel="stylesheet">


    <style>
        /* Colores y variables base */
        :root {
            --body-bg: #1E293B; /* Fondo general del cuerpo */
            --sidebar-bg: #111827; /* Fondo de la barra lateral */
            --sidebar-active-link: #DC2626; /* Rojo para el enlace activo de la sidebar */
            --navbar-bg: #111827; /* Fondo de la barra de navegación */
            --navbar-logout-bg: #DC2626; /* Fondo del botón Cerrar Sesión */
            --primary-text: #F9FAFB; /* Texto principal claro */
            --secondary-text: #D1D5DB; /* Texto secundario más claro */
            --table-header-bg: #DC2626; /* Fondo del encabezado de la tabla */
            --table-row-hover: #374151; /* Hover de la fila de la tabla */
            --button-blue: #3B82F6; /* Azul para Editar */
            --button-red: #EF4444; /* Rojo para Eliminar */
            --button-yellow: #F59E0B; /* Amarillo/Naranja para Deshabilitar */
            --badge-active-bg: #16A34A; /* Verde para Activa */
            --badge-inactive-bg: #4B5563; /* Grisáceo para Inactiva */
            --border-color: #4B5563; /* Color de los bordes */
        }

        body {
            margin: 0;
            font-family: 'Nunito Sans', Arial, sans-serif;
            background: var(--body-bg);
            color: var(--primary-text);
            font-size: 16px;
            overflow-x: hidden; /* Evita el scroll horizontal por desbordamiento */
        }

        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 220px;
            background: var(--sidebar-bg);
            padding: 20px 15px;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.2);
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            transition: transform 0.3s ease-in-out; /* Para animación responsive */
            position: relative; /* Para el icono de cierre en móvil */
            z-index: 1000; /* Asegura que esté sobre otros elementos en móvil */
        }

        .sidebar .logo {
            color: var(--primary-text);
            text-align: left;
            margin-bottom: 30px;
            font-size: 24px;
            font-weight: 700;
        }

        .sidebar .logo span {
            color: var(--sidebar-active-link);
        }

        .sidebar .nav-links {
            list-style: none;
            padding: 0;
            margin: 0;
            flex-grow: 1;
        }

        .sidebar .nav-links li {
            margin-bottom: 5px;
        }

        .sidebar .nav-links li a {
            color: var(--secondary-text);
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 10px 15px;
            border-radius: 6px;
            transition: background 0.2s ease, color 0.2s ease;
            font-size: 15px;
        }

        .sidebar .nav-links li a:hover,
        .sidebar .nav-links li a.active {
            background: var(--sidebar-active-link);
            color: var(--primary-text);
        }

        .sidebar .nav-links li a i {
            margin-right: 10px;
            font-size: 16px;
        }

        /* Botón de cierre en Sidebar (para móvil) */
        .sidebar .close-sidebar-btn {
            display: none; /* Por defecto oculto en desktop */
            position: absolute;
            top: 15px;
            right: 15px;
            background: none;
            border: none;
            color: var(--primary-text);
            font-size: 24px;
            cursor: pointer;
            z-index: 1001; /* Asegura que esté por encima de la sidebar */
        }

        /* Main Content & Navbar */
        .main-content {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            background-color: var(--body-bg);
        }

        .navbar {
            background: var(--navbar-bg);
            padding: 15px 20px;
            display: flex;
            justify-content: flex-start;
            align-items: center;
            border-bottom: 1px solid var(--border-color);
            position: sticky; /* Sticky navbar */
            top: 0;
            z-index: 999;
        }

        /* Botón de menú en Navbar (para móvil) */
        .navbar .menu-toggle-btn {
            display: none; /* Por defecto oculto en desktop */
            background: none;
            border: none;
            color: var(--primary-text);
            font-size: 24px;
            cursor: pointer;
            margin-right: 15px;
        }

        .navbar .btn-logout {
            background: var(--navbar-logout-bg);
            color: var(--primary-text);
            border: none;
            padding: 8px 15px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            transition: background 0.2s ease;
            text-decoration: none; /* Eliminar subrayado */
            margin-right: 20px;
        }

        .btn-logout:hover {
            background: #B91C1C;
        }

        .content-container {
            padding: 25px;
            flex-grow: 1;
        }

        .content-container h1 {
            margin-bottom: 20px;
            font-weight: 600;
            color: var(--primary-text);
            font-size: 2em;
        }

        .content-container h3 {
            color: var(--secondary-text);
            font-size: 1.2em;
            margin-top: 0;
        }

        /* Asistente Animatrónico IA - Posicionamiento para escritorio */
        .asistente-ia {
            position: fixed; /* Cambiado a fixed para que se quede en su lugar al hacer scroll */
            bottom: 20px;
            left: 50%; /* Centrado horizontalmente */
            transform: translateX(-50%); /* Ajuste para centrado perfecto */
            display: flex;
            align-items: center;
            justify-content: center;
            width: 700px; /* Ancho fijo para escritorio */
            background: rgba(0, 0, 0, 0.8);
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0px 0px 20px rgba(255, 0, 0, 0.6);
            z-index: 998; /* Un z-index menor que la sidebar */
            transition: all 0.3s ease; /* Transición para cambios responsive */
        }
        
        .asistente-imagen {
            width: 160px; 
            height: 160px;
            border-radius: 50%;
            overflow: hidden;
            box-shadow: 0px 0px 25px rgba(255, 0, 0, 0.7);
            border: 4px solid red;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-shrink: 0; /* Evita que la imagen se encoja */
        }

        .asistente-imagen video {
            width: 110%;
            height: 110%;
            object-fit: cover;
            border-radius: 50%;
        }

        .asistente-mensaje {
            background: rgba(30, 30, 30, 0.95);
            color: #fff;
            padding: 20px;
            border-radius: 12px;
            width: 450px; /* Ancho fijo para escritorio */
            max-width: calc(100% - 200px); /* Ajuste para el espacio del video */
            height: 250px; /* Altura fija, podría ser max-height para flexibilidad */
            box-shadow: 0px 5px 15px rgba(255, 0, 0, 0.4);
            font-size: 18px;
            text-align: justify;
            line-height: 1.6;
            margin-left: 20px;
            border-left: 5px solid red;
            animation: fadeIn 0.5s ease-in-out;
            overflow-y: auto; /* Permite scroll si el contenido es largo */
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateX(-10px); }
            to { opacity: 1; transform: translateX(0); }
        }

        /* --- MEDIA QUERIES PARA RESPONSIVE --- */

        /* Para pantallas más pequeñas (teléfonos, hasta 768px) */
        @media (max-width: 768px) {
            .dashboard-container {
                flex-direction: column; /* Apila sidebar y contenido */
            }

            .sidebar {
                position: fixed;
                top: 0;
                left: -220px; /* Oculta la sidebar fuera de la pantalla */
                height: 100vh;
                padding-top: 60px; /* Espacio para el botón de cierre */
                width: 220px; /* Mantén el ancho fijo para cuando aparezca */
            }

            .sidebar.active {
                transform: translateX(220px); /* Muestra la sidebar */
            }

            .sidebar .close-sidebar-btn {
                display: block; /* Muestra el botón de cierre */
            }

            .navbar .menu-toggle-btn {
                display: block; /* Muestra el botón de menú */
            }

            .navbar {
                justify-content: space-between; /* Ajusta la distribución de elementos en la navbar */
            }

            .navbar .btn-logout {
                margin-right: 0; /* Elimina el margen derecho del botón de cerrar sesión */
            }
            
            .main-content {
                width: 100%; /* El contenido principal ocupa todo el ancho */
                padding-left: 0; /* Asegúrate de que no haya padding extra */
            }

            .content-container {
                padding: 15px; /* Reduce el padding general en móvil */
            }

            .content-container h1 {
                font-size: 1.8em; /* Ajusta el tamaño del título */
            }

            .content-container h3 {
                font-size: 1em; /* Ajusta el tamaño del subtítulo */
            }

            /* Asistente Animatrónico IA - Ajustes para móvil */
            .asistente-ia {
                position: static; /* Cambia a posicionamiento normal en móvil */
                width: 95%; /* Ocupa casi todo el ancho */
                max-width: 500px; /* Pero con un máximo si la pantalla es muy grande */
                margin: 20px auto; /* Centrado con margen automático */
                padding: 15px;
                flex-direction: column; /* Apila la imagen y el mensaje verticalmente */
                border-radius: 10px;
                box-shadow: 0px 0px 10px rgba(255, 0, 0, 0.4);
            }

            .asistente-imagen {
                width: 120px; /* Imagen más pequeña */
                height: 120px;
                box-shadow: 0px 0px 15px rgba(255, 0, 0, 0.5);
                margin-bottom: 15px; /* Espacio entre imagen y mensaje */
            }

            .asistente-mensaje {
                width: 100%; /* Ocupa todo el ancho disponible */
                max-width: none; /* Elimina la restricción de max-width de escritorio */
                height: auto; /* Altura automática según el contenido */
                max-height: 150px; /* Altura máxima para el mensaje en móvil */
                font-size: 14px;
                margin-left: 0; /* Elimina el margen izquierdo */
                border-left: none; /* Quita el borde izquierdo */
                border-top: 3px solid red; /* Agrega un borde superior */
                padding: 15px;
            }

            /* Ocultar elementos de escritorio si es necesario, ejemplo: */
            /* .some-desktop-only-element { display: none; } */
        }

        /* Para pantallas medianas (tabletas, entre 769px y 1024px) */
        @media (min-width: 769px) and (max-width: 1024px) {
            .sidebar {
                width: 200px; /* Ajusta el ancho de la sidebar para tabletas */
            }

            .main-content {
                /* No se necesita margen a la izquierda si el sidebar no es fijo */
                /* O puedes ajustar el padding-left para compensar si la sidebar es fija */
            }

            .asistente-ia {
                width: 90%;
                max-width: 600px; /* Un poco más pequeño que en desktop */
                padding: 15px;
            }

            .asistente-imagen {
                width: 140px;
                height: 140px;
            }

            .asistente-mensaje {
                width: 100%;
                max-width: calc(100% - 160px); /* Ajuste dinámico */
                font-size: 16px;
                height: 200px;
            }
        }

        /* Para pantallas grandes (desktop, a partir de 1025px) */
        @media (min-width: 1025px) {
            .sidebar {
                width: 220px; /* Ancho completo de la sidebar en desktop */
            }
        }
    </style>

</head>
<body>
    <div class="dashboard-container">
        <div class="sidebar" id="sidebar">
            <button class="close-sidebar-btn" id="closeSidebarBtn"><i class="fas fa-times"></i></button>
            <h2 class="logo">Monitor <span>Encuestal</span></h2>
            <ul class="nav-links">
                <li><a href="<?= site_url('administrador') ?>" class="active"><i class="fas fa-home"></i> Inicio</a></li>
                <li><a href="<?= site_url('encuestas') ?>"><i class="fas fa-poll"></i> Encuestas</a></li>
                <li><a href="<?= site_url('preguntas') ?>"><i class="fas fa-question-circle"></i> Preguntas</a></li>
                <li><a href="<?= site_url('usuarios') ?>"><i class="fas fa-users"></i> Usuarios</a></li>
                <li><a href="<?= site_url('estadisticas') ?>"><i class="fas fa-chart-bar"></i> Estadísticas</a></li>
            </ul>
        </div>

        <div class="main-content">
            <header class="navbar">
                <button class="menu-toggle-btn" id="menuToggleBtn"><i class="fas fa-bars"></i></button>
                <div class="nav-icons">
                    <a href="<?= site_url('login') ?>">
                        <button class="btn-logout">Cerrar Sesión</button>
                    </a>
                </div>
            </header>

            <div class="content-container">
                <h1 class="welcome-text">¡Bienvenido al Panel de Administrador!</h1>
                <h3>Selecciona una opción del menú para comenzar</h3>
            </div>
            
            <div class="asistente-ia">
                <div class="asistente-imagen">
                    <video autoplay loop muted playsinline>
                        <source src="<?= base_url('video/ia.mp4'); ?>" type="video/mp4">
                        Tu navegador no soporta videos.
                    </video>
                </div>
                <div class="asistente-mensaje" id="asistenteMensaje"></div>
            </div>
        </div>
    </div>

    <script>
        // Lógica para el asistente de mensajes (sin cambios significativos)
        const mensajes = [
            "🤖 ¡Hola, Administrador! Bienvenido al sistema de encuestas. Soy tu asistente virtual y estoy aquí para ayudarte a gestionar cada sección de manera eficiente. Con mi ayuda, podrás administrar encuestas, gestionar usuarios, analizar estadísticas y revisar respuestas de manera sencilla. Vamos a explorar juntos todas las funciones disponibles.",
            "📊 En la sección de *Encuestas*, puedes crear encuestas con preguntas personalizadas y definir el tipo de respuestas que los participantes pueden seleccionar. También tienes la opción de editar encuestas existentes o eliminarlas si ya no son necesarias. Además, puedes activar o desactivar encuestas según la etapa en la que se encuentren, permitiendo un control total sobre su disponibilidad.",
            "👥 La sección de *Usuarios* te permite registrar nuevos administradores y participantes en el sistema. Puedes modificar la información de cada usuario y asignarles diferentes roles según sus responsabilidades. También puedes eliminar usuarios que ya no necesiten acceso o gestionar permisos para restringir o ampliar las funciones a las que pueden acceder dentro del sistema.",
            "📈 En la sección de *Estadísticas*, puedes visualizar datos en tiempo real sobre las respuestas de las encuestas. Aquí puedes encontrar gráficos detallados que te ayudarán a comprender mejor los patrones y tendencias en las respuestas de los participantes. Estos análisis son clave para la toma de decisiones, ya que permiten evaluar el impacto de las encuestas y entender el comportamiento de los usuarios.",
            "📝 La sección de *Respuestas* te permite revisar las respuestas enviadas por los participantes en cada encuesta. Puedes filtrar los datos por encuesta y analizar la información recolectada para identificar patrones o tendencias específicas. Además, esta sección es útil para verificar la calidad de las respuestas y asegurarte de que la información recolectada sea útil para los análisis posteriores.",
            "🔐 **Seguridad y privacidad:** Es importante cerrar sesión cuando termines de trabajar en el sistema, especialmente si usas un dispositivo compartido. Esto ayuda a mantener la seguridad de la información y evita accesos no autorizados. Recuerda que la protección de los datos es clave para el correcto funcionamiento del sistema."
        ];

        let indiceMensaje = 0;
        const asistenteMensaje = document.getElementById("asistenteMensaje");

        function cambiarMensaje() {
            asistenteMensaje.style.opacity = 0;
            setTimeout(() => {
                asistenteMensaje.innerHTML = mensajes[indiceMensaje];
                indiceMensaje = (indiceMensaje + 1) % mensajes.length;
                asistenteMensaje.style.opacity = 1;
            }, 500);
        }

        asistenteMensaje.style.transition = "opacity 0.5s ease-in-out";
        setInterval(cambiarMensaje, 7000);
        window.onload = cambiarMensaje;

        // Lógica para la barra lateral responsive
        const menuToggleBtn = document.getElementById('menuToggleBtn');
        const closeSidebarBtn = document.getElementById('closeSidebarBtn');
        const sidebar = document.getElementById('sidebar');

        menuToggleBtn.addEventListener('click', () => {
            sidebar.classList.add('active');
        });

        closeSidebarBtn.addEventListener('click', () => {
            sidebar.classList.remove('active');
        });

        // Cerrar sidebar al hacer clic fuera (opcional, pero buena práctica)
        document.addEventListener('click', (event) => {
            if (sidebar.classList.contains('active') && 
                !sidebar.contains(event.target) && 
                !menuToggleBtn.contains(event.target)) {
                sidebar.classList.remove('active');
            }
        });
    </script>
</body>
</html>