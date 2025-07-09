<?php

namespace App\Models;

use CodeIgniter\Model;

class EncuestaModel extends Model
{
    protected $table      = 'encuestas';
    protected $primaryKey = 'id_encuesta';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    // Campos permitidos para inserción/actualización
    protected $allowedFields = ['titulo', 'descripcion', 'activa']; 

    // Timestamps
    protected $useTimestamps = false;

       protected $createdField  = 'fecha_creacion'; // Mapea tu columna 'fecha_creacion'
}