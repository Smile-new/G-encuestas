<?php

namespace App\Models;

use CodeIgniter\Model;

class SeccionModel extends Model
{
    protected $table = 'seccion';
    protected $primaryKey = 'id_seccion';
    protected $allowedFields = ['nombre_seccion', 'id_municipio'];

    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $useTimestamps = false;

    /**
     * Obtiene todas las Secciones con la información de su Municipio asociado.
     *
     * @return array Un array de Secciones, cada una con un índice 'municipio'
     * que contiene los datos del municipio padre.
     */
    public function getSeccionesConMunicipio()
    {
        $secciones = $this->findAll();
        $municipioModel = new MunicipioModel(); // Instancia el modelo padre

        foreach ($secciones as $key => $s) {
            $secciones[$key]['municipio'] = $municipioModel->find($s['id_municipio']);
        }

        return $secciones;
    }
}