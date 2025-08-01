<?php

namespace App\Models;

use CodeIgniter\Model;

class MunicipioModel extends Model
{
    protected $table = 'municipio';
    protected $primaryKey = 'id_municipio';
    protected $allowedFields = ['nombre_municipio', 'id_distrito_local'];

    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $useTimestamps = false;

    /**
     * Obtiene un Municipio y su Distrito Local padre.
     * @param int $id_municipio
     * @return array|null
     */
    public function getMunicipioConDistritoLocal(int $id_municipio)
    {
        $municipio = $this->find($id_municipio);
        if ($municipio) {
            $distritoLocalModel = new DistritoLocalModel();
            $municipio['distrito_local'] = $distritoLocalModel->find($municipio['id_distrito_local']);
        }
        return $municipio;
    }

    /**
     * Obtiene todas las Secciones que pertenecen a un Municipio.
     * @param int $id_municipio
     * @return array
     */
    public function getSeccionesByMunicipio(int $id_municipio)
    {
        $seccionModel = new SeccionModel();
        return $seccionModel->where('id_municipio', $id_municipio)->findAll();
    }
}