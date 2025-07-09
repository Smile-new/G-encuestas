<?php

namespace App\Models;

use CodeIgniter\Model;

class OpcionModel extends Model
{
    protected $table      = 'opciones';
    protected $primaryKey = 'id_opcion';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id_pregunta', 'texto_opcion'];

    protected $useTimestamps = false;
}