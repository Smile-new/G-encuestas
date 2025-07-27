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
     * Obtiene todos los Distritos Locales con la información de su Distrito Federal asociado.
     *
     * @return array Un array de Distritos Locales, cada uno con un índice 'distrito_federal'
     * que contiene los datos del distrito federal padre.
     */
    public function getDistritosLocalesConDistritoFederal()
    {
        $distritosLocales = $this->findAll();
        $distritoFederalModel = new DistritoFederalModel(); // Instancia el modelo padre

        foreach ($distritosLocales as $key => $dl) {
            $distritosLocales[$key]['distrito_federal'] = $distritoFederalModel->find($dl['id_distrito_federal']);
        }

        return $distritosLocales;
    }
}