<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\EncuestaModel;
use App\Models\PreguntaModel; // Importa el PreguntaModel
use App\Models\OpcionModel;   // Importa el OpcionModel

class Encuestador extends Controller
{
    protected $encuestaModel;
    protected $preguntaModel; // Propiedad para PreguntaModel
    protected $opcionModel;   // Propiedad para OpcionModel

    public function __construct()
    {
        $this->encuestaModel = new EncuestaModel();
        $this->preguntaModel = new PreguntaModel(); // Instancia el PreguntaModel
        $this->opcionModel = new OpcionModel();     // Instancia el OpcionModel
        // helper('url'); // Si no usas BaseController y necesitas el helper aquí, descoméntalo.
    }

    /**
     * Carga la vista principal del encuestador (home.php).
     */
    public function index()
    {
        $session = session();
        $data = [
            'isLoggedIn' => $session->get('isLoggedIn'),
            'userData'   => $session->get('usuario'),
        ];
        return view('encuestador/home', $data);
    }

    /**
     * Carga la vista 'cam.php'.
     */
    public function cam()
    {
        $session = session();
        $data = [
            'isLoggedIn' => $session->get('isLoggedIn'),
            'userData'   => $session->get('usuario')
        ];
        return view('encuestador/cam', $data);
    }

    /**
     * Carga la vista 'formularios.php' y pasa las encuestas activas.
     */
    public function formularios()
    {
        $session = session();
        $encuestasActivas = $this->encuestaModel->where('activa', 1)->findAll();

        // Preparar los datos del usuario para la vista de formularios
        $userData = $session->get('usuario');
        $nombreCompleto = "Invitado";
        $nombreUsuario = "invitado";
        $rutaFotoPerfil = base_url(RECURSOS_ENCUESTADOR_IMAGES . '/user.png'); // Default image

        if ($session->get('isLoggedIn') && is_array($userData)) {
            $nombreCompleto = esc($userData['nombre'] ?? '') . ' ' .
                              esc($userData['apellido_paterno'] ?? '') . ' ' .
                              esc($userData['apellido_materno'] ?? '');
            $nombreUsuario = esc($userData['usuario'] ?? '');
            if (!empty($userData['foto'])) {
                $rutaFotoPerfil = base_url('public/img_user/' . esc($userData['foto']));
            }
        }

        $data = [
            'isLoggedIn' => $session->get('isLoggedIn'),
            'userData'   => $userData,
            'nombreCompleto' => $nombreCompleto,
            'nombreUsuario' => $nombreUsuario,
            'rutaFotoPerfil' => $rutaFotoPerfil,
            'encuestas'  => $encuestasActivas,
        ];
        return view('encuestador/formularios', $data);
    }

    /**
     * Muestra una encuesta específica con sus preguntas y opciones.
     * @param int $idEncuesta El ID de la encuesta a mostrar.
     */
    public function verEncuesta($idEncuesta)
    {
        $session = session();

        // Obtener los detalles de la encuesta
        $encuesta = $this->encuestaModel->find($idEncuesta);

        // Si la encuesta no existe o no está activa, redirigir o mostrar un error
        if (!$encuesta || $encuesta['activa'] != 1) {
            // Puedes redirigir a la página de formularios con un mensaje de error
            return redirect()->to(base_url('formularios'))->with('error', 'La encuesta solicitada no existe o no está activa.');
            // O mostrar una página 404
            // throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Obtener las preguntas de la encuesta con sus opciones
        // El método getPreguntasConOpciones de PreguntaModel ya hace el trabajo pesado
        $preguntas = $this->preguntaModel->getPreguntasConOpciones($idEncuesta);

        // Preparar los datos del usuario para la vista (sidebar, navbar)
        $userData = $session->get('usuario');
        $nombreCompleto = "Invitado";
        $nombreUsuario = "invitado";
        $rutaFotoPerfil = base_url(RECURSOS_ENCUESTADOR_IMAGES . '/user.png'); // Default image

        if ($session->get('isLoggedIn') && is_array($userData)) {
            $nombreCompleto = esc($userData['nombre'] ?? '') . ' ' .
                              esc($userData['apellido_paterno'] ?? '') . ' ' .
                              esc($userData['apellido_materno'] ?? '');
            $nombreUsuario = esc($userData['usuario'] ?? '');
            if (!empty($userData['foto'])) {
                $rutaFotoPerfil = base_url('public/img_user/' . esc($userData['foto']));
            }
        }


        // Pasar los datos a la vista
        $data = [
            'isLoggedIn' => $session->get('isLoggedIn'),
            'userData'   => $userData, // Mantener userData para acceso directo si es necesario
            'nombreCompleto' => $nombreCompleto,
            'nombreUsuario' => $nombreUsuario,
            'rutaFotoPerfil' => $rutaFotoPerfil,
            'encuesta'   => $encuesta,
            'preguntas'  => $preguntas,
        ];

        return view('encuestador/ver_encuesta', $data);
    }
}
