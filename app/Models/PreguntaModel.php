<?php

namespace App\Models;

use CodeIgniter\Model;

class PreguntaModel extends Model
{
    protected $table = 'preguntas';
    protected $primaryKey = 'id_pregunta';
    protected $allowedFields = ['id_encuesta', 'texto_pregunta', 'tipo_pregunta'];

    // Método para obtener preguntas y sus opciones
    public function getPreguntasConOpciones($idEncuesta)
    {
        $preguntas = $this->where('id_encuesta', $idEncuesta)->findAll();

        foreach ($preguntas as $key => $pregunta) {
            // Suponiendo que tienes un OpcionModel
            $opcionModel = new OpcionModel();
            $preguntas[$key]['opciones'] = $opcionModel->where('id_pregunta', $pregunta['id_pregunta'])->findAll();
        }

        return $preguntas;
    }
}