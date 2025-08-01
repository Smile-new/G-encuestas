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
     * Obtiene una Sección y su Municipio padre.
     * @param int $id_seccion
     * @return array|null
     */
    public function getSeccionConMunicipio(int $id_seccion)
    {
        $seccion = $this->find($id_seccion);
        if ($seccion) {
            $municipioModel = new MunicipioModel();
            $seccion['municipio'] = $municipioModel->find($seccion['id_municipio']);
        }
        return $seccion;
    }

    /**
     * Obtiene todas las Comunidades que pertenecen a una Sección.
     * @param int $id_seccion
     * @return array
     */
    public function getComunidadesBySeccion(int $id_seccion)
    {
        $comunidadModel = new ComunidadModel();
        return $comunidadModel->where('id_seccion', $id_seccion)->findAll();
    }
}