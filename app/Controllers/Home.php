<?php

namespace App\Controllers;

// Importa BaseController que es la clase de la que extienden todos los controladores
use App\Controllers\BaseController;

class Home extends BaseController
{
    /**
     * Muestra la página de inicio del portal (app/Views/portal/index.php).
     * Esta será la vista por defecto cuando se acceda a la URL base (/).
     */
    public function index()
    {
        // La función 'view()' busca automáticamente los archivos dentro de 'app/Views/'.
        // Al especificar 'portal/index', busca el archivo 'index.php' dentro de la subcarpeta 'portal'.
        return view('portal/index');
    }

    /**
     * Muestra la página "Acerca de" del portal (app/Views/portal/acerca.php).
     */
    public function acerca()
    {
        return view('portal/acerca');
    }

    /**
     * Muestra la página de contacto del portal (app/Views/portal/contacto.php).
     */
    public function contacto()
    {
        return view('portal/contacto');
    }

    /**
     * Muestra la página de servicios del portal (app/Views/portal/servicios.php).
     */
    public function servicios()
    {
        return view('portal/servicios');
    }
}