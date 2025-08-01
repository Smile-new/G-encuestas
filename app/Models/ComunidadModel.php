<?php

namespace App\Models;

use CodeIgniter\Model;

class ComunidadModel extends Model
{
    protected $table = 'comunidades';
    protected $primaryKey = 'id_comunidad';
    protected $allowedFields = ['nombre_comunidad', 'id_seccion'];

    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $useTimestamps = false;

    /**
     * Obtiene una Comunidad y su Sección padre.
     * @param int $id_comunidad
     * @return array|null
     */
    public function getComunidadConSeccion(int $id_comunidad)
    {
        $comunidad = $this->find($id_comunidad);
        if ($comunidad) {
            $seccionModel = new SeccionModel();
            $comunidad['seccion'] = $seccionModel->find($comunidad['id_seccion']);
        }
        return $comunidad;
    }
}