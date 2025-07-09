<?php
namespace App\Controllers;

use App\Models\EncuestaModel;
use App\Models\PreguntaModel;
use App\Models\RespuestaModel;
use App\Models\OpcionModel;
use App\Models\EstadoModel;
use App\Models\MunicipioModel;
use App\Models\UsuarioModel;
use App\Models\SeccionModel; // <-- NUEVO: Importar el SeccionModel

class EstadisticasController extends BaseController
{
    protected $encuestaModel;
    protected $estadoModel;
    protected $preguntaModel;
    protected $municipioModel;
    protected $seccionModel; // <-- NUEVO: Declarar la propiedad para SeccionModel

    public function __construct()
    {
        $this->encuestaModel = new EncuestaModel();
        $this->estadoModel = new EstadoModel();
        $this->preguntaModel = new PreguntaModel();
        $this->municipioModel = new MunicipioModel();
        $this->seccionModel = new SeccionModel(); // <-- NUEVO: Instanciar SeccionModel
    }

    public function index()
    {
        $data = [
            'encuestas' => $this->encuestaModel->findAll(),
            'estados' => $this->estadoModel->findAll()
        ];
        return view('administrador/estadisticas', $data);
    }

    public function getPreguntas($idEncuesta)
    {
        $preguntas = $this->preguntaModel->where('id_encuesta', $idEncuesta)->findAll();
        return $this->response->setJSON($preguntas);
    }

    public function getMunicipios($idEstado)
    {
        $municipios = $this->municipioModel->where('id_estado', $idEstado)->findAll();
        if(empty($municipios)) {
            return $this->response->setJSON([]);
        }
        return $this->response->setJSON($municipios);
    }

    // <-- NUEVO: Método para obtener secciones basado en el id_municipio
    public function getSecciones($idMunicipio)
    {
        $secciones = $this->seccionModel->where('id_municipio', $idMunicipio)->findAll();
        if(empty($secciones)) {
            return $this->response->setJSON([]);
        }
        return $this->response->setJSON($secciones);
    }

    public function obtenerResultadosResumen()
    {
        $id_pregunta = $this->request->getPost('id_pregunta');
        $id_estado = $this->request->getPost('id_estado');
        $id_municipio = $this->request->getPost('id_municipio');
        $id_seccion = $this->request->getPost('id_seccion'); // <-- NUEVO: Obtener id_seccion

        $db = \Config\Database::connect();
        
        $sql = "
            SELECT 
                O.opcion_texto as opcion, 
                COUNT(R.id_respuesta) as votos
            FROM respuestas R
            JOIN opciones O ON R.id_opcion = O.id_opcion
            JOIN usuarios U ON R.id_usuario = U.id_usuario
            WHERE R.id_pregunta = ?
        ";
        $params = [$id_pregunta];

        if ($id_estado) {
            $sql .= " AND U.id_estado = ?";
            $params[] = $id_estado;
        }
        if ($id_municipio) {
            $sql .= " AND U.id_municipio = ?";
            $params[] = $id_municipio;
        }
        if ($id_seccion) { // <-- NUEVO: Añadir filtro por sección
            $sql .= " AND U.id_seccion = ?";
            $params[] = $id_seccion;
        }

        $sql .= "
            GROUP BY O.opcion_texto
            ORDER BY votos DESC
        ";

        $query = $db->query($sql, $params);

        return $this->response->setJSON($query->getResultArray());
    }

    public function obtenerRespuestasDetalle()
    {
        $id_pregunta = $this->request->getPost('id_pregunta');
        $id_estado = $this->request->getPost('id_estado');
        $id_municipio = $this->request->getPost('id_municipio');
        $id_seccion = $this->request->getPost('id_seccion'); // <-- NUEVO: Obtener id_seccion

        $db = \Config\Database::connect();
        
        $sql = "
            SELECT
                O.opcion_texto AS opcion_elegida,
                (SELECT COUNT(r2.id_respuesta)
                 FROM respuestas r2
                 JOIN usuarios u2 ON r2.id_usuario = u2.id_usuario
                 WHERE r2.id_pregunta = R.id_pregunta
                 AND r2.id_opcion = R.id_opcion
        ";
        $params = [];

        // Parámetros para la subconsulta
        if ($id_estado) {
            $sql .= " AND u2.id_estado = ?";
            $params[] = $id_estado;
        }
        if ($id_municipio) {
            $sql .= " AND u2.id_municipio = ?";
            $params[] = $id_municipio;
        }
        if ($id_seccion) { // <-- NUEVO: Añadir filtro por sección en subconsulta
            $sql .= " AND u2.id_seccion = ?";
            $params[] = $id_seccion;
        }

        $sql .= "
                ) AS votos,
                TRIM(
                    CONCAT_WS(', ',
                        NULLIF(R.calle, ''),
                        NULLIF(R.colonia, ''),
                        NULLIF(R.municipio, ''),
                        NULLIF(R.estado, '')
                    )
                ) AS ubicacion_completa,
                R.fecha_ubicacion
            FROM respuestas R
            JOIN opciones O ON R.id_opcion = O.id_opcion
            JOIN usuarios U ON R.id_usuario = U.id_usuario
            WHERE R.id_pregunta = ?
        ";
        // El primer parámetro de la consulta principal (id_pregunta) se agrega al final del array $params
        // después de todos los parámetros de la subconsulta.
        $params[] = $id_pregunta; 

        // Parámetros para la consulta principal
        if ($id_estado) {
            $sql .= " AND U.id_estado = ?";
            $params[] = $id_estado;
        }
        if ($id_municipio) {
            $sql .= " AND U.id_municipio = ?";
            $params[] = $id_municipio;
        }
        if ($id_seccion) { // <-- NUEVO: Añadir filtro por sección en consulta principal
            $sql .= " AND U.id_seccion = ?";
            $params[] = $id_seccion;
        }

        $sql .= "
            ORDER BY O.opcion_texto ASC, R.fecha_ubicacion DESC
        ";

        $query = $db->query($sql, $params);

        return $this->response->setJSON($query->getResultArray());
    }
}