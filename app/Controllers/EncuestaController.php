<?php

namespace App\Controllers; // Namespace ahora es directamente App\Controllers

use App\Controllers\BaseController; // Asume que BaseController está en App\Controllers
use App\Models\EncuestaModel;
use App\Models\PreguntaModel;
use App\Models\OpcionModel;
use CodeIgniter\Database\Exceptions\DatabaseException; // Para manejar errores de base de datos

class EncuestaController extends BaseController
{
    // Se elimina el 'use ResponseTrait' si no se está usando $this->respond() o $this->fail()
    // Si necesitas usar respuestas JSON directas (ej. para APIs), manténlo.
    // use CodeIgniter\API\ResponseTrait;

    protected $encuestaModel;
    protected $preguntaModel;
    protected $opcionModel;

    public function __construct()
    {
        $this->encuestaModel = new EncuestaModel();
        $this->preguntaModel = new PreguntaModel();
        $this->opcionModel = new OpcionModel();
    }

    /**
     * Muestra la lista de encuestas.
     */
    public function index()
    {
        $data['encuestas'] = $this->encuestaModel->findAll();
        // Las vistas siguen estando en la carpeta 'admin'
        return view('admin/encuestas', $data);
    }

    /**
     * Muestra el formulario para crear una nueva encuesta.
     */
    public function create()
    {
        // Carga la vista 'create_encuesta.php'
        return view('admin/create_encuesta');
    }

    /**
     * Guarda una nueva encuesta (con sus preguntas y opciones).
     */
   public function store()
{
    // Reglas de validación del lado del servidor.
    $rules = [
    'titulo' => 'required',
    'descripcion' => 'permit_empty',
    'activa' => 'required|in_list[0,1]',
    'preguntas' => 'required',
    'preguntas.*.texto_pregunta' => 'required',
    'preguntas.*.opciones' => 'required',
    'preguntas.*.opciones.*.texto_opcion' => 'required',
];



    if (!$this->validate($rules)) {
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    $postData = $this->request->getPost();

    // Validación manual: cada pregunta debe tener al menos 2 opciones
    foreach ($postData['preguntas'] as $index => $pregunta) {
        if (!isset($pregunta['opciones']) || !is_array($pregunta['opciones']) || count($pregunta['opciones']) < 2) {
            session()->setFlashdata('error', 'La pregunta #' . ($index + 1) . ' debe tener al menos dos opciones.');
            return redirect()->back()->withInput();
        }
    }

    // Iniciar transacción
    $this->encuestaModel->db->transBegin();

    try {
        // Guardar encuesta principal
        $encuestaData = [
            'titulo' => $postData['titulo'],
            'descripcion' => $postData['descripcion'],
            'activa' => $postData['activa'],
        ];

        if (!$this->encuestaModel->insert($encuestaData)) {
            throw new \Exception('No se pudo crear la encuesta: ' . implode(', ', $this->encuestaModel->errors()));
        }

        $idEncuesta = $this->encuestaModel->insertID();

        // Guardar preguntas y opciones
        foreach ($postData['preguntas'] as $preguntaIndex => $pregunta) {
            $preguntaData = [
                'id_encuesta' => $idEncuesta,
                'texto_pregunta' => $pregunta['texto_pregunta'],
                'tipo_pregunta' => 'opcion_multiple',
            ];

            if (!$this->preguntaModel->insert($preguntaData)) {
                throw new \Exception('No se pudo crear la pregunta ' . ($preguntaIndex + 1) . ': ' . implode(', ', $this->preguntaModel->errors()));
            }

            $idPregunta = $this->preguntaModel->insertID();

            foreach ($pregunta['opciones'] as $opcionIndex => $opcion) {
                $opcionData = [
                    'id_pregunta' => $idPregunta,
                    'texto_opcion' => $opcion['texto_opcion'],
                ];

                if (!$this->opcionModel->insert($opcionData)) {
                    throw new \Exception('No se pudo crear la opción ' . ($opcionIndex + 1) . ' para la pregunta ' . ($preguntaIndex + 1) . ': ' . implode(', ', $this->opcionModel->errors()));
                }
            }
        }

        $this->encuestaModel->db->transComplete();

        if ($this->encuestaModel->db->transStatus() === false) {
            throw new \Exception('Error en la transacción de la base de datos.');
        }

        session()->setFlashdata('message', 'Encuesta creada exitosamente.');
        return redirect()->to(base_url('encuestas'));

    } catch (DatabaseException $e) {
        $this->encuestaModel->db->transRollback();
        session()->setFlashdata('error', 'Error de base de datos: ' . $e->getMessage());
        return redirect()->back()->withInput();
    } catch (\Exception $e) {
        $this->encuestaModel->db->transRollback();
        session()->setFlashdata('error', 'Error al crear la encuesta: ' . $e->getMessage());
        return redirect()->back()->withInput();
    }
}

    /**
     * Muestra el formulario para editar una encuesta existente.
     * @param int $id El ID de la encuesta a editar.
     */
    public function edit($id = null)
    {
        $encuesta = $this->encuestaModel->find($id);

        if (!$encuesta) {
            session()->setFlashdata('error', 'Encuesta no encontrada.');
            return redirect()->to(base_url('encuestas')); // Redirige si la encuesta no existe
        }

        // Obtener preguntas asociadas a la encuesta
        $preguntas = $this->preguntaModel->where('id_encuesta', $id)->findAll();

        // Para cada pregunta, obtener sus opciones asociadas
        foreach ($preguntas as &$pregunta) {
            $pregunta['opciones'] = $this->opcionModel->where('id_pregunta', $pregunta['id_pregunta'])->findAll();
        }

        $data['encuesta'] = $encuesta;
        $data['preguntas'] = $preguntas;

        // Carga la vista de actualización con los datos de la encuesta
        return view('admin/update_encuesta', $data);
    }

    /**
     * Actualiza una encuesta existente (con sus preguntas y opciones).
     * @param int $id El ID de la encuesta a actualizar.
     */
   public function update($id = null)
{
    $encuestaExistente = $this->encuestaModel->find($id);
    if (!$encuestaExistente) {
        session()->setFlashdata('error', 'Encuesta no encontrada.');
        return redirect()->to(base_url('encuestas'));
    }

    // Reglas de validación (sin usar 'array')
    $rules = [
    'titulo' => 'required',
    'descripcion' => 'permit_empty',
    'activa' => 'required|in_list[0,1]',
    'preguntas' => 'required',
    'preguntas.*.texto_pregunta' => 'required',
    'preguntas.*.opciones' => 'required',
    'preguntas.*.opciones.*.texto_opcion' => 'required',
];


    if (!$this->validate($rules)) {
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    $postData = $this->request->getPost();

    // Validación manual para mínimo dos opciones por pregunta
    if (!is_array($postData['preguntas']) || empty($postData['preguntas'])) {
        session()->setFlashdata('error', 'Debe proporcionar al menos una pregunta válida.');
        return redirect()->back()->withInput();
    }

    foreach ($postData['preguntas'] as $i => $pregunta) {
        if (!isset($pregunta['opciones']) || !is_array($pregunta['opciones']) || count($pregunta['opciones']) < 2) {
            session()->setFlashdata('error', 'La pregunta #' . ($i + 1) . ' debe tener al menos dos opciones.');
            return redirect()->back()->withInput();
        }
    }

    $this->encuestaModel->db->transBegin();

    try {
        // Actualizar encuesta
        $encuestaData = [
            'titulo' => $postData['titulo'],
            'descripcion' => $postData['descripcion'],
            'activa' => $postData['activa'],
        ];

        if (!$this->encuestaModel->update($id, $encuestaData)) {
            throw new \Exception('No se pudo actualizar la encuesta: ' . implode(', ', $this->encuestaModel->errors()));
        }

        // Eliminar preguntas anteriores (ON DELETE CASCADE debe estar configurado)
        $this->preguntaModel->where('id_encuesta', $id)->delete();

        // Insertar nuevas preguntas y opciones
        foreach ($postData['preguntas'] as $preguntaIndex => $pregunta) {
            $preguntaData = [
                'id_encuesta' => $id,
                'texto_pregunta' => $pregunta['texto_pregunta'],
                'tipo_pregunta' => 'opcion_multiple',
            ];

            if (!$this->preguntaModel->insert($preguntaData)) {
                throw new \Exception('No se pudo insertar la pregunta ' . ($preguntaIndex + 1) . ': ' . implode(', ', $this->preguntaModel->errors()));
            }

            $idPregunta = $this->preguntaModel->insertID();

            foreach ($pregunta['opciones'] as $opcionIndex => $opcion) {
                $opcionData = [
                    'id_pregunta' => $idPregunta,
                    'texto_opcion' => $opcion['texto_opcion'],
                ];

                if (!$this->opcionModel->insert($opcionData)) {
                    throw new \Exception('No se pudo insertar la opción ' . ($opcionIndex + 1) . ' para la pregunta ' . ($preguntaIndex + 1) . ': ' . implode(', ', $this->opcionModel->errors()));
                }
            }
        }

        $this->encuestaModel->db->transComplete();

        if ($this->encuestaModel->db->transStatus() === false) {
            throw new \Exception('Error en la transacción de la base de datos.');
        }

        session()->setFlashdata('message', 'Encuesta actualizada exitosamente.');
        return redirect()->to(base_url('encuestas'));

    } catch (DatabaseException $e) {
        $this->encuestaModel->db->transRollback();
        session()->setFlashdata('error', 'Error de base de datos: ' . $e->getMessage());
        return redirect()->back()->withInput();
    } catch (\Exception $e) {
        $this->encuestaModel->db->transRollback();
        session()->setFlashdata('error', 'Error al actualizar la encuesta: ' . $e->getMessage());
        return redirect()->back()->withInput();
    }
}

    /**
     * Elimina una encuesta.
     * @param int $id El ID de la encuesta a eliminar.
     */
    public function delete($id = null)
    {
        try {
            if ($this->encuestaModel->delete($id)) {
                // Debido a ON DELETE CASCADE, las preguntas y opciones asociadas se eliminarán automáticamente.
                session()->setFlashdata('message', 'Encuesta eliminada exitosamente.');
            } else {
                session()->setFlashdata('error', 'No se pudo eliminar la encuesta.');
            }
        } catch (\Exception $e) {
            session()->setFlashdata('error', 'Error al eliminar la encuesta: ' . $e->getMessage());
        }

        return redirect()->to(base_url('encuestas')); // Redirige a la lista de encuestas
    }

   public function estatus($id = null)
{
    if (!$id || !is_numeric($id)) {
        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'ID de encuesta inválido.'
            ]);
        }
        session()->setFlashdata('error', 'ID de encuesta inválido.');
        return redirect()->to(base_url('encuestas'));
    }

    $encuesta = $this->encuestaModel->find($id);

    if (!$encuesta) {
        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Encuesta no encontrada.'
            ]);
        }
        session()->setFlashdata('error', 'Encuesta no encontrada.');
        return redirect()->to(base_url('encuestas'));
    }

    try {
        $nuevoEstado = $encuesta['activa'] == 1 ? 0 : 1;
        $this->encuestaModel->update($id, ['activa' => $nuevoEstado]);

        // Preparar respuesta JSON si es AJAX
        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => true,
                'nuevoEstado' => $nuevoEstado,
                'textoEstado' => $nuevoEstado ? 'Activa' : 'Inactiva'
            ]);
        }

        $estadoTexto = $nuevoEstado ? 'activada' : 'desactivada';
        session()->setFlashdata('message', 'Encuesta ' . $estadoTexto . ' correctamente.');

    } catch (\Exception $e) {
        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error al cambiar el estado: ' . $e->getMessage()
            ]);
        }
        session()->setFlashdata('error', 'Error al cambiar el estado: ' . $e->getMessage());
    }

    return redirect()->to(base_url('encuestas'));
}

}
