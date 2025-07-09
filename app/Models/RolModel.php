<?php

namespace App\Models;

use CodeIgniter\Model;

class RolModel extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'id_rol';
    protected $returnType = 'array';
    protected $useTimestamps = false;
    protected $allowedFields = ['nombre_rol'];
    protected $skipValidation = false;

   
}