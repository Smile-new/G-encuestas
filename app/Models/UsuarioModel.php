<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    // Nombre de la tabla de la base de datos
    protected $table = 'usuarios';
    // Clave primaria de la tabla
    protected $primaryKey = 'id_usuario';
    
    
    protected $allowedFields = [
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'telefono',
        'usuario',
        'contrasena',
        'foto',
        'id_rol',
        'creado_por_id' 
    ];
}
