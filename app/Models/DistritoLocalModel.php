<?php

namespace App\Models;

use CodeIgniter\Model;

class DistritoLocalModel extends Model
{
    protected $table = 'distritolocal';
    protected $primaryKey = 'id_distrito_local';
    protected $allowedFields = ['nombre_distrito_local', 'id_distrito_federal'];

    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $useTimestamps = false;

    /**
     * Obtiene un Distrito Local y su Distrito Federal padre.
     * @param int $id_distrito_local
     * @return array|null
     */
    public function getDistritoLocalConDistritoFederal(int $id_distrito_local)
    {
        $distritoLocal = $this->find($id_distrito_local);
        if ($distritoLocal) {
            $distritoFederalModel = new DistritoFederalModel();
            $distritoLocal['distrito_federal'] = $distritoFederalModel->find($distritoLocal['id_distrito_federal']);
        }
        return $distritoLocal;
    }

    /**
     * Obtiene todos los Municipios que pertenecen a un Distrito Local.
     * @param int $id_distrito_local
     * @return array
     */
    public function getMunicipiosByDistritoLocal(int $id_distrito_local)
    {
        $municipioModel = new MunicipioModel();
        return $municipioModel->where('id_distrito_local', $id_distrito_local)->findAll();
    }
}