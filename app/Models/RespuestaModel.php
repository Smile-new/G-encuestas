<?php

namespace App\Models;

use CodeIgniter\Model;

class RespuestaModel extends Model
{
    protected $table = 'respuestas';

    protected $primaryKey = 'id_respuesta';

    protected $useAutoIncrement = true;

    protected $returnType = 'array';

    protected $allowedFields = [
        'id_usuario',
        'id_encuesta',
        'id_pregunta',
        'id_opcion',
        'respuesta_texto',
        'id_estado',
        'id_distritofederal',
        'id_distritolocal',
        'id_municipio',
        'id_seccion',
        'id_comunidad',
    ];

    protected $useTimestamps = true;

    protected $createdField = 'fecha_respuesta';

    protected $updatedField = '';

    protected $useSoftDeletes = false;
}