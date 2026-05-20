<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Config\Database;
use Config\Google;

use App\Models\EncuestaModel;
use App\Models\EstadoModel;
use App\Models\DistritoFederalModel;
use App\Models\DistritoLocalModel;
use App\Models\MunicipioModel;
use App\Models\SeccionModel;
use App\Models\ComunidadModel;
use App\Models\PreguntaModel;
use App\Models\OpcionModel;

class Cruces extends Controller
{
    /* ==========================================================
       VISTA PRINCIPAL
    ========================================================== */
    public function index()
    {
        $encuestaModel = new EncuestaModel();
        $estadoModel = new EstadoModel();
        $googleConfig = config(Google::class);

        // CAMBIO: Ahora apunta a la vista admin/cruces
        return view('admin/cruces', [
            'encuestas' => $encuestaModel->where('activa', 1)->findAll(),
            'estados' => $estadoModel->findAll(),
            'google_maps_api_key' => $googleConfig->apiKey
        ]);
    }

    /* ==========================================================
       ENCUESTAS
    ========================================================== */
    public function getPreguntas($idEncuesta)
    {
        return $this->response->setJSON(
            (new PreguntaModel())
                ->where('id_encuesta', $idEncuesta)
                ->findAll()
        );
    }

    public function getOpcionesPregunta($idPregunta)
    {
        return $this->response->setJSON(
            (new OpcionModel())
                ->where('id_pregunta', $idPregunta)
                ->findAll()
        );
    }

    /* ==========================================================
       GEOGRAFÍA
    ========================================================== */
    public function getDistritosFederales($idEstado)
    {
        return $this->response->setJSON(
            (new DistritoFederalModel())->where('id_estado', $idEstado)->findAll()
        );
    }

    public function getDistritosLocales($idDF)
    {
        return $this->response->setJSON(
            (new DistritoLocalModel())->where('id_distrito_federal', $idDF)->findAll()
        );
    }

    public function getMunicipios($idDL)
    {
        return $this->response->setJSON(
            (new MunicipioModel())->where('id_distrito_local', $idDL)->findAll()
        );
    }

    public function getSecciones($idMunicipio)
    {
        return $this->response->setJSON(
            (new SeccionModel())->where('id_municipio', $idMunicipio)->findAll()
        );
    }

    public function getComunidades($idSeccion)
    {
        return $this->response->setJSON(
            (new ComunidadModel())->where('id_seccion', $idSeccion)->findAll()
        );
    }

    /* ==========================================================
       PROCESAMIENTO DE UNIÓN / CRUCE
    ========================================================== */
    public function procesar()
    {
        try {
            $db = Database::connect();

            $idEncuesta = $this->request->getPost('id_encuesta');
            $filtros = $this->request->getPost('filtros');
            $geo = $this->request->getPost('geo');

            if (empty($filtros)) {
                return $this->response->setJSON(['status' => 'empty']);
            }

            /* ==================================================
               MAPEO GEOGRÁFICO (El puente entre JS y BD)
            ================================================== */
            $camposGeoMap = [
                'id_estado'          => 'id_estado',
                'id_distritofederal' => 'id_distrito_federal', 
                'id_distritolocal'   => 'id_distrito_local',   
                'id_municipio'       => 'id_municipio',
                'id_seccion'         => 'id_seccion',
                'id_comunidad'       => 'id_comunidad'
            ];

            /* ==================================================
               1. CALCULAR EL UNIVERSO TOTAL (Con Filtro Geográfico)
            ================================================== */
            $builderUniverso = $db->table('respuestas r')
                ->where('r.id_encuesta', $idEncuesta);

            foreach ($camposGeoMap as $columnaBD => $claveJS) {
                if (!empty($geo[$claveJS])) {
                    $builderUniverso->where('r.' . $columnaBD, $geo[$claveJS]);
                }
            }

            $totalUniverso = $builderUniverso->groupBy('r.id_monitoreo')->countAllResults();

            /* ==================================================
               2. INTERSECCIÓN ESTRICTA (Filtrado jerárquico)
            ================================================== */
            $idPreguntasFiltro = array_keys($filtros);
            $opcionesFlat = [];
            foreach ($filtros as $opciones) {
                $opcionesFlat = array_merge($opcionesFlat, (array) $opciones);
            }
            $totalPreguntasCategorias = count($idPreguntasFiltro);

            $builder = $db->table('respuestas r')
                ->select('r.id_monitoreo')
                ->where('r.id_encuesta', $idEncuesta)
                ->whereIn('r.id_opcion', $opcionesFlat);

            foreach ($camposGeoMap as $columnaBD => $claveJS) {
                if (!empty($geo[$claveJS])) {
                    $builder->where('r.' . $columnaBD, $geo[$claveJS]);
                }
            }

            $builder->groupBy('r.id_monitoreo')
                ->having('COUNT(DISTINCT r.id_pregunta)', $totalPreguntasCategorias);

            $queryIds = $builder->get();

            if (!$queryIds) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'msg' => 'Error SQL (Intersección): ' . $db->error()['message']
                ]);
            }

            $idsMonitoreo = array_column($queryIds->getResultArray(), 'id_monitoreo');

            if (empty($idsMonitoreo)) {
                return $this->response->setJSON(['status' => 'empty', 'total_universo' => $totalUniverso]);
            }

            /* ==================================================
               3. DESGLOSE DE RESULTADOS (AGRUPADO POR PREGUNTA)
            ================================================== */
            // Hacemos JOIN con preguntas para traer el título de cada gráfica
            $queryRespuestas = $db->table('respuestas r')
                ->select('p.texto_pregunta, o.texto_opcion, COUNT(r.id_monitoreo) as total, r.id_pregunta')
                ->join('opciones o', 'o.id_opcion = r.id_opcion')
                ->join('preguntas p', 'p.id_pregunta = r.id_pregunta')
                ->whereIn('r.id_monitoreo', $idsMonitoreo)
                ->whereIn('r.id_opcion', $opcionesFlat)
                ->groupBy('r.id_pregunta, o.id_opcion') // Agrupamos por pregunta y luego por opción
                ->orderBy('r.id_pregunta', 'ASC')
                ->get();

            if (!$queryRespuestas) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'msg' => 'Error SQL (Desglose): ' . $db->error()['message']
                ]);
            }

            $resultadoGrafica = [];
            foreach ($queryRespuestas->getResultArray() as $row) {
                $idPreg = $row['id_pregunta'];
                
                // Si la pregunta no existe en nuestro arreglo, la creamos
                if (!isset($resultadoGrafica[$idPreg])) {
                    $resultadoGrafica[$idPreg] = [
                        'pregunta' => $row['texto_pregunta'],
                        'opciones' => []
                    ];
                }

                // Guardamos las opciones dentro de su pregunta correspondiente
                $resultadoGrafica[$idPreg]['opciones'][] = [
                    'perfil_corto' => $row['texto_opcion'],
                    'total' => (int) $row['total']
                ];
            }

            // Reindexamos el arreglo para que las llaves numéricas sean secuenciales y limpias para JS
            $resultadoGrafica = array_values($resultadoGrafica);

            /* ==================================================
               4. GEOLOCALIZACIÓN
            ================================================== */
            $queryPuntos = $db->table('monitoreo_ubicacion')
                ->select('id_monitoreo, latitud, longitud')
                ->whereIn('id_monitoreo', $idsMonitoreo)
                ->get();

            $puntos = $queryPuntos ? $queryPuntos->getResultArray() : [];

            return $this->response->setJSON([
                'status' => 'success',
                'desglose' => $resultadoGrafica,
                'puntos' => $puntos,
                'resumen' => [
                    'total_encuesta' => $totalUniverso,
                    'coincidencias' => count($idsMonitoreo)
                ]
            ]);

        } catch (\Throwable $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'msg' => 'Error de Servidor: ' . $e->getMessage()
            ]);
        }
    }
}