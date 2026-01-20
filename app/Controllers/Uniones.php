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
               1. PREPARAR PREGUNTAS, OPCIONES Y PREGUNTA EJE
            ================================================== */
            $idPreguntasFiltro = array_keys($filtros);
            $totalPreguntasReq = count($idPreguntasFiltro);
            $opcionesFlat = [];

            $idPreguntaEje = null;
            $maxOpciones = 0;

            foreach ($filtros as $idPregunta => $arrOpciones) {
                $arrOpciones = (array) $arrOpciones;
                $conteo = count($arrOpciones);
                $opcionesFlat = array_merge($opcionesFlat, $arrOpciones);

                if ($conteo > $maxOpciones) {
                    $maxOpciones = $conteo;
                    $idPreguntaEje = $idPregunta;
                }
            }

            if (!$idPreguntaEje) {
                $idPreguntaEje = $idPreguntasFiltro[0];
            }

            /* ==================================================
               2. MAPA DE TEXTOS DE PREGUNTAS (CLAVE DEL FIX)
            ================================================== */
            $preguntas = $db->table('preguntas')
                ->select('id_pregunta, texto_pregunta')
                ->whereIn('id_pregunta', $idPreguntasFiltro)
                ->get()->getResultArray();

            $mapPreguntas = [];
            foreach ($preguntas as $p) {
                $mapPreguntas[$p['id_pregunta']] = trim($p['texto_pregunta']);
            }

            /* ==================================================
               3. BUSCAR PERSONAS QUE CUMPLEN TODOS LOS FILTROS
            ================================================== */
            $builder = $db->table('respuestas')
                ->select('id_monitoreo')
                ->where('id_encuesta', $idEncuesta)
                ->whereIn('id_opcion', $opcionesFlat);

            $camposGeo = [
                'id_estado' => 'id_estado',
                'id_distritofederal' => 'id_distrito_federal',
                'id_distritolocal' => 'id_distrito_local',
                'id_municipio' => 'id_municipio',
                'id_seccion' => 'id_seccion',
                'id_comunidad' => 'id_comunidad'
            ];

            foreach ($camposGeo as $postKey => $dbCol) {
                if (!empty($geo[$postKey])) {
                    $builder->where($dbCol, $geo[$postKey]);
                }
            }

            $builder->groupBy('id_monitoreo')
                ->having('COUNT(DISTINCT id_pregunta)', $totalPreguntasReq);

            $idsValidos = array_column($builder->get()->getResultArray(), 'id_monitoreo');

            if (empty($idsValidos)) {
                return $this->response->setJSON(['status' => 'empty']);
            }

            /* ==================================================
               4. TRAER RESPUESTAS LIMPIAS
            ================================================== */
            $respuestas = $db->table('respuestas r')
                ->select('r.id_monitoreo, r.id_pregunta, o.texto_opcion')
                ->join('opciones o', 'o.id_opcion = r.id_opcion')
                ->whereIn('r.id_monitoreo', $idsValidos)
                ->whereIn('r.id_pregunta', $idPreguntasFiltro)
                ->whereIn('r.id_opcion', $opcionesFlat)
                ->orderBy('r.id_monitoreo')
                ->get()
                ->getResultArray();

            /* ==================================================
               5. MAPA PERSONA → BARRA (PREGUNTA EJE)
            ================================================== */
            $personaColorMap = [];
            foreach ($respuestas as $row) {
                if ($row['id_pregunta'] == $idPreguntaEje) {
                    $personaColorMap[$row['id_monitoreo']] = $row['texto_opcion'];
                }
            }

            /* ==================================================
               6. CONTEO PRINCIPAL + RELACIONES CORRECTAS
            ================================================== */
            $conteoCaminos = [];
            $relacionesOpciones = [];

            foreach ($respuestas as $row) {
                $idPersona = $row['id_monitoreo'];
                $idPregunta = $row['id_pregunta'];
                $textoOpcion = $row['texto_opcion'];

                // Conteo de la gráfica (solo eje)
                if ($idPregunta == $idPreguntaEje) {
                    $conteoCaminos[$textoOpcion] = ($conteoCaminos[$textoOpcion] ?? 0) + 1;
                }

                // Relaciones opción ↔ barras
                if (isset($personaColorMap[$idPersona])) {
                    $textoPregunta = $mapPreguntas[$idPregunta] ?? 'Pregunta';
                    $claveRelacion = $textoPregunta . '|' . $textoOpcion;
                    $colorKey = $personaColorMap[$idPersona];

                    $relacionesOpciones[$claveRelacion][$colorKey] = true;
                }
            }

            /* ==================================================
               7. LIMPIAR RELACIONES PARA JS
            ================================================== */
            $relacionesFinal = [];
            foreach ($relacionesOpciones as $clave => $colores) {
                $relacionesFinal[$clave] = array_keys($colores);
            }

            ksort($conteoCaminos);

            $resultadoGrafica = [];
            foreach ($conteoCaminos as $texto => $total) {
                $resultadoGrafica[] = [
                    'perfil_corto' => $texto,
                    'texto_completo' => $texto,
                    'total' => $total
                ];
            }

            /* ==================================================
               8. PUNTOS DEL MAPA
            ================================================== */
            $puntos = $db->table('monitoreo_ubicacion')
                ->select('id_monitoreo, latitud, longitud')
                ->whereIn('id_monitoreo', $idsValidos)
                ->get()
                ->getResultArray();

            return $this->response->setJSON([
                'status' => 'success',
                'desglose' => $resultadoGrafica,
                'puntos' => $puntos,
                'relaciones' => $relacionesFinal,
                'resumen' => [
                    'coincidencias' => count($idsValidos),
                    'encuesta_nombre' => 'Resultados Filtrados'
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
