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

// *** ¡CORRECCIÓN IMPORTANTE! ***
// Debes incluir las clases de PhpSpreadsheet que estás utilizando.
// Sin estas líneas, PHP no sabrá qué son 'Spreadsheet' y 'Xlsx' y mostrará un error.
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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

        $encuestas = $this->encuestaModel->where('activa', 1)->findAll() ?? [];
        $municipios = $this->municipioModel->findAll() ?? [];

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
                'municipio'        => $municipio,
                'distrito_local'   => $distritoLocal,
                'distrito_federal' => $distritoFederal,
                'estado'           => $estado,
            ];

            return $this->response->setJSON($data);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'error'   => 'Error interno del servidor al obtener los datos geográficos.',
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
        $preguntas = $this->preguntaModel->where('id_encuesta', $idEncuesta)->findAll() ?? [];
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
        $opciones = $this->opcionModel->where('id_pregunta', $idPregunta)->findAll() ?? [];
        return $this->response->setJSON($opciones);
    }

    /**
     * Método AJAX para obtener las secciones de un municipio.
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
     */
    public function getRespuestas()
    {
        try {
            $idEncuesta = $this->request->getGet('id_encuesta');
            $idPregunta = $this->request->getGet('id_pregunta');
            $idMunicipio = $this->request->getGet('id_municipio');
            $idSeccion = $this->request->getGet('id_seccion');
            $idComunidad = $this->request->getGet('id_comunidad');

            if (empty($idEncuesta) || empty($idPregunta)) {
                return $this->response->setStatusCode(400)->setJSON([
                    'error' => 'Parámetros obligatorios (id_encuesta o id_pregunta) faltantes.',
                ]);
            }
            
            $query = $this->respuestaModel
                ->select('id_opcion, COUNT(id_respuesta) as total')
                ->where('id_encuesta', $idEncuesta)
                ->where('id_pregunta', $idPregunta);
            
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

    public function descargarExcel()
    {
    

        try {
            // 1. OBTENER Y VALIDAR FILTROS
            $idEncuesta = $this->request->getGet('id_encuesta');
            $idsPreguntasStr = $this->request->getGet('ids_preguntas');
            $idMunicipio = $this->request->getGet('id_municipio');
            $idSeccion = $this->request->getGet('id_seccion');
            $idComunidad = $this->request->getGet('id_comunidad');
            
            $idsPreguntasArray = [];
            if (!empty($idsPreguntasStr)) {
                $idsPreguntasArray = array_filter(explode(',', $idsPreguntasStr), 'is_numeric');
            }

            if (empty($idEncuesta) || empty($idsPreguntasArray)) {
                return redirect()->back()->with('error', 'Parámetros inválidos. Debes seleccionar una encuesta y al menos una pregunta.');
            }

            // 2. CONSTRUIR LA CONSULTA
            $query = $this->respuestaModel
                ->select([
                    'respuestas.fecha_respuesta', 'usuarios.nombre as nombre_usuario', 'usuarios.apellido_paterno',
                    'preguntas.texto_pregunta', 'opciones.texto_opcion', 'respuestas.referencias', 
                    'respuestas.direccion', 
                    'municipio.nombre_municipio',
                    'seccion.nombre_seccion', // <-- CORRECCIÓN AQUÍ
                    'comunidades.nombre_comunidad'
                ])
                ->join('usuarios', 'usuarios.id_usuario = respuestas.id_usuario', 'left')
                ->join('preguntas', 'preguntas.id_pregunta = respuestas.id_pregunta', 'left')
                ->join('opciones', 'opciones.id_opcion = respuestas.id_opcion', 'left')
                ->join('municipio', 'municipio.id_municipio = respuestas.id_municipio', 'left')
                ->join('seccion', 'seccion.id_seccion = respuestas.id_seccion', 'left') // <-- CORRECCIÓN AQUÍ
                ->join('comunidades', 'comunidades.id_comunidad = respuestas.id_comunidad', 'left')
                ->where('respuestas.id_encuesta', $idEncuesta)
                ->whereIn('respuestas.id_pregunta', $idsPreguntasArray);

            if (!empty($idMunicipio)) $query->where('respuestas.id_municipio', $idMunicipio);
            if (!empty($idSeccion)) $query->where('respuestas.id_seccion', $idSeccion);
            if (!empty($idComunidad)) $query->where('respuestas.id_comunidad', $idComunidad);
            
            $resultados = $query->orderBy('respuestas.fecha_respuesta', 'DESC')->findAll();

            if (empty($resultados)) {
                return redirect()->back()->with('error', 'No se encontraron datos con los filtros seleccionados para generar el reporte.');
            }

            // 3. GENERAR EL EXCEL
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('Reporte de Encuestas');

            $sheet->setCellValue('A1', 'Fecha Respuesta')->setCellValue('B1', 'Encuestador')
                  ->setCellValue('C1', 'Pregunta')->setCellValue('D1', 'Respuesta (Opción)')
                  ->setCellValue('E1', 'Referencias')->setCellValue('F1', 'Dirección Geolocalizada')
                  ->setCellValue('G1', 'Municipio')->setCellValue('H1', 'Sección')->setCellValue('I1', 'Comunidad');
            $sheet->getStyle('A1:I1')->getFont()->setBold(true);

            $row = 2;
            foreach ($resultados as $data) {
                $sheet->setCellValue('A' . $row, $data['fecha_respuesta']);
                $sheet->setCellValue('B' . $row, trim($data['nombre_usuario'] . ' ' . $data['apellido_paterno']));
                $sheet->setCellValue('C' . $row, $data['texto_pregunta']);
                $sheet->setCellValue('D' . $row, $data['texto_opcion']);
                $sheet->setCellValue('E' . $row, $data['referencias']);
                $sheet->setCellValue('F' . $row, $data['direccion']);
                $sheet->setCellValue('G' . $row, $data['nombre_municipio']);
                $sheet->setCellValue('H' . $row, $data['nombre_seccion']);
                $sheet->setCellValue('I' . $row, $data['nombre_comunidad']);
                $row++;
            }

            foreach (range('A', 'I') as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }

            // 4. ENVIAR EL ARCHIVO AL NAVEGADOR
            $writer = new Xlsx($spreadsheet);
            $filename = 'Reporte_Encuestas_' . date('Y-m-d_H-i-s') . '.xlsx';

            if (ob_get_level()) {
                ob_end_clean();
            }

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
            $writer->save('php://output');
            exit();

        } catch (\Throwable $e) {
            if (ENVIRONMENT === 'development') {
                throw $e;
            } else {
                log_message('error', '[Excel Generation Error] ' . $e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine());
                return redirect()->back()->with('error', 'Ocurrió un error crítico al generar el reporte.');
            }
        }
    }
}
