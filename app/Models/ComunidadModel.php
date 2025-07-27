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
     * Obtiene todas las Comunidades con la información de su Sección asociada.
     *
     * @return array Un array de Comunidades, cada una con un índice 'seccion'
     * que contiene los datos de la sección padre.
     */
    public function getComunidadesConSeccion()
    {
        $comunidades = $this->findAll();
        $seccionModel = new SeccionModel(); // Instancia el modelo padre

        foreach ($comunidades as $key => $c) {
            $comunidades[$key]['seccion'] = $seccionModel->find($c['id_seccion']);
        }

        return $comunidades;
    }
}