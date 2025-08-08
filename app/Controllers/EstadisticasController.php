<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\RespuestaModel;
use App\Models\EncuestaModel;
use App\Models\PreguntaModel;
use App\Models\OpcionModel;
use App\Models\EstadoModel;
use App\Models\DistritoFederalModel;
use App\Models\DistritoLocalModel;
use App\Models\MunicipioModel;
use App\Models\SeccionModel;
use App\Models\ComunidadModel;

class EstadisticasController extends Controller
{
    protected $respuestaModel;
    protected $encuestaModel;
    protected $preguntaModel;
    protected $opcionModel;
    protected $estadoModel;
    protected $distritoFederalModel;
    protected $distritoLocalModel;
    protected $municipioModel;
    protected $seccionModel;
    protected $comunidadModel;

    public function __construct()
    {
        $this->respuestaModel = new RespuestaModel();
        $this->encuestaModel = new EncuestaModel();
        $this->preguntaModel = new PreguntaModel();
        $this->opcionModel = new OpcionModel();
        $this->estadoModel = new EstadoModel();
        $this->distritoFederalModel = new DistritoFederalModel();
        $this->distritoLocalModel = new DistritoLocalModel();
        $this->municipioModel = new MunicipioModel();
        $this->seccionModel = new SeccionModel();
        $this->comunidadModel = new ComunidadModel();
    }

    /**
     * Muestra la interfaz de estadísticas para el usuario.
     */
    public function index()
    {
        $session = session();
        
        if (!$session->get('isLoggedIn')) {
            return redirect()->to(base_url('login'))->with('error', 'Tu sesión ha expirado. Por favor, inicia sesión de nuevo.');
        }

        $userData = $session->get('usuario');
        
        $nombreCompleto = esc($userData['nombre'] ?? '') . ' ' . esc($userData['apellido_paterno'] ?? '');
        $nombreUsuario = esc($userData['usuario'] ?? '');
        $rutaFotoPerfil = base_url('public/img_user/' . esc($userData['foto'] ?? 'user.png'));
        $rolTexto = '';
        
        if (isset($userData['id_rol'])) {
            switch ($userData['id_rol']) {
                case 1: $rolTexto = 'Administrador'; break;
                case 2: $rolTexto = 'Operador'; break;
                case 3: $rolTexto = 'Encuestador'; break;
                default: $rolTexto = 'Miembro'; break;
            }
        }
        
        $encuestas = $this->encuestaModel->where('activa', 1)->findAll();
        $estados = $this->estadoModel->findAll();

        $data = [
            'isLoggedIn' => $session->get('isLoggedIn'),
            'userData'   => $userData,
            'nombreCompleto' => $nombreCompleto,
            'nombreUsuario' => $nombreUsuario,
            'rolTexto' => $rolTexto,
            'rutaFotoPerfil' => $rutaFotoPerfil,
            'encuestas' => $encuestas,
            'estados' => $estados,
        ];

        return view('admin/estadisticas', $data);
    }

    /**
     * Método AJAX para obtener las preguntas de una encuesta específica.
     * @param int $idEncuesta El ID de la encuesta.
     */
    public function getPreguntas($idEncuesta)
    {
        $preguntas = $this->preguntaModel->where('id_encuesta', $idEncuesta)->findAll();
        return $this->response->setJSON($preguntas);
    }

    /**
     * Método AJAX para obtener las opciones de una pregunta específica.
     * @param int $idPregunta El ID de la pregunta.
     */
    public function getOpcionesPregunta($idPregunta)
    {
        $opciones = $this->opcionModel->where('id_pregunta', $idPregunta)->findAll();
        return $this->response->setJSON($opciones);
    }
    
    /**
     * Método AJAX para obtener los distritos federales de un estado.
     * @param int $idEstado El ID del estado.
     */
    public function getDistritosFederales($idEstado)
    {
        $distritosFederales = $this->distritoFederalModel->where('id_estado', $idEstado)->findAll() ?? [];
        return $this->response->setJSON($distritosFederales);
    }

    /**
     * Método AJAX para obtener los distritos locales de un distrito federal.
     * @param int $idDistritoFederal El ID del distrito federal.
     */
    public function getDistritosLocales($idDistritoFederal)
    {
        $distritosLocales = $this->distritoLocalModel->where('id_distrito_federal', $idDistritoFederal)->findAll() ?? [];
        return $this->response->setJSON($distritosLocales);
    }

    /**
     * Método AJAX para obtener los municipios de un distrito local.
     * @param int $idDistritoLocal El ID del distrito local.
     */
    public function getMunicipios($idDistritoLocal)
    {
        $municipios = $this->municipioModel->where('id_distrito_local', $idDistritoLocal)->findAll() ?? [];
        return $this->response->setJSON($municipios);
    }

    /**
     * Método AJAX para obtener las secciones de un municipio.
     * @param int $idMunicipio El ID del municipio.
     */
    public function getSecciones($idMunicipio)
    {
        $secciones = $this->seccionModel->where('id_municipio', $idMunicipio)->findAll() ?? [];
        return $this->response->setJSON($secciones);
    }

    /**
     * Método AJAX para obtener las comunidades de una sección.
     * @param int $idSeccion El ID de la sección.
     */
    public function getComunidades($idSeccion)
    {
        $comunidades = $this->comunidadModel->where('id_seccion', $idSeccion)->findAll() ?? [];
        return $this->response->setJSON($comunidades);
    }

    /**
     * Método AJAX para obtener los datos de las respuestas de una pregunta.
     */
    public function getRespuestas()
    {
        try {
            $idEncuesta = $this->request->getGet('id_encuesta');
            $idPregunta = $this->request->getGet('id_pregunta');

            if (empty($idEncuesta) || empty($idPregunta)) {
                return $this->response->setStatusCode(400)->setJSON([
                    'error' => 'Parámetros obligatorios (id_encuesta o id_pregunta) faltantes.',
                    'debug' => [
                        'id_encuesta' => $idEncuesta,
                        'id_pregunta' => $idPregunta
                    ]
                ]);
            }
            
            // Inicialización de la consulta con los filtros de encuesta y pregunta.
            $query = $this->respuestaModel
                ->select('id_opcion, COUNT(id_respuesta) as total')
                ->where('id_encuesta', $idEncuesta)
                ->where('id_pregunta', $idPregunta);
            
            // FILTROS GEOGRÁFICOS CORREGIDOS SEGÚN EL MODELO DE DATOS
            $idEstado = $this->request->getGet('id_estado');
            if (!empty($idEstado)) {
                $query->where('id_estado', $idEstado);
            }
            
            // El nombre de la columna en la tabla de respuestas es 'id_distritofederal'
            $idDistritoFederal = $this->request->getGet('id_distrito_federal');
            if (!empty($idDistritoFederal)) {
                $query->where('id_distritofederal', $idDistritoFederal);
            }
            
            // El nombre de la columna en la tabla de respuestas es 'id_distritolocal'
            $idDistritoLocal = $this->request->getGet('id_distrito_local');
            if (!empty($idDistritoLocal)) {
                $query->where('id_distritolocal', $idDistritoLocal);
            }
            
            // El nombre de la columna en la tabla de respuestas es 'id_municipio'
            $idMunicipio = $this->request->getGet('id_municipio');
            if (!empty($idMunicipio)) {
                $query->where('id_municipio', $idMunicipio);
            }
            
            // El nombre de la columna en la tabla de respuestas es 'id_seccion'
            $idSeccion = $this->request->getGet('id_seccion');
            if (!empty($idSeccion)) {
                $query->where('id_seccion', $idSeccion);
            }
            
            // El nombre de la columna en la tabla de respuestas es 'id_comunidad'
            $idComunidad = $this->request->getGet('id_comunidad');
            if (!empty($idComunidad)) {
                $query->where('id_comunidad', $idComunidad);
            }

            $resultados = $query->groupBy('id_opcion')
                ->findAll() ?? [];

            return $this->response->setJSON($resultados);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'error' => 'Error interno del servidor al obtener las respuestas.',
                'message' => $e->getMessage()
            ]);
        }
    }
}