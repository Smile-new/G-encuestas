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
     * Obtiene todos los estados.
     * No tiene asociaciones padre ya que es la entidad superior.
     *
     * @return array
     */
    public function getAllEstados()
    {
        return $this->findAll();
    }
}