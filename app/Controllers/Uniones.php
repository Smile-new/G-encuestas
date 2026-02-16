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
           1. PREPARAR FILTROS Y OBTENER IDS
        ================================================== */
        $idPreguntasFiltro = array_keys($filtros);
        $opcionesFlat = [];
        foreach ($filtros as $opciones) {
            $opcionesFlat = array_merge($opcionesFlat, (array) $opciones);
        }
        $totalPreguntas = count($idPreguntasFiltro);

        /* ==================================================
           2. INTERSECCIÓN (AND): Personas que cumplen TODO
        ================================================== */
        $builder = $db->table('respuestas')
            ->select('id_monitoreo')
            ->where('id_encuesta', $idEncuesta)
            ->whereIn('id_opcion', $opcionesFlat);

        $camposGeo = ['id_estado', 'id_distrito_federal', 'id_distrito_local', 'id_municipio', 'id_seccion', 'id_comunidad'];
        foreach ($camposGeo as $campo) {
            if (!empty($geo[$campo])) {
                $builder->where($campo, $geo[$campo]);
            }
        }

        // Filtro estricto: la persona debe tener al menos una respuesta de CADA pregunta filtrada
        $builder->groupBy('id_monitoreo')
                ->having('COUNT(DISTINCT id_pregunta)', $totalPreguntas);

        $idsMonitoreo = array_column($builder->get()->getResultArray(), 'id_monitoreo');

        if (empty($idsMonitoreo)) {
            return $this->response->setJSON(['status' => 'empty']);
        }

        /* ==================================================
           3. OBTENER CONTEO CONCATENADO (Individual por Opción)
           Aquí es donde generamos los datos para la gráfica tipo "image_63f306.png"
        ================================================== */
        $respuestas = $db->table('respuestas r')
            ->select('o.texto_opcion, COUNT(r.id_monitoreo) as total')
            ->join('opciones o', 'o.id_opcion = r.id_opcion')
            ->whereIn('r.id_monitoreo', $idsMonitoreo)
            ->whereIn('r.id_opcion', $opcionesFlat) // Solo contamos las opciones que están en el filtro
            ->groupBy('o.texto_opcion')
            ->orderBy('r.id_pregunta', 'ASC') // Para mantener el orden de las preguntas en la gráfica
            ->get()
            ->getResultArray();

        /* ==================================================
           4. FORMATO PARA LA GRÁFICA
        ================================================== */
        $resultadoGrafica = [];
        foreach ($respuestas as $row) {
            $resultadoGrafica[] = [
                'perfil_corto' => $row['texto_opcion'],
                'texto_completo' => $row['texto_opcion'],
                'total' => (int)$row['total']
            ];
        }

        /* ==================================================
           5. PUNTOS MAPA (Mantener ubicación de los filtrados)
        ================================================== */
        $puntos = $db->table('monitoreo_ubicacion')
            ->select('id_monitoreo, latitud, longitud')
            ->whereIn('id_monitoreo', $idsMonitoreo)
            ->get()
            ->getResultArray();

        return $this->response->setJSON([
            'status' => 'success',
            'desglose' => $resultadoGrafica,
            'puntos' => $puntos,
            'resumen' => [
                'coincidencias' => count($idsMonitoreo) // Total de personas únicas que cumplen el filtro
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
