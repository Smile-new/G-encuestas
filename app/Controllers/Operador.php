<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Operador extends Controller
{
    
    public function dashboard()
    {
        
        return view('operador/dash');
    }

   
    public function estadisticas()
    {
        
        return view('operador/estat');
    }

   
   

   
    
    
}