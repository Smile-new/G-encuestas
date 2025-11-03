<?php

namespace App\Controllers;

use CodeIgniter\Controller;
// Models existentes
use App\Models\EncuestaModel;
use App\Models\PreguntaModel;
use App\Models\OpcionModel;
use App\Models\RespuestaModel;
use App\Models\EstadoModel;
use App\Models\DistritoFederalModel;
use App\Models\DistritoLocalModel;
use App\Models\MunicipioModel;
use App\Models\SeccionModel;
use App\Models\ComunidadModel;
// --- NUEVO: Modelo para el monitoreo ---
use App\Models\MonitoreoModel;
use App\Models\UsuarioModel;

class Encuestador extends Controller
{
    protected $encuestaModel;
    protected $preguntaModel;
    protected $opcionModel;
    protected $respuestaModel;
    protected $estadoModel;
    protected $distritoFederalModel;
    protected $distritoLocalModel;
    protected $municipioModel;
    protected $seccionModel;
    protected $comunidadModel;
    // --- NUEVO: Propiedad para el nuevo modelo ---
    protected $monitoreoModel;
    protected $usuarioModel;

    public function __construct()
    {
        // Inicialización de todos los modelos
        $this->encuestaModel = new EncuestaModel();
        $this->preguntaModel = new PreguntaModel();
        $this->opcionModel = new OpcionModel();
        $this->respuestaModel = new RespuestaModel();
        $this->estadoModel = new EstadoModel();
        $this->distritoFederalModel = new DistritoFederalModel();
        $this->distritoLocalModel = new DistritoLocalModel();
        $this->municipioModel = new MunicipioModel();
        $this->seccionModel = new SeccionModel();
        $this->comunidadModel = new ComunidadModel();
        // --- NUEVO: Inicialización del modelo de monitoreo ---
        $this->monitoreoModel = new MonitoreoModel();
        $this->usuarioModel = new UsuarioModel();
    }

    /**
     * Prepara los datos comunes del usuario para las vistas.
     * @return array Datos del usuario (nombre, foto, etc.)
     */
private function _prepareUserData(): array
{
    $session = session();
    $userData = $session->get('usuario');
    $data = [];

    $data['isLoggedIn'] = $session->get('isLoggedIn');
    $data['id_encuestador'] = $userData['id_usuario'] ?? null;
    $data['nombreCompleto'] = "Invitado";
    $data['nombreUsuario'] = "invitado";
    $data['rutaFotoPerfil'] = base_url(RECURSOS_ENCUESTADOR_IMAGES . '/user.png');
    $data['rolTexto'] = "Rol desconocido";

    if ($data['isLoggedIn'] && is_array($userData)) {
        // Obtener usuario actualizado con JOIN al rol
        $usuarioConRol = $this->usuarioModel->getUsuarioConRol($userData['id_usuario']);

        if ($usuarioConRol) {
            $data['userData'] = $usuarioConRol;
            $data['nombreCompleto'] = trim(esc($usuarioConRol['nombre'] ?? '') . ' ' .
                esc($usuarioConRol['apellido_paterno'] ?? '') . ' ' .
                esc($usuarioConRol['apellido_materno'] ?? ''));
            $data['nombreUsuario'] = esc($usuarioConRol['usuario'] ?? '');
            $data['rolTexto'] = esc($usuarioConRol['nombre_rol']);

            if (!empty($usuarioConRol['foto'])) {
                $data['rutaFotoPerfil'] = base_url('public/img_user/' . esc($usuarioConRol['foto']));
            }
        }
    }

    return $data;
}

    public function index()
    {
        $data = $this->_prepareUserData();
        return view('encuestador/home', $data);
    }

public function perfil()
    {
        $data = $this->_prepareUserData();
        return view('encuestador/cam', $data);
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

    public function formularios()
    {
        $data = $this->_prepareUserData();
        $data['encuestas'] = $this->encuestaModel->where('activa', 1)->findAll();
        return view('encuestador/formularios', $data);
    }

    public function verEncuesta($idEncuesta)
    {
        $encuesta = $this->encuestaModel->find($idEncuesta);

        if (!$encuesta || $encuesta['activa'] != 1) {
            return redirect()->to(base_url('formularios'))->with('error', 'La encuesta solicitada no existe o no está activa.');
        }

        $data = $this->_prepareUserData();

        if (!$data['id_encuestador']) {
            return redirect()->to(base_url('login'))->with('error', 'Tu sesión ha expirado. Por favor, inicia sesión de nuevo.');
        }
        
        $data['encuesta'] = $encuesta;
        $data['preguntas'] = $this->preguntaModel->getPreguntasConOpciones($idEncuesta);
        $data['comunidades'] = $this->getComunidadesConJerarquiaCompleta();

        return view('encuestador/ver_encuesta', $data);
    }

    /**
     * VERSIÓN OPTIMIZADA: Obtiene todas las comunidades con su jerarquía completa
     * realizando un número mínimo de consultas a la base de datos para un rendimiento superior.
     * @return array
     */
    private function getComunidadesConJerarquiaCompleta(): array
    {
        // 1. Obtener todos los datos necesarios en pocas consultas
        $comunidades = $this->comunidadModel->findAll();
        $secciones = $this->seccionModel->findAll();
        $municipios = $this->municipioModel->findAll();
        $distritosLocales = $this->distritoLocalModel->findAll();
        $distritosFederales = $this->distritoFederalModel->findAll();
        $estados = $this->estadoModel->findAll();

        // 2. Crear mapas (arrays asociativos) para búsqueda rápida en memoria
        $seccionesMap = array_column($secciones, null, 'id_seccion');
        $municipiosMap = array_column($municipios, null, 'id_municipio');
        $distritosLocalesMap = array_column($distritosLocales, null, 'id_distrito_local');
        $distritosFederalesMap = array_column($distritosFederales, null, 'id_distrito_federal');
        $estadosMap = array_column($estados, null, 'id_estado');

        $comunidadesConJerarquia = [];

        // 3. Construir la jerarquía sin hacer más consultas a la BD
        foreach ($comunidades as $comunidad) {
            $seccion = $seccionesMap[$comunidad['id_seccion']] ?? null;
            if ($seccion) {
                $municipio = $municipiosMap[$seccion['id_municipio']] ?? null;
                if ($municipio) {
                    $distritoLocal = $distritosLocalesMap[$municipio['id_distrito_local']] ?? null;
                    if ($distritoLocal) {
                        $distritoFederal = $distritosFederalesMap[$distritoLocal['id_distrito_federal']] ?? null;
                        if ($distritoFederal) {
                            $estado = $estadosMap[$distritoFederal['id_estado']] ?? null;
                            if ($estado) {
                                // Anidar los datos en la estructura final
                                $distritoFederal['estado'] = $estado;
                                $distritoLocal['distrito_federal'] = $distritoFederal;
                                $municipio['distrito_local'] = $distritoLocal;
                                $seccion['municipio'] = $municipio;
                                $comunidad['seccion'] = $seccion;
                            }
                        }
                    }
                }
            }
            $comunidadesConJerarquia[] = $comunidad;
        }

        return $comunidadesConJerarquia;
    }

    public function guardarRespuestas()
    {
        $session = session();
        if ($this->request->getMethod() !== 'post' || !$session->get('isLoggedIn')) {
            return redirect()->to(base_url('formularios'))->with('error', 'Acceso no autorizado.');
        }

        $idUsuario = $session->get('usuario')['id_usuario'];
        $idEncuesta = $this->request->getPost('id_encuesta');
        $idComunidad = $this->request->getPost('id_comunidad');
        $latitud = $this->request->getPost('latitud');
        $longitud = $this->request->getPost('longitud');
        $referenciasTexto = $this->request->getPost('referencias_texto');
        
        // --- Generar el ID ÚNICO para esta sesión de encuesta ---
        // Esto es CLAVE para contar las encuestas realizadas, no solo las respuestas.
        $idEncuestaRealizada = uniqid('encuesta_' . $idUsuario . '_', true);
        // --------------------------------------------------------

        $direccionTexto = (!empty($latitud) && !empty($longitud))
            ? $this->respuestaModel->obtenerDireccion($latitud, $longitud)
            : null;

        $comunidad = $this->comunidadModel->find($idComunidad);
        if (!$comunidad) {
            return redirect()->back()->with('error', 'La comunidad seleccionada no es válida.');
        }

        $seccion = $this->seccionModel->find($comunidad['id_seccion']);
        $municipio = $this->municipioModel->find($seccion['id_municipio']);
        $distritoLocal = $this->distritoLocalModel->find($municipio['id_distrito_local']);
        $distritoFederal = $this->distritoFederalModel->find($distritoLocal['id_distrito_federal']);
        $estado = $this->estadoModel->find($distritoFederal['id_estado']);
        
        foreach ($this->request->getPost() as $key => $value) {
            if (strpos($key, 'respuesta_') === 0) {
                $idPregunta = str_replace('respuesta_', '', $key);
                $idOpcion = $value;
                $data = [
                    'id_usuario' => $idUsuario,
                    'id_encuesta' => $idEncuesta,
                    'id_pregunta' => $idPregunta,
                    'id_opcion' => $idOpcion,
                    'referencias' => $referenciasTexto, 
                    'id_estado' => $estado['id_estado'],
                    'id_distritofederal' => $distritoFederal['id_distrito_federal'],
                    'id_distritolocal' => $distritoLocal['id_distrito_local'],
                    'id_municipio' => $municipio['id_municipio'],
                    'id_seccion' => $seccion['id_seccion'],
                    'id_comunidad' => $idComunidad,
                    'direccion' => $direccionTexto, 
                    'id_encuesta_realizada' => $idEncuestaRealizada, // <<< AÑADIDO EL ID ÚNICO
                ];
                $this->respuestaModel->insert($data);
            }
        }
        return redirect()->to(base_url('formularios'))->with('success', 'Respuestas guardadas exitosamente.');
    }

    /**
     * --- NUEVO MÉTODO PARA MONITOREO EN TIEMPO REAL ---
     * Recibe coordenadas por AJAX y las guarda/actualiza en la base de datos.
     */
    public function guardarUbicacionMonitoreo()
    {
        // 1. Verificación de seguridad
        if (!$this->request->isAJAX() || !session()->get('isLoggedIn')) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false, 
                'message' => 'Acceso no autorizado.'
            ]);
        }

        // 2. Lectura y validación de los datos JSON enviados
        $json = $this->request->getJSON();
        if (empty($json->latitud) || empty($json->longitud)) {
            return $this->response->setStatusCode(400)->setJSON([
                'success' => false, 
                'message' => 'Datos de ubicación incompletos.'
            ]);
        }

        // 3. Obtener el ID del usuario de la sesión actual
        $idUsuario = session()->get('usuario')['id_usuario'];

        $data = [
            'id_usuario' => $idUsuario,
            'latitud'    => $json->latitud, // <<<< Limpiado
            'longitud'   => $json->longitud, // <<<< Limpiado
        ];

        // 4. Usar el método save() que inserta o actualiza automáticamente
        if ($this->monitoreoModel->save($data)) {
            return $this->response->setJSON(['success' => true]);
        } else {
            // En caso de un error de base de datos, lo reportamos
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false, 
                'message' => 'Error interno al guardar la ubicación.'
            ]);
        }
    }

    /**
     * Destruye la sesión del usuario y lo redirige al login.
     */
    public function logout()
    {
        // Carga el servicio de sesión
        $session = session();

        // Elimina todos los datos de la sesión (isLoggedIn, usuario, etc.)
        $session->destroy();

        // Redirige al usuario a la página de inicio (o de login) con un mensaje
        return redirect()->to(base_url('/login'))->with('message', 'Has cerrado sesión correctamente.');
    }
}
