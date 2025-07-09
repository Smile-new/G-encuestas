<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PreguntaModel;
use App\Models\OpcionModel;
use App\Models\EncuestaModel;

class Preguntas extends BaseController
{
    protected $preguntaModel;
    protected $opcionModel;
    protected $encuestaModel;

    public function __construct()
    {
        $this->preguntaModel = new PreguntaModel();
        $this->opcionModel   = new OpcionModel();
        $this->encuestaModel = new EncuestaModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        // Ahora, el método index() debe obtener TODAS las encuestas
        $encuestas = $this->encuestaModel->findAll(); // O puedes filtrar por 'activa' => 1 si solo quieres activas

        $data = [
            'title'   => 'Gestión de Preguntas por Encuesta',
            'encuestas' => $encuestas, // Pasa la lista de encuestas a la vista
            'session' => session(),
        ];

        // Carga la vista que ahora es interactiva
        return view('admin/preguntas', $data);
    }

    /**
     * Nuevo método AJAX: Obtiene preguntas y sus opciones para una encuesta específica.
     * Retorna JSON.
     * @param int $idEncuesta El ID de la encuesta.
     * @return \CodeIgniter\HTTP\Response
     */
    public function getPreguntasConOpcionesPorEncuesta($idEncuesta = null)
    {
        // Validar el ID
        if (!$idEncuesta || !is_numeric($idEncuesta)) {
            return $this->response->setJSON(['error' => 'ID de encuesta no válido.'])->setStatusCode(400);
        }

        // Obtener preguntas por ID de encuesta
        $preguntas = $this->preguntaModel->where('id_encuesta', $idEncuesta)->findAll();

        // Para cada pregunta, obtener sus opciones
        foreach ($preguntas as &$pregunta) {
            $pregunta['opciones'] = $this->opcionModel->where('id_pregunta', $pregunta['id_pregunta'])->findAll();
        }

        // Devolver los datos como JSON
        return $this->response->setJSON($preguntas);
    }

    // Mantén tu método 'mostrar' si lo utilizas en otras partes para mostrar una página completa
    // Por ejemplo, si tienes un enlace directo a /preguntas/mostrar/ID_ENCUESTA en otro lugar.
    // public function mostrar($idEncuesta = null) { ... }
}