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
     * Obtiene todos los Distritos Federales con la información de su Estado asociado.
     *
     * @return array Un array de Distritos Federales, cada uno con un índice 'estado'
     * que contiene los datos del estado padre.
     */
    public function getDistritosFederalesConEstado()
    {
        $distritosFederales = $this->findAll();
        $estadoModel = new EstadoModel(); // Instancia el modelo padre

        foreach ($distritosFederales as $key => $df) {
            // Busca el estado asociado y lo adjunta
            $distritosFederales[$key]['estado'] = $estadoModel->find($df['id_estado']);
        }

        return $distritosFederales;
    }
}