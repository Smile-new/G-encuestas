<?php

namespace App\Models;

use CodeIgniter\Model;

class MonitoreoModel extends Model
{
    // Nombre de la tabla
    protected $table = 'monitoreo_ubicacion';

    // CAMBIO CLAVE: Ahora la llave primaria es el ID autoincrementable
    protected $primaryKey = 'id_monitoreo';

    // CAMBIO CLAVE: Habilitamos el autoincremento para generar IDs únicos por captura
    protected $useAutoIncrement = true;

    protected $returnType = 'array';

    // Agregamos 'id_monitoreo' a los campos permitidos
    protected $allowedFields = [
        'id_monitoreo',
        'id_usuario',
        'latitud',
        'longitud',
        'ultima_actualizacion'
    ];

    // Configuración de marcas de tiempo
    protected $useTimestamps = true;
    protected $createdField = '';
    protected $updatedField = 'ultima_actualizacion'; // Columna personalizada en tu DB
}