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
    }

    // Método que coincide con la ruta 'home'
    public function index()
    {
        $session = session();
        $data = [
            'isLoggedIn' => $session->get('isLoggedIn'),
            'userData'   => $session->get('usuario'),
        ];
        return view('encuestador/home', $data);
    }

    // Método que coincide con la ruta 'cam'
    public function cam()
    {
        $session = session();
        $data = [
            'isLoggedIn' => $session->get('isLoggedIn'),
            'userData'   => $session->get('usuario')
        ];
        return view('encuestador/cam', $data);
    }

    // Método que coincide con la ruta 'formularios'
    public function formularios()
    {
        $session = session();
        $encuestasActivas = $this->encuestaModel->where('activa', 1)->findAll();

        $userData = $session->get('usuario');
        $nombreCompleto = "Invitado";
        $nombreUsuario = "invitado";
        $rutaFotoPerfil = base_url(RECURSOS_ENCUESTADOR_IMAGES . '/user.png');

        if ($session->get('isLoggedIn') && is_array($userData)) {
            $nombreCompleto = esc($userData['nombre'] ?? '') . ' ' .
                             esc($userData['apellido_paterno'] ?? '') . ' ' .
                             esc($userData['apellido_materno'] ?? '');
            $nombreUsuario = esc($userData['usuario'] ?? '');
            if (!empty($userData['foto'])) {
                $rutaFotoPerfil = base_url('public/img_user/' . esc($userData['foto']));
            }
        }

        $data = [
            'isLoggedIn' => $session->get('isLoggedIn'),
            'userData'   => $userData,
            'nombreCompleto' => $nombreCompleto,
            'nombreUsuario' => $nombreUsuario,
            'rutaFotoPerfil' => $rutaFotoPerfil,
            'encuestas'  => $encuestasActivas,
        ];
        return view('encuestador/formularios', $data);
    }

    /**
     * Muestra una encuesta específica con sus preguntas y opciones,
     * e incluye un array plano de comunidades con toda su jerarquía de padres.
     * @param int $idEncuesta El ID de la encuesta a mostrar.
     */
    // Método que coincide con la ruta 'encuestas/ver/(:num)'
    public function verEncuesta($idEncuesta)
    {
        $session = session();
        $encuesta = $this->encuestaModel->find($idEncuesta);

        if (!$encuesta || $encuesta['activa'] != 1) {
            return redirect()->to(base_url('formularios'))->with('error', 'La encuesta solicitada no existe o no está activa.');
        }

        $preguntas = $this->preguntaModel->getPreguntasConOpciones($idEncuesta);
        $comunidadesConJerarquia = $this->getComunidadesConJerarquiaCompleta();

        $userData = $session->get('usuario');
        $id_encuestador = $userData['id_usuario'] ?? null;
        
        if (!$id_encuestador) {
            return redirect()->to(base_url('login'))->with('error', 'Tu sesión ha expirado. Por favor, inicia sesión de nuevo.');
        }
        
        $nombreCompleto = "Invitado";
        $nombreUsuario = "invitado";
        $rutaFotoPerfil = base_url(RECURSOS_ENCUESTADOR_IMAGES . '/user.png');

        if ($session->get('isLoggedIn') && is_array($userData)) {
            $nombreCompleto = esc($userData['nombre'] ?? '') . ' ' .
                             esc($userData['apellido_paterno'] ?? '') . ' ' .
                             esc($userData['apellido_materno'] ?? '');
            $nombreUsuario = esc($userData['usuario'] ?? '');
            if (!empty($userData['foto'])) {
                $rutaFotoPerfil = base_url('public/img_user/' . esc($userData['foto']));
            }
        }

        $data = [
            'isLoggedIn' => $session->get('isLoggedIn'),
            'userData'   => $userData,
            'nombreCompleto' => $nombreCompleto,
            'nombreUsuario' => $nombreUsuario,
            'rutaFotoPerfil' => $rutaFotoPerfil,
            'encuesta'   => $encuesta,
            'preguntas'  => $preguntas,
            'comunidades' => $comunidadesConJerarquia,
            'id_encuestador' => $id_encuestador,
        ];

        return view('encuestador/ver_encuesta', $data);
    }

    /**
     * Método auxiliar para obtener todas las comunidades con su jerarquía de padres completa.
     * La lógica está adaptada para el flujo de abajo hacia arriba.
     * @return array
     */
    private function getComunidadesConJerarquiaCompleta()
    {
        $comunidades = $this->comunidadModel->findAll();
        $comunidadesConJerarquia = [];

        foreach ($comunidades as $comunidad) {
            $seccion = $this->seccionModel->find($comunidad['id_seccion']);
            if ($seccion) {
                $comunidad['seccion'] = $seccion;
                $municipio = $this->municipioModel->find($seccion['id_municipio']);
                if ($municipio) {
                    $comunidad['seccion']['municipio'] = $municipio;
                    $distritoLocal = $this->distritoLocalModel->find($municipio['id_distrito_local']);
                    if ($distritoLocal) {
                        $comunidad['seccion']['municipio']['distrito_local'] = $distritoLocal;
                        $distritoFederal = $this->distritoFederalModel->find($distritoLocal['id_distrito_federal']);
                        if ($distritoFederal) {
                            $comunidad['seccion']['municipio']['distrito_local']['distrito_federal'] = $distritoFederal;
                            $estado = $this->estadoModel->find($distritoFederal['id_estado']);
                            if ($estado) {
                                $comunidad['seccion']['municipio']['distrito_local']['distrito_federal']['estado'] = $estado;
                            }
                        }
                    }
                }
            }
            $comunidadesConJerarquia[] = $comunidad;
        }

        return $comunidadesConJerarquia;
    }

    /**
     * Procesa la inserción de las respuestas de la encuesta.
     * El formulario debe enviar los datos de las preguntas, la encuesta, el usuario y la ubicación.
     */
    // Método que coincide con la ruta 'encuestas/guardar'
    public function guardarRespuestas()
    {
        $session = session();

        if ($this->request->getMethod() !== 'post' || !$session->get('isLoggedIn')) {
            return redirect()->to(base_url('formularios'))->with('error', 'Acceso no autorizado.');
        }

        $idUsuario = $session->get('usuario')['id_usuario'];
        $idEncuesta = $this->request->getPost('id_encuesta');
        $idComunidad = $this->request->getPost('id_comunidad');

        // ** AÑADIDO: Lógica para obtener la jerarquía geográfica completa desde el ID de la comunidad **
        // Se obtiene el objeto comunidad completo desde el modelo
        $comunidad = $this->comunidadModel->find($idComunidad);
        if (!$comunidad) {
            return redirect()->to(base_url('encuestas/ver/' . $idEncuesta))->with('error', 'Error: La comunidad seleccionada no es válida.');
        }

        // Se obtienen los IDs de los padres a partir del ID de la comunidad
        $seccion = $this->seccionModel->find($comunidad['id_seccion']);
        $municipio = $this->municipioModel->find($seccion['id_municipio']);
        $distritoLocal = $this->distritoLocalModel->find($municipio['id_distrito_local']);
        $distritoFederal = $this->distritoFederalModel->find($distritoLocal['id_distrito_federal']);
        $estado = $this->estadoModel->find($distritoFederal['id_estado']);

        // Se asignan los IDs a las variables
        $idEstado = $estado['id_estado'];
        $idDistritoFederal = $distritoFederal['id_distrito_federal'];
        $idDistritoLocal = $distritoLocal['id_distrito_local'];
        $idMunicipio = $municipio['id_municipio'];
        $idSeccion = $seccion['id_seccion'];
        // El id_comunidad ya lo tenemos del formulario
        
        foreach ($this->request->getPost() as $key => $value) {
            // Procesar solo los campos que corresponden a preguntas
            if (strpos($key, 'respuesta_') === 0) {
                $idPregunta = str_replace('respuesta_', '', $key);

                // El valor del campo 'respuesta_[id_pregunta]' es el 'id_opcion' seleccionado.
                $idOpcion = $value;

                $data = [
                    'id_usuario' => $idUsuario,
                    'id_encuesta' => $idEncuesta,
                    'id_pregunta' => $idPregunta,
                    'id_opcion' => $idOpcion,
                    'respuesta_texto' => null, // No hay texto libre en tu formulario actual
                    'id_estado' => $idEstado,
                    'id_distritofederal' => $idDistritoFederal,
                    'id_distritolocal' => $idDistritoLocal,
                    'id_municipio' => $idMunicipio,
                    'id_seccion' => $idSeccion,
                    'id_comunidad' => $idComunidad,
                ];
                
                $this->respuestaModel->insert($data);
            }
        }

        return redirect()->to(base_url('formularios'))->with('success', 'Respuestas guardadas exitosamente.');
    }
}
