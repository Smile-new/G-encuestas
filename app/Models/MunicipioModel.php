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
     * Obtiene todos los Municipios con la información de su Distrito Local asociado.
     *
     * @return array Un array de Municipios, cada uno con un índice 'distrito_local'
     * que contiene los datos del distrito local padre.
     */
    public function getMunicipiosConDistritoLocal()
    {
        $municipios = $this->findAll();
        $distritoLocalModel = new DistritoLocalModel(); // Instancia el modelo padre

        foreach ($municipios as $key => $m) {
            $municipios[$key]['distrito_local'] = $distritoLocalModel->find($m['id_distrito_local']);
        }

        return $municipios;
    }
}