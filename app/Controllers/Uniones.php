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
               1. APLANAR OPCIONES
            ================================================== */
            $totalPreguntas = count($filtros);
            $opcionesFlat = [];

            foreach ($filtros as $opciones) {
                $opcionesFlat = array_merge($opcionesFlat, (array) $opciones);
            }

            /* ==================================================
               2. OBTENER MONITOREOS QUE CUMPLEN TODAS LAS PREGUNTAS
            ================================================== */
            $builder = $db->table('respuestas')
                ->select('id_monitoreo')
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
                    $builder->where($campo, $geo[$campo]);
                }
            }

            $builder
                ->groupBy('id_monitoreo')
                ->having('COUNT(DISTINCT id_pregunta)', $totalPreguntas);

            $idsMonitoreo = array_column(
                $builder->get()->getResultArray(),
                'id_monitoreo'
            );

            if (empty($idsMonitoreo)) {
                return $this->response->setJSON(['status' => 'empty']);
            }

            /* ==================================================
               3. PUNTOS MAPA
            ================================================== */
            $puntos = $db->table('monitoreo_ubicacion')
                ->select('id_monitoreo, latitud, longitud')
                ->whereIn('id_monitoreo', $idsMonitoreo)
                ->get()
                ->getResultArray();

            /* ==================================================
               4. RESPUESTAS POR PERSONA (ID ÚNICO)
            ================================================== */
            $respuestas = $db->table('respuestas r')
                ->select('r.id_monitoreo, r.id_pregunta, o.texto_opcion')
                ->join('opciones o', 'o.id_opcion = r.id_opcion')
                ->whereIn('r.id_monitoreo', $idsMonitoreo)
                ->whereIn('r.id_opcion', $opcionesFlat)
                ->orderBy('r.id_monitoreo')
                ->orderBy('r.id_pregunta')
                ->get()
                ->getResultArray();

            /* ==================================================
               5. PERFIL REAL POR PERSONA
            ================================================== */
            $perfilesPorPersona = [];

            foreach ($respuestas as $row) {
                $id = $row['id_monitoreo'];
                $pregunta = $row['id_pregunta'];
                $opcion = $row['texto_opcion'];

                $perfilesPorPersona[$id][$pregunta] = $opcion;
            }

            /* ==================================================
               6. AGRUPAR CAMINOS
            ================================================== */
            $perfilesFinales = [];

            foreach ($perfilesPorPersona as $perfil) {
                ksort($perfil);
                $clave = implode(' + ', $perfil);

                if (!isset($perfilesFinales[$clave])) {
                    $perfilesFinales[$clave] = 0;
                }

                $perfilesFinales[$clave]++;
            }

            /* ==================================================
               7. FORMATO GRÁFICA
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
                    'coincidencias' => count($idsMonitoreo)
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
