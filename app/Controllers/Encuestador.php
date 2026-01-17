<?php

namespace App\Controllers;

use CodeIgniter\Controller;
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
    protected $monitoreoModel;
    protected $usuarioModel;

    public function __construct()
    {
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
        $this->monitoreoModel = new MonitoreoModel();
        $this->usuarioModel = new UsuarioModel();
    }

    private function _prepareUserData(): array
    {
        $session = session();
        $userData = $session->get('usuario');
        $data = [];

        $data['isLoggedIn'] = $session->get('isLoggedIn');
        $data['id_encuestador'] = $userData['id_usuario'] ?? null;
        $data['nombreCompleto'] = "Invitado";
        $data['nombreUsuario'] = "invitado";
        $data['rutaFotoPerfil'] = base_url('recursos_admin/images/faces/face15.jpg');
        $data['rolTexto'] = "Rol desconocido";

        if ($data['isLoggedIn'] && is_array($userData)) {
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

    /* --- VISTAS --- */

    public function index()
    {
        $data = $this->_prepareUserData();
        return view('encuestador/home', $data);
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
            return redirect()->to(base_url('formularios'))->with('error', 'Encuesta no disponible.');
        }

        $data = $this->_prepareUserData();
        $data['encuesta'] = $encuesta;
        $data['preguntas'] = $this->preguntaModel->getPreguntasConOpciones($idEncuesta);
        $data['comunidades'] = $this->getComunidadesConJerarquiaCompleta();

        return view('encuestador/ver_encuesta', $data);
    }

    /* --- LÓGICA DE GUARDADO --- */

    public function guardarRespuestas()
    {
        $session = session();
        if ($this->request->getMethod() !== 'post' || !$session->get('isLoggedIn')) {
            return redirect()->to(base_url('formularios'))->with('error', 'Acceso denegado.');
        }

        $idUsuario = $session->get('usuario')['id_usuario'];
        $idEncuesta = $this->request->getPost('id_encuesta');
        $idComunidad = $this->request->getPost('id_comunidad');
        $latitud = $this->request->getPost('latitud');
        $longitud = $this->request->getPost('longitud');
        $referenciasTexto = $this->request->getPost('referencias_texto');

        // 1. GENERAR UN SOLO REGISTRO DE UBICACIÓN PARA ESTA CAPTURA
        $monitoreoData = [
            'id_usuario' => $idUsuario,
            'latitud'    => $latitud,
            'longitud'   => $longitud
        ];
        
        // Insertamos y recuperamos el ID único de esta ubicación
        $this->monitoreoModel->insert($monitoreoData);
        $idMonitoreoUnico = $this->monitoreoModel->getInsertID(); 

        // 2. OBTENER DIRECCIÓN Y JERARQUÍA GEOGRÁFICA
        $idEncuestaRealizada = uniqid('encuesta_' . $idUsuario . '_', true);
        
        $direccionTexto = (!empty($latitud) && !empty($longitud))
            ? $this->respuestaModel->obtenerDireccion($latitud, $longitud)
            : null;

        $comunidad = $this->comunidadModel->find($idComunidad);
        $seccion = $this->seccionModel->find($comunidad['id_seccion']);
        $municipio = $this->municipioModel->find($seccion['id_municipio']);
        $distritoLocal = $this->distritoLocalModel->find($municipio['id_distrito_local']);
        $distritoFederal = $this->distritoFederalModel->find($distritoLocal['id_distrito_federal']);
        $estado = $this->estadoModel->find($distritoFederal['id_estado']);

        // 3. GUARDAR TODAS LAS RESPUESTAS VINCULADAS AL MISMO id_monitoreo
        foreach ($this->request->getPost() as $key => $value) {
            if (strpos($key, 'respuesta_') === 0) {
                $idPregunta = str_replace('respuesta_', '', $key);
                
                $data = [
                    'id_usuario'            => $idUsuario,
                    'id_encuesta'           => $idEncuesta,
                    'id_pregunta'           => $idPregunta,
                    'id_opcion'             => $value,
                    'referencias'           => $referenciasTexto, 
                    'id_monitoreo'          => $idMonitoreoUnico, // Mismo ID para todas
                    'id_encuesta_realizada' => $idEncuestaRealizada,
                    'id_comunidad'          => $idComunidad,
                    'id_seccion'            => $seccion['id_seccion'],
                    'id_municipio'          => $municipio['id_municipio'],
                    'id_distritolocal'      => $distritoLocal['id_distrito_local'],
                    'id_distritofederal'    => $distritoFederal['id_distrito_federal'],
                    'id_estado'             => $estado['id_estado'],
                    'direccion'             => $direccionTexto
                ];
                
                $this->respuestaModel->insert($data);
            }
        }

        return redirect()->to(base_url('formularios'))->with('success', 'Encuesta enviada con éxito.');
    }

    public function guardarUbicacionMonitoreo()
    {
        if (!$this->request->isAJAX() || !session()->get('isLoggedIn')) {
            return $this->response->setStatusCode(403)->setJSON(['success' => false]);
        }

        $json = $this->request->getJSON();
        $idUsuario = session()->get('usuario')['id_usuario'];

        $data = [
            'id_usuario' => $idUsuario,
            'latitud'    => $json->latitud,
            'longitud'   => $json->longitud,
        ];

        // Se guarda como nuevo registro en el historial
        if ($this->monitoreoModel->save($data)) {
            return $this->response->setJSON(['success' => true]);
        }
        return $this->response->setStatusCode(500)->setJSON(['success' => false]);
    }

    /* --- AUXILIARES --- */

    private function getComunidadesConJerarquiaCompleta(): array
    {
        $comunidades = $this->comunidadModel->findAll();
        $secciones = $this->seccionModel->findAll();
        $municipios = $this->municipioModel->findAll();
        $distritosLocales = $this->distritoLocalModel->findAll();
        $distritosFederales = $this->distritoFederalModel->findAll();
        $estados = $this->estadoModel->findAll();

        $seccionesMap = array_column($secciones, null, 'id_seccion');
        $municipiosMap = array_column($municipios, null, 'id_municipio');
        $distritosLocalesMap = array_column($distritosLocales, null, 'id_distrito_local');
        $distritosFederalesMap = array_column($distritosFederales, null, 'id_distrito_federal');
        $estadosMap = array_column($estados, null, 'id_estado');

        $comunidadesConJerarquia = [];
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

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('/login'))->with('message', 'Sesión cerrada.');
    }
    // app\Controllers\Encuestador.php

    /**
 * Muestra la vista del perfil del encuestador
 * Ruta: GET /perfil
 */
public function perfil()
{
    $session = session();
    $userData = $session->get('usuario'); // Recuperamos el array de usuario de la sesión
    
    if (!$userData) {
        return redirect()->to(base_url('login'));
    }

    $idUsuario = $userData['id_usuario'];
    
    // Preparamos los datos base (nombre, fotos, roles) para el layout
    $data = $this->_prepareUserData(); 
    
    // Obtenemos la información más fresca del modelo
    $data['usuario'] = $this->usuarioModel->find($idUsuario);

    return view('encuestador/perfil', $data);
}

/**
 * Procesa la actualización de datos personales y fotografía
 * Ruta: POST /perfil/actualizar
 */
public function actualizarPerfil()
{
    $session = session();
    $userData = $session->get('usuario');
    $idUsuario = $userData['id_usuario'];

    $usuarioActual = $this->usuarioModel->find($idUsuario);
    
    // 1. Definir la ruta de almacenamiento físico
    $pathRuta = 'public/img_user/'; 
    $dbFotoName = $usuarioActual['foto']; 

    // 2. Manejo de la subida de imagen (Input name="foto")
    $file = $this->request->getFile('foto');

    if ($file && $file->isValid() && !$file->hasMoved()) {
        
        // Borrar la foto anterior del servidor si existe para ahorrar espacio
        if (!empty($usuarioActual['foto'])) {
            $oldPath = FCPATH . $pathRuta . $usuarioActual['foto'];
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }

        // Generar un nombre aleatorio para evitar problemas de caché en el navegador
        $dbFotoName = $file->getRandomName();
        $file->move(FCPATH . $pathRuta, $dbFotoName);
    }

    // 3. Recopilación de datos del formulario
    $datosActualizados = [
        'nombre'           => $this->request->getPost('nombre'),
        'apellido_paterno' => $this->request->getPost('apellido_paterno'),
        'apellido_materno' => $this->request->getPost('apellido_materno'),
        'telefono'         => $this->request->getPost('telefono'),
        'foto'             => $dbFotoName 
    ];

    // 4. Actualización en Base de Datos y Sesión
    if ($this->usuarioModel->update($idUsuario, $datosActualizados)) {
        
        // Actualizamos el array de la sesión para que los cambios se vean sin re-loguear
        $nuevoUserData = array_merge($userData, $datosActualizados);
        $session->set('usuario', $nuevoUserData);

        return redirect()->to(base_url('perfil'))->with('success', 'Perfil actualizado correctamente.');
    } else {
        return redirect()->back()->with('error', 'No se pudieron guardar los cambios.');
    }
}

}