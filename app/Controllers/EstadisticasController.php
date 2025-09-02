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
     * Pasa solo la lista de municipios inicial para que el frontend
     * pueda cargarlos en el primer selector.
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
        $municipios = $this->municipioModel->findAll();

        $data = [
            'isLoggedIn'     => $session->get('isLoggedIn'),
            'userData'       => $userData,
            'nombreCompleto' => $nombreCompleto,
            'nombreUsuario'  => $nombreUsuario,
            'rolTexto'       => $rolTexto,
            'rutaFotoPerfil' => $rutaFotoPerfil,
            'encuestas'      => $encuestas,
            'municipios'     => $municipios,
        ];

        return view('admin/estadisticas', $data);
    }

    /**
     * Método AJAX para obtener la jerarquía completa de un municipio.
     * Esto incluye el Distrito Local, Distrito Federal y Estado.
     * @param int $idMunicipio El ID del municipio.
     */
    public function getGeodataByMunicipio($idMunicipio)
    {
        if (!is_numeric($idMunicipio)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'ID de municipio inválido.']);
        }

        try {
            $municipio = $this->municipioModel->find($idMunicipio);
            if (!$municipio) {
                return $this->response->setStatusCode(404)->setJSON(['error' => 'Municipio no encontrado.']);
            }

            $distritoLocal = $this->distritoLocalModel->find($municipio['id_distrito_local']);
            if (!$distritoLocal) {
                return $this->response->setStatusCode(404)->setJSON(['error' => 'Distrito Local no encontrado.']);
            }

            $distritoFederal = $this->distritoFederalModel->find($distritoLocal['id_distrito_federal']);
            if (!$distritoFederal) {
                return $this->response->setStatusCode(404)->setJSON(['error' => 'Distrito Federal no encontrado.']);
            }

            $estado = $this->estadoModel->find($distritoFederal['id_estado']);
            if (!$estado) {
                return $this->response->setStatusCode(404)->setJSON(['error' => 'Estado no encontrado.']);
            }

            $data = [
                'municipio' => $municipio,
                'distrito_local' => $distritoLocal,
                'distrito_federal' => $distritoFederal,
                'estado' => $estado,
            ];

            return $this->response->setJSON($data);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'error' => 'Error interno del servidor al obtener los datos geográficos.',
                'message' => $e->getMessage()
            ]);
        }
    }


    /**
     * Método AJAX para obtener las preguntas de una encuesta específica.
     * @param int $idEncuesta El ID de la encuesta.
     */
    public function getPreguntas($idEncuesta)
    {
        if (!is_numeric($idEncuesta)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'ID de encuesta inválido.']);
        }
        $preguntas = $this->preguntaModel->where('id_encuesta', $idEncuesta)->findAll();
        return $this->response->setJSON($preguntas);
    }

    /**
     * Método AJAX para obtener las opciones de una pregunta específica.
     * @param int $idPregunta El ID de la pregunta.
     */
    public function getOpcionesPregunta($idPregunta)
    {
        if (!is_numeric($idPregunta)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'ID de pregunta inválido.']);
        }
        $opciones = $this->opcionModel->where('id_pregunta', $idPregunta)->findAll();
        return $this->response->setJSON($opciones);
    }

    /**
     * Método AJAX para obtener las secciones de un municipio.
     * Esta función es llamada desde el frontend cuando se selecciona un municipio.
     * @param int $idMunicipio El ID del municipio.
     */
    public function getSecciones($idMunicipio)
    {
        if (!is_numeric($idMunicipio)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'ID de municipio inválido.']);
        }
        $secciones = $this->seccionModel->where('id_municipio', $idMunicipio)->findAll() ?? [];
        return $this->response->setJSON($secciones);
    }

    /**
     * Método AJAX para obtener las comunidades de una sección.
     * Esta función es llamada desde el frontend cuando se selecciona una sección.
     * @param int $idSeccion El ID de la sección.
     */
    public function getComunidades($idSeccion)
    {
        if (!is_numeric($idSeccion)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'ID de sección inválido.']);
        }
        $comunidades = $this->comunidadModel->where('id_seccion', $idSeccion)->findAll() ?? [];
        return $this->response->setJSON($comunidades);
    }

    /**
     * Método AJAX para obtener los datos de las respuestas de una pregunta.
     * La consulta se adapta dinámicamente según los filtros geográficos
     * seleccionados por el usuario.
     */
    public function getRespuestas()
    {
        try {
            $idEncuesta = $this->request->getGet('id_encuesta');
            $idPregunta = $this->request->getGet('id_pregunta');
            $idMunicipio = $this->request->getGet('id_municipio');
            $idSeccion = $this->request->getGet('id_seccion');
            $idComunidad = $this->request->getGet('id_comunidad');

            // Validación de parámetros obligatorios
            if (empty($idEncuesta) || empty($idPregunta)) {
                return $this->response->setStatusCode(400)->setJSON([
                    'error' => 'Parámetros obligatorios (id_encuesta o id_pregunta) faltantes.',
                ]);
            }
            
            // Inicialización de la consulta con los filtros de encuesta y pregunta.
            $query = $this->respuestaModel
                ->select('id_opcion, COUNT(id_respuesta) as total')
                ->where('id_encuesta', $idEncuesta)
                ->where('id_pregunta', $idPregunta);
            
            // FILTROS GEOGRÁFICOS CONDICIONALES
            // Se aplican solo si el ID correspondiente está presente.
            if (!empty($idMunicipio) && is_numeric($idMunicipio)) {
                $query->where('id_municipio', $idMunicipio);
            }
            if (!empty($idSeccion) && is_numeric($idSeccion)) {
                $query->where('id_seccion', $idSeccion);
            }
            if (!empty($idComunidad) && is_numeric($idComunidad)) {
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
