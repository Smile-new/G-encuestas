<?php

namespace App\Models;

use CodeIgniter\Model;

class MonitoreoModel extends Model
{
    protected $table            = 'monitoreo_ubicacion';
    protected $primaryKey       = 'id_usuario';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';

    // Estos son los únicos campos que permitiremos que se modifiquen
    protected $allowedFields    = ['id_usuario', 'latitud', 'longitud'];

    // Habilitamos las marcas de tiempo para que 'ultima_actualizacion' funcione
    protected $useTimestamps = true;
    protected $createdField  = ''; // No usamos 'created_at'
    protected $updatedField  = 'ultima_actualizacion'; // Usamos nuestra columna personalizada
}