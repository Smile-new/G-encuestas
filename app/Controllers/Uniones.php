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

class Uniones extends Controller
{
    /* ==========================================================
       VISTA PRINCIPAL
    ========================================================== */
    public function index()
    {
        $encuestaModel = new EncuestaModel();
        $estadoModel = new EstadoModel();
        $googleConfig = config(Google::class);

        return view('admin/uniones', [
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
       PROCESAMIENTO DE UNIÓN (CORREGIDO)
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
               1. APLANAR OPCIONES (OR por pregunta)
            ================================================== */
            $totalPreguntas = count($filtros);
            $opcionesFlat = [];

            foreach ($filtros as $opciones) {
                $opcionesFlat = array_merge($opcionesFlat, (array) $opciones);
            }

            /* ==================================================
               2. INTERSECCIÓN AND ENTRE PREGUNTAS
            ================================================== */
            $builder = $db->table('respuestas')
                ->select('referencias')
                ->where('id_encuesta', $idEncuesta)
                ->whereIn('id_opcion', $opcionesFlat);

            $camposGeo = [
                'id_estado',
                'id_distrito_federal', 
                'id_distrito_local',   
                'id_municipio',
                'id_seccion',
                'id_comunidad'
            ];


            foreach ($camposGeo as $campo) {
                if (!empty($geo[$campo])) {
                    $builder->where("respuestas.$campo", $geo[$campo]);
                }
            }

            $builder
                ->groupBy('referencias')
                ->having('COUNT(DISTINCT id_pregunta)', $totalPreguntas);

            $folios = array_column(
                $builder->get()->getResultArray(),
                'referencias'
            );

            if (empty($folios)) {
                return $this->response->setJSON(['status' => 'empty']);
            }

            /* ==================================================
               3. PUNTOS PARA MAPA
            ================================================== */
            $puntos = $db->table('respuestas')
                ->select('respuestas.referencias, MU.latitud, MU.longitud')
                ->join(
                    'monitoreo_ubicacion AS MU',
                    'MU.id_monitoreo = respuestas.id_monitoreo'
                )
                ->whereIn('respuestas.referencias', $folios)
                ->groupBy('respuestas.referencias')
                ->get()
                ->getResultArray();

            /* ==================================================
               4. OBTENER RESPUESTAS POR PERSONA (CLAVE)
            ================================================== */
            $respuestas = $db->table('respuestas r')
                ->select('r.referencias, r.id_pregunta, o.texto_opcion')
                ->join('opciones o', 'o.id_opcion = r.id_opcion')
                ->whereIn('r.referencias', $folios)
                ->whereIn('r.id_opcion', $opcionesFlat)
                ->orderBy('r.referencias')
                ->orderBy('r.id_pregunta')
                ->get()
                ->getResultArray();

            /* ==================================================
               5. CONSTRUIR PERFIL REAL POR PERSONA
               (1 opción por pregunta)
            ================================================== */
            $perfilesPorPersona = [];

            foreach ($respuestas as $row) {
                $folio = $row['referencias'];
                $pregunta = $row['id_pregunta'];
                $opcion = $row['texto_opcion'];

                // Garantiza solo una opción por pregunta
                $perfilesPorPersona[$folio][$pregunta] = $opcion;
            }

            /* ==================================================
               6. AGRUPAR CAMINOS IDÉNTICOS
            ================================================== */
            $perfilesFinales = [];

            foreach ($perfilesPorPersona as $perfil) {
                ksort($perfil); // orden fijo
                $clavePerfil = implode(' + ', $perfil);

                if (!isset($perfilesFinales[$clavePerfil])) {
                    $perfilesFinales[$clavePerfil] = 0;
                }

                $perfilesFinales[$clavePerfil]++;
            }

            /* ==================================================
               7. FORMATO PARA GRÁFICA
            ================================================== */
            $resultadoGrafica = [];
            $i = 1;

            foreach ($perfilesFinales as $perfil => $cantidad) {
                $resultadoGrafica[] = [
                    'perfil_corto' => 'Camino ' . $i++,
                    'texto_completo' => $perfil,
                    'total' => $cantidad
                ];
            }

            /* ==================================================
               8. RESPUESTA FINAL
            ================================================== */
            return $this->response->setJSON([
                'status' => 'success',
                'desglose' => $resultadoGrafica,
                'puntos' => $puntos,
                'resumen' => [
                    'coincidencias' => count($folios)
                ]
            ]);

        } catch (\Throwable $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'msg' => $e->getMessage()
            ]);
        }
    }

}
