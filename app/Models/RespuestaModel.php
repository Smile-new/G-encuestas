<?php

namespace App\Models;

use CodeIgniter\Model;

class RespuestaModel extends Model
{
    protected $table = 'respuestas'; // Nombre de la tabla
    protected $primaryKey = 'id_respuesta'; // Clave primaria de la tabla

    protected $allowedFields = [
        'id_encuesta',
        'id_pregunta',
        'id_usuario',
        'respuesta_texto',
        'id_opcion',
        // Nuevos campos de geolocalización de dirección
        'calle',
        'colonia',
        'municipio',
        'estado',
        'fecha_ubicacion' // Campo para la fecha y hora de la ubicación
    ];

   
}