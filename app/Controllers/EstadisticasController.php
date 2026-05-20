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

// Librerías necesarias para la generación de Reportes
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class EstadisticasController extends Controller
{
    // Propiedades para los modelos
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
        // Instanciación de modelos para uso global en el controlador
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
     * Carga la vista principal. 
     * Provee el nivel raíz de la geografía (Estados) y las encuestas activas.
     */
    public function index()
    {
        $session = session();

        if (!$session->get('isLoggedIn')) {
            return redirect()->to(base_url('login'))->with('error', 'Tu sesión ha expirado.');
        }

        $userData = $session->get('usuario');

        // Preparación de datos de perfil para el sidebar/navbar
        $data = [
            'nombreCompleto' => trim(($userData['nombre'] ?? '') . ' ' . ($userData['apellido_paterno'] ?? '')),
            'rolTexto' => $this->_getRolTexto($userData['id_rol'] ?? 0),
            'rutaFotoPerfil' => !empty($userData['foto']) ? base_url('public/img_user/' . $userData['foto']) : base_url('recursos_admin/images/faces/face15.jpg'),
            'encuestas' => $this->encuestaModel->where('activa', 1)->findAll() ?? [],
            'estados' => $this->estadoModel->findAll() ?? [], // Punto de partida de la cascada
        ];

        return view('admin/estadisticas', $data);
    }

    // =========================================================================
    // MÉTODOS AJAX: CASCADA GEOGRÁFICA MANUAL (Top-Down)
    // =========================================================================

    public function getDistritosFederales($idEstado)
    {
        if (!is_numeric($idEstado))
            return $this->response->setJSON([]);
        return $this->response->setJSON($this->distritoFederalModel->where('id_estado', $idEstado)->findAll() ?? []);
    }

    public function getDistritosLocales($idDistritoFederal)
    {
        if (!is_numeric($idDistritoFederal))
            return $this->response->setJSON([]);
        return $this->response->setJSON($this->distritoLocalModel->where('id_distrito_federal', $idDistritoFederal)->findAll() ?? []);
    }

    public function getMunicipios($idDistritoLocal)
    {
        if (!is_numeric($idDistritoLocal))
            return $this->response->setJSON([]);
        return $this->response->setJSON($this->municipioModel->where('id_distrito_local', $idDistritoLocal)->findAll() ?? []);
    }

    public function getSecciones($idMunicipio)
    {
        if (!is_numeric($idMunicipio))
            return $this->response->setJSON([]);
        return $this->response->setJSON($this->seccionModel->where('id_municipio', $idMunicipio)->findAll() ?? []);
    }

    public function getComunidades($idSeccion)
    {
        if (!is_numeric($idSeccion))
            return $this->response->setJSON([]);
        return $this->response->setJSON($this->comunidadModel->where('id_seccion', $idSeccion)->findAll() ?? []);
    }

    // =========================================================================
    // MÉTODOS AJAX: DATOS DE ENCUESTA Y GRÁFICAS
    // =========================================================================

    public function getPreguntas($idEncuesta)
    {
        return $this->response->setJSON($this->preguntaModel->where('id_encuesta', $idEncuesta)->findAll() ?? []);
    }

    public function getOpcionesPregunta($idPregunta)
    {
        return $this->response->setJSON($this->opcionModel->where('id_pregunta', $idPregunta)->findAll() ?? []);
    }

    public function getRespuestas()
    {
        try {
            $idEncuesta = $this->request->getGet('id_encuesta');
            $idPregunta = $this->request->getGet('id_pregunta');

            // Capturamos TODOS los filtros posibles
            $idEstado = $this->request->getGet('id_estado');
            $idDistFed = $this->request->getGet('id_distrito_federal');
            $idDistLoc = $this->request->getGet('id_distrito_local');
            $idMunicipio = $this->request->getGet('id_municipio');
            $idSeccion = $this->request->getGet('id_seccion');
            $idComunidad = $this->request->getGet('id_comunidad');

            if (empty($idEncuesta) || empty($idPregunta)) {
                return $this->response->setStatusCode(400)->setJSON(['error' => 'Faltan parámetros básicos.']);
            }

            // Iniciamos la consulta base
            $query = $this->respuestaModel->select('id_opcion, COUNT(id_respuesta) as total')
                ->where('id_encuesta', $idEncuesta)
                ->where('id_pregunta', $idPregunta);

            // --- LÓGICA DE FILTRADO CON JOINS ---
            // Si hay filtros de Estado o Distritos, necesitamos unir las tablas geográficas
            if (!empty($idEstado) || !empty($idDistFed) || !empty($idDistLoc)) {
                $query->join('municipio', 'municipio.id_municipio = respuestas.id_municipio', 'left')
                    ->join('distritolocal', 'distritolocal.id_distrito_local = municipio.id_distrito_local', 'left')
                    ->join('distritofederal', 'distritofederal.id_distrito_federal = distritolocal.id_distrito_federal', 'left')
                    ->join('estado', 'estado.id_estado = distritofederal.id_estado', 'left');

                if (!empty($idEstado))
                    $query->where('estado.id_estado', $idEstado);
                if (!empty($idDistFed))
                    $query->where('distritofederal.id_distrito_federal', $idDistFed);
                if (!empty($idDistLoc))
                    $query->where('distritolocal.id_distrito_local', $idDistLoc);
            }

            // Filtros directos (ya están en la tabla respuestas)
            if (!empty($idMunicipio))
                $query->where('respuestas.id_municipio', $idMunicipio);
            if (!empty($idSeccion))
                $query->where('respuestas.id_seccion', $idSeccion);
            if (!empty($idComunidad))
                $query->where('respuestas.id_comunidad', $idComunidad);

            $resultados = $query->groupBy('id_opcion')->findAll();
            return $this->response->setJSON($resultados);

        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON(['error' => $e->getMessage()]);
        }
    }

    // =========================================================================
    // EXPORTACIÓN A EXCEL: CON JERARQUÍA GEOGRÁFICA COMPLETA
    // =========================================================================

    public function descargarExcel()
    {
        try {
            $idEncuesta = $this->request->getGet('id_encuesta');
            $idsPreguntasStr = $this->request->getGet('ids_preguntas');
            $idsPreguntas = array_filter(explode(',', $idsPreguntasStr), 'is_numeric');

            // Filtros adicionales
            $idMunicipio = $this->request->getGet('id_municipio');
            $idSeccion = $this->request->getGet('id_seccion');
            $idComunidad = $this->request->getGet('id_comunidad');

            if (empty($idEncuesta) || empty($idsPreguntas)) {
                return redirect()->back()->with('error', 'Selección inválida para el reporte.');
            }

            // CONSULTA MAESTRA (Optimizada sin tabla de usuarios)
            $builder = $this->respuestaModel
                ->select([
                    'respuestas.fecha_respuesta',
                    'preguntas.texto_pregunta',
                    'opciones.texto_opcion',
                    'respuestas.referencias',
                    'respuestas.direccion',
                    'estado.nombre_estado',
                    'distritofederal.nombre_distrito_federal',
                    'distritolocal.nombre_distrito_local',
                    'municipio.nombre_municipio',
                    'seccion.nombre_seccion',
                    'comunidades.nombre_comunidad'
                ])
                ->join('preguntas', 'preguntas.id_pregunta = respuestas.id_pregunta', 'left')
                ->join('opciones', 'opciones.id_opcion = respuestas.id_opcion', 'left')
                ->join('comunidades', 'comunidades.id_comunidad = respuestas.id_comunidad', 'left')
                ->join('seccion', 'seccion.id_seccion = respuestas.id_seccion', 'left')
                ->join('municipio', 'municipio.id_municipio = respuestas.id_municipio', 'left')
                ->join('distritolocal', 'distritolocal.id_distrito_local = municipio.id_distrito_local', 'left')
                ->join('distritofederal', 'distritofederal.id_distrito_federal = distritolocal.id_distrito_federal', 'left')
                ->join('estado', 'estado.id_estado = distritofederal.id_estado', 'left')
                ->where('respuestas.id_encuesta', $idEncuesta)
                ->whereIn('respuestas.id_pregunta', $idsPreguntas);

            if (!empty($idMunicipio))
                $builder->where('respuestas.id_municipio', $idMunicipio);
            if (!empty($idSeccion))
                $builder->where('respuestas.id_seccion', $idSeccion);
            if (!empty($idComunidad))
                $builder->where('respuestas.id_comunidad', $idComunidad);

            $resultados = $builder->orderBy('respuestas.fecha_respuesta', 'DESC')->findAll();

            if (empty($resultados)) {
                return redirect()->back()->with('error', 'No hay datos para exportar con estos filtros.');
            }

            // --- 1. PROCESAMIENTO DINÁMICO (PIVOT) ---
            $encuestasAgrupadas = [];
            $preguntasUnicas = [];

            foreach ($resultados as $row) {
                // LLAVE ÚNICA para agrupar respuestas de la misma persona
                $idEncuestado = $row['fecha_respuesta'] . '|' . $row['direccion'] . '|' . $row['referencias'];

                $pregunta = $row['texto_pregunta'];
                $respuesta = $row['texto_opcion'];

                if (!in_array($pregunta, $preguntasUnicas)) {
                    $preguntasUnicas[] = $pregunta;
                }

                if (!isset($encuestasAgrupadas[$idEncuestado])) {
                    $encuestasAgrupadas[$idEncuestado] = [
                        'fecha' => $row['fecha_respuesta'],
                        'estado' => $row['nombre_estado'],
                        'distrito_federal' => $row['nombre_distrito_federal'],
                        'distrito_local' => $row['nombre_distrito_local'],
                        'municipio' => $row['nombre_municipio'],
                        'seccion' => $row['nombre_seccion'],
                        'comunidad' => $row['nombre_comunidad'],
                        'direccion' => $row['direccion'],
                        'referencias' => $row['referencias'],
                        'respuestas' => []
                    ];
                }

                // Concatenar respuestas si hay opciones múltiples en la misma pregunta
                if (isset($encuestasAgrupadas[$idEncuestado]['respuestas'][$pregunta])) {
                    $encuestasAgrupadas[$idEncuestado]['respuestas'][$pregunta] .= ', ' . $respuesta;
                } else {
                    $encuestasAgrupadas[$idEncuestado]['respuestas'][$pregunta] = $respuesta;
                }
            }

            // --- 2. GENERACIÓN DEL EXCEL ---
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('Reporte G-Encuestas');

            // --- AQUÍ ESTÁ EL ORDEN EXACTO SOLICITADO ---
            $headersBase = [
                'Fecha',
                'Estado',
                'Distrito Federal',
                'Distrito Local',
                'Municipio',
                'Sección',
                'Comunidad',
                'Dirección GPS',
                'Referencias'
            ];

            $headersFinales = array_merge($headersBase, $preguntasUnicas);
            $sheet->fromArray($headersFinales, NULL, 'A1');

            // Estilos para la fila de títulos
            $totalColumnas = count($headersFinales);
            $ultimaLetraColumna = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($totalColumnas);

            $estiloCabecera = [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF4A4A4A'] // Gris oscuro
                ]
            ];
            $sheet->getStyle('A1:' . $ultimaLetraColumna . '1')->applyFromArray($estiloCabecera);

            // --- 3. LLENADO DE FILAS ---
            $rowNumber = 2;
            foreach ($encuestasAgrupadas as $encuesta) {
                // --- DATOS EN EL ORDEN EXACTO ---
                $datosFila = [
                    $encuesta['fecha'],
                    $encuesta['estado'],
                    $encuesta['distrito_federal'],
                    $encuesta['distrito_local'],
                    $encuesta['municipio'],
                    $encuesta['seccion'],
                    $encuesta['comunidad'],
                    $encuesta['direccion'],
                    $encuesta['referencias']
                ];

                // Agregar las respuestas dinámicas
                foreach ($preguntasUnicas as $pregunta) {
                    $datosFila[] = isset($encuesta['respuestas'][$pregunta]) ? $encuesta['respuestas'][$pregunta] : '';
                }

                $sheet->fromArray($datosFila, NULL, 'A' . $rowNumber++);
            }

            // Auto-ajustar ancho de las columnas
            foreach (range(1, $totalColumnas) as $colIndex) {
                $colLetra = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex);
                $sheet->getColumnDimension($colLetra)->setAutoSize(true);
            }

            // --- 4. DESCARGA DEL ARCHIVO ---
            $filename = 'Reporte_Geo_Encuestas_' . date('Ymd_His') . '.xlsx';

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');

            // Prevenir archivos corruptos limpiando el buffer de salida
            if (ob_get_level()) {
                ob_end_clean();
            }

            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $writer->save('php://output');
            exit();

        } catch (\Throwable $e) {
            log_message('error', '[Excel Error]: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error crítico al generar el Excel.');
        }
    }
    /**
     * Helper privado para transformar ID de rol en texto legible.
     */
    private function _getRolTexto($idRol)
    {
        $roles = [1 => 'Administrador', 2 => 'Operador', 3 => 'Encuestador'];
        return $roles[$idRol] ?? 'Miembro';
    }
}