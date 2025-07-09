<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\SecureHeaders;
use App\Filters\AuthFilter; // <-- Importa tu filtro aquí

class Filters extends BaseConfig
{
    public array $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'auth'          => AuthFilter::class, // <-- Alias para tu filtro de autenticación
    ];

    public array $globals = [
        'before' => [
            // 'honeypot',
            // 'csrf', // Descomenta si usas CSRF globalmente para todas las solicitudes POST
        ],
        'after' => [
            'toolbar',
            // 'honeypot',
        ],
    ];

    public array $methods = [];

    /**
     * Lista de alias de filtros que deben ejecutarse en rutas específicas.
     * Aquí es donde aplicas tu filtro 'auth' a las rutas protegidas.
     */
    
}
