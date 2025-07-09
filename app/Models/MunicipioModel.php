<?php

namespace App\Models;

use CodeIgniter\Model;

class MunicipioModel extends Model
{
    // Define el nombre de la tabla de la base de datos
    protected $table      = 'municipios';
    // Define la clave primaria de la tabla
    protected $primaryKey = 'id_municipio';

    // Define el tipo de retorno para los métodos de este modelo
    protected $returnType     = 'array'; // Puede ser 'array' o 'object'
    protected $useTimestamps  = false; // No se usan timestamps para esta tabla
    
    protected $allowedFields = ['id_estado', 'nombre'];

}
