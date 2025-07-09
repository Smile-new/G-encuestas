<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    // Nombre de la tabla de la base de datos
    protected $table = 'usuarios';
    // Clave primaria de la tabla
    protected $primaryKey = 'id_usuario';
    
    // Campos permitidos para ser manipulados por el modelo (insertar/actualizar)
    protected $allowedFields = [
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'telefono',
        'usuario', // Campo 'usuario' que reemplaza a 'correo'
        'contrasena',
        'foto',
        'id_rol'   // Clave foránea al rol, basándonos en tu tabla SQL 'usuarios'
    ];

    
}