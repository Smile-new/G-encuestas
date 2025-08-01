<?php

namespace App\Models;

use CodeIgniter\Model;

class EstadoModel extends Model
{
    protected $table = 'estado';
    protected $primaryKey = 'id_estado';
    protected $allowedFields = ['nombre_estado'];

    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $useTimestamps = false;

    /**
     * Obtiene todos los Estados. Es la entidad superior.
     * @return array
     */
    public function getAllEstados()
    {
        return $this->findAll();
    }

    /**
     * Obtiene todos los Distritos Federales que pertenecen a un Estado.
     * @param int $id_estado
     * @return array
     */
    public function getDistritosFederalesByEstado(int $id_estado)
    {
        $distritoFederalModel = new DistritoFederalModel();
        return $distritoFederalModel->where('id_estado', $id_estado)->findAll();
    }
}