<?php

namespace App\Controllers;

// Usamos los modelos para poder interactuar con la base de datos
use App\Models\UsuarioModel;
use App\Models\RolModel;
use App\Models\EncuestaModel;
use App\Models\RespuestaModel;
use App\Models\PreguntaModel;
use App\Models\OpcionModel;
use App\Models\MonitoreoModel;
use Config\Google; 

class Propietario extends BaseController
{
    protected $usuarioModel; 

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
    }

    private function _prepareUserData(): array
    {
        $session = session();
        $userData = $session->get('usuario');
        $data = [];

        $data['isLoggedIn'] = $session->get('isLoggedIn');
        $data['userData'] = $userData;
        $data['id_encuestador'] = $userData['id_usuario'] ?? null;
        $data['nombreCompleto'] = "Invitado";
        $data['nombreUsuario'] = "invitado";
        $data['rutaFotoPerfil'] = base_url('recursos_encuestador_images/user.png'); 

        if ($data['isLoggedIn'] && is_array($userData)) {
            $data['nombreCompleto'] = trim(esc($userData['nombre'] ?? '') . ' ' .
                esc($userData['apellido_paterno'] ?? '') . ' ' .
                esc($userData['apellido_materno'] ?? ''));
            $data['nombreUsuario'] = esc($userData['usuario'] ?? '');
            if (!empty($userData['foto'])) {
                $data['rutaFotoPerfil'] = base_url('public/img_user/' . esc($userData['foto']));
            }
        }
        return $data;
    }
    
    /**
     * [NUEVO INDEX] Muestra la vista principal del panel (Controlador/panel).
     */
    public function index()
    {
        // El index ahora solo carga la vista base del panel.
        return view('Controlador/panel');
    }

    /**
     * [NUEVA GRÁFICAS] Contiene la lógica completa de obtención y preparación de datos para las gráficas y KPIs.
     */
    public function graficas()
    {
        // 1. Instanciamos los modelos
        $usuarioModel   = new UsuarioModel();
        $encuestaModel  = new EncuestaModel();
        $respuestaModel = new RespuestaModel();

        // 2. Obtenemos los conteos totales para las tarjetas (KPIs)
        $totalUsuarios   = $usuarioModel->countAllResults();
        $totalEncuestas  = $encuestaModel->countAllResults();
        $totalRespuestas = $respuestaModel->countAllResults();

        // 3. GRÁFICA DE BARRAS VERTICALES: Usuarios por Rol 
        $usuariosPorRol = $usuarioModel
            ->select('roles.nombre_rol, COUNT(usuarios.id_usuario) as total')
            ->join('roles', 'roles.id_rol = usuarios.id_rol', 'left')
            ->groupBy('roles.nombre_rol')
            ->orderBy('roles.id_rol', 'ASC')
            ->findAll();

        $graficaRolesLabels = array_column($usuariosPorRol, 'nombre_rol');
        $graficaRolesData   = array_column($usuariosPorRol, 'total');
        
        // 4. GRÁFICA DE PASTEL: Estado de las Encuestas (Activas vs. Inactivas)
        $estadoEncuestas = $encuestaModel
            ->select('CASE WHEN activa = 1 THEN "Activas" ELSE "Inactivas" END as estado, COUNT(id_encuesta) as total', false)
            ->groupBy('estado')
            ->findAll();
        
        $graficaEncuestasStatusLabels = array_column($estadoEncuestas, 'estado');
        $graficaEncuestasStatusData   = array_column($estadoEncuestas, 'total');

        // 5. GRÁFICA DE LÍNEA DE PICOS: Actividad general de los últimos 30 días 
        $actividad30Dias = $respuestaModel
            ->select('DATE(fecha_respuesta) as fecha, COUNT(id_respuesta) as total')
            ->where('fecha_respuesta >=', date('Y-m-d H:i:s', strtotime('-30 days')))
            ->groupBy('DATE(fecha_respuesta)')
            ->orderBy('fecha', 'ASC')
            ->findAll();

        $actividadMap = array_column($actividad30Dias, 'total', 'fecha');
        $graficaActividadLabels = [];
        $graficaActividadData   = [];
        for ($i = 29; $i >= 0; $i--) {
            $currentDate = date('Y-m-d', strtotime("-$i days"));
            $graficaActividadLabels[] = $currentDate;
            $graficaActividadData[]   = $actividadMap[$currentDate] ?? 0;
        }

        // 6. Pasamos todos los datos a la vista 
        $data = [
            'totalUsuarios'                => $totalUsuarios,
            'totalEncuestas'               => $totalEncuestas,
            'totalRespuestas'              => $totalRespuestas,
            'graficaRolesLabels'           => json_encode($graficaRolesLabels),
            'graficaRolesData'             => json_encode($graficaRolesData),
            'graficaEncuestasStatusLabels' => json_encode($graficaEncuestasStatusLabels),
            'graficaEncuestasStatusData'   => json_encode($graficaEncuestasStatusData),
            'graficaActividadLabels'       => json_encode($graficaActividadLabels),
            'graficaActividadData'         => json_encode($graficaActividadData),
        ];

        return view('Controlador/graficas', $data);
    }
    
    /**
     * [FUNCIÓN AJAX]
     * Devuelve los datos de actividad de una encuesta específica en formato JSON.
     */
    public function actividadPorEncuesta()
    {
        $encuestaId = $this->request->getGet('id');
        $respuestaModel = new RespuestaModel();
        
        $query = $respuestaModel
            ->select('DATE(fecha_respuesta) as fecha, COUNT(id_respuesta) as total')
            ->where('fecha_respuesta >=', date('Y-m-d', strtotime('-30 days')));

        if ($encuestaId && $encuestaId !== 'all') {
            $query->where('id_encuesta', $encuestaId);
        }

        $actividad = $query->groupBy('DATE(fecha_respuesta)')->orderBy('fecha', 'ASC')->findAll();

        $actividadMap = array_column($actividad, 'total', 'fecha');

        $labels = [];
        $data   = [];
        for ($i = 29; $i >= 0; $i--) {
            $currentDate = date('Y-m-d', strtotime("-$i days"));
            $labels[] = $currentDate;
            $data[]   = $actividadMap[$currentDate] ?? 0;
        }

        return $this->response->setJSON(['labels' => $labels, 'data' => $data]);
    }

    /**
     * Muestra la interfaz de supervisión de usuarios.
     * Carga la lista principal con roles y el nombre del creador.
     */
    public function usuarios()
    {
        $usuarioModel = new UsuarioModel();
        $rolModel = new RolModel();

        // Obtener la lista de usuarios con JOINs para supervisión
        $listaUsuarios = $usuarioModel
            ->select('
                usuarios.id_usuario, 
                usuarios.nombre, 
                usuarios.apellido_paterno,
                usuarios.apellido_materno,
                usuarios.usuario,
                roles.nombre_rol,
                usuarios.foto,
                usuarios.telefono,
                usuarios.creado_por_id,
                CONCAT(creador.nombre, " ", creador.apellido_paterno) AS nombre_creador
            ')
            ->join('roles', 'roles.id_rol = usuarios.id_rol', 'left')
            ->join('usuarios AS creador', 'creador.id_usuario = usuarios.creado_por_id', 'left')
            ->orderBy('usuarios.id_usuario', 'DESC')
            ->findAll();

        // Variable con la ruta de las fotos
        $img_path_user = rtrim(base_url('public/img_user'), '/') . '/';

        $data = [
            'listaUsuarios' => $listaUsuarios,
            'rolesDisponibles' => $rolModel->findAll(),
            'img_path_user' => $img_path_user,
        ];

        return view('Controlador/usuarios', $data);
    }
    
    /**
     * [FUNCIÓN AJAX ESPECIAL]
     * Devuelve todos los datos de perfil de un usuario específico en JSON.
     */
    public function detalleUsuario()
    {
        $usuarioId = $this->request->getGet('id');

        if (!$usuarioId) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'ID de usuario requerido.']);
        }

        $usuarioModel = new UsuarioModel();

        // Obtener detalles completos del usuario
        $usuarioDetalles = $usuarioModel
            ->select('
                usuarios.*, 
                roles.nombre_rol,
                CONCAT(creador.nombre, " ", creador.apellido_paterno, " (", creador.usuario, ")") AS creado_por_nombre_completo,
                creador.id_usuario AS id_creador
            ')
            ->join('roles', 'roles.id_rol = usuarios.id_rol', 'left')
            ->join('usuarios AS creador', 'creador.id_usuario = usuarios.creado_por_id', 'left')
            ->where('usuarios.id_usuario', $usuarioId)
            ->first();

        if (!$usuarioDetalles) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Usuario no encontrado.']);
        }

        // Información de auditoría: Usuarios Creados por este Usuario
        $creadosPorEsteUsuario = $usuarioModel
            ->select('id_usuario, nombre, apellido_paterno, usuario')
            ->where('creado_por_id', $usuarioId)
            ->findAll();

        $response = [
            'perfil' => $usuarioDetalles,
            'usuarios_creados' => $creadosPorEsteUsuario,
            'seguridad' => [
                'nota_contrasena' => 'La contraseña se almacena de forma hasheada y no es legible directamente.',
            ]
        ];

        return $this->response->setJSON($response);
    }
    
    /**
     * [FUNCIÓN ESPECIAL]
     * Muestra la vista de auditoría para ver los usuarios creados por un usuario específico.
     */
    public function auditoriaPorCreador(int $creadorId)
    {
        $usuarioModel = new UsuarioModel();
        
        $creador = $usuarioModel->select('nombre, apellido_paterno, usuario')->find($creadorId);

        if (!$creador) {
             return redirect()->back()->with('error', 'Creador no encontrado.');
        }

        $usuariosCreados = $usuarioModel
            ->select('
                usuarios.id_usuario, 
                usuarios.nombre, 
                usuarios.apellido_paterno,
                usuarios.usuario,
                roles.nombre_rol
            ')
            ->join('roles', 'roles.id_rol = usuarios.id_rol', 'left')
            ->where('usuarios.creado_por_id', $creadorId)
            ->orderBy('usuarios.id_usuario', 'DESC')
            ->findAll();

        $data = [
            'creador' => $creador,
            'usuariosCreados' => $usuariosCreados,
            'titulo' => 'Auditoría: Usuarios creados por ' . $creador['nombre']
        ];

        return view('Controlador/auditoria_creados', $data);
    }
    
    /**
     * [FUNCIÓN PRINCIPAL]
     * Muestra la interfaz de supervisión de encuestas con los datos resumidos.
     */
    public function encuestas()
    {
        $encuestaModel = new EncuestaModel();

        $listaEncuestas = $encuestaModel->orderBy('fecha_creacion', 'DESC')->findAll();

        foreach ($listaEncuestas as &$encuesta) {
            $encuesta['descripcion_corta'] = strlen($encuesta['descripcion']) > 100 
                ? substr($encuesta['descripcion'], 0, 100) . '...' 
                : $encuesta['descripcion'];
        }

        $data = [
            'listaEncuestas' => $listaEncuestas,
        ];

        return view('Controlador/Encuestas', $data);
    }

    /**
     * [FUNCIÓN AJAX ESPECIAL]
     * Devuelve los detalles de una encuesta, incluyendo preguntas y opciones, en JSON.
     */
    public function detalleEncuesta()
    {
        $encuestaId = $this->request->getGet('id');

        if (!$encuestaId) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'ID de encuesta requerido.']);
        }

        $encuestaModel = new EncuestaModel();
        $preguntaModel = new PreguntaModel();
        $opcionModel = new OpcionModel();

        $encuesta = $encuestaModel->find($encuestaId);

        if (!$encuesta) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Encuesta no encontrada.']);
        }

        $preguntas = $preguntaModel->where('id_encuesta', $encuestaId)->findAll();
        
        foreach ($preguntas as $key => $pregunta) {
            $preguntas[$key]['opciones'] = $opcionModel->where('id_pregunta', $pregunta['id_pregunta'])->findAll();
        }
        
        $response = [
            'encuesta' => $encuesta,
            'preguntas' => $preguntas
        ];

        return $this->response->setJSON($response);
    }

    // ----------------------------------------------------------------
    // FUNCIONES PARA RESPUESTAS (SUPERVISIÓN ESPACIAL CON PAGINACIÓN)
    // ----------------------------------------------------------------

    /**
     * [FUNCIÓN PRINCIPAL]
     * Muestra la interfaz de supervisión de respuestas con PAGINACIÓN.
     */
    public function respuestas()
    {
        $respuestaModel = new RespuestaModel();
        $usuarioModel = new UsuarioModel();
        $encuestaModel = new EncuestaModel();

        // --- Lógica de Paginación ---
        $perPage = 50; // Definimos el límite de 50 respuestas por página
        
        // Configuramos la consulta base con los JOINs necesarios
        $query = $respuestaModel
            ->select('
                respuestas.id_respuesta,
                respuestas.fecha_respuesta,
                respuestas.direccion,
                respuestas.id_usuario, 
                usuarios.usuario AS nombre_encuestador,
                encuestas.titulo AS nombre_encuesta
            ')
            ->join('usuarios', 'usuarios.id_usuario = respuestas.id_usuario', 'left')
            ->join('encuestas', 'encuestas.id_encuesta = respuestas.id_encuesta', 'left')
            ->orderBy('respuestas.fecha_respuesta', 'DESC');
        
        // Obtenemos las respuestas paginadas
        $listaRespuestas = $query->paginate($perPage);
        $pager = $respuestaModel->pager; // Obtenemos la instancia de Pager

        // Obtenemos la clave de API de Google Maps
        $googleConfig = config(\Config\Google::class);
        $google_maps_api_key = $googleConfig->apiKey;

        $data = [
            'listaRespuestas' => $listaRespuestas,
            'pager' => $pager, // Pasamos el objeto Pager a la vista
            'perPage' => $perPage, // Pasamos el límite para referencia en la vista
            'google_maps_api_key' => $google_maps_api_key, 
            'listaEncuestadores' => $usuarioModel->select('id_usuario, nombre, usuario')->findAll(),
            'listaEncuestas' => $encuestaModel->select('id_encuesta, titulo')->findAll(),
        ];

        return view('Controlador/repuestas', $data);
    }

    /**
     * [FUNCIÓN AJAX]
     * Devuelve los detalles completos de una respuesta, incluyendo pregunta, opción y ubicación.
     */
    public function detalleRespuesta()
    {
        $respuestaId = $this->request->getGet('id');
        
        if (!$respuestaId) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'ID de respuesta requerido.']);
        }
        
        $db = \Config\Database::connect();
        
        // Query para obtener la respuesta detallada con JOINS a todas las tablas necesarias
        $builder = $db->table('respuestas');
        $builder->select('
            respuestas.*, 
            usuarios.nombre AS nombre_usuario, usuarios.apellido_paterno, usuarios.usuario AS alias_usuario,
            encuestas.titulo AS titulo_encuesta,
            preguntas.texto_pregunta,
            opciones.texto_opcion
        ')
        ->join('usuarios', 'usuarios.id_usuario = respuestas.id_usuario', 'left')
        ->join('encuestas', 'encuestas.id_encuesta = respuestas.id_encuesta', 'left')
        ->join('preguntas', 'preguntas.id_pregunta = respuestas.id_pregunta', 'left')
        ->join('opciones', 'opciones.id_opcion = respuestas.id_opcion', 'left')
        ->where('respuestas.id_respuesta', $respuestaId);

        $detalle = $builder->get()->getRowArray();

        if (!$detalle) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Detalle de respuesta no encontrado.']);
        }
        
        // OBTENER COORDENADAS DE MONITOREO DEL USUARIO
        $monitoreoModel = new MonitoreoModel();
        $ubicacionMonitoreo = $monitoreoModel->find($detalle['id_usuario']);
        
        return $this->response->setJSON([
            'detalle' => $detalle,
            'ubicacion_mapa' => [
                'direccion' => $detalle['direccion'] ?? 'Ubicación no registrada',
                'referencias' => $detalle['referencias'] ?? 'N/A',
                // Devolvemos las coordenadas para el mapa
                'latitud' => $ubicacionMonitoreo['latitud'] ?? null,
                'longitud' => $ubicacionMonitoreo['longitud'] ?? null
            ]
        ]);
    }

    // Esta función ya no es necesaria, la lógica se movió a graficas()
    public function respuestas_original()
    {
        // Función vacía
    }

    /**
     * Mostrar perfil del operador
     */
    public function perfil()
    {
        $data = $this->_prepareUserData();
        return view('Controlador/perfil', $data);
    }

/** * Actualizar datos del perfil del operador */ 
public function actualizarPerfil() { 
    $session = session(); 
    $user = $session->get('usuario'); 
    // ✅ Reglas de validación 
    $rules = [ 
        'nombre' => 'required|min_length[3]|max_length[50]', 
        'apellido_paterno' => 'required|min_length[3]|max_length[50]', 
        'apellido_materno' => 'permit_empty|max_length[50]', 
        'telefono' => 'permit_empty|min_length[7]|max_length[15]', 
        'usuario' => 'required|min_length[4]|max_length[30]', 
        'foto' => 'permit_empty|is_image[foto]|max_size[foto,2048]|mime_in[foto,image/jpg,image/jpeg,image/png]', 
    ]; 
    
    if (!$this->validate($rules)) { 
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors()); 
    } 
    
    // ✅ Preparar datos a actualizar 
    $dataUpdate = [ 
        'nombre' => $this->request->getPost('nombre'), 
        'apellido_paterno' => $this->request->getPost('apellido_paterno'), 
        'apellido_materno' => $this->request->getPost('apellido_materno'), 
        'telefono' => $this->request->getPost('telefono'), 
        'usuario' => $this->request->getPost('usuario'), 
    ]; 
    
    // ✅ Procesar la foto si fue subida 
    $fotoFile = $this->request->getFile('foto');
    if ($fotoFile && $fotoFile->isValid() && !$fotoFile->hasMoved()) { 
        $nombreFoto = time() . '_' . $fotoFile->getName(); 
        $fotoFile->move(FCPATH . 'public/img_user', $nombreFoto); 
        $dataUpdate['foto'] = $nombreFoto; 
        
        // Actualizar la sesión con nueva foto 
        $user['foto'] = $nombreFoto; } 
        
        // ✅ Actualizar base de datos 
        $this->usuarioModel->update($user['id_usuario'], $dataUpdate); 
        
        // ✅ Refrescar sesión con los datos nuevos 
        $user = array_merge($user, $dataUpdate); 
        $session->set('usuario', $user); 
        $session->setFlashdata('success', 'Perfil actualizado correctamente'); 
        return redirect()->back(); 
    }
}
