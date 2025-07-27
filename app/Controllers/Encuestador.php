<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\EncuestaModel;
use App\Models\PreguntaModel;
use App\Models\OpcionModel;

// Importa los modelos geográficos que acabamos de definir
use App\Models\EstadoModel;
use App\Models\DistritoFederalModel;
use App\Models\DistritoLocalModel;
use App\Models\MunicipioModel;
use App\Models\SeccionModel;
use App\Models\ComunidadModel;

class Encuestador extends Controller
{
    protected $encuestaModel;
    protected $preguntaModel;
    protected $opcionModel;

    // Propiedades para los modelos geográficos
    protected $estadoModel;
    protected $distritoFederalModel;
    protected $distritoLocalModel;
    protected $municipioModel;
    protected $seccionModel;
    protected $comunidadModel;

    public function __construct()
    {
        $this->encuestaModel = new EncuestaModel();
        $this->preguntaModel = new PreguntaModel();
        $this->opcionModel = new OpcionModel();

        // Instancia los modelos geográficos
        $this->estadoModel = new EstadoModel();
        $this->distritoFederalModel = new DistritoFederalModel();
        $this->distritoLocalModel = new DistritoLocalModel();
        $this->municipioModel = new MunicipioModel();
        $this->seccionModel = new SeccionModel();
        $this->comunidadModel = new ComunidadModel();

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
        // Asegúrate de que RECURSOS_ENCUESTADOR_IMAGES esté definido en Constants.php
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
     * Muestra una encuesta específica con sus preguntas y opciones,
     * e incluye todos los datos geográficos con sus asociaciones.
     * @param int $idEncuesta El ID de la encuesta a mostrar.
     */
    public function verEncuesta($idEncuesta)
    {
        $session = session();

        // Obtener los detalles de la encuesta
        $encuesta = $this->encuestaModel->find($idEncuesta);

        // Si la encuesta no existe o no está activa, redirigir o mostrar un error
        if (!$encuesta || $encuesta['activa'] != 1) {
            return redirect()->to(base_url('formularios'))->with('error', 'La encuesta solicitada no existe o no está activa.');
        }

        // Obtener las preguntas de la encuesta con sus opciones
        $preguntas = $this->preguntaModel->getPreguntasConOpciones($idEncuesta);

        // --- Cargar TODOS los datos geográficos con sus asociaciones ---
        // Usamos los métodos que te proporcioné en la última iteración.
        // Carga los datos de cada nivel.
        // Los métodos get...ConAsociacion() ya incluyen los datos del padre.
        $estados = $this->estadoModel->getAllEstados(); // Estado no tiene padre
        $distritosFederales = $this->distritoFederalModel->getDistritosFederalesConEstado();
        $distritosLocales = $this->distritoLocalModel->getDistritosLocalesConDistritoFederal();
        $municipios = $this->municipioModel->getMunicipiosConDistritoLocal();
        $secciones = $this->seccionModel->getSeccionesConMunicipio();
        $comunidades = $this->comunidadModel->getComunidadesConSeccion();
        // --- FIN de carga de datos geográficos ---


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

        // Pasar todos los datos a la vista
        $data = [
            'isLoggedIn' => $session->get('isLoggedIn'),
            'userData'   => $userData,
            'nombreCompleto' => $nombreCompleto,
            'nombreUsuario' => $nombreUsuario,
            'rutaFotoPerfil' => $rutaFotoPerfil,
            'encuesta'   => $encuesta,
            'preguntas'  => $preguntas,

            // Añadimos los datos geográficos
            'estados' => $estados,
            'distritosFederales' => $distritosFederales,
            'distritosLocales' => $distritosLocales,
            'municipios' => $municipios,
            'secciones' => $secciones,
            'comunidades' => $comunidades,
        ];

        // La vista que mostrará todo es 'encuestador/ver_encuesta'
        // Asegúrate de que tu archivo de vista se llame ver_encuesta.php
        return view('encuestador/ver_encuesta', $data);
    }
}