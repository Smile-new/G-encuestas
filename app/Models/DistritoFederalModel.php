<?php

namespace App\Models;

use CodeIgniter\Model;

class DistritoFederalModel extends Model
{
    protected $table = 'distritofederal';
    protected $primaryKey = 'id_distrito_federal';
    protected $allowedFields = ['nombre_distrito_federal', 'id_estado'];

    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $useTimestamps = false;

    /**
     * Obtiene un Distrito Federal y su Estado padre.
     * @param int $id_distrito_federal
     * @return array|null
     */
    public function getDistritoFederalConEstado(int $id_distrito_federal)
    {
        $distritoFederal = $this->find($id_distrito_federal);
        if ($distritoFederal) {
            $estadoModel = new EstadoModel();
            $distritoFederal['estado'] = $estadoModel->find($distritoFederal['id_estado']);
        }
        return $distritoFederal;
    }

    /**
     * Obtiene todos los Distritos Locales que pertenecen a un Distrito Federal.
     * @param int $id_distrito_federal
     * @return array
     */
    public function getDistritosLocalesByDistritoFederal(int $id_distrito_federal)
    {
        $distritoLocalModel = new DistritoLocalModel();
        return $distritoLocalModel->where('id_distrito_federal', $id_distrito_federal)->findAll();
    }
}