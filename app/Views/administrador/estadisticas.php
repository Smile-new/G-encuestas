<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estadísticas de Encuestas</title>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>


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
            --button-green: #16A34A; /* Verde para Agregar / Activa */
            --border-color: #4B5563; /* Color de los bordes */
            --input-bg: #2C3E50; /* Fondo para campos de entrada/select */
            --input-border: #DC2626; /* Borde para campos de entrada/select */
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
            transition: transform 0.3s ease-in-out;
            position: relative;
            z-index: 1000;
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

        .sidebar .nav-links li a i {
            margin-right: 10px;
            font-size: 16px;
        }

        .sidebar .nav-links li a:hover,
        .sidebar .nav-links li a.active {
            background: var(--sidebar-active-link);
            color: var(--primary-text);
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
            z-index: 1001;
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
            justify-content: space-between; /* Ajustado para distribuir los elementos */
            align-items: center;
            border-bottom: 1px solid var(--border-color);
            position: sticky;
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

        .navbar h1 {
            margin: 0;
            font-size: 1.5rem;
            color: var(--primary-text); /* Color del título principal */
        }

        .navbar .nav-icons {
            display: flex;
            align-items: center;
            gap: 15px; /* Espacio entre el botón de cerrar sesión y el de PDF */
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
            text-decoration: none; /* Eliminar subrayado si es un <a> */
        }

        .navbar .btn-logout:hover {
            background: #B91C1C;
        }

        /* Botón Descargar PDF */
        .navbar .btn-danger { /* Renombrado de btn-lg a btn-danger para seguir la convención de colores */
            background-color: var(--button-red) !important;
            border-radius: 6px; /* Redondez similar a otros botones */
            padding: 8px 12px; /* Padding similar a otros botones */
            font-weight: bold;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.2s ease;
            display: flex; /* Para alinear el icono y el texto */
            align-items: center;
            font-size: 14px; /* Tamaño de fuente similar */
        }

        .navbar .btn-danger i {
            margin-right: 5px;
        }

        .navbar .btn-danger:hover {
            background-color: #C82333 !important;
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
        
        .content-container h3 { /* Estilo para los subtítulos de la tabla/gráfica */
            color: var(--primary-text);
            font-size: 1.5em;
            margin-bottom: 15px;
        }

        /* ===== Card con selects (Filtros) ===== */
        .card {
            background: var(--sidebar-bg); /* Fondo oscuro consistente */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); /* Sombra más sutil */
            margin-bottom: 20px;
            border: 1px solid var(--border-color); /* Borde suave */
        }
        
        .card label {
            color: var(--primary-text);
            font-weight: bold;
            display: block; /* Para que cada label ocupe su propia línea */
            margin-bottom: 5px;
        }
        
        .card select {
            width: 100%;
            margin: 5px 0 15px;
            padding: 10px;
            border-radius: 5px;
            background: var(--input-bg); /* Fondo oscuro para el select */
            color: var(--primary-text);
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
            border: 1px solid var(--input-border); /* Borde rojo */
            -webkit-appearance: none; /* Quita el estilo por defecto de navegadores */
            -moz-appearance: none;
            appearance: none;
            background-image: url('data:image/svg+xml;utf8,<svg fill="%23F9FAFB" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/><path d="M0 0h24v24H0z" fill="none"/></svg>'); /* Icono de flecha personalizado */
            background-repeat: no-repeat;
            background-position: right 10px top 50%;
            background-size: 20px auto;
            padding-right: 35px; /* Espacio para el icono */
        }
        
        .card select:hover {
            background: var(--table-row-hover); /* Tono más claro al pasar el mouse */
            color: var(--primary-text);
        }
        
        .card select:focus {
            outline: none;
            border: 2px solid var(--primary-text); /* Borde blanco al enfocar */
        }

        .card select:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        /* ===== Contenedor de las gráficas ===== */
        .chart-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .chart-box {
            flex: 1 1 500px; /* Base flexible, crece hasta 500px */
            background: var(--sidebar-bg); /* Fondo oscuro para el box */
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            min-width: 300px; /* Mínimo para que no se colapse demasiado en móvil */
            height: 400px; /* Altura fija para la gráfica */
            position: relative;
            border: 1px solid var(--border-color); /* Borde suave */
        }

        .chart-box h3 {
            margin-bottom: 10px;
            color: var(--primary-text);
            text-align: center;
            font-size: 1.3em;
        }

        canvas#grafico-principal {
            width: 100% !important;
            height: 100% !important;
            /* El fondo blanco lo manejamos con un plugin de Chart.js para el PDF */
            border-radius: 5px;
        }

        /* ===== Tabla de resultados ===== */
        .table-container {
            margin-top: 30px; /* Más espacio */
            overflow-x: auto; /* Para tablas que exceden el ancho */
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .styled-table {
            width: 100%;
            border-collapse: collapse;
            background: var(--body-bg); /* Fondo de la tabla similar al body */
            color: var(--secondary-text);
            border-radius: 8px;
            overflow: hidden;
        }

        .styled-table thead {
            background: var(--table-header-bg); /* Rojo de la cabecera */
            color: var(--primary-text);
        }

        .styled-table th, .styled-table td {
            padding: 10px 12px;
            text-align: center;
            border-bottom: 1px solid var(--border-color);
        }

        .styled-table tbody tr:last-child td {
            border-bottom: none;
        }

        .styled-table tbody tr:hover {
            background: var(--table-row-hover);
        }

        /* --- MEDIA QUERIES PARA RESPONSIVE --- */

        /* Para pantallas más pequeñas (teléfonos, hasta 768px) */
        @media (max-width: 768px) {
            .dashboard-container {
                flex-direction: column;
            }

            .sidebar {
                position: fixed;
                top: 0;
                left: -220px; /* Oculto por defecto */
                height: 100vh;
                padding-top: 60px; /* Espacio para el botón de cerrar */
                width: 220px;
            }

            .sidebar.active {
                transform: translateX(220px); /* Muestra la sidebar */
            }

            .sidebar .close-sidebar-btn {
                display: block;
            }

            .navbar {
                justify-content: space-between; /* Vuelve a justificar para botón de menú y logout */
                flex-wrap: nowrap; /* Evita que los elementos de la navbar se envuelvan */
            }

            .navbar .menu-toggle-btn {
                display: block;
            }

            .navbar h1 {
                font-size: 1.2em; /* Título más pequeño */
            }

            .navbar .nav-icons {
                flex-direction: column; /* Apila botones en la navbar */
                align-items: flex-end; /* Alinea a la derecha */
                gap: 8px; /* Espacio más pequeño */
                width: auto; /* Ajusta el ancho automáticamente */
            }

            .navbar .btn-logout,
            .navbar .btn-danger {
                width: auto; /* Ajusta el ancho al contenido */
                font-size: 12px; /* Fuente más pequeña */
                padding: 6px 10px;
            }

            .main-content {
                width: 100%;
                padding-left: 0;
            }

            .content-container {
                padding: 15px;
            }

            .content-container h1 {
                font-size: 1.8em;
            }

            /* Ajustes para la card de selects */
            .card {
                padding: 15px;
            }

            .card select {
                margin-bottom: 10px; /* Menos margen inferior */
            }

            /* Gráficas */
            .chart-box {
                min-width: 100%; /* Ocupa todo el ancho disponible */
                height: 300px; /* Altura un poco más pequeña */
                padding: 15px;
            }

            .chart-box h3 {
                font-size: 1.1em;
            }

            /* Tabla más compacta en móvil */
            .styled-table th, .styled-table td {
                padding: 8px 10px;
                font-size: 0.9em;
            }
        }

        /* Para pantallas medianas (tabletas, entre 769px y 1024px) */
        @media (min-width: 769px) and (max-width: 1024px) {
            .sidebar {
                width: 200px;
            }
            .content-container {
                padding: 20px;
            }
            .chart-box {
                flex: 1 1 45%; /* Dos columnas si hay espacio suficiente */
                min-width: 380px; /* Asegura un tamaño mínimo si hay solo una gráfica */
            }
        }

        /* Para pantallas grandes (desktop, a partir de 1025px) */
        @media (min-width: 1025px) {
            .sidebar {
                width: 220px;
            }
            .chart-box {
                flex: 1 1 500px; /* Vuelve al tamaño original */
            }
        }

        .btn-excel {
    background-color: #28a745; /* verde tipo Excel */
    color: #fff;
    border: none;
    padding: 10px 16px;
    font-size: 14px;
    font-weight: bold;
    border-radius: 6px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: background-color 0.3s, transform 0.2s;
}

.btn-excel:hover {
    background-color: #218838;
    transform: scale(1.03);
}

.btn-excel i {
    font-size: 16px;
}


.btn-pdf {
    background-color: #c0392b; /* Rojo para PDF */
    color: #ffffff;
    padding: 10px 18px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 0.95rem;
    font-weight: 600;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.btn-pdf:hover {
    background-color: #a93226; /* Rojo un poco más oscuro al pasar el ratón */
    transform: translateY(-2px); /* Pequeño efecto de elevación */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Sombra más pronunciada al pasar el ratón */
}

/* Estilo para el icono dentro del botón, si se usa Font Awesome */
.btn-pdf i {
    font-size: 1.1rem;
}

        
    </style>
</head>
<body>

<div class="dashboard-container">
    <div class="sidebar" id="sidebar">
        <button class="close-sidebar-btn" id="closeSidebarBtn"><i class="fas fa-times"></i></button>
        <h2 class="logo">Monitor <span>Encuestal</span></h2>
        <ul class="nav-links">
            <li><a href="<?= site_url('administrador') ?>"><i class="fas fa-home"></i> Inicio</a></li>
            <li><a href="<?= site_url('encuestas') ?>"><i class="fas fa-poll"></i> Encuestas</a></li>
            <li><a href="<?= site_url('preguntas') ?>"><i class="fas fa-question-circle"></i> Preguntas</a></li>
            <li><a href="<?= site_url('usuarios') ?>"><i class="fas fa-users"></i> Usuarios</a></li>
            <li><a href="<?= site_url('estadisticas') ?>" class="active"><i class="fas fa-chart-bar"></i> Estadísticas</a></li>
        </ul>
    </div>
<div class="main-content" id="mainContent">
    <header class="navbar">
        <button class="menu-toggle-btn" id="menuToggleBtn"><i class="fas fa-bars"></i></button>
        <h1>Estadísticas de Encuestas</h1>
        <div class="nav-icons">
            <button id="descargarExcel" class="btn-excel">
                <i class="fas fa-file-excel"></i> Descargar Excel
            </button>
            <button id="descargarPdf" class="btn-pdf">
                <i class="fas fa-file-pdf"></i> Descargar PDF
            </button>
            <a href="<?= site_url('logout') ?>"> <button class="btn-logout">Cerrar Sesión</button>
            </a>
        </div>
    </header>

  <div class="content-container">
    <div class="card">
        <label for="select-encuesta">Selecciona una Encuesta:</label>
        <select id="select-encuesta">
            <option value="">-- Selecciona --</option>
            <?php foreach($encuestas as $encuesta): ?>
                <option value="<?= $encuesta['id_encuesta'] ?>"><?= esc($encuesta['titulo']) ?></option>
            <?php endforeach; ?>
        </select>

        <label for="select-pregunta">Selecciona una Pregunta:</label>
        <select id="select-pregunta" disabled>
            <option value="">-- Selecciona --</option>
        </select>

        <label for="select-estado-filtro">Selecciona un Estado:</label>
        <select id="select-estado-filtro">
            <option value="">-- Selecciona --</option>
            <?php if (isset($estados)): ?>
                <?php foreach($estados as $estado): ?>
                    <option value="<?= $estado['id_estado'] ?>"><?= esc($estado['nombre']) ?></option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>

        <label for="select-municipio-filtro">Selecciona un Municipio:</label>
        <select id="select-municipio-filtro" disabled>
            <option value="">-- Selecciona --</option>
        </select>

        <label for="select-seccion-filtro">Selecciona una Sección:</label>
        <select id="select-seccion-filtro" disabled>
            <option value="">-- Selecciona --</option>
        </select>

        <label for="select-grafica">Tipo de Gráfica:</label>
        <select id="select-grafica">
            <option value="bar">Barras Verticales</option>
            <option value="horizontalBar">Barras Horizontales</option>
            <option value="line">Líneas</option>
            <option value="radar">Radar</option>
            <option value="doughnut">Donut</option>
            <option value="pie">Pastel</option>
            <option value="polarArea">Área Polar</option>
        </select>

        <div class="chart-container" style="position: relative; height:40vh; width:80vw; margin-top: 20px;">
            <h3 id="titulo-grafica">Gráfica (polarArea)</h3>
            <canvas id="grafico-principal"></canvas>
        </div>

        <div class="table-container" style="margin-top: 20px;">
            <h3>Resultados Resumen (Opciones y Votos)</h3>
            <table class="styled-table" id="tabla-resumen">
                <thead>
                    <tr>
                        <th>Opción</th>
                        <th>Votos</th>
                    </tr>
                </thead>
                <tbody id="tabla-resumen-resultados">
                    <tr><td colspan="2">Selecciona una pregunta para ver el resumen.</td></tr>
                </tbody>
            </table>
        </div>

        <div class="table-container" style="margin-top: 20px;">
            <h3>Detalle de Respuestas</h3>
            <table class="styled-table" id="tabla-detalle">
                <thead>
                    <tr>
                        <th>Opción Elegida</th>
                        <th>Votos (de esta Opción)</th>
                        <th>Ubicación Completa</th>
                        <th>Fecha y Hora</th>
                    </tr>
                </thead>
                <tbody id="tabla-principal-resultados">
                    <tr><td colspan="4">Selecciona una pregunta para ver las respuestas.</td></tr>
                </tbody>
            </table>
        </div>

      
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.16/jspdf.plugin.autotable.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>

<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

<script>
    const baseUrl = "<?= base_url(); ?>";
    let myChart; // Variable global para la instancia de la gráfica
    let currentChartData = []; // Almacena los datos de la gráfica/resumen

    $(document).ready(function () {
        // --- Lógica del Sidebar --- (Mantengo tu código original aquí ya que no afecta la funcionalidad principal)
        const menuToggleBtn = document.getElementById('menuToggleBtn');
        const closeSidebarBtn = document.getElementById('closeSidebarBtn');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');

        function adjustLayout() {
            if (window.innerWidth <= 768) {
                if (menuToggleBtn) menuToggleBtn.style.display = 'block';
                if (mainContent) mainContent.classList.remove('sidebar-active');
            } else {
                if (menuToggleBtn) menuToggleBtn.style.display = 'none';
                if (sidebar) sidebar.classList.remove('active');
                if (mainContent) mainContent.classList.remove('sidebar-active');
            }
        }

        adjustLayout();
        window.addEventListener('resize', adjustLayout);

        if (menuToggleBtn) {
            menuToggleBtn.addEventListener('click', () => {
                if (sidebar) sidebar.classList.add('active');
                if (mainContent) mainContent.classList.add('sidebar-active');
            });
        }
        if (closeSidebarBtn) {
            closeSidebarBtn.addEventListener('click', () => {
                if (sidebar) sidebar.classList.remove('active');
                if (mainContent) mainContent.classList.remove('sidebar-active');
            });
        }

        document.addEventListener('click', (event) => {
            if (sidebar?.classList.contains('active') &&
                !sidebar.contains(event.target) &&
                !menuToggleBtn?.contains(event.target)) {
                if (sidebar) sidebar.classList.remove('active');
                if (mainContent) mainContent.classList.remove('sidebar-active');
            }
        });

        // --- Lógica de carga de Encuestas y Preguntas ---
        $("#select-encuesta").change(function () {
            const idEncuesta = $(this).val();
            $("#select-pregunta").prop("disabled", true).html('<option value="">Cargando...</option>');
            limpiarContenidoCompleto(); // Llama a una nueva función para limpiar todo

            if (!idEncuesta) {
                $("#select-pregunta").html('<option value="">-- Selecciona --</option>').prop("disabled", true);
                return;
            }

            $.ajax({
                url: `${baseUrl}/estadisticas/getPreguntas/${idEncuesta}`,
                type: "GET",
                dataType: "json",
                success: function (resp) {
                    if (resp.length > 0) {
                        const opciones = ['<option value="">-- Selecciona --</option>']
                            .concat(resp.map(p => `<option value="${p.id_pregunta}">${p.pregunta_texto}</option>`));
                        $("#select-pregunta").html(opciones.join('')).prop("disabled", false);
                    } else {
                        $("#select-pregunta").html('<option value="">Sin preguntas</option>').prop("disabled", true);
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error al cargar preguntas:", status, error, xhr.responseText);
                    $("#select-pregunta").html('<option value="">Error al cargar</option>').prop("disabled", true);
                    limpiarContenidoCompleto();
                }
            });
        });

        // --- Lógica de carga de Municipios y Secciones ---
        $("#select-estado-filtro").change(function () {
            const idEstado = $(this).val();
            $("#select-municipio-filtro").prop("disabled", true).html('<option value="">Cargando...</option>');
            $("#select-seccion-filtro").prop("disabled", true).html('<option value="">-- Selecciona --</option>'); // Limpiar y deshabilitar secciones

            if (!idEstado) {
                $("#select-municipio-filtro").html('<option value="">-- Selecciona --</option>').prop("disabled", true);
                cargarDatosFiltrados(); 
                return;
            }

            $.ajax({
                url: `${baseUrl}/estadisticas/getMunicipios/${idEstado}`,
                type: "GET",
                dataType: "json",
                success: function (resp) {
                    if (resp.length > 0) {
                        const opciones = ['<option value="">-- Selecciona --</option>']
                            .concat(resp.map(m => `<option value="${m.id_municipio}">${m.nombre}</option>`));
                        $("#select-municipio-filtro").html(opciones.join('')).prop("disabled", false);
                    } else {
                        $("#select-municipio-filtro").html('<option value="">Sin municipios</option>').prop("disabled", true);
                    }
                    // IMPORTANTE: Aquí se debe cargar las secciones si ya hay un municipio seleccionado,
                    // o limpiar las secciones si no hay municipio.
                    // La carga de datos filtrados general se manejará al cambiar la sección también.
                    $("#select-municipio-filtro").trigger('change'); // Dispara el evento change del municipio para cargar secciones
                },
                error: function (xhr, status, error) {
                    console.error("Error al cargar municipios:", status, error, xhr.responseText);
                    $("#select-municipio-filtro").html('<option value="">Error al cargar</option>').prop("disabled", true);
                    $("#select-seccion-filtro").html('<option value="">Error al cargar</option>').prop("disabled", true);
                    cargarDatosFiltrados(); 
                }
            });
        });

        // NUEVO: Lógica para cargar secciones cuando cambia el municipio
        $("#select-municipio-filtro").change(function () {
            const idMunicipio = $(this).val();
            $("#select-seccion-filtro").prop("disabled", true).html('<option value="">Cargando...</option>');
            
            if (!idMunicipio) {
                $("#select-seccion-filtro").html('<option value="">-- Selecciona --</option>').prop("disabled", true);
                cargarDatosFiltrados(); // Recargar datos sin filtro de sección
                return;
            }

            $.ajax({
                url: `${baseUrl}/estadisticas/getSecciones/${idMunicipio}`,
                type: "GET",
                dataType: "json",
                success: function (resp) {
                    if (resp.length > 0) {
                        const opciones = ['<option value="">-- Selecciona --</option>']
                            .concat(resp.map(s => `<option value="${s.id_seccion}">${s.nombre_seccion}</option>`));
                        $("#select-seccion-filtro").html(opciones.join('')).prop("disabled", false);
                    } else {
                        $("#select-seccion-filtro").html('<option value="">Sin secciones</option>').prop("disabled", true);
                    }
                    cargarDatosFiltrados(); // Cargar datos después de cargar las secciones
                },
                error: function (xhr, status, error) {
                    console.error("Error al cargar secciones:", status, error, xhr.responseText);
                    $("#select-seccion-filtro").html('<option value="">Error al cargar</option>').prop("disabled", true);
                    cargarDatosFiltrados(); // Intentar cargar datos incluso si hay un error
                }
            });
        });


        // --- Event Listeners para cargar datos filtrados ---
        // Se añadió #select-seccion-filtro
        $("#select-pregunta, #select-estado-filtro, #select-municipio-filtro, #select-seccion-filtro").change(function () {
            cargarDatosFiltrados();
        });

        // --- Función principal para cargar datos con filtros ---
        function cargarDatosFiltrados() {
            const idPregunta = $("#select-pregunta").val();
            const idEstado = $("#select-estado-filtro").val();
            const idMunicipio = $("#select-municipio-filtro").val();
            const idSeccion = $("#select-seccion-filtro").val(); // <-- NUEVO: Obtener el ID de la sección

            if (!idPregunta) {
                limpiarContenidoCompleto();
                return;
            }

            // 1. Cargar datos para la gráfica y tabla resumen
            $.ajax({
                url: `${baseUrl}/estadisticas/obtenerResultadosResumen`,
                type: "POST",
                data: {
                    id_pregunta: idPregunta,
                    id_estado: idEstado || null,
                    id_municipio: idMunicipio || null,
                    id_seccion: idSeccion || null // <-- NUEVO: Enviar ID de la sección
                },
                dataType: "json",
                success: function(data) {
                    currentChartData = data;
                    generarGraficas(data);
                    generarTablaResumen(data);
                },
                error: function(xhr, status, error) {
                    console.error("Error al cargar resultados resumen:", status, error, xhr.responseText);
                    limpiarGraficas();
                    limpiarTablaResumen();
                }
            });

            // 2. Cargar tabla detalle
            $.ajax({
                url: `${baseUrl}/estadisticas/obtenerRespuestasDetalle`,
                type: "POST",
                data: {
                    id_pregunta: idPregunta,
                    id_estado: idEstado || null,
                    id_municipio: idMunicipio || null,
                    id_seccion: idSeccion || null // <-- NUEVO: Enviar ID de la sección
                },
                dataType: "json",
                success: generarTablaPrincipal,
                error: function(xhr, status, error) {
                    console.error("Error al cargar detalle:", status, error, xhr.responseText);
                    $("#tabla-principal-resultados").html('<tr><td colspan="4">Error al cargar datos de detalle</td></tr>');
                }
            });
        }

        // --- Lógica para cambiar tipo de gráfica ---
        $("#select-grafica").change(function() {
            const idPregunta = $("#select-pregunta").val();
            if (idPregunta && currentChartData.length > 0) {
                generarGraficas(currentChartData);
            } else {
                limpiarGraficas();
            }
        });

        // --- Funciones para generar y limpiar gráficas ---
        function generarGraficas(datos) {
            const tipoSeleccionado = $("#select-grafica").val() || "bar";
            const tipoGrafica = (tipoSeleccionado === "horizontalBar") ? "bar" : tipoSeleccionado;

            const etiquetas = datos.map(d => d.opcion || "Sin dato");
            const valores = datos.map(d => d.votos);

            // Paleta de colores vivos sobre fondo blanco
            const colores = [
                "#FF6347", "#36A2EB", "#FFD700", "#20B2AA", "#FF8C00", 
                "#9932CC", "#228B22", "#4169E1", "#000000", "#DAA520",
                "#FF4500", "#1E90FF", "#FFDAB9", "#3CB371", "#FFA07A"
            ];

            $("#titulo-grafica").text(`Gráfica (${tipoSeleccionado})`);
            limpiarGraficas();

            const ctx = document.getElementById("grafico-principal").getContext("2d");

            // Plugin para fondo blanco dentro del canvas
            const fondoBlanco = {
                id: 'fondo_blanco',
                beforeDraw: (chart) => {
                    const ctx = chart.canvas.getContext('2d');
                    ctx.save();
                    ctx.globalCompositeOperation = 'destination-over';
                    ctx.fillStyle = '#ffffff';
                    ctx.fillRect(0, 0, chart.width, chart.height);
                    ctx.restore();
                }
            };

            const config = {
                type: tipoGrafica,
                data: {
                    labels: etiquetas,
                    datasets: [{
                        label: "Votos",
                        data: valores,
                        backgroundColor: colores,
                        borderColor: "#333",
                        borderWidth: 1,
                        fill: (tipoGrafica === "line" || tipoGrafica === "radar")
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        duration: 2000,
                        easing: "easeOutBounce"
                    },
                    plugins: {
                        legend: {
                            labels: {
                                color: "#000",
                                font: { weight: "bold" }
                            }
                        },
                        tooltip: {
                            backgroundColor: "#eee",
                            titleColor: "#000",
                            bodyColor: "#000",
                            borderColor: "#999",
                            borderWidth: 1
                        }
                    },
                    indexAxis: tipoSeleccionado === "horizontalBar" ? "y" : "x",
                    scales: {}
                },
                plugins: [fondoBlanco]
            };

            // Configuración de escalas según tipo de gráfica
            if (["bar", "line"].includes(tipoGrafica)) {
                config.options.scales = {
                    y: {
                        beginAtZero: true,
                        ticks: { color: "#000" },
                        grid: { color: "#ccc" }
                    },
                    x: {
                        ticks: { color: "#000" },
                        grid: { color: "#ccc" }
                    }
                };
            }

            if (tipoGrafica === "radar" || tipoGrafica === "polarArea") {
                config.options.scales = {
                    r: {
                        beginAtZero: true,
                        min: 0,
                        suggestedMax: Math.max(...valores) + (valores.length > 0 ? Math.ceil(Math.max(...valores) * 0.1) : 10),
                        ticks: { color: "#000" },
                        grid: { color: "#ccc" },
                        angleLines: { color: "#aaa" },
                        pointLabels: { color: "#000", font: { size: 14 } }
                    }
                };
            }

            myChart = new Chart(ctx, config);
        }

        function limpiarGraficas() {
            if (myChart) {
                myChart.destroy();
                myChart = null;
            }
        }

        // --- Funciones para generar tablas ---
        function generarTablaPrincipal(datos) {
            let html = "";
            if (!Array.isArray(datos) || datos.length === 0) {
                html = '<tr><td colspan="4">No hay respuestas para esta pregunta con los filtros seleccionados.</td></tr>';
            } else {
                datos.forEach(d => {
                    const opcionElegida = d.opcion_elegida || "N/A";
                    const votos = (d.votos !== undefined && d.votos !== null) ? d.votos : "N/A";
                    const ubicacionCompleta = d.ubicacion_completa || "Sin ubicación";
                    const fechaUbicacion = d.fecha_ubicacion ? new Date(d.fecha_ubicacion).toLocaleString('es-ES', {
                        year: 'numeric',
                        month: '2-digit',
                        day: '2-digit',
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit',
                        hour12: false
                    }) : "N/A";

                    html += `
                        <tr>
                            <td>${opcionElegida}</td>
                            <td>${votos}</td>
                            <td>${ubicacionCompleta}</td>
                            <td>${fechaUbicacion}</td>
                        </tr>`;
                });
            }
            $("#tabla-principal-resultados").html(html);
        }

        function limpiarTablaPrincipal() {
            $("#tabla-principal-resultados").html('<tr><td colspan="4">Selecciona una pregunta para ver las respuestas.</td></tr>');
        }

        function generarTablaResumen(datos) {
            let html = "";
            if (!Array.isArray(datos) || datos.length === 0) {
                html = '<tr><td colspan="2">No hay datos resumidos para esta pregunta con los filtros seleccionados.</td></tr>';
            } else {
                datos.forEach(d => {
                    const opcion = d.opcion || "N/A";
                    const votos = (d.votos !== undefined && d.votos !== null) ? d.votos : "N/A";
                    html += `
                        <tr>
                            <td>${opcion}</td>
                            <td>${votos}</td>
                        </tr>`;
                });
            }
            $("#tabla-resumen-resultados").html(html);
        }

        function limpiarTablaResumen() {
            $("#tabla-resumen-resultados").html('<tr><td colspan="2">Selecciona una pregunta para ver el resumen.</td></tr>');
        }

        // Nueva función para limpiar todo el contenido relevante
        function limpiarContenidoCompleto() {
            limpiarGraficas();
            limpiarTablaPrincipal();
            limpiarTablaResumen();
            currentChartData = []; // Resetear los datos de la gráfica
        }


        // --- Lógica de Descarga de Excel para la Tabla Detalle ---
        $("#descargarExcel").click(function () {
            const tabla = document.getElementById("tabla-detalle");
            const encuesta = $("#select-encuesta option:selected").text();
            const pregunta = $("#select-pregunta option:selected").text();
            const estado = $("#select-estado-filtro option:selected").text() || "Todos";
            const municipio = $("#select-municipio-filtro option:selected").text() || "Todos";
            const seccion = $("#select-seccion-filtro option:selected").text() || "Todas"; // <-- NUEVO: Obtener la sección

            if (!tabla || tabla.rows.length <= 0 || (tabla.rows.length === 1 && tabla.rows[0].cells[0].colSpan > 1)) {
                alert("No hay datos en la tabla de detalle para exportar.");
                return;
            }

            const wb = XLSX.utils.book_new();
            const ws_data = [];

            ws_data.push(["Encuesta:", encuesta]);
            ws_data.push(["Pregunta:", pregunta]);
            ws_data.push(["Estado:", estado]);
            ws_data.push(["Municipio:", municipio]);
            ws_data.push(["Sección:", seccion]); // <-- NUEVO: Añadir al encabezado del Excel
            ws_data.push([]); // Fila vacía para separación
            ws_data.push(["Opción Elegida", "Votos (de esta Opción)", "Ubicación Completa", "Fecha y Hora"]);

            Array.from(tabla.querySelectorAll('#tabla-principal-resultados tr')).forEach((row) => {
                const cols = Array.from(row.cells).map(col => col.textContent.trim());
                if (cols.length === 4 && cols[0] !== "Selecciona una pregunta para ver las respuestas." && cols[0] !== "Error al cargar datos de detalle") { 
                    ws_data.push(cols);
                }
            });

            const ws = XLSX.utils.aoa_to_sheet(ws_data);
            XLSX.utils.book_append_sheet(wb, ws, "DetalleRespuestas");

            XLSX.writeFile(wb, `Detalle_Respuestas_${encuesta.replace(/[^a-z0-9]/gi, '_')}.xlsx`);
        });

        // --- Lógica de Descarga de PDF (Gráfica y Tabla Resumen) ---
        $("#descargarPdf").click(async function () {
            const encuestaTitulo = $("#select-encuesta option:selected").text();
            const preguntaTexto = $("#select-pregunta option:selected").text();
            const estadoTexto = $("#select-estado-filtro option:selected").text() || "Todos";
            const municipioTexto = $("#select-municipio-filtro option:selected").text() || "Todos";
            const seccionTexto = $("#select-seccion-filtro option:selected").text() || "Todas"; // <-- NUEVO: Obtener la sección

            if (!encuestaTitulo || !preguntaTexto || preguntaTexto === "-- Selecciona --" || preguntaTexto === "Sin preguntas") {
                alert("Por favor, selecciona una encuesta y una pregunta con datos para generar el PDF.");
                return;
            }

            const { jsPDF } = window.jspdf;
            const doc = new jsPDF('p', 'mm', 'a4');

            let yPos = 10;

            // Encabezados
            doc.setFontSize(16);
            doc.text(`Encuesta: ${encuestaTitulo}`, 10, yPos);
            yPos += 7;
            
            doc.setFontSize(14);
            doc.text(`Pregunta: ${preguntaTexto}`, 10, yPos);
            yPos += 7;
            
            // Actualizar la línea de filtros para incluir sección
            doc.text(`Filtros: Estado: ${estadoTexto} / Municipio: ${municipioTexto} / Sección: ${seccionTexto}`, 10, yPos);
            yPos += 10;

            // Gráfica
            if (myChart) {
                const canvas = document.getElementById("grafico-principal");
                // Crear un canvas temporal para asegurar el fondo blanco para la imagen del PDF
                const tempCanvas = document.createElement('canvas');
                const tempCtx = tempCanvas.getContext('2d');
                tempCanvas.width = canvas.width;
                tempCanvas.height = canvas.height;
                tempCtx.fillStyle = '#ffffff'; // Fondo blanco
                tempCtx.fillRect(0, 0, tempCanvas.width, tempCanvas.height);
                tempCtx.drawImage(canvas, 0, 0);

                const imgData = tempCanvas.toDataURL('image/png');
                const imgWidth = 180;
                const imgHeight = (tempCanvas.height * imgWidth) / tempCanvas.width;

                if (yPos + imgHeight > 280) { // Si no cabe en la página actual, añadir nueva página
                    doc.addPage();
                    yPos = 10;
                }
                doc.addImage(imgData, 'PNG', 10, yPos, imgWidth, imgHeight);
                yPos += imgHeight + 10;
            } else {
                doc.setFontSize(12);
                doc.text("No se pudo generar la gráfica para esta pregunta.", 10, yPos);
                yPos += 10;
            }

            // Tabla de resumen
            doc.setFontSize(14);
            doc.text("Resultados Resumen (Opciones y Votos)", 10, yPos);
            yPos += 7;

            const tablaResumen = document.getElementById("tabla-resumen");
            const headResumen = Array.from(tablaResumen.querySelectorAll('thead th')).map(th => th.innerText);
            const bodyResumen = Array.from(tablaResumen.querySelectorAll('#tabla-resumen-resultados tr')).map(row =>
                Array.from(row.cells).map(cell => cell.innerText)
            ).filter(row => row.length > 1 && row[0] !== "Selecciona una pregunta para ver el resumen." && row[0] !== "No hay datos resumidos para esta pregunta con los filtros seleccionados.");

            if (bodyResumen.length > 0) {
                doc.autoTable({
                    startY: yPos,
                    head: [headResumen],
                    body: bodyResumen,
                    theme: 'grid',
                    styles: { fillColor: [255, 255, 255], textColor: [0, 0, 0] },
                    headStyles: { fillColor: [200, 50, 50], textColor: [255, 255, 255], fontStyle: 'bold' },
                    didDrawPage: function (data) {
                        yPos = data.cursor.y + 10;
                    }
                });
                yPos = doc.autoTable.previous.finalY + 10;
            } else {
                doc.setFontSize(12);
                doc.text("No hay datos de resumen para esta pregunta.", 10, yPos);
                yPos += 10;
            }

            const filename = `Reporte_${encuestaTitulo.replace(/[^a-z0-9]/gi, '_')}_${preguntaTexto.replace(/[^a-z0-9]/gi, '_')}.pdf`;
            doc.save(filename);
        });
    });
</script>
</body>
</html>